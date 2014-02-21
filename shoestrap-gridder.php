<?php
/*
Plugin Name:         Shoestrap 3 Gridder Addon
Plugin URI:          http://shoestrap.org/downloads/shoestrap-3-gridder-addon/
Description:         This plugin adds infinite scroll and isotope's masonry to the Shoestrap 3 theme.
Version:             3.1.1-RC1
Author:              Aristeides Stathopoulos, Dimitris Kalliris
Author URI:          http://wpmu.io
GitHub Plugin URI:   https://github.com/shoestrap/shoestrap-gridder
GitHub Access Token: 35ac969e65c1e15373b79cfb0bdfc0e025529b15
*/

if ( !defined( 'REDUX_OPT_NAME' ) )
	define( 'REDUX_OPT_NAME', 'shoestrap' );

define( 'SHOESTRAPGRIDDERURL', plugins_url( '', __FILE__ ) );
define( 'SHOESTRAPGRIDDERFILE', __FILE__ );

function shoestrap_gridder_include_files() {
	require_once dirname( __FILE__ ) . '/includes/class.ShoestrapGridder.php';
}
add_action( 'shoestrap_include_files', 'shoestrap_gridder_include_files' );