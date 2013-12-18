<?php
/*
Plugin Name: Shoestrap 3 Gridder Addon
Plugin URI: http://shoestrap.org/downloads/shoestrap-3-gridder-addon/
Description: This plugin adds infinite scroll and isotope's masonry to the Shoestrap 3 theme.
Version: 3.1.0
Author: Aristeides Stathopoulos, Dimitris Kalliris
Author URI: http://wpmu.io
*/

define( 'SHOESTRAPGRIDDERURL', plugins_url( '', __FILE__ ) );
define( 'SHOESTRAPGRIDDERFILE', __FILE__ );

if ( file_exists( get_template_directory() . '/lib/modules/core.redux/module.php' ) )
	require_once get_template_directory() . '/lib/modules/core.redux/module.php';

if ( file_exists( dirname( __FILE__ ) . '/includes/admin.php' ) )
	require_once dirname( __FILE__ ) . '/includes/admin.php';

if ( file_exists( dirname( __FILE__ ) . '/includes/functions.php' ) )
	require_once dirname( __FILE__ ) . '/includes/functions.php';

if ( file_exists( dirname( __FILE__ ) . '/includes/scripts.php' ) )
	require_once dirname( __FILE__ ) . '/includes/scripts.php';

if ( file_exists( dirname( __FILE__ ) . '/includes/template-functions.php' ) )
	require_once dirname( __FILE__ ) . '/includes/template-functions.php';