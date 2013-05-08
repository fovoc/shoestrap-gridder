<?php

function shoestrap_gridder_customizer( $wp_customize ) {
  
  $sections = array();
  $sections[] = array( 'slug'=>'shoestrap_gridder', 'title' => __('Gridder', 'shoestrap_gridder'), 'priority' => 15);

  foreach($sections as $section){
    $wp_customize->add_section( $section['slug'], array( 'title' => $section['title'], 'priority' => $section['priority']));
  }
  $settings = array();
  $settings[] = array( 'slug'=> 'shoestrap_gridder_show_text_in_lists', 'default' => 'show');
  $settings[] = array( 'slug'=> 'shoestrap_gridder_posts_columns',      'default' => '3');
  $settings[] = array( 'slug'=> 'shoestrap_gridder_list_title_size',    'default' => 'h3');
  $settings[] = array( 'slug'=> 'shoestrap_gridder_loading_text',       'default' => 'Loading...');
  $settings[] = array( 'slug'=> 'shoestrap_gridder_loading_color',      'default' => 'progress-info');
  $settings[] = array( 'slug'=> 'shoestrap_gridder_end_text',           'default' => 'End of list');
  $settings[] = array( 'slug'=> 'shoestrap_gridder_end_color',          'default' => 'progress-danger');

  foreach($settings as $setting){
    $wp_customize->add_setting( $setting['slug'], array( 'default' => $setting['default'], 'type' => 'theme_mod', 'capability' => 'edit_theme_options' ));
  }
  $wp_customize->add_setting( 'posts_per_page', array(
    'default'        => '12',
    'type'           => 'option',
    'capability'     => 'manage_options',
) );
  
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
    'label'       => __( 'Item width', 'shoestrap_gridder' ),
    'section'     => 'shoestrap_gridder',
    'settings'    => 'shoestrap_gridder_posts_columns',
    'type'        => 'select',
    'priority'    => 1,
    'choices'     => array(
      'narrow'    => 'Narrow',
      'normal'    => 'Normal',
      'wide'      => 'Wide',
    ),
  ));
  
  $wp_customize->add_control( 'shoestrap_gridder_list_title_size', array(
    'label'       => __( 'List titles type', 'shoestrap_gridder' ),
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
    'label'       => __( 'Posts Per Page', 'shoestrap_gridder' ),
    'section'     => 'shoestrap_gridder',
    'settings'    => 'posts_per_page',
    'type'        => 'text'
  ));
  
  $wp_customize->add_control( 'shoestrap_gridder_loading_text', array(
    'label'       => __( '"loading" message', 'shoestrap_gridder' ),
    'section'     => 'shoestrap_gridder',
    'settings'    => 'shoestrap_gridder_loading_text',
    'type'        => 'text'
  ));

  $wp_customize->add_control( 'shoestrap_gridder_loading_color', array(
    'label'       => __( 'Color of loading progress bar', 'shoestrap_gridder' ),
    'section'     => 'shoestrap_gridder',
    'settings'    => 'shoestrap_gridder_loading_color',
    'type'        => 'select',
    //'priority'    => 1,
    'choices'     => array(
      'progress-info'      => 'Light Blue',
      'progress-success'   => 'Green',
      'progress-warning'   => 'Orange',
      'progress-danger'    => 'Red',
    ),
  ));

  $wp_customize->add_control( 'shoestrap_gridder_end_text', array(
    'label'       => __( '"End of List" Message', 'shoestrap_gridder' ),
    'section'     => 'shoestrap_gridder',
    'settings'    => 'shoestrap_gridder_end_text',
    'type'        => 'text'
  ));

  $wp_customize->add_control( 'shoestrap_gridder_end_color', array(
    'label'       => __( 'Colr of loading bar on the end of the list', 'shoestrap_gridder' ),
    'section'     => 'shoestrap_gridder',
    'settings'    => 'shoestrap_gridder_end_color',
    'type'        => 'select',
    //'priority'    => 1,
    'choices'     => array(
      'progress-info'      => 'Light Blue',
      'progress-success'   => 'Green',
      'progress-warning'   => 'Orange',
      'progress-danger'    => 'Red',
    ),
  ));

}
add_action( 'customize_register', 'shoestrap_gridder_customizer' );

function shoestrap_gridder_posts_column( $echo = true ) {
  
  $class = get_theme_mod( 'shoestrap_gridder_posts_columns', 'normal' );
  
  if ( $echo == true ) {
    echo $class;
  } else {
    return $class;
  }
}

function shoestrap_gridder_customizer_output() {
  
  $background_color = get_theme_mod( 'shoestrap_background_color' );
  $background_color = '#' . str_replace( '#', '', $background_color );
  ?>
  <style>
    #main .entry{
      <?php if ( shoestrap_get_brightness( $background_color ) >= 160 ) {
        echo 'color: ' . shoestrap_adjust_brightness( $background_color, -180 ) . ';';
        echo 'background: ' . shoestrap_adjust_brightness( $background_color, 20 ) . ';';
      } else {
        echo 'color: ' . shoestrap_adjust_brightness( $background_color, 180 ) . ';';
        echo 'background: ' . shoestrap_adjust_brightness( $background_color, -20 ) . ';';
      }?>
    }
  </style>

<?php }
add_action( 'wp_head', 'shoestrap_gridder_customizer_output' );
