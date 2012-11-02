<?php
/*
Plugin Name: Shoestrap Blog Addon
Plugin URI: http://bootstrap-commerce.com
Description: This plugin adds the necessary templates and functions to the shoestrap theme
Version: 1.0.0
Author: Aristeides Stathopoulos
Author URI: http://aristeides.com
*/

// Check if the Shoestrap theme is enabled.
// Only process this plugin if the enabled theme is called shoestrap
$shoestrap_enabled = wp_get_theme( 'shoestrap' );
if ( $shoestrap_enabled->exists() ) {
  
}
