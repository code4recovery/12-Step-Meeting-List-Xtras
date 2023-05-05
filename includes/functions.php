<?php
/**
 * Helper functions used in various places
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'tsmlx_array_insert' ) ) {
	/**
	 * @param array $array
	 * @param int|string $position
	 * @param mixed $insert
	 */
	function tsmlx_array_insert( &$array, $position, $insert ) {
		if ( is_int( $position ) ) {
			array_splice( $array, $position, 0, $insert );
		} else {
			$pos   = array_search( $position, array_keys( $array ) );
			$array = array_merge(
				array_slice( $array, 0, $pos ),
				$insert,
				array_slice( $array, $pos )
			);
		}
	}
}

if ( ! function_exists( 'tsmlx_get_program' ) ) {
	/**
	 * Returns the name of the program as configured in TSML
	 *
	 * @param string $format short/long
	 *
	 * @return mixed|string
	 */
	function tsmlx_get_program( $format = 'short' ) {
		global $tsml_program, $tsml_programs;
		if ( $format === 'long' ) {
			return $tsml_programs[ $tsml_program ]['name'];
		} else {
			return strtoupper( $tsml_program );
		}
	}
}

if ( ! function_exists( 'tsmlxxtras_unformat_address' ) ) {
	/**
	 * Breaks a US address into an array
	 *
	 * @param $formatted_address
	 * @param null $loc_name
	 * @param false $street_only
	 *
	 * @return array|mixed|string|null
	 */
	function tsmlxxtras_unformat_address( $formatted_address, $loc_name = NULL, bool $street_only = FALSE ) {
		$parts = explode( ',', esc_attr( $formatted_address ) );
		$parts = array_map( 'trim', $parts );
		// US Addresses
		if ( in_array( end( $parts ), [ 'USA', 'US' ] ) ) {
			$address['loc']     = $loc_name;
			$address['line1']   = $parts[0];
			$address['city']    = $parts[1];
			$statezip           = explode( ' ', $parts[2] );
			$address['state']   = $statezip[0];
			$address['zip']     = $statezip[1];
			$address['country'] = $parts[3];
			array_pop( $parts );
			if ( count( $parts ) > 1 ) {
				$state_zip                    = array_pop( $parts );
				$parts[ count( $parts ) - 1 ] .= ', ' . $state_zip;
			}
		}
		if ( $street_only ) {
			return array_shift( $parts );
		}
		
		return $address;
	}
}

if ( ! function_exists( 'tsmlxtras_format_address' ) ) {
	/**
	 * Reformats a group address using an overridable template
	 * See: partials/address.php
	 *
	 * @param $formatted_address
	 * @param $template_loader
	 * @param null $loc_name
	 * @param string $location_notes
	 * @param bool $street_only
	 *
	 * @return string|void
	 */
	function tsmlxtras_format_address( $formatted_address, $template_loader, $loc_name = NULL, $location_notes = '', $street_only = FALSE ) {
		$address                   = tsmlxxtras_unformat_address( $formatted_address );
		$address['location_notes'] = $location_notes;
		
		$template_loader->set_template_data( $address );
		$template_loader->get_template_part( 'partials/address' );
	}
}

if ( ! function_exists( 'tsmlxtras_get_gmapscript' ) ) {
	/**
	 * Returns google maps script setup
	 *
	 * @return void
	 */
	function tsmlxtras_get_gmapscript( $template_loader ) {
		global $tsml_google_maps_key, $tsmlxtras_options;
		
		$data['gmap_id']  = $tsmlxtras_options['gmap_id'];
		$data['gmap_key'] = $tsml_google_maps_key;
		
		$template_loader->set_template_data( $data );
		$template_loader->get_template_part( 'partials/gmap-script' );
	}
}

if ( ! function_exists( 'tsmlxtras_get_typesbadges' ) ) {
	/**
	 * Reformats a meeting types as badges using an overridable template
	 *
	 * @return void
	 */
	function tsmlxtras_get_typesbadges( $types, $template_loader, $styles = '' ) {
		$data['types'] = $types;
		$data['styles'] = $styles;
		
		$template_loader->set_template_data( $data );
		$template_loader->get_template_part( 'partials/meeting-types-badges' );
	}
}

