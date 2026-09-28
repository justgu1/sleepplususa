<?php
/**
 * Plugin Name: iThemes Security cluster whitelist
 * Description: Never lock out or ban Kubernetes internal addresses.
 */

// Traffic reaches WordPress through Traefik, so when the real client IP is
// missing iThemes falls back to a cluster address shared by every visitor.
// Banning that address takes the whole site down.
add_filter( 'itsec_white_ips', function ( $ips ) {
	return array_merge( (array) $ips, array( '10.42.0.0/16', '10.43.0.0/16', '127.0.0.1' ) );
} );
