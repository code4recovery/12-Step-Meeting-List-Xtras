<?php
/**
 * Creates all shortcodes.
 *
 * This class is instantiated and run() in the main TSMLXtras class to create
 * all shortcodes that are available within the plugin
 *
 * @author Anthony B <anthony@bustedspring.com>
 * @version 1.0.0
 * @since 1.0.0
 * @package TSMLXtras\Shortcodes
 */

namespace TSMLXtras\Shortcodes;

use TSMLXtras\TSMLXtras;
use TSMLXtras\Utility\TSMLX_Frontend_Template_Loader;

if ( ! class_exists( 'TSMLX_Shortcodes' ) ) {
	class TSMLX_Shortcodes {
		
		/**
		 * Instance of main plugin object.
		 *
		 * @acces protected
		 * @var \TSMLXtras\TSMLXtras $plugin
		 */
		protected TSMLXtras $TSMLXtras;
		
		/**
		 * All paths associated with this plugin.
		 *
		 * @acces protected
		 * @var mixed $paths
		 */
		protected mixed $paths;
		
		/**
		 * Plugin name, version, etc from plugin file header.
		 *
		 * @acces protected
		 * @var array $plugin_info
		 */
		protected mixed $plugin_info;
		
		/**
		 * Settings for this plugin.
		 *
		 * @acces protected
		 * @var array $plugin_options
		 */
		protected mixed $plugin_options;
		
		/**
		 * Template loader class.
		 *
		 * @acces protected
		 * @var \TSMLXtras\Utility\TSMLX_Frontend_Template_Loader $template_loader
		 */
		protected TSMLX_Frontend_Template_Loader $template_loader;
		
		/**
		 * Constructor..
		 *
		 * @param \TSMLXtras\TSMLXtras $TSMLXtras
		 */
		public function __construct(TSMLXtras $TSMLXtras) {
			$this->TSMLXtras = $TSMLXtras;
			$this->paths = $this->TSMLXtras->get_path();
			$this->plugin_options = $this->TSMLXtras->get_setting();
			$this->plugin_info = $this->TSMLXtras->get_info();
			$this->template_loader = new TSMLX_Frontend_Template_Loader($this->TSMLXtras);
		}
		
		/**
		 * Sets this class into motion.
		 *
		 * Executes the plugin by calling the run method of classes.
		 *
		 * @return void
		 */
		public function run(): void {
			$this->setup_actions();
		}
		
		/**
		 * Setting up shortcode/action hooks.
		 *
		 * @return void
		 */
		private function setup_actions(): void {
			add_shortcode( 'tsmlx', [$this, 'meetings'] );
			add_action( 'wp_enqueue_scripts', [$this, 'assets'] );
		}
		
		/**
		 * Load javscript & css.
		 *
		 * @return void
		 */
		public function assets(): void {
			// Enqueue the frontend 12 step meeting list javascript
			wp_enqueue_style( 'tsmlxtras-front', $this->paths['plugin_url'] . 'assets/css/tsmlxtras.css' );
			wp_enqueue_style( 'tsmlxtras-frontnew', $this->paths['plugin_url'] . 'assets/css/main.css' );
			// Register bootstrap js
			wp_register_script('tsmlxtras-bootstrapjs', $this->paths['plugin_url'] . 'assets/css/bootstrap-5.1.3/dist/js/bootstrap.js', array('jquery'), NULL, TRUE);
			// Enqueue the script
			wp_enqueue_script('tsmlxtras-bootstrapjs');
			// Register our frontend script
			wp_register_script('tsmlxtras-frontjs', $this->paths['plugin_url'] . 'assets/js/tsmlxtras-frontend.js', array('jquery'), NULL, TRUE);
			// Enqueue the script
			wp_enqueue_script('tsmlxtras-frontjs');
		}
		
		
		/**
		 * Shortcode output for meetings grouped by day of week.
		 *
		 * @param $atts
		 *
		 * @return false|string
		 */
		function meetings( $atts ): bool|string {
			// Include needed globals
			global $tsml_days, $tsml_meeting_attendance_options, $tsmlx_services, $tsml_columns, $tsml_street_only;
			
			// Shortcode attributes with defaults
			$args = shortcode_atts( array(
				'show_footer' => "1",
				'show_header' => "1",
				'template' => 'meeting-table-accordion',
				'group' => NULL,
			), $atts );
			
			$data['show_header'] = $args['show_header'];
			$data['show_footer'] = $args['show_footer'];
			
			$today_day    = date( 'l' );
			$today_number = array_search( $today_day, $tsml_days );

			// Default values for arguments
			$data['hide_footer'] = FALSE;
			$data['hide_header'] = FALSE;
			
			// Set data array to send to template
			$data['notes_above']                     = $this->plugin_options['notes_above'];
			$data['notes_below']                     = $this->plugin_options['notes_below'];
			$data['header_invert']                   = !empty($this->plugin_options['header_invert']);
			$data['secondary_dark']                  = !empty($this->plugin_options['secondary_dark']);
			$data['tsml_days']                       = $tsml_days;
			$data['tsml_street_only']                = $tsml_street_only;
			$data['tsml_meeting_attendance_options'] = $tsml_meeting_attendance_options;
			$data['services']                        = $tsmlx_services;
			$data['types_order'] = [];
			if (!empty($this->plugin_options['types_order'])) {
				$types_order = json_decode($this->plugin_options['types_order'], true);
				foreach ($types_order as $order => $type) {
					$data['types_order'][$order] = $type['key'];
				}
			}

			// Meetings
			if (empty($atts['group'])) {
				$tsmlmeetings = tsml_get_meetings();
				// Set columns for this view
				$data['tsml_columns'] = $tsml_columns;
			} else {
				$tsmlmeetings = tsml_get_meetings(['group_id' => $atts['group'], '']);
				// Set columns for this view
				$data['tsml_columns'] = [
					'time_formatted' => 'Day/Time',
					'type'           => 'Type',
				];
			}
			
			// If no meetings exist return false, otherwise group meetings by day
			if ( ! count( $tsmlmeetings ) && empty( $atts['message'] ) ) {
				return FALSE;
			} else {
				// Group array by day
				foreach ( $tsmlmeetings as $meeting ) {
					$meeting['types_expanded'] = tsmlxtras_expand_meeting_types($meeting['types'], json_decode($this->plugin_options['types_order'], true));
					$data['meetings'][ $meeting['day'] ][] = $meeting;
				}
			}
			// Sort meetings by today's day first if we are not on a group page
			if (empty($atts['group'])) {
				$data['meetings'] = tsmlxtras_sortby_currentday_first( $data['meetings'], $today_number );
			}
			$data['loader'] = $this->template_loader;
			// Do output
			ob_start();
			$this->template_loader->set_template_data( $data );
			$this->template_loader->get_template_part( $args['template'], '' );
			return ob_get_clean();
		}
	}
}
