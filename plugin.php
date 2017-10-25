<?php
/*
Plugin Name:  JWT Registration
Plugin URI:   https://developer.wordpress.org/plugins/the-basics/
Description:  JWT Registration for WP REST API. Requires JWT Authentication Plugin.
Version:      1.0.0
Author:       bluder
Author URI:   https://www.fiverr.com/bluder
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Bootstrap RJWT API
 */
class RJWT_APP {

	function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	function init() {
		include_once( 'includes/api/class-rjwt-rest-users-controller.php' );
		$rjwt_users = new RJWT_REST_Users_Controller();
		add_action( 'rest_api_init', array($rjwt_users, 'register_routes'));
	}

}

new RJWT_APP();