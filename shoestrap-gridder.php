<?php
/*
Plugin Name:         Shoestrap 3 Gridder Addon
Plugin URI:          http://shoestrap.org/downloads/shoestrap-3-gridder-addon/
Description:         This plugin adds infinite scroll and isotope's masonry to the Shoestrap 3 theme.
Version:             3.4
Author:              Aristeides Stathopoulos, Dimitris Kalliris
Author URI:          http://wpmu.io
*/

define( 'SHOESTRAPGRIDDERURL', plugins_url( '', __FILE__ ) );
define( 'SHOESTRAPGRIDDERFILE', __FILE__ );

function shoestrap_gridder_include_files() {
	require_once dirname( __FILE__ ) . '/includes/class.ShoestrapGridder.php';
}
add_action( 'shoestrap_include_files', 'shoestrap_gridder_include_files' );

require_once dirname( __FILE__ ) . '/includes/updater/updater.php';