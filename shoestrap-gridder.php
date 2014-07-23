<?php
/*
Plugin Name:         Shoestrap 3 Gridder Addon
Plugin URI:          http://shoestrap.org/downloads/shoestrap-3-gridder-addon/
Description:         This plugin adds infinite scroll and isotope's masonry to the Shoestrap 3 theme.
Version:             3.3
Author:              Aristeides Stathopoulos, Dimitris Kalliris
Author URI:          http://wpmu.io
*/

define( 'SHOESTRAPGRIDDERURL', plugins_url( '', __FILE__ ) );
define( 'SHOESTRAPGRIDDERFILE', __FILE__ );

function shoestrap_gridder_include_files() {
	require_once dirname( __FILE__ ) . '/includes/class.ShoestrapGridder.php';
}
add_action( 'shoestrap_include_files', 'shoestrap_gridder_include_files' );


function shoestrap_gridder_updater() {

	$args = array(
		'remote_api_url' => 'http://shoestrap.org',
		'item_name'      => 'Shoestrap 3 Gridder Addon',
		'version'        => '3.3',
		'author'         => 'Aristeides Stathopoulos, Dimitris Kalliris',
		'mode'           => 'plugin',
		'title'          => 'Shoestrap Gridder Addon License',
		'field_name'     => 'shoestrap_gridder_license',
		'description'    => 'The licence key provided with Shoestrap Gridder Addon.',
		'single_license' => false
	);

	if ( class_exists( 'SS_EDD_SL_Updater' ) ) {
		$updater = new SS_EDD_SL_Updater( $args );
	}

}
add_action( 'admin_init', 'shoestrap_gridder_updater' );