<?php

/*

Plugin Name: Cornerstone
Plugin URI: http://theme.co/cornerstone
Description: The WordPress Page Builder
Author: Themeco
Author URI: http://theme.co/
Version: 1.0.5
X Plugin: cornerstone
Text Domain: cornerstone
Domain Path: lang

*/

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Load main plugin class
require_once 'includes/class-cornerstone.php';

// Fire it up
Cornerstone::run( __FILE__ );

// Disable update checks/notices and auto-update for this plugin.
add_filter( 'site_transient_update_plugins', function( $transient ) {
	$plugin_file = plugin_basename( __FILE__ );
	if ( isset( $transient->response[ $plugin_file ] ) ) {
		unset( $transient->response[ $plugin_file ] );
	}
	if ( isset( $transient->no_update[ $plugin_file ] ) ) {
		unset( $transient->no_update[ $plugin_file ] );
	}
	return $transient;
} );

add_filter( 'auto_update_plugin', function( $update, $item ) {
	if ( isset( $item->plugin ) && $item->plugin === plugin_basename( __FILE__ ) ) {
		return false;
	}
	return $update;
}, 10, 2 );