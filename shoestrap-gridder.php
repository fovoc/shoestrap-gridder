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

if ( $shoestrap_enabled -> exists() || $shoestrap_child_enabled -> exists() ) {
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
      'finishedMsg'   => __( 'No more pages', 'shoestrap_gridder' ),
      'loadingImg'    => 'http://i.imgur.com/6RMhx.gif',
    ) );

    // MarketPress-specific script
    global $mp;
    $view_mode = '';
    $view_mode = $mp->get_setting('list_view');
    if ( $view_mode != 'grid' && $view_mode != 'list' ) {
      $view_mode = 'grid';
    }
    
    // Register the appropriate script if MarketPress is installed
    if ( class_exists( 'MarketPress' ) && mp_is_shop_page() ) {
      if ( $view_mode == 'list' ) {
        echo 'mp exists';
        wp_register_script('shoestrap_gridder_mp_script', plugins_url( 'assets/js/scripts-mp-list.js', __FILE__ ), false, null, false);
      } else {
        wp_register_script('shoestrap_gridder_mp_script', plugins_url( 'assets/js/scripts-mp-grid.js', __FILE__ ), false, null, false);
      }
    }
    if ( class_exists( 'MarketPress' ) ) {
      // if mp is installed and user IS viewing a store page, enqueue the marketpress script.
      if ( !mp_is_shop_page() ) {
        wp_enqueue_script('shoestrap_gridder_script');
      // if mp is installed and user IS NOT viewing a store page, enqueue the default script.
      } else {
        wp_enqueue_script('shoestrap_gridder_mp_script');
      }
    // if mp is NOT installed enqueue the default script.
    } else {
      wp_enqueue_script('shoestrap_gridder_script');
    }
  }
  add_action('wp_enqueue_scripts', 'shoestrap_gridder_enqueue_resources', 103);
}

// Load the plugin updater
require_once dirname( __FILE__ ) . '/includes/updater/licencing.php';

