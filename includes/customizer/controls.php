<?php

function shoestrap_gridder_register_controls($wp_customize){
  
/*
 * EDD SECTION
 */
  $wp_customize->add_control( 'shoestrap_gridder_show_text_in_lists', array(
    'label'       => __( 'Show post content in lists', 'shoestrap_gridder' ),
    'section'     => 'shoestrap_gridder',
    'settings'    => 'shoestrap_gridder_show_text_in_lists',
    'type'        => 'select',
    'priority'    => 1,
    'choices'     => array(
      'show'      => __('Show', 'shoestrap_gridder'),
      'hide'      => __('Hide', 'shoestrap_gridder'),
    ),
  ));
  
  $wp_customize->add_control( 'shoestrap_gridder_posts_columns', array(
    'label'       => __( 'Columns', 'shoestrap_gridder' ),
    'section'     => 'shoestrap_gridder',
    'settings'    => 'shoestrap_gridder_posts_columns',
    'type'        => 'select',
    'priority'    => 1,
    'choices'     => array(
      '1'         => '1',
      '2'         => '2',
      '3'         => '3',
      '4'         => '4',
    ),
  ));
  
  $wp_customize->add_control( 'shoestrap_gridder_list_title_size', array(
    'label'       => __( 'Size of list titles', 'shoestrap_gridder' ),
    'section'     => 'shoestrap_gridder',
    'settings'    => 'shoestrap_gridder_list_title_size',
    'type'        => 'select',
    'priority'    => 1,
    'choices'     => array(
      'h3'        => 'h3',
      'h4'        => 'h4',
    ),
  ));
  
  $wp_customize->add_control( 'posts_per_page', array(
    'label'       => __( 'Products Per Page', 'shoestrap_gridder' ),
    'section'     => 'shoestrap_gridder',
    'settings'    => 'posts_per_page',
    'type'        => 'text'
  ));
  
}
add_action( 'customize_register', 'shoestrap_gridder_register_controls' );
