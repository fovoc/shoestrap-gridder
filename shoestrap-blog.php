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
  require_once dirname( __FILE__ ) . '/template-redirects.php';
  
  require_once dirname( __FILE__ ) . '/includes/customizer/sections.php';
  require_once dirname( __FILE__ ) . '/includes/customizer/settings.php';
  require_once dirname( __FILE__ ) . '/includes/customizer/controls.php';
  require_once dirname( __FILE__ ) . '/includes/customizer/functions.php';
  require_once dirname( __FILE__ ) . '/includes/customizer/output.php';
  
  function shoestrap_blog_enqueue_resources() {
    wp_enqueue_style('shoestrap_styles', plugins_url('assets/css/style.css', __FILE__), false, null);
    
    wp_register_script('shoestrap_blog_infinitescroll', plugins_url( 'assets/js/jquery.infinitescroll.min.js', __FILE__ ), false, null, false);
    wp_register_script('shoestrap_blog_isotope', plugins_url( 'assets/js/jquery.masonry.min.js', __FILE__ ), false, null, false);
    wp_enqueue_script('shoestrap_blog_infinitescroll');
    wp_enqueue_script('shoestrap_blog_isotope');
  }
  add_action('wp_enqueue_scripts', 'shoestrap_blog_enqueue_resources', 103);

}