if ( ! function_exists( 'tsmlxtras_get_calendardisplay' ) ) {
	/**
	 * Returns calendar style day/time using an overridable template
	 */
	function tsmlxtras_get_calendardisplay( $day, $time, $template_loader ) {
		$data['daytime']  = $time;
		$data['day']      = substr( $day, 0, 3 );
		$timearray        = explode( ' ', $time );
		$data['time']     = $timearray[0];
		$data['meridiem'] = $timearray[1];
		
		$template_loader->set_template_data( $data );
		$template_loader->get_template_part( 'partials/day-time' );
	}
}

if ( ! function_exists( 'tsmlxtras_get_basketbutton' ) ) {
	/**
	 * Returns a single digital basket button using an overridable template
	 */
	function tsmlxtras_get_basketbutton( $service_key, $service_data, $username, $template_loader ) {
		$data = [
			'service_key'  => $service_key,
			'service_url'  => $service_data['url'],
			'username'     => $username,
			'service_name' => $service_data['name'],
		];
		$template_loader->set_template_data( $data );
		$template_loader->get_template_part( 'partials/digital-basket-button' );
	}
}
if ( ! function_exists( 'tsmlxtras_get_colors' ) ) {
	/**
	 * Returns stylesheet with root color variables from config
	 */
	function tsmlxtras_get_colors( $template_loader ) {
		global $tsmlxtras_options;

		$header_rgb = hex2rgb( $tsmlxtras_options['header_color'] );
		$primary_rgb = hex2rgb( $tsmlxtras_options['primary_color'] );
		$secondary_rgb = hex2rgb( $tsmlxtras_options['secondary_color'] );
		$tertiary_rgb = hex2rgb( $tsmlxtras_options['tertiary_color'] );
		$header_hsl = rgbToHsl( $header_rgb['r'], $header_rgb['g'], $header_rgb['b'] );
		$primary_hsl = rgbToHsl( $primary_rgb['r'], $primary_rgb['g'], $primary_rgb['b'] );
		$secondary_hsl = rgbToHsl( $secondary_rgb['r'], $secondary_rgb['g'], $secondary_rgb['b'] );
		$tertiary_hsl = rgbToHsl( $tertiary_rgb['r'], $tertiary_rgb['g'], $tertiary_rgb['b'] );

		$data['header_color']['hex']   = $tsmlxtras_options['header_color'];
		$data['primary_color']['hex']   = $tsmlxtras_options['primary_color'];
		$data['secondary_color']['hex'] = $tsmlxtras_options['secondary_color'];
		$data['tertiary_color']['hex']  = $tsmlxtras_options['tertiary_color'];
		$data['header_color']['rgb']   = $header_rgb;
		$data['primary_color']['rgb']   = $primary_rgb;
		$data['secondary_color']['rgb'] = $secondary_rgb;
		$data['tertiary_color']['rgb']  = $tertiary_rgb;
		$data['header_color']['hsl']   = $header_hsl;
		$data['primary_color']['hsl']   = $primary_hsl;
		$data['secondary_color']['hsl'] = $secondary_hsl;
		$data['tertiary_color']['hsl']  = $tertiary_hsl;

		$template_loader->set_template_data( $data );
		$template_loader->get_template_part( 'partials/stylesheet-colors' );
	}
}

if ( ! function_exists( 'tsmlxtras_sortby_currentday_first' ) ) {
	/**
	 * Re-orders a meetings array with currend day of week forst, then other
	 * days following in chronological order
	 *
	 * @param $meetings
	 * @param $daynum
	 *
	 * @return array
	 */
	function tsmlxtras_sortby_currentday_first( $meetings, $daynum ) {
		// Set empty arrays
		// $now_to_end_of_week = $daynum forward to saturday
		// $beginning_to_now = Sunday to dey before $beginning_to_now
		// Slice $meetings array into 2 peices between $daynum and reassemble
		if ( array_key_exists( $daynum, $meetings ) ) {
			$offset = array_search($daynum, array_keys($meetings), true);
			$now_to_end_of_week = array_slice( $meetings, $offset, null, TRUE );
			$beginning_to_now   = array_slice( $meetings, 0, $daynum, TRUE );

			return $now_to_end_of_week + $beginning_to_now;
		}
	}
}

if ( ! function_exists( 'tsmlx_get_regions_list' ) ) {
	/**
	 * Renders an unordered, hierarchical list of all regions
	 *
	 * @param array $args Array of arguments
	 *
	 * @return void
	 */
	function tsmlx_get_regions_list( $args ) {
		$showcount = FALSE;
		if ( array_key_exists( 'showCount', $args ) ) {
			$showcount = TRUE;
		}
		echo wp_list_categories( [
			'taxonomy'   => 'tsml_region',
			'show_count' => $showcount,
			'title_li'   => '<h3>' . __( 'Regions', 'textdomain' ) . '</h3>',
		] );
	}
}

