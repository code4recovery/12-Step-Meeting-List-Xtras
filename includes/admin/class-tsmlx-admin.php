<?php
/**
 * Creates settings page and related functionality.
 *
 * This class is instantiated and run() in the main TSMLXtras class to add
 * the settings page and all forms/fields and functions related to persisting
 * settings to the database.
 *
 * @author Anthony B <anthony@bustedspring.com>
 * @version 1.0.0
 * @since 1.0.0
 * @package TSMLXtras\Admin
 */

namespace TSMLXtras\Admin;

use TSMLXtras\TSMLXtras;
use TSMLXtras\Utility\TSMLX_Forms;
use TSMLXtras\Utility\TSMLX_Admin_Template_Loader;

if ( ! class_exists( 'TSMLX_Admin' ) ) {
	class TSMLX_Admin {

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
		 * @var array $paths
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
		 * Plugin slug with underscores in place of spaces
		 *
		 * @acces protected
		 * @var string $plugin_slug_underscores
		 */
		protected string $plugin_slug_underscores;
		
		/**
		 * Template loader class.
		 *
		 * @acces protected
		 * @var \TSMLXtras\Utility\TSMLX_Admin_Template_Loader $template_loader
		 */
		protected TSMLX_Admin_Template_Loader $template_loader;
		
		/**
		 * Template loader class.
		 *
		 * @acces protected
		 * @var \TSMLXtras\Utility\TSMLX_Forms $form_loader
		 */
		protected TSMLX_Forms $form_loader;
		
		/**
		 * Options page's hook_suffix returned by add_options_page() WP function.
		 *
		 * @var string|bool $options_page
		 */
		protected string|bool $options_page;
		
		/**
		 * Constructor.
		 *
		 * @param \TSMLXtras\TSMLXtras $TSMLXtras
		 */
		public function __construct( TSMLXtras $TSMLXtras ) {
			global $tsml_column_defaults;

			$this->TSMLXtras               = $TSMLXtras;
			$this->paths                   = $this->TSMLXtras->get_path();
			$this->plugin_info             = $this->TSMLXtras->get_info();
			$this->plugin_slug_underscores = $this->TSMLXtras->get_slug( 'underscores' );
			$this->plugin_options          = $this->TSMLXtras->get_setting();
			$this->template_loader         = new TSMLX_Admin_Template_Loader( $this->TSMLXtras );
			$this->form_loader             = new TSMLX_Forms( $this->TSMLXtras );
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
		 * Setting up action/filter hooks.
		 *
		 * @return void
		 */
		private function setup_actions(): void {
			add_action( 'admin_menu', [ $this, 'create_settings_menu' ] );
			add_action( 'admin_init', [ $this, 'register_settings' ] );
			add_action( 'wp_ajax_tsmlxtras_get_image', [ $this, 'get_image' ] );
			add_filter( 'plugin_action_links_' . $this->paths['plugin_basename'], [ $this, 'plugin_action_links', ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'admin_assets' ] );
			add_action( 'wp_head', [ $this, 'enqueue_colors' ] );
			add_action( "admin_head", [ $this, 'help_tabs' ] );
		}
		
		/**
		 * Load javscript & css.
		 *
		 * @return void
		 */
		public function admin_assets(): void {
			// check if user is on TSML Xtras settings page
			if ( $this->is_settings_page() ) {
				// enqueue the media picker
				wp_enqueue_media();
				// enqueue the color picker
				wp_enqueue_style( 'wp-color-picker' );
				// enqueue the admin CSS
				wp_enqueue_style( $this->plugin_slug_underscores . '-admincss', $this->paths['plugin_url'] . 'assets/css/tsmlxtras-admin.css', [], $this->plugin_info['Version'] );
				wp_enqueue_script( 'jquery-ui-core' );
				wp_enqueue_script('jquery-ui-sortable' );
				wp_enqueue_script( $this->plugin_slug_underscores . '-adminjs', $this->paths['plugin_url'] . 'assets/js/tsmlxtras-admin.js', [ 'wp-color-picker' ], $this->plugin_info['Version'], TRUE );
			}
		}
		
		/**
		 * Add menu item to wp-admin settings page.
		 *
		 * @return void
		 */
		public function create_settings_menu(): void {
			$this->options_page = add_submenu_page(
				'edit.php?post_type=tsml_meeting',
				__( $this->plugin_info['ShortName'] . ' Settings', $this->plugin_info['TextDomain'] ),
				__( $this->plugin_info['ShortName'], $this->plugin_info['TextDomain'] ), 'manage_options', $this->plugin_slug_underscores . '_settings',
				[ $this, 'render_settings_page' ]
			);
			
		}
		
		/**
		 * Create settings page.
		 *
		 * @return void
		 */
		public function render_settings_page(): void {
			$data['options']        = $this->plugin_options;
			$data['plugin_url']     = $this->paths['plugin_url'];
			$data['plugin_version'] = $this->plugin_info['Version'];
			$data['plugin_name']    = $this->plugin_info['Name'];
			$data['plugin_slug']    = $this->plugin_slug_underscores;
			
			$this->template_loader->set_template_data( $data );
			$this->template_loader->get_template_part( $this->plugin_info['TextDomain'] . '-settings-page' );
		}
		
		/**
		 * Register settings in the database.
		 *
		 * @return void
		 */
		public function register_settings(): void {
			global $tsml_column_defaults, $tsml_programs, $tsml_program;
			$types_defaults = [];
			foreach ($tsml_programs[$tsml_program]['types'] as $key => $label) {
				$types_defaults[] = [
					'key' => $key,
					'label' => $label,
					'exclude' => false,
				];
			}
			$before_section  = '<div class="postbox"><div class="postbox-header"><h2>';
			$before_section2 = '</h2></div><div class="inside">';
			$after_section   = '</div></div>';
			// Flush rewrite rules on every save
			if ( delete_transient( 'tsmlxtras_flush_rules' ) ) {
				flush_rewrite_rules();
			}
			register_setting( $this->plugin_slug_underscores . '_settings_group', $this->plugin_slug_underscores . '_settings', [
				'sanitize_callback' => [
					$this,
					'sanitize_settings',
				],
			] );
			// TSML Settings
			add_settings_section(
				$this->plugin_slug_underscores . '_tsml_settings_section',
				'',
				[ $this->form_loader, 'print_section_info' ],
				$this->plugin_slug_underscores . '_settings_page',
				[
					'before_section' => $before_section . '12 Step Meeting List Settings' . $before_section2,
					'after_section'  => $after_section,
					'description'    => 'These are some options for the 12 Step Meeting List plugin that are normally set in code. We have simply created a way to do it in the admin.',
				]
			);
			add_settings_field(
				'tsml_columns',
				'TSML columns',
				[ $this->form_loader, 'draggable_list' ],
				$this->plugin_slug_underscores . '_settings_page',
				$this->plugin_slug_underscores . '_tsml_settings_section',
				[
					'id'          => 'tsml_columns',
					'description' => 'Show, hide & reorder columns in the meetings list.',
					'defaults' => $tsml_column_defaults,
					'draggables' => !empty($this->plugin_options['tsml_columns']) ? json_decode($this->plugin_options['tsml_columns'], true) : $tsml_column_defaults,
				]
			);
			add_settings_field(
				'tsml_street_only',
				'Show full address',
				[ $this->form_loader, 'checkbox' ],
				$this->plugin_slug_underscores . '_settings_page',
				$this->plugin_slug_underscores . '_tsml_settings_section',
				[
					'id'          => 'tsml_street_only',
					'description' => 'Show full address in meeting list including city, state, & country.',
				]
			);
			add_settings_field(
				'tsml_google_geocoding_key',
				'Custom Geocoding Key',
				[ $this->form_loader, 'text' ],
				$this->plugin_slug_underscores . '_settings_page',
				$this->plugin_slug_underscores . '_tsml_settings_section',
				[
					'id'          => 'tsml_google_geocoding_key',
					'description' => 'Enter your own geocoding key. Make sure you’ve enabled the Geocoding API in the Google Cloud Console.',
				]
			);
			add_settings_field(
				'tsml_slug',
				'Custom meeting page URL',
				[ $this->form_loader, 'text' ],
				$this->plugin_slug_underscores . '_settings_page',
				$this->plugin_slug_underscores . '_tsml_settings_section',
				[
					'id'          => 'tsml_slug',
					'description' => 'If you want your /meetings page to be someting else, type it here without slashes. You may set it to false to hide the public meeting finder altogether.',
				]
			);
			add_settings_field(
				'types_order',
				'Types order',
				[ $this->form_loader, 'draggable_list' ],
				$this->plugin_slug_underscores . '_settings_page',
				$this->plugin_slug_underscores . '_tsml_settings_section',
				[
					'id'          => 'types_order',
					'description' => 'Drag and drop to reorder meeting types in the meeting list.',
					'defaults' => $types_defaults,
					'add_another_enabled' => true,
					'deletable' => true,
					'draggables' => !empty($this->plugin_options['types_order']) ? json_decode($this->plugin_options['types_order'], true) : $types_defaults,
				]
			);
			// Schema Settings
			add_settings_section(
				$this->plugin_slug_underscores . '_schema_settings_section',
				'',
				[ $this->form_loader, 'print_section_info' ],
				$this->plugin_slug_underscores . '_settings_page',
				[
					'before_section' => $before_section . 'Schema Settings' . $before_section2,
					'after_section'  => $after_section,
					'description'    => 'Outputs structured data within the code of your meetings to imporove readability by search engines. Data is not visible to users.',
				]
			);
			add_settings_field(
				'include_schema',
				'Include Schema.org markup',
				[ $this->form_loader, 'checkbox' ],
				$this->plugin_slug_underscores . '_settings_page',
				$this->plugin_slug_underscores . '_schema_settings_section',
				[
					'id'          => 'include_schema',
					'description' => 'Checking this will add rich data to your meeting pages.',
				]
			);
			add_settings_field(
				'tsmlx_image_id',
				'Default Image',
				[ $this->form_loader, 'image' ],
				$this->plugin_slug_underscores . '_settings_page',
				$this->plugin_slug_underscores . '_schema_settings_section',
				[
					'id'          => 'tsmlx_image_id',
					'description' => 'This is the default image that is included with every meeting in Schema.org data.',
				]
			);
			// Extra Content
			add_settings_section(
				$this->plugin_slug_underscores . '_extracontent_settings_section',
				'',
				[ $this->form_loader, 'print_section_info' ],
				$this->plugin_slug_underscores . '_settings_page',
				[
					'before_section' => $before_section . 'Extra Content' . $before_section2,
					'after_section'  => $after_section,
					'description'    => 'Add content above and below the meeting table created with our shortcode (only works with the [tsmlx] shortcode).',
				]
			);
			add_settings_field(
				'notes_above',
				'Notes Above',
				[ $this->form_loader, 'textarea' ],
				$this->plugin_slug_underscores . '_settings_page',
				$this->plugin_slug_underscores . '_extracontent_settings_section',
				[
					'id'          => 'notes_above',
					'description' => 'Text to be placed above the meeting list. You can use this to put your meeting code legend or other helpful information for your users.',
				]
			);
			add_settings_field(
				'notes_below',
				'Notes Below',
				[ $this->form_loader, 'textarea' ],
				$this->plugin_slug_underscores . '_settings_page',
				$this->plugin_slug_underscores . '_extracontent_settings_section',
				[
					'id'          => 'notes_below',
					'description' => 'Text to be placed below the meeting list. You can use this to put your meeting code legend or other helpful information for your users.',
				]
			);
			// Colors
			add_settings_section(
				$this->plugin_slug_underscores . '_colors_settings_section',
				'',
				[ $this->form_loader, 'print_section_info' ],
				$this->plugin_slug_underscores . '_settings_page',
				[
					'before_section' => $before_section . 'Colors' . $before_section2,
					'after_section'  => $after_section,
					"description"    => 'Select colors for the 12 Step Meeting List Xtras shortcode output.',
				]
			);
			add_settings_field(
				'header_color',
				'Header Color',
				[ $this->form_loader, 'color' ],
				$this->plugin_slug_underscores . '_settings_page',
				$this->plugin_slug_underscores . '_colors_settings_section',
				[
					'id'          => 'header_color',
					'description' => 'Background color used for the day of week headers.',
				]
			);
			add_settings_field(
				'header_invert',
				'Invert Header Text',
				[ $this->form_loader, 'checkbox' ],
				$this->plugin_slug_underscores . '_settings_page',
				$this->plugin_slug_underscores . '_colors_settings_section',
				[
					'id'          => 'header_invert',
					'description' => 'Checking this box will set the day of week text to white instead of the theme default.',
				]
			);
			add_settings_field(
				'primary_color',
				'Primary Color',
				[ $this->form_loader, 'color' ],
				$this->plugin_slug_underscores . '_settings_page',
				$this->plugin_slug_underscores . '_colors_settings_section',
				[
					'id'          => 'primary_color',
					'description' => 'Color used for: Main heading (Meeting Schedule), Arrow color, Day of the week headings, "Online" indicator, & link color.',
				]
			);
			add_settings_field(
				'secondary_color',
				'Secondary Color',
				[ $this->form_loader, 'color' ],
				$this->plugin_slug_underscores . '_settings_page',
				$this->plugin_slug_underscores . '_colors_settings_section',
				[
					'id'          => 'secondary_color',
					'description' => 'Color used for: "In Person" indicator & main table row background.',
				]
			);
			add_settings_field(
				'tertiary_color',
				'Tertiary Color',
				[ $this->form_loader, 'color' ],
				$this->plugin_slug_underscores . '_settings_page',
				$this->plugin_slug_underscores . '_colors_settings_section',
				[
					'id'          => 'tertiary_color',
					'description' => 'Color used for: "Hybrid" indicator',
				]
			);
			// Other Settings
			add_settings_section(
				$this->plugin_slug_underscores . '_other_settings_section',
				'',
				[ $this->form_loader, 'print_section_info' ],
				$this->plugin_slug_underscores . '_settings_page',
				[
					'before_section' => $before_section . 'Other Settings' . $before_section2,
					'after_section'  => $after_section,
					"description"    => 'Various general plugin settings.',
				
				]
			);
			add_settings_field(
				'disable_meetings_archive',
				'Disable meetings page',
				[ $this->form_loader, 'checkbox' ],
				$this->plugin_slug_underscores . '_settings_page',
				$this->plugin_slug_underscores . '_other_settings_section',
				[
					'id'          => 'disable_meetings_archive',
					'description' => 'Checking this will disable the default meetings page provided by the 12 Step Meeting List plugin. This might be useful if you are using your homepage to display all meetings.',
				]
			);
			add_settings_field(
				'enable_group_id',
				'Enable unique group ID field',
				[ $this->form_loader, 'checkbox' ],
				$this->plugin_slug_underscores . '_settings_page',
				$this->plugin_slug_underscores . '_other_settings_section',
				[
					'id'          => 'enable_group_id',
					'description' => 'Checking this will show a "Unique Meeting ID" field on admin pages. Can be used to input GSO group ID or aything else you find useful',
				]
			);
		}
		
		public function help_tabs(): void {
			if ( ! $this->is_settings_page() ) {
				return;
			}
			
			$screen = get_current_screen();
			
			/**
			 * Overview Tab
			 */
			ob_start();
			$this->template_loader->get_template_part( 'help-tab-overview' );
			$overview = ob_get_clean();
			
			$screen->add_help_tab( [
				'id'      => 'tsmlxtras_help_tab-overview',
				'title'   => __( 'Overview', $this->plugin_slug_underscores ),
				'content' => $overview,
			] );
			
			/**
			 * Settings Tab
			 */
			ob_start();
			$this->template_loader->get_template_part( 'help-tab-settings' );
			$settings = ob_get_clean();
			
			$screen->add_help_tab( [
				'id'      => 'tsmlxtras_help_tab-settings',
				'title'   => __( 'Settings', $this->plugin_slug_underscores ),
				'content' => $settings,
			] );
			
			/**
			 * Shortcodes Tab
			 */
			ob_start();
			$data['plugin_url']     = $this->paths['plugin_url'];
			$this->template_loader->set_template_data($data);
			$this->template_loader->get_template_part( 'help-tab-shortcodes' );
			$shortcode = ob_get_clean();
			$screen->add_help_tab( [
				'id'      => 'tsmlxtras_help_tab_usage-standard',
				'title'   => __( 'Shortcodes', $this->plugin_slug_underscores ),
				'content' => $shortcode,
			] );
			
			/**
			 * Group Unique ID field Tab
			 */
			ob_start();
			$data['plugin_url']     = $this->paths['plugin_url'];
			$this->template_loader->set_template_data($data);
			$this->template_loader->get_template_part( 'help-tab-groupid' );
			$groupid = ob_get_clean();
			$screen->add_help_tab( [
				'id'      => 'tsmlxtras_help_tab-groupid',
				'title'   => __( 'Group Unique ID', $this->plugin_slug_underscores ),
				'content' => $groupid,
			] );

			/**
			 * Gutenberg blocks Tab
			 */
			ob_start();
			$data['plugin_url']     = $this->paths['plugin_url'];
			$this->template_loader->set_template_data($data);
			$this->template_loader->get_template_part( 'help-tab-blocks' );
			$blocks = ob_get_clean();
			$screen->add_help_tab( [
				'id'      => 'tsmlxtras_help_tab-blocks',
				'title'   => __( 'Gutenberg Blocks', $this->plugin_slug_underscores ),
				'content' => $blocks,
			] );

			/**
			 * Yoast SEO Variables blocks Tab
			 */
			ob_start();
			$data['plugin_url']     = $this->paths['plugin_url'];
			$this->template_loader->set_template_data($data);
			$this->template_loader->get_template_part( 'help-tab-yoastvars' );
			$yoast = ob_get_clean();
			$screen->add_help_tab( [
				'id'      => 'tsmlxtras_help_tab-yoastvars',
				'title'   => __( 'Yoast SEO Variables', $this->plugin_slug_underscores ),
				'content' => $yoast,
			] );
		}
		
		/**
		 * Queues a rewrite flush on next load. No sanitization performed.
		 *
		 * @param $input
		 *
		 * @return mixed
		 */
		function sanitize_settings( $input ): mixed {
			foreach ( $input as $key => $item ) {
				if ($key === 'tsml_google_geocoding_key' || $key === 'tsml_slug') {
					$input[$key] = trim($input[$key]);
				}
			}
			// Flush rewrite rules on every save
			set_transient( 'tsmlxtras_flush_rules', TRUE );
			
			return $input;
		}
		
		/**
		 * Add extra links in plugin listing.
		 *
		 * @param $links
		 *
		 * @return array
		 */
		function plugin_action_links( $links ): array {
			return array_merge(
				[
					'<a href="' . admin_url( 'edit.php?post_type=tsml_meeting&page=' . $this->plugin_slug_underscores . '_settings' ) . '" title="' . __( 'TSML Xtras', $this->plugin_info['TextDomain'] ) . '">' . __( 'Settings', $this->plugin_info['TextDomain'] ) . '</a>',
				], $links
			);
		}
		
		/**
		 * Screen check function.
		 *
		 * Checks if current page is the plugin settings page.
		 *
		 * @return bool
		 */
		private function is_settings_page(): bool {
			// check current page
			$screen = get_current_screen();
			// check if we're on Ivy.ai Chatbot Integration settings page
			if ( is_object( $screen ) && $screen->id == 'tsml_meeting_page_' . $this->plugin_slug_underscores . '_settings' ) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
		
		/**
		 * Ajax action to refresh the schema image.
		 *
		 * @return void
		 */
		function get_image(): void {
			if ( isset( $_GET['id'] ) ) {
				$image = wp_get_attachment_image( filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT ), 'medium', FALSE, [ 'id' => 'tsmlxtras-preview-image' ] );
				$data  = [
					'image' => $image,
				];
				wp_send_json_success( $data );
			} else {
				wp_send_json_error();
			}
		}
		
		/**
		 * Enqueue custom colors chosen in UI.
		 *
		 * @return void
		 */
		function enqueue_colors(): void {
			$headers_rgb = hex2rgb( $this->plugin_options['header_color'] );
			$primary_rgb = hex2rgb( $this->plugin_options['primary_color'] );
			$secondary_rgb = hex2rgb( $this->plugin_options['secondary_color'] );
			$tertiary_rgb = hex2rgb( $this->plugin_options['tertiary_color'] );
			$headers_hsl = rgbToHsl( $headers_rgb['r'], $headers_rgb['g'], $headers_rgb['b'] );
			$primary_hsl = rgbToHsl( $primary_rgb['r'], $primary_rgb['g'], $primary_rgb['b'] );
			$secondary_hsl = rgbToHsl( $secondary_rgb['r'], $secondary_rgb['g'], $secondary_rgb['b'] );
			$tertiary_hsl = rgbToHsl( $tertiary_rgb['r'], $tertiary_rgb['g'], $tertiary_rgb['b'] );
			$style = '<style id="tsmlx-global">:root {';
			$style .= '--bs-primary:' . $this->plugin_options['primary_color'] . ';';
			$style .= '--tsmlx-headers:' . $this->plugin_options['header_color'] . ';';
			$style .= '--tsmlx-primary:' . $this->plugin_options['primary_color'] . ';';
			$style .= '--tsmlx-secondary:' . $this->plugin_options['secondary_color'] . ';';
			$style .= '--tsmlx-tertiary:' . $this->plugin_options['tertiary_color'] . ';';
			$style .= '--tsmlx-headers-rgb:' . implode( ' ', $headers_rgb ) . ';';
			$style .= '--tsmlx-primary-rgb:' . implode( ' ', $primary_rgb ) . ';';
			$style .= '--tsmlx-secondary-rgb:' . implode( ' ', $secondary_rgb ) . ';';
			$style .= '--tsmlx-tertiary-rgb:' . implode( ' ', $tertiary_rgb ) . ';';
			$style .= '--tsmlx-headers-hsl:' . implode( ' ',  $headers_hsl ) . ';';
			$style .= '--tsmlx-primary-hsl:' . implode( ' ',  $primary_hsl ) . ';';
			$style .= '--tsmlx-secondary-hsl:' . implode( ' ',  $secondary_hsl ) . ';';
			$style .= '--tsmlx-tertiary-hsl:' . implode( ' ',  $tertiary_hsl ) . ';';
			$style .= '} </style>';
			echo $style;
		}
	}
	
}
