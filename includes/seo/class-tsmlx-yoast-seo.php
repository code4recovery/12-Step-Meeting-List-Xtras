<?php
/**
 * Creates all SEO functionality.
 *
 * This class is instantiated and run() in the main TSMLXtras class to add
 * all SEO related functionality that is available within the plugin.
 *
 * @author Anthony B <anthony@bustedspring.com>
 * @version 1.0.0
 * @since 1.0.0
 * @package TSMLXtras\SEO
 */

namespace TSMLXtras\SEO;

use TSMLXtras\TSMLXtras;

if ( ! class_exists( 'TSMLX_Yoast_SEO' ) ) {
	class TSMLX_Yoast_SEO {
		
		/**
		 *
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
			$this->TSMLXtras = $TSMLXtras;
		}
		
		/**
		 * Sets this class into motion.
		 *
		 * Executes the plugin by calling the run method of classes.
		 *
		 * @return void
		 */
		public function run(): void {
			global $tsml_user_interface;
			if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) && $tsml_user_interface === 'legacy' ) {
				$this->setup_actions();
			}
		}
		
		/**
		 * Setting up action/filter hooks.
		 *
		 * @return void
		 */
		private function setup_actions(): void {
			add_action( 'wpseo_register_extra_replacements', [
				$this,
				'add_vars',
			] );
		}
		
		/**
		 * Registers variable replacement function.
		 *
		 * @return void
		 */
		public function add_vars(): void {
			wpseo_register_var_replacement( '%%tsml_meetingdate%%', [
				$this,
				'meetingdaytime_var',
			], 'advanced', 'Add the meeting day/time' );
			wpseo_register_var_replacement( '%%tsml_city%%', [
				$this,
				'city_var',
			], 'advanced', 'Add the meeting city' );
			wpseo_register_var_replacement( '%%tsml_state%%', [
				$this,
				'state_var',
			], 'advanced', 'Add the meeting state' );
			wpseo_register_var_replacement( '%%tsml_citystate%%', [
				$this,
				'citystate_var',
			], 'advanced', 'Add the meeting state' );
			wpseo_register_var_replacement( '%%tsml_group%%', [
				$this,
				'group_var',
			], 'advanced', 'Add the meeting group' );
		}
		
		/**
		 * Outputs meeting day & time variable.
		 *
		 * @return string
		 */
		public function meetingdaytime_var(): string {
			$queried_object = get_queried_object();
			if ( $queried_object->post_type === 'tsml_meeting' ) {
				global $tsml_days;
				$day        = $tsml_days[ $queried_object->day ];
				$start_time = $queried_object->time;
				
				return $day . ' ' . tsml_format_time( $start_time );
			}
			
			return '';
		}
		
		/**
		 * Outputs city variable.
		 *
		 * @return string
		 */
		public function city_var(): string {
			$queried_object = get_queried_object();
			if ( $queried_object->post_type === 'tsml_meeting' ) {
				$location_array = tsmlxxtras_unformat_address( $queried_object->formatted_address, $queried_object->location );
				
				return $location_array['city'];
			}
			if ( $queried_object->post_type === 'tsml_group' ) {
				$city = '';
				// Get all meetings for group
				$meetings  = tsml_get_meetings( [ 'group_id' => $queried_object->ID ] );
				$locations = tsmlxtras_get_unique_locations( $meetings );
				$counter   = 1;
				foreach ( $locations as $location ) {
					$location_array = tsmlxxtras_unformat_address( $location['formatted_address'] );
					$city           .= $location_array['city'];
					if ( count( $locations ) > $counter ) {
						$city .= '/';
					}
					$counter ++;
				}
				
				return $city;
			}
			
			return '';
		}
		
		/**
		 * Outputs state variable.
		 *
		 * @return string
		 */
		public function state_var(): string {
			$queried_object = get_queried_object();
			if ( $queried_object->post_type === 'tsml_meeting' ) {
				$location_array = tsmlxxtras_unformat_address( $queried_object->formatted_address, $queried_object->location );
				
				return $location_array['state'];
			}
			if ( $queried_object->post_type === 'tsml_group' ) {
				$state = '';
				// Get all meetings for group
				$meetings  = tsml_get_meetings( [ 'group_id' => $queried_object->ID ] );
				$locations = tsmlxtras_get_unique_locations( $meetings );
				$counter   = 1;
				foreach ( $locations as $location ) {
					$location_array = tsmlxxtras_unformat_address( $location['formatted_address'] );
					$state          .= $location_array['state'];
					if ( count( $locations ) > $counter ) {
						$state .= '/';
					}
					$counter ++;
				}
				
				return $state;
			}
			
			return '';
		}
		
		/**
		 * Outputs city & state variable.
		 *
		 * @return string
		 */
		public function citystate_var(): string {
			$queried_object = get_queried_object();
			if ( $queried_object->post_type === 'tsml_meeting' ) {
				$location_array = tsmlxxtras_unformat_address( $queried_object->formatted_address, $queried_object->location );
				
				return $location_array['city'] . ', ' . $location_array['state'];
			}
			if ( $queried_object->post_type === 'tsml_group' ) {
				$state = '';
				// Get all meetings for group
				$meetings  = tsml_get_meetings( [ 'group_id' => $queried_object->ID ] );
				$locations = tsmlxtras_get_unique_locations( $meetings );
				$counter   = 1;
				foreach ( $locations as $location ) {
					$location_array = tsmlxxtras_unformat_address( $location['formatted_address'] );
					$state          .= $location_array['city'] . ', ' . $location_array['state'];
					if ( count( $locations ) > $counter ) {
						$state .= '/';
					}
					$counter ++;
				}
				
				return $state;
			}
			
			return '';
		}
		
		/**
		 * Outputs group variable.
		 *
		 * @return string
		 */
		public function group_var(): string {
			$queried_object = get_queried_object();
			if ( $queried_object->post_type === 'tsml_meeting' ) {
				return $queried_object->group;
			}
			
			return '';
		}
	}
}
