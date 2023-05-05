<?php
/**
 * Disables the /meetings archive page created by 12 Step Meeing List.
 *
 * This class is instantiated and run() in the main TSMLXtras class. It
 * disables the /meeetings archive page created by the 12 Step Meeting List
 * plugin. Particularly usefule if the [tsmlx] shorcod or the main [tsml_ui]
 * shortcode is used on a site's homepage, making the /meetings page redundant.
 *
 * @author Anthony B <anthony@bustedspring.com>
 * @version 1.0.0
 * @since 1.0.0
 * @package TSMLXtras\DisableMeetingsPage
 */

namespace TSMLXtras\DisableMeetingsPage;

use TSMLXtras\TSMLXtras;

if ( ! class_exists( 'TSMLX_Disable_Meetings_Page' ) ) {
	class TSMLX_Disable_Meetings_Page {
		
		/**
		 * Instance of main plugin object.
		 *
		 * @acces protected
		 * @var \TSMLXtras\TSMLXtras $plugin
		 */
		protected TSMLXtras $TSMLXtras;
		
		
		/**
		 * Flag to determin if page should be disabled or not.
		 *
		 * @var bool
		 */
		private bool $disabled;
		
		/**
		 * Constructor.
		 *
		 * @param \TSMLXtras\TSMLXtras $TSMLXtras
		 */
		public function __construct(TSMLXtras $TSMLXtras) {
			$this->TSMLXtras = $TSMLXtras;
			$this->disabled = array_key_exists('disable_meetings_archive', $this->TSMLXtras->get_setting());
		}
		
		/**
		 * Sets this class into motion.
		 *
		 * Executes the plugin by calling the run method of classes.
		 *
		 * @return void
		 */
		public function run(): void {
			if ($this->disabled) {
				$this->setup_actions();
			}
		}
		
		/**
		 * Setting up action/filter hooks.
		 *
		 * @return void
		 */
		private function setup_actions(): void {
			remove_filter('archive_template', 'tsml_archive_template');
			add_filter( 'register_post_type_args', [$this, 'modify_post_types'], 20, 2 );
		}
		
		public function modify_post_types( $args, $post_type ) {
			if ($post_type === 'tsml_meeting') {
				$args['has_archive'] = 0;
			}
			return $args;
		}
	}
}