if ( ! function_exists( 'tsmlxtras_get_unique_locations' ) ) {
	/**
	 * Get unique location(s) from an array of meetings
	 */
	function tsmlxtras_get_unique_locations( $meetings = NULL ) {
		if ( empty( $meetings ) ) {
			return;
		}
		$locations = [];
		foreach ( $meetings as $meeting ) {
			$locations[ $meeting['location_id'] ] = [
				'location'          => $meeting['location'],
				'location_notes'    => $meeting['location_notes'],
				'location_url'      => $meeting['location_url'],
				'formatted_address' => $meeting['formatted_address'],
				'approximate'       => $meeting['approximate'],
				'latitude'          => $meeting['latitude'],
				'longitude'         => $meeting['longitude'],
				'region_id'         => $meeting['region_id'],
				'region'            => $meeting['region'],
			];
		}
		
		return $locations;
	}
}

if ( ! function_exists( 'tsmlxtras_expand_meeting_types' ) ) {
	/**
	 * Get's the allowed types based on the chosen program (AA, NA, etc.)
	 *
	 * @param $types
	 *
	 * @return array
	 */
	function tsmlxtras_expand_meeting_types( $types, $types_order ) {
		error_log(print_r($types, 1));
		error_log(print_r($types_order, 1));
		global $tsml_programs, $tsml_program;
		foreach ($types_order as $order => $type) {
			if ($type['key'] === 'ONL' || $type['key'] === 'TC') {
				continue;
			}

			if (in_array($type['key'], $types)) {
				$types_expanded[] = $type['label'];
			}
		}

		return $types_expanded;
	}
}

if ( ! function_exists( 'hex2rgb' ) ) {
	/**
	 * Convert hex color values to rgb
	 *
	 * @param $hex
	 *
	 * @return array
	 */
	function hex2rgb( $hex ) {
		$hex = str_replace( "#", "", $hex );
		
		if ( strlen( $hex ) == 3 ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}
		
		//return implode(",", $rgb); // returns the rgb values separated by commas
		return [ 'r' => $r, 'g' => $g, 'b' => $b ]; // returns an array with the rgb values
	}
}

if ( ! function_exists( 'rgbToHsl' ) ) {
	function rgbToHsl( $r, $g, $b ) {
		$oldR = $r;
		$oldG = $g;
		$oldB = $b;

		$r /= 255;
		$g /= 255;
		$b /= 255;

		$max = max( $r, $g, $b );
		$min = min( $r, $g, $b );

		$h;
		$s;
		$l = ( $max + $min ) / 2;
		$d = $max - $min;

		if( $d == 0 ){
			$h = $s = 0; // achromatic
		} else {
			$s = $d / ( 1 - abs( 2 * $l - 1 ) );

			switch( $max ){
				case $r:
					$h = 60 * fmod( ( ( $g - $b ) / $d ), 6 );
					if ($b > $g) {
						$h += 360;
					}
					break;

				case $g:
					$h = 60 * ( ( $b - $r ) / $d + 2 );
					break;

				case $b:
					$h = 60 * ( ( $r - $g ) / $d + 4 );
					break;
			}
		}
		return array( round( $h, 2 ), (round( $s, 2 )*100) . '%', (round( $l, 2 )*100) . '%' );
	}
}

