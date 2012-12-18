<?php
/*
Plugin Name: Shoestrap Gridder Addon
Plugin URI: http://bootstrap-commerce.com
Description: This plugin adds the necessary templates and functions to the shoestrap theme
Version: 1.10
Author: Aristeides Stathopoulos
Author URI: http://aristeides.com
*/

add_image_size( 'shoestrap-gridder-grid', 350 );

// Check if the Shoestrap theme is enabled.
// Only process this plugin if the enabled theme is called shoestrap
$shoestrap_enabled        = wp_get_theme( 'shoestrap' );
$shoestrap_child_enabled  = wp_get_theme( 'shoestrap-child-theme' );

require_once dirname( __FILE__ ) . '/template-redirects.php';

require_once dirname( __FILE__ ) . '/includes/customizer/sections.php';
require_once dirname( __FILE__ ) . '/includes/customizer/settings.php';
require_once dirname( __FILE__ ) . '/includes/customizer/controls.php';
require_once dirname( __FILE__ ) . '/includes/customizer/functions.php';
require_once dirname( __FILE__ ) . '/includes/customizer/output.php';

function shoestrap_gridder_enqueue_resources() {

  // Enqueue the styles
  wp_enqueue_style('shoestrap_gridder_styles', plugins_url('assets/css/style.css', __FILE__), false, null);
  
  // Infinite scroll jQuery Plugin
  wp_register_script('shoestrap_gridder_infinitescroll', plugins_url( 'assets/js/jquery.infinitescroll.min.js', __FILE__ ), false, null, false);
  wp_enqueue_script('shoestrap_gridder_infinitescroll');
	
	// Masonry jQuery Plugin
  wp_register_script('shoestrap_gridder_masonry', plugins_url( 'assets/js/jquery.masonry.min.js', __FILE__ ), false, null, false);
  wp_enqueue_script('shoestrap_gridder_masonry');
  
  // Plugin-specific script
  wp_register_script('shoestrap_gridder_script', plugins_url( 'assets/js/scripts.js', __FILE__ ), false, null, false);

  wp_localize_script( 'shoestrap_gridder_script', 'shoestrapScript', array(
    'loadingImg'    => 'http://i.imgur.com/6RMhx.gif',
    'end' 					=> __( get_theme_mod('shoestrap_gridder_end_text'))
  ) );

	$translation_array = array( 'text' => __( get_theme_mod('shoestrap_gridder_loading_text')) );
	wp_localize_script( 'shoestrap_gridder_infinitescroll', 'msg', $translation_array );
	
  wp_enqueue_script('shoestrap_gridder_script');
}

function shoestrap_gridder_enqueue_resources_checked() {
  if ( !is_singular() ) {
    add_action('wp_enqueue_scripts', 'shoestrap_gridder_enqueue_resources', 103);
  }
}
add_action( 'wp', 'shoestrap_gridder_enqueue_resources_checked' );

// Load the plugin updater
require_once dirname( __FILE__ ) . '/includes/updater/licencing.php';
