<?php

function shoestrap_gridder_register_settings($wp_customize){

  $settings = array();
  $settings[] = array( 'slug'=> 'shoestrap_gridder_show_text_in_lists', 'default' => 'show');
  $settings[] = array( 'slug'=> 'shoestrap_gridder_posts_columns',      'default' => '3');
  $settings[] = array( 'slug'=> 'shoestrap_gridder_list_title_size',    'default' => 'h3');

  foreach($settings as $setting){
    $wp_customize->add_setting( $setting['slug'], array( 'default' => $setting['default'], 'type' => 'theme_mod', 'capability' => 'edit_theme_options' ));
  }
  $wp_customize->add_setting( 'posts_per_page', array(
    'default'        => '12',
    'type'           => 'option',
    'capability'     => 'manage_options',
) );
  
}
add_action( 'customize_register', 'shoestrap_blog_register_settings' );
