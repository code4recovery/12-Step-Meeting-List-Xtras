<?php
/**
 * Loads and parses templates in templates/frontend.
 *
 * Used in class-shortcodes.php
 *
 * @author Anthony B <anthony@bustedspring.com>
 * @version 1.0.0
 * @since 1.0.0
 * @package TSMLXtras\Utility\TSMLX_Frontend_Template_Loader
 */

namespace TSMLXtras\Utility;

use TSMLXtras\TSMLXtras;

if ( ! class_exists( 'TSMLX_Frontend_Template_Loader' ) ) {
	class TSMLX_Frontend_Template_Loader extends Gamajo_Template_Loader {
		
		/**
		 * Instance of main plugin object.
		 *
		 * @acces protected
		 * @var \TSMLXtras\TSMLXtras $plugin
		 */
		protected TSMLXtras $TSMLXtras;
		
		/**
		 * Constructor.
		 *
		 * @param \TSMLXtras\TSMLXtras $TSMLXtras
		 */
		public function __construct( TSMLXtras $TSMLXtras ) {
			$this->TSMLXtras                 = $TSMLXtras;
			$this->plugin_directory          = $this->TSMLXtras->get_path( 'plugin_path' );
			$this->plugin_info               = $this->TSMLXtras->get_info();
			$this->filter_prefix             = $this->plugin_info['TextDomain'];
			$this->theme_template_directory  = $this->plugin_info['TextDomain'];
			$this->plugin_template_directory = $this->TSMLXtras->get_path( 'frontend_templates_path' );
		}
		
		/**
		 * Plugin name, version, etc from plugin file header.
		 *
		 * @acces protected
		 * @var array $plugin_info
		 */
		protected mixed $plugin_info;
		
		/**
		 * Prefix for filter names.
		 *
		 * @since 1.0.0
		 *
		 * @var string $filter_prefix
		 */
		protected string $filter_prefix;
		
		/**
		 * Directory name where custom templates for this plugin should be found in the theme.
		 *
		 * @since 1.0.0
		 *
		 * @var string $theme_template_directory
		 */
		protected string $theme_template_directory;
		
		/**
		 * Reference to the root directory path of this plugin.
		 *
		 * @since 1.0.0
		 *
		 * @var string $plugin_directory
		 */
		protected string $plugin_directory;
		
		/**
		 * Directory name where templates are found in this plugin.
		 *
		 * @since 1.1.0
		 *
		 * @var string $plugin_template_directory
		 */
		protected string $plugin_template_directory;
	}
}
