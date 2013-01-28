<?php

function shoestrap_gridder_register_sections($wp_customize){
  
  // remove default sections
  $sections = array();
  $sections[] = array( 'slug'=>'shoestrap_gridder', 'title' => __('Gridder', 'shoestrap_gridder'), 'priority' => 15);

  foreach($sections as $section){
    $wp_customize->add_section( $section['slug'], array( 'title' => $section['title'], 'priority' => $section['priority']));
  }
}
add_action( 'customize_register', 'shoestrap_gridder_register_sections' );
