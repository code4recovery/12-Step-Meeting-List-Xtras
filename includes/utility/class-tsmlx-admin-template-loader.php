<?php
/**
 * Loads and parses templates in templates/admin.
 *
 * Used in class-forms.php & class-admin.php
 *
 * @author Anthony B <anthony@bustedspring.com>
 * @version 1.0.0
 * @since 1.0.0
 * @package TSMLXtras\Utility\TSMLX_Admin_Template_Loader
 */

namespace TSMLXtras\Utility;

use TSMLXtras\TSMLXtras;

if ( ! class_exists( 'TSMLX_Admin_Template_Loader' ) ) {
	class TSMLX_Admin_Template_Loader extends Gamajo_Template_Loader {
		
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
		 * @param \TSMLXtras\TSMLXtras $TSMLXtras .
		 */
		public function __construct( TSMLXtras $TSMLXtras ) {
			$this->TSMLXtras                 = $TSMLXtras;
			$this->plugin_directory          = $TSMLXtras->get_path( 'plugin_path' );
			$this->plugin_info               = $this->TSMLXtras->get_info();
			$this->filter_prefix             = $this->plugin_info['TextDomain'];
			$this->theme_template_directory  = $this->plugin_info['TextDomain'];
			$this->plugin_template_directory = $this->TSMLXtras->get_path( 'admin_templates_path' );
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
		
		/**
		 * Return a list of paths to check for template locations.
		 *
		 * Default is to check in a child theme (if relevant) before a parent theme, so that themes which inherit from a
		 * parent theme can just overload one file. If the template is not found in either of those, it looks in the
		 * theme-compat folder last. Overridden to prevent theme versions of admin teplates.
		 *
		 * @return array
		 * @since 1.0.0
		 *
		 */
		protected function get_template_paths(): array {
			$theme_directory = trailingslashit( $this->theme_template_directory );
			
			$file_paths = [
				100 => $this->get_templates_dir(),
			];
			
			// Only add this conditionally, so non-child themes don't redundantly check active theme twice.
			if ( get_stylesheet_directory() !== get_template_directory() ) {
				$file_paths[1] = trailingslashit( get_stylesheet_directory() ) . $theme_directory;
			}
			
			/**
			 * Allow ordered list of template paths to be amended.
			 *
			 * @param array $var Default is directory in child theme at index 1, parent theme at 10, and plugin at 100.
			 *
			 * @since 1.0.0
			 *
			 */
			$file_paths = apply_filters( $this->filter_prefix . '_template_paths', $file_paths );
			
			// Sort the file paths based on priority.
			ksort( $file_paths, SORT_NUMERIC );
			
			return array_map( 'trailingslashit', $file_paths );
		}
	}
}
