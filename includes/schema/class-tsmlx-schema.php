<?php
/**
 * Creates all Schema.org functionality.
 *
 * This class is instantiated and run() in the main TSMLXtras class to add
 * all schema.org realted functionality that is available within the plugin.
 *
 * @author Anthony B <anthony@bustedspring.com>
 * @version 1.0.0
 * @since 1.0.0
 * @package TSMLXtras\Schema
 */

namespace TSMLXtras\Schema;

use stdClass;
use TSMLXtras\TSMLXtras;

if ( ! class_exists( 'TSMLX_Schema' ) ) {
	class TSMLX_Schema {
		
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
			if ( $this->TSMLXtras->get_setting( 'include_schema' ) && $tsml_user_interface === 'legacy' ) {
				$this->setup_actions();
			}
		}
		
		/**
		 * Setting up action/filter hooks.
		 *
		 * @return void
		 */
		private function setup_actions(): void {
			add_action( 'wp_head', [ $this, 'add_schema' ] );
		}
		
		
		public function add_schema(): void {
			// Only do this for single posts (meeting, group, etc.)
			if ( is_single() ) {
				global $tsml_feedback_addresses, $tsml_days, $tsml_meeting_attendance_options;
				// Get post
				$post = get_post();
				// Base schema
				$schema                      = $this->base_schema_localbusiness( TRUE );
				$schema->name                = $post->post_title;
				$schema->url                 = get_post_permalink( $post->ID );
				$schema->isAccessibleForFree = TRUE;
				$schema->keywords            = "Alcoholics Anonymous Meeting, AA Meeting, Mississippi";
				$schema->email               = $tsml_feedback_addresses;
				$schema->logo                = isset( $tsmlxtras_options['tsmlx_image_id'] ) ?
					wp_get_attachment_url( $tsmlxtras_options['tsmlx_image_id'] ) :
					$this->TSMLXtras->get_path( 'plugin_url' ) . 'assets/svg/AA-fat.svg';
				
				/** Group */
				if ( get_post_type() === 'tsml_group' ) {
					// Get all meetings & location for this group
					$meetings  = tsml_get_meetings( [ 'group_id' => $post->ID ] );
					$locations = tsmlxtras_get_unique_locations( $meetings );
					
					// Set schema values
					// Set opening hours
					foreach ( $meetings as $meeting ) {
						$schema->openingHours[] = substr( $tsml_days[ $meeting['day'] ], 0, 2 ) . ' ' . $meeting['time'] . '-' . $meeting['end_time'];
					}
					foreach ( $locations as $location ) {
						// Get the unformatted address
						$unformatted_address                      = tsmlxxtras_unformat_address( $location['formatted_address'] );
						$locationSchema                           = $this->base_schema_place();
						$locationSchema->name                     = $location['location'];
						$locationSchema->latitude                 = $location['latitude'];
						$locationSchema->longitude                = $location['longitude'];
						$locationSchema->description              = $location['location_notes'];
						$locationSchema->address->addressLocality = $unformatted_address['city'];
						$locationSchema->address->addressRegion   = $unformatted_address['state'];
						$locationSchema->address->postalCode      = $unformatted_address['zip'];
						$locationSchema->address->streetAddress   = $unformatted_address['line1'];
						$locationSchema->address->addressCountry  = $unformatted_address['country'];
						$schema->location[]                       = $locationSchema;
					}
				} /** Meeting */
				elseif ( get_post_type() === 'tsml_meeting' ) {
					// Get the meeting post
					$meeting_description = $tsml_meeting_attendance_options[ $post->attendance_option ] . ', ';
					$meeting_description .= implode( ', ', $post->types_expanded ) . '. ';
					if ( ! empty( $post->post_content ) ) {
						$meeting_description .= strip_tags( $post->post_content ) . '. ';
					}
					$meeting_description .= $post->type_description;
					
					// Set schema
					$schema->description    = $meeting_description;
					$schema->publicAccess   = in_array( 'O', $post->types );
					$schema->smokingAllowed = in_array( 'SM', $post->types );
					$schema->openingHours[] = substr( $tsml_days[ $post->day ], 0, 2 ) . ' ' . $post->time . '-' . $post->end_time;
					
					if ( $post->attendance_option === 'in_person' ) {
						// Get the unformatted address
						$unformatted_address                        = tsmlxxtras_unformat_address( $post->formatted_address );
						$schema->location                           = $this->base_schema_place();
						$schema->location->name                     = $post->location;
						$schema->location->latitude                 = $post->latitude;
						$schema->location->longitude                = $post->longitude;
						$schema->location->description              = $post->location_notes;
						$schema->location->address->addressLocality = $unformatted_address['city'];
						$schema->location->address->addressRegion   = $unformatted_address['state'];
						$schema->location->address->postalCode      = $unformatted_address['zip'];
						$schema->location->address->streetAddress   = $unformatted_address['line1'];
						$schema->location->address->addressCountry  = $unformatted_address['country'];
					} elseif ( $post->attendance_option === 'online' ) {
						$schema->location            = new stdClass();
						$schema->location->{"@type"} = "VirtualLocation";
						$schema->location->{'@id'}   = $post->conference_url;
						$schema->location->url       = $post->conference_url;
					} elseif ( $post->attendance_option === 'hybrid' ) {
						// Get the unformatted address
						$unformatted_address                      = tsmlxxtras_unformat_address( $post->formatted_address );
						$locationSchema                           = $this->base_schema_place();
						$locationSchema->name                     = $post->location;
						$locationSchema->latitude                 = $post->latitude;
						$locationSchema->longitude                = $post->longitude;
						$locationSchema->description              = $post->location_notes;
						$locationSchema->address->addressLocality = $unformatted_address['city'];
						$locationSchema->address->addressRegion   = $unformatted_address['state'];
						$locationSchema->address->postalCode      = $unformatted_address['zip'];
						$locationSchema->address->streetAddress   = $unformatted_address['line1'];
						$locationSchema->address->addressCountry  = $unformatted_address['country'];
						$virtualSchema                            = new stdClass();
						$virtualSchema->{"@type"}                 = "VirtualLocation";
						$virtualSchema->url                       = $post->conference_url;
						$schema->location                         = [
							$locationSchema,
							$virtualSchema,
						];
					}
				}
				?>
				<script id="tsmlx-schema" type="application/ld+json"><?php echo json_encode( $schema, JSON_UNESCAPED_SLASHES ); ?></script>
				<?php
			}
		}
		
		/**
		 * Returns base schema for Organization.
		 *
		 * @param bool $context Whether to return @context
		 *
		 * @return \stdClass
		 */
		private function base_schema_organization( bool $context = FALSE ): stdClass {
			$schema = new stdClass();
			if ( $context ) {
				$schema->{"@context"} = "https://schema.org";
			}
			$schema->{"@type"}   = "Organization";
			$schema->description = "Alcoholics Anonymous Group";
			
			return $schema;
		}
		
		/**
		 * Returns base schema for LocalBusiness.
		 *
		 * @param bool $context Whether to return @context
		 *
		 * @return \stdClass
		 */
		private function base_schema_localbusiness( bool $context = FALSE ): stdClass {
			$schema = new stdClass();
			if ( $context ) {
				$schema->{"@context"} = "https://schema.org";
			}
			$schema->{"@type"}   = "LocalBusiness";
			$schema->description = "Alcoholics Anonymous Group";
			
			return $schema;
		}
		
		/**
		 * Returns base schema for Event.
		 *
		 * @param bool $context Whether to return @context
		 *
		 * @return \stdClass
		 */
		private function base_schema_event( bool $context = FALSE ): stdClass {
			global $tsmlxtras_options;
			$schema = new stdClass();
			if ( $context ) {
				$schema->{"@context"} = "https://schema.org";
			}
			$schema->{"@type"}           = "Event";
			$schema->eventStatus         = "https://schema.org/EventScheduled";
			$schema->organizer           = $this->base_schema_organization();
			$schema->image               = isset( $tsmlxtras_options['tsmlx_image_id'] ) ?
				wp_get_attachment_url( $tsmlxtras_options['tsmlx_image_id'] ) :
				$this->TSMLXtras->get_path( 'plugin_url' ) . 'assets/svg/AA-fat.svg';
			$schema->isAccessibleForFree = TRUE;
			
			return $schema;
		}
		
		/**
		 * Returns base schema for Place.
		 *
		 * @param bool $context Whether to return @context
		 *
		 * @return \stdClass
		 */
		private function base_schema_place( bool $context = FALSE ): stdClass {
			$schema = new stdClass();
			if ( $context ) {
				$schema->{"@context"} = "https://schema.org";
			}
			$schema->{"@type"} = "Place";
			$schema->address   = $this->base_schema_address();
			
			return $schema;
		}
		
		/**
		 * Returns base schema for Address.
		 *
		 * @param bool $context Whether to return @context
		 *
		 * @return \stdClass
		 */
		private function base_schema_address( bool $context = FALSE ): stdClass {
			$schema = new stdClass();
			if ( $context ) {
				$schema->{"@context"} = "https://schema.org";
			}
			$schema->{"@type"} = "PostalAddress";
			
			return $schema;
		}
		
		/**
		 * Returns base schema for Schedule.
		 *
		 * @param bool $context Whether to return @context
		 *
		 * @return \stdClass
		 */
		private function base_schema_schedule( bool $context = FALSE ): stdClass {
			$schema = new stdClass();
			if ( $context ) {
				$schema->{"@context"} = "https://schema.org";
			}
			$schema->{"@type"} = "Schedule";
			// Set start date to yesterday and end date 1 year from now
			$schema->startDate        = date( 'Y-m-d', strtotime( "-1 days" ) );
			$schema->endDate          = date( 'Y-m-d', strtotime( '+1 year' ) );
			$schema->repeatFrequency  = "P1W";
			$schema->scheduleTimezone = get_option( 'timezone_string' );
			
			return $schema;
		}
		
		/**
		 * Returns base schema for Offers.
		 *
		 * @param bool $context Whether to return @context
		 *
		 * @return \stdClass
		 */
		private function base_schema_offers( bool $context = FALSE ): stdClass {
			$schema = new stdClass();
			if ( $context ) {
				$schema->{"@context"} = "https://schema.org";
			}
			$schema->{"@type"} = "Offer";
			// Set start date to yesterday and end date 1 year from now
			$schema->availability  = "https://schema.org/InStock";
			$schema->price         = 0;
			$schema->priceCurrency = "USD";
			
			return $schema;
		}
	}
}