if ( ! function_exists( 'tsml_xtras_get_classes' ) ) {
	/**
	 * Gets predefined and repeating classes.
	 *
	 * @param $which
	 *
	 * @return string
	 */
	function tsml_xtras_get_classes( $which = '' ) {
		if ( ! empty( $which ) ) {
			$classes = [
				'card'             	       => 'tw-border tw-border-l-4 tw-border-tsmlx-primary/10 tw-border-l-tsmlx-primary tw-bg-tsmlx-primary/5 tw-rounded-sm tw-h-full',
				'card_header'      		   => 'tw-flex tw-flex-row tw-gap-1 tw-items-center tw-py-2 tw-px-4 tw-pb-2 tw-mb-0 tw-border-b tw-bg-tsmlx-primary/10',
				'card_header_svg'  		   => 'tw-flex',
				'card_header_text' 		   => 'tw-mb-0 tw-inline-block tw-font-bold',
				'button'	   	   		   => 'tw-inline-flex tw-items-center tw-gap-1 tw-px-2 tw-py-1 tw-border tw-rounded tw-uppercase tw-font-bold tw-text-xs tw-tracking-wider tw-no-underline',
				'button_secondary' 		   => 'tw-text-white tw-bg-tsmlx-secondary/80 hover:tw-bg-tsmlx-secondary',
				'button_secondary_outline' => 'tw-text-tsmlx-secondary tw-border-tsmlx-secondary tw-border hover:tw-bg-tsmlx-secondary hover:tw-text-white',
				'button_primary'   		   => 'tw-text-white tw-bg-tsmlx-primary/80 hover:tw-bg-tsmlx-primary',
				'button_primary_outline'   => 'tw-text-tsmlx-primary tw-border-tsmlx-primary tw-border hover:tw-bg-tsmlx-primary hover:tw-text-white',
				'badge'			   		   => 'tw-whitespace-nowrap tw-inline tw-rounded-full tw-py-0.5 tw-px-2 tw-leading-3 tw-uppercase tw-font-bold tw-tracking-wider tw-text-xs',
				'notes'			   		   => 'tw-border tw-bg-tsmlx-primary/5 tw-border-tsmlx-primary/10 tw-border-solid tw-my-4 tw-p-2 tw-text-sm tw-rounded-none tw-shadow-sm tw-whitespace-normal',
			];
			if ( array_key_exists( $which, $classes ) ) {
				return $classes[ $which ];
			}
			
		}
		
		return '';
	}
}

