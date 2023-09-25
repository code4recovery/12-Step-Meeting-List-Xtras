<?php
/**
 * Global variables & constants
 */

$tsmlx_services = [
	'venmo' => [
		'name' => 'Venmo',
		'url' => 'https://venmo.com/',
		'substr' => 1,
	],
	'square' => [
		'name' => 'Cash App',
		'url' => 'https://cash.app/',
		'substr' => 0,
	],
	'paypal' => [
		'name' => 'PayPal',
		'url' => 'https://www.paypal.me/',
		'substr' => 0,
	],
];

$tsml_contact_fields = [
	'website' => 'url',
	'website_2' => 'url',
	'email' => 'string',
	'phone' => 'phone',
	'mailing_address' => 'string',
	'venmo' => 'string',
	'square' => 'string',
	'paypal' => 'string',
	'last_contact' => 'date',
	'group_unique_id' => 'string',
];
//append to contacts
defined('TSML_GROUP_CONTACT_COUNT') or define('TSML_GROUP_CONTACT_COUNT', 3);
for ($i = 1; $i <= TSML_GROUP_CONTACT_COUNT; $i++) {
	foreach (['name', 'email', 'phone'] as $field) {
		$tsml_contact_fields['contact_' . $i . '_' . $field] = $field == 'phone' ? 'phone' : 'string';
	}
}

/**
 * Default settings for which columns show on the meeting list and in what order.
 */
$tsml_column_defaults = [
	[
		'key' => 'time',
		'label' => 'Time',
		'exclude' => false
	],
	[
		'key' => 'distance',
		'label' => 'Distance',
		'exclude' => false,
	],
	[
		'key' => 'name',
		'label' => 'Meeting',
		'exclude' => false,
	],
	[
		'key' => 'location_group',
		'label' => 'Location / Group',
		'exclude' => false,
	],
	[
		'key' => 'address',
		'label' => 'Address',
		'exclude' => false,
	],
	[
		'key' => 'region',
		'label' => 'Region',
		'exclude' => false,
	],
	[
		'key' => 'district',
		'label' => 'District',
		'exclude' => false,
	],
	[
		'key' => 'types',
		'label' => 'Types',
		'exclude' => false,
	],
	[
		'key' => 'location',
		'label' => 'Location',
		'exclude' => true,
	],
];

/** Plugin Options */
global $tsmlx_plugin_settings;

/**
 * Set the $tsml_columns variable from config
 */
if (!empty($tsmlx_plugin_settings['tsml_columns'])) {
	// Reset existing array
	$tsml_columns = [];
	$tsmlx_cols = json_decode($tsmlx_plugin_settings['tsml_columns'], true);
	foreach ($tsmlx_cols as $order => $col) {
		if (empty($col['exclude'])) {
			$tsml_columns[$col['key']] = $col['label'];
		}
	}
}

/**
 * Set the $tsml_street_only option
 */
$tsml_street_only = empty($tsmlx_plugin_settings['tsml_street_only']);

/**
 * Set the $tsml_google_geocoding_key option
 */
if (!empty($tsmlx_plugin_settings['tsml_google_geocoding_key'])) {
	$tsml_google_geocoding_key = $tsmlx_plugin_settings['tsml_google_geocoding_key'];
}

/**
 * Set the $tsml_slug option
 */
if (!empty($tsmlx_plugin_settings['tsml_slug'])) {
	$tsml_slug = $tsmlx_plugin_settings['tsml_slug'];
}

/**
 * Add custom types from config
 */
function tsmlx_types() {
	global $tsmlx_plugin_settings, $tsml_programs, $tsml_program;
	foreach ($tsml_programs[$tsml_program]['types'] as $key => $label) {
		$types_defaults[] = [
			'key' => $key,
			'label' => $label,
			'exclude' => false,
		];
	}
	define('TSML_TYPES_DEFAULTS', $types_defaults);
	if (!empty($tsmlx_plugin_settings['types_order'])) {
		$tsmlx_types = json_decode($tsmlx_plugin_settings['types_order'], true);
		$tsml_programs[$tsml_program]['types'] = [];
		foreach ($tsmlx_types as $k => $v) {
			if ($v['exclude'] !== true) {
				$tsml_programs[$tsml_program]['types'][$v['key']] = $v['label'];
			}
		}
	}
}
add_action('init', 'tsmlx_types', 20);
