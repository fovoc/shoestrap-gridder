<?php

function shoestrap_blog_register_controls($wp_customize){
  
/*
 * EDD SECTION
 */
  $wp_customize->add_control( 'shoestrap_blog_show_text_in_lists', array(
    'label'       => __( 'Show post content in lists', 'shoestrap_blog' ),
    'section'     => 'shoestrap_blog',
    'settings'    => 'shoestrap_blog_show_text_in_lists',
    'type'        => 'select',
    'priority'    => 1,
    'choices'     => array(
      'show'      => __('Show', 'shoestrap_blog'),
      'hide'      => __('Hide', 'shoestrap_blog'),
    ),
  ));
  
  $wp_customize->add_control( 'shoestrap_blog_frontpage', array(
    'label'       => __( 'Frontpage Mode', 'shoestrap_blog' ),
    'section'     => 'shoestrap_blog',
    'settings'    => 'shoestrap_blog_frontpage',
    'type'        => 'select',
    'priority'    => 1,
    'choices'     => array(
      'blog_list' => __( 'Adaptive', 'shoestrap_blog'),
      'default'   => __( 'Site Default', 'shoestrap_blog'),
    ),
  ));
  
  $wp_customize->add_control( 'shoestrap_blog_posts_columns', array(
    'label'       => __( 'Columns', 'shoestrap_blog' ),
    'section'     => 'shoestrap_blog',
    'settings'    => 'shoestrap_blog_posts_columns',
    'type'        => 'select',
    'priority'    => 1,
    'choices'     => array(
      '1'         => '1',
      '2'         => '2',
      '3'         => '3',
      '4'         => '4',
    ),
  ));
  
  $wp_customize->add_control( 'shoestrap_blog_list_title_size', array(
    'label'       => __( 'Size of list titles', 'shoestrap_blog' ),
    'section'     => 'shoestrap_blog',
    'settings'    => 'shoestrap_blog_list_title_size',
    'type'        => 'select',
    'priority'    => 1,
    'choices'     => array(
      'h3'        => 'h3',
      'h4'        => 'h4',
    ),
  ));
  
  $wp_customize->add_control( 'posts_per_page', array(
    'label'       => __( 'Products Per Page', 'shoestrap_blog' ),
    'section'     => 'shoestrap_blog',
    'settings'    => 'posts_per_page',
    'type'        => 'text'
  ));
  
}
add_action( 'customize_register', 'shoestrap_blog_register_controls' );
