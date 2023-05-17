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
		echo wp_list_categories( [
				'walker' => new \TSMLXtras\Blocks\Classes\TSMLX_Regions_Walker(),
				'taxonomy'   => 'tsml_region',
				'show_count' => $args['showCount'],
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
