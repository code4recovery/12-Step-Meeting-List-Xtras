<?php
/**
Plugin Name: 12 Step Meeting List Xtras
Plugin URI: https://github.com/anchovie91471/tsmlxtras
Description: This plugin provides a few useful extras & overrides for the 12 Step Meeting List Plugin
Version: 1.0.0
Author: Anthony B
Author URI: https://github.com/anchovie91471
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: tsmlxtras
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Get plugin options
 */
$tsmlx_plugin_settings = get_option('tsmlxtras_settings');

use TSMLXtras\TSMLXtras;
use TSMLXtras\Utility\TSMLX_Activator;

// Load autoloader
require_once 'includes/autoload.php';

// Instantiate requirements checker
$activator = new TSMLX_Activator(plugin_basename(__FILE__), '12-step-meeting-list/12-step-meeting-list.php');

// If requirements are met, proceed
if ($activator->check_requirements()) {
	// Includes variables
	include plugin_dir_path( __FILE__ ) . 'includes/variables.php';
	// Include functions file
	include plugin_dir_path( __FILE__ ) . 'includes/functions.php'; // Helper functions
	
	// Instantiate the plugin class
	$tsml_xtras = new TSMLXtras( __FILE__, $tsmlx_plugin_settings);
	$tsml_xtras->run();
}
