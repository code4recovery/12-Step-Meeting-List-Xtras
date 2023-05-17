<?php
/**
 * Main class that sets all functionality in motion.
 *
 * This class is instantiated and run() from the main TSMLXtras plugin file to
 * enable & manage all plugin functionality.
 *
 * @author Anthony B <anthony@bustedspring.com>
 * @version 1.0.0
 * @since 1.0.0
 * @package TSMLXtras
 */

namespace TSMLXtras;

use TSMLXtras\Admin\TSMLX_Admin;
use TSMLXtras\Blocks\TSMLX_Blocks;
use TSMLXtras\DisableMeetingsPage\TSMLX_Disable_Meetings_Page;
use TSMLXtras\Schema\TSMLX_Schema;
use TSMLXtras\SEO\TSMLX_Yoast_SEO;
use TSMLXtras\Shortcodes\TSMLX_Shortcodes;
use TSMLXtras\Xtrafields\TSMLX_Xtrafields;

if ( ! class_exists( 'TSMLXtras' ) ) {
	class TSMLXtras  {
		
		/**
		 * All paths associated with this plugin.
		 *
		 * @acces protected
		 * @var array $paths
		 */
		protected $paths;
		
		/**
		 * Plugin name, version, etc from plugin file header.
		 *
		 * @acces protected
		 * @var array $plugin_info
		 */
		protected $plugin_info;
		
		/**
		 * Settings for this plugin.
		 *
		 * @acces protected
		 * @var array $plugin_options
		 */
		protected $plugin_options;
		
		/**
		 * Blocks made available by the plugin.
		 *
		 * @var \TSMLXtras\Blocks\TSMLX_Blocks $blocks
		 */
		protected $blocks;

		/**
		 * Admin settings page class.
		 *
		 * @var \TSMLXtras\Admin\TSMLX_Admin $admin
		 */
		protected $admin;
		
		/**
		 * Shortcodes made available by the plugin.
		 *
		 * @var \TSMLXtras\Shortcodes\TSMLX_Shortcodes $shortcodes
		 */
		protected $shortcodes;
		
		/**
		 * Disable main meetings page functionality.
		 *
		 * @var \TSMLXtras\DisableMeetingsPage\TSMLX_Disable_Meetings_Page $disable_meetings_page
		 */
		protected $disable_meetings_page;
		
		/**
		 * Custom fields.
		 *
		 * @var \TSMLXtras\Xtrafields\TSMLX_Xtrafields $xtra_fields
		 */
		protected $xtra_fields;
		
		/**
		 * Yoast SEO.
		 *
		 * @var \TSMLXtras\SEO\TSMLX_Yoast_SEO $seo
		 */
		protected $seo;
		
		/**
		 * Add Schema.org markup.
		 *
		 * @var \TSMLXtras\Schema\TSMLX_Schema $schema
		 */
		protected $schema;
		
		/**
		 * Constructor.
		 *
		 * @param string $plugin __FILE__ variable for the main plugin file.
		 */
		public function __construct( $plugin, $plugin_options ) {
			// Full path to main plugin file
			$this->paths['plugin'] = $plugin;
			
			// Path to plugin file, relative to plugins directory
			$this->paths['plugin_basename'] = plugin_basename($plugin);
			
			// Full path to plugin folder
			$this->paths['plugin_path'] = plugin_dir_path($plugin);
			
			// URL to plugin folder
			$this->paths['plugin_url'] = plugin_dir_url($plugin);
			
			// Directory where admin templates are found, relative to templates directory
			$this->paths['admin_templates_path'] = 'templates/admin/';
			
			// Directory where frontend templates are found, relative to templates directory
			$this->paths['frontend_templates_path'] = 'templates/frontend/';
			
			// Plugin name, version, etc from plugin file header
			$this->plugin_info = get_plugin_data($this->get_path('plugin'), FALSE );
			
			// Add Short Name to info
			$this->plugin_info['ShortName'] = 'TSML Xtras';
			
			// Settings
			$this->plugin_options = $plugin_options;
			
			// Run methods for what's needed
			$this->load_dependencies();
		}
		
		/**
		 * Load dependent classes.
		 *
		 * @return void
		 */
		private function load_dependencies() {
			$this->admin                    = new TSMLX_Admin($this);
			$this->blocks                   = new TSMLX_Blocks();
			$this->disable_meetings_page    = new TSMLX_Disable_Meetings_Page($this);
			$this->shortcodes               = new TSMLX_Shortcodes($this);
			$this->seo                      = new TSMLX_Yoast_SEO($this);
			$this->schema                   = new TSMLX_Schema($this);
			$this->xtra_fields              = new TSMLX_Xtrafields($this);
		}
		
		/**
		 * Sets this class into motion.
		 *
		 * Executes the plugin by calling the run method of classes.
		 *
		 * @return void
		 */
		public function run() {
			$this->admin->run();
			$this->shortcodes->run();
			$this->disable_meetings_page->run();
			$this->xtra_fields->run();
			$this->blocks->run();
			$this->seo->run();
			$this->schema->run();
		}
		
		// ======== GETTERS/SETTERS ======== //
		/**
		 * Get a path from paths array.
		 *
		 * @param string $key Key to path in paths array
		 *
		 * @return mixed
		 */
		public function get_path($key = '') {
			if (empty($key)) {
				return $this->paths;
			}
			return $this->paths[$key];
		}
		
		/**
		 * Get info from plugin_info array.
		 *
		 * @param string $key Key to info in plugin_info array
		 *
		 * @return mixed
		 */
		public function get_info($key = '') {
			if (empty($key)) {
				return $this->plugin_info;
			}
			return $this->plugin_info[$key];
		}
		
		/**
		 * Get a setting from plugin_options array.
		 *
		 * @param string $key Key to setting in plugin_options array
		 *
		 * @return mixed
		 */
		public function get_setting($key = '') {
            // All options.
			if (empty($key)) {
				return $this->plugin_options;
			}
            // Specific option or false
			if (empty($this->plugin_options[$key])) {
				return false;
			}
			return $this->plugin_options[$key];
		}
		
		/**
		 * Transforms the slug in useful ways (uppercase, underscores, etc.).
		 *
		 * @param array $type Use one or multiple types to transform
		 *
		 * @return string
		 */
		public function get_slug($type = '') {
			// If no type is sent, then just return the slug
			if ( empty($type))
				return $this->plugin_info['TextDomain'];
			// Loop through types and transform
			$slug = $this->plugin_info['TextDomain'];
			switch ($type):
				case 'upper':
					$slug = strtoupper($slug);
					break;
				case 'underscores':
					$slug = str_replace('-', '_', $slug);
					break;
				endswitch;
			return $slug;
		}
	}
}