if ( ! function_exists( 'tsmlx_groups_metabox_embedded' ) ) {
	/**
	 * Generates group form with Group ID field for meetings admin page.
	 * @todo refactor to use forms class
	 *
	 * @return void
	 */
	function tsmlx_groups_metabox_embedded(): void {
		global $tsml_contact_display;
		$meeting  = tsml_get_meeting();
		$meetings = [];
		$district = 0;
		if ( ! empty( $meeting->group_id ) ) {
			$meetings = tsml_get_meetings( [ 'group_id' => $meeting->group_id ] );
			$district = wp_get_post_terms( $meeting->group_id, 'tsml_district', [ 'fields' => 'ids' ] );
			if ( is_array( $district ) ) {
				$district = empty( $district ) ? 0 : $district[0];
			}
		}
		?>
		<div id="contact-type" data-type="<?php echo empty( $meeting->group ) ? 'meeting' : 'group' ?>">
			<div class="meta_form_row radio">
				<label>
					<input type="radio" name="group_status" value="meeting" <?php checked( empty( $meeting->group ) ) ?>>
					<?php _e( 'Individual meeting', '12-step-meeting-list' ) ?>
				</label>
				<label>
					<input type="radio" name="group_status" value="group" <?php checked( ! empty( $meeting->group ) ) ?>>
					<?php _e( 'Part of a group', '12-step-meeting-list' ) ?>
				</label>
			</div>
			<div class="meta_form_row group-visible">
				<label for="group"><?php _e( 'Group', '12-step-meeting-list' ) ?></label>
				<input type="text" name="group" id="group" value="<?php tsml_echo( $meeting, 'group' ) ?>">
			</div>
			<div class="meta_form_row group-visible">
				<label for="group_unique_id"><?php _e( 'Unique ID', '12-step-meeting-list' ) ?></label>
				<input type="text" name="group_unique_id" id="group_unique_id" value="<?php tsml_echo( $meeting, 'group_unique_id' ) ?>">
			</div>
			<div class="meta_form_row checkbox apply_group_to_location hidden">
				<label>
					<input type="checkbox" name="apply_group_to_location">
					<?php _e( 'Apply this group to all meetings at this location', '12-step-meeting-list' ) ?>
				</label>
			</div>
			<?php if ( count( $meetings ) > 1 ) { ?>
				<div class="meta_form_row">
					<label>Meetings</label>
					<ol>
						<?php foreach ( $meetings as $m ) {
							if ( $m['id'] != @$meeting->ID ) {
								$m['name'] = '<a href="' . get_edit_post_link( $m['id'] ) . '">' . $m['name'] . '</a>';
							}
							
							?>
							<li>
								<span><?php echo tsml_format_day_and_time( $m['day'], $m['time'], ' ', TRUE ) ?></span> <?php echo $m['name'] ?>
							</li>
						<?php } ?>
					</ol>
				</div>
			<?php }
			if ( wp_count_terms( 'tsml_district' ) ) { ?>
				<div class="meta_form_row group-visible">
					<label for="district"><?php _e( 'District', '12-step-meeting-list' ) ?></label>
					<?php wp_dropdown_categories( [
						'name'             => 'district',
						'taxonomy'         => 'tsml_district',
						'hierarchical'     => TRUE,
						'hide_empty'       => FALSE,
						'orderby'          => 'name',
						'selected'         => $district,
						'show_option_none' => __( 'District', '12-step-meeting-list' ),
					] ) ?>
				</div>
			<?php } ?>
			<div class="meta_form_row group-visible">
				<label for="group_notes"><?php _e( 'Group Notes', '12-step-meeting-list' ) ?></label>
				<textarea name="group_notes" id="group_notes" placeholder="<?php _e( 'eg. Group history, when the business meeting is, etc.', '12-step-meeting-list' ) ?>"><?php echo @$meeting->group_notes ?></textarea>
			</div>
			<div class="meta_form_row">
				<label for="website"><?php _e( 'Website', '12-step-meeting-list' ) ?></label>
				<input type="text" name="website" id="website" value="<?php tsml_echo( $meeting, 'website' ) ?>" placeholder="https://">
			</div>
			<div class="meta_form_row">
				<label for="website_2"><?php _e( 'Website 2', '12-step-meeting-list' ) ?></label>
				<input type="text" name="website_2" id="website_2" value="<?php tsml_echo( $meeting, 'website_2' ) ?>" placeholder="https://">
			</div>
			<div class="meta_form_row">
				<label for="email"><?php _e( 'Email', '12-step-meeting-list' ) ?></label>
				<input type="text" name="email" id="email" value="<?php tsml_echo( $meeting, 'email' ) ?>" placeholder="group@website.org">
			</div>
			<div class="meta_form_row">
				<label for="phone"><?php _e( 'Phone', '12-step-meeting-list' ) ?></label>
				<input type="text" name="phone" id="phone" value="<?php tsml_echo( $meeting, 'phone' ) ?>" placeholder="+18005551212">
			</div>
			<div class="meta_form_row">
				<label for="mailing_address"><?php _e( 'Mailing Address', '12-step-meeting-list' ) ?></label>
				<input type="text" name="mailing_address" id="mailing_address" value="<?php tsml_echo( $meeting, 'mailing_address' ) ?>" placeholder="123 Main St, Anytown OK">
			</div>
			<div class="meta_form_row">
				<label><?php _e( 'Venmo', '12-step-meeting-list' ) ?></label>
				<input type="text" name="venmo" placeholder="@VenmoHandle" value="<?php tsml_echo( $meeting, 'venmo' ) ?>">
			</div>
			<div class="meta_form_row">
				<label><?php _e( 'Square Cash', '12-step-meeting-list' ) ?></label>
				<input type="text" name="square" placeholder="$Cashtag" value="<?php tsml_echo( $meeting, 'square' ) ?>">
			</div>
			<div class="meta_form_row">
				<label><?php _e( 'PayPal', '12-step-meeting-list' ) ?></label>
				<input type="text" name="paypal" placeholder="PayPalUsername" value="<?php tsml_echo( $meeting, 'paypal' ) ?>">
			</div>
			<div class="meta_form_row">
				<label>
					<?php _e( 'Contacts', '12-step-meeting-list' ) ?>
					<span style="display: block;font-size:90%;color:#999;">
						(<?php if ( $tsml_contact_display == 'public' ) {
							_e( 'Public', '12-step-meeting-list' );
						} else {
							_e( 'Private', '12-step-meeting-list' );
						} ?>)
					</span>
				</label>
				<div class="container">
					<?php
					for ( $i = 1; $i <= TSML_GROUP_CONTACT_COUNT; $i ++ ) { ?>
						<div class="row">
							<?php
							foreach (
								[
									'name'  => __( 'Name', '12-step-meeting-list' ),
									'email' => __( 'Email', '12-step-meeting-list' ),
									'phone' => __( 'Phone', '12-step-meeting-list' ),
								] as $key => $label
							) {
								$field = implode( '_', [ 'contact', $i, $key ] );
								?>
								<div>
									<input type="text" name="<?php echo $field ?>" placeholder="<?php echo $label ?>" value="<?php tsml_echo( $meeting, $field ) ?>">
								</div>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="meta_form_row">
				<label for="last_contact"><?php _e( 'Last Contact', '12-step-meeting-list' ) ?></label>
				<input type="date" name="last_contact" value="<?php tsml_echo( $meeting, 'last_contact' ) ?>">
			</div>
		</div>
		<?php
	}
}
