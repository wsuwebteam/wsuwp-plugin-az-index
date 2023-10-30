<?php
/**
 * Plugin Name: WSUWP A-Z Index
 * Plugin URI: https://github.com/wsuwebteam/wsuwp-plugin-az-index
 * Description: Plugin to manage and an A-Z Index of links.
 * Version: 0.0.2
 * Requires PHP: 7.0
 * Author: Washington State University, Danial Bleile, Dan White
 * Author URI: https://web.wsu.edu/
 * Text Domain: wsuwp-plugin-az-index
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Initiate plugin
require_once __DIR__ . '/includes/plugin.php';
