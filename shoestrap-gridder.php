<?php
/*
Plugin Name: Shoestrap 3 Gridder Addon
Plugin URI: http://shoestrap.org
Description: This plugin adds infinite scroll and masonry to the Shoestrap 3 theme.
Version: 3.0.00
Author: Aristeides Stathopoulos
Author URI: http://aristeides.com
*/

define( 'SHOESTRAPGRIDDERURL', plugins_url( '', __FILE__ ) );
define( 'SHOESTRAPGRIDDERFILE', __FILE__ );
require_once get_template_directory() . '/lib/modules/core.redux/module.php';
require_once dirname( __FILE__ ) . '/includes/admin.php';
require_once dirname( __FILE__ ) . '/includes/functions.php';
require_once dirname( __FILE__ ) . '/includes/scripts.php';
require_once dirname( __FILE__ ) . '/includes/template-functions.php';
