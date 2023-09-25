<?php
/**
 * Fired during plugin activation,
 *
 * Prevents activation of this plugin if 12 Step Meeting List isn't active. If
 * the 12 Step Meeting List is active, save default settings in database.
 *
 * @since      1.0.0
 * @package    TSMLXtras\Utility\TSMLX_Activator
 * @author     Anthony B <anthony@bustedspring.com>
 */

namespace TSMLXtras\Utility;

if ( ! class_exists( 'TSMLX_Activator' ) ) {
	class TSMLX_Activator {
		
		/**
		 * Path to plugin file, relative to plugins directory.
		 *
		 * @var string $txmlxtras_plugin_basename
		 */
		protected string $txmlxtras_plugin_basename;
		
		/**
		 * Path relative to plugins folder of required plugin.
		 *
		 * @var string $required_plugin ;
		 */
		protected string $required_plugin;
		
		/**
		 * Constructor.
		 *
		 * @param string $txmlxtras_plugin_basename Path to plugin file, relative to plugins directory.
		 * @param string $required_plugin Path relative to plugins folder of required plugin.
		 */
		public function __construct( string $txmlxtras_plugin_basename, string $required_plugin ) {
			$this->txmlxtras_plugin_basename = $txmlxtras_plugin_basename;
			$this->required_plugin           = $required_plugin;
		}
		
		/**
		 * Checks requiresments and returns true/false.
		 *
		 * @return bool Are the requirements met?
		 */
		public function check_requirements(): bool {
			// get is_plugin_active() function
			require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
			// Ensure plugin is active first
			if ( ! is_plugin_active( $this->required_plugin ) ) {
				deactivate_plugins( $this->txmlxtras_plugin_basename );
				add_action( 'admin_notices', [
					$this,
					'parent_plugin_not_active_notice',
				] );
				if ( isset( $_GET['activate'] ) ) {
					unset( $_GET['activate'] );
				}
				
				return FALSE;
			} else {
				if ( get_option( 'tsmlxtras_settings' ) === FALSE ) {
					// Default settings
					$base_options = [
						'tsmlx_image_id'  => NULL,
						'notes_above'     => '',
						'notes_below'     => '',
						'header_color'    => '#046bd2',
						'header_invert'   => true,
						'primary_color'   => '#334155',
						'secondary_color' => '#045cb4',
						'tertiary_color'  => '#a51f1f',
					];
					// Set default settings in DB
					update_option( 'tsmlxtras_settings', $base_options );
				}
				
				return TRUE;
			}
		}
		
		/**
		 * Echo's notice in admin if requirements aren't met.
		 *
		 * @return void
		 */
        public static function parent_plugin_not_active_notice(): void {
            $class = 'notice notice-error';
            $message = 'The TSML Xtras plugin requires the <a href="%s">12 Step Meeting List plugin</a> to be active. Please activate the 12 Step Meeting List plugin and try again.';

            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), sprintf($message, './plugin-install.php?s=12%2520Step%2520Meeting%2520List&tab=search&type=term') );
        }
	}
}
