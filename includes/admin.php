<?php


/*
 * Gridder Addon options
 */
if ( !function_exists( 'shoestrap_module_gridder_options' ) ) :
function shoestrap_module_gridder_options( $sections ) {

  $section = array(
    'title' => __( 'Gridder', 'shoestrap' ),
    'icon'  => 'el-icon-th icon-large'
  );

  $fields[] = array( 
    'title'     => __( 'Enable Infinite Scroll', 'shoestrap' ),
    'desc'      => __( 'Default: On.', 'shoestrap' ),
    'id'        => 'shoestrap_gridder_infinite_scroll',
    'default'   => 1,
    'type'      => 'switch'
  );

  $fields[] = array( 
    'title'     => __( 'Show text in lists', 'shoestrap' ),
    'desc'      => __( 'Default: On.', 'shoestrap' ),
    'id'        => 'shoestrap_gridder_show_text_in_lists',
    'default'   => 1,
    'on'        => __("Show", "shoestrap"),
    'off'       => __("Hide", "shoestrap"),
    'customizer'=> array(),
    'type'      => 'switch'
  );

  $fields[] = array( 
    'title'     => __( 'Select list title size', 'shoestrap' ),
    'desc'      => __( 'Default: On.', 'shoestrap' ),
    'id'        => 'shoestrap_gridder_list_title_size',
    'default'   => 1,
    'on'        => __("h3", "shoestrap"),
    'off'       => __("h4", "shoestrap"),
    'customizer'=> array(),
    'type'      => 'switch'
  );

  $fields[] = array( 
    'title'     => __( 'Select between box styles', 'shoestrap' ),
    'desc'      => __( 'Select between box styles.', 'shoestrap' ),
    'id'        => 'shoestrap_gridder_box_style',
    'type'      => 'button_set',
    'options'   => array(
      ' '                   => 'Default',
      'well'                => 'Well',
      'panel panel-default' => 'Panel'
    ),
    'default' => ' '
  );

  $fields[] = array( 
    'title'     => __( 'Loading text', 'shoestrap' ),
    'desc'      => __( 'The text inside the progress bar as next set is loading.', 'shoestrap' ),
    'id'        => 'shoestrap_gridder_loading_text',
    'default'   => 'Loading...',
    'type'      => 'text'
  );

  $fields[] = array( 
    'title'     => __( 'End text', 'shoestrap' ),
    'desc'      => __( 'The text inside the progress bar when no more posts are available.', 'shoestrap' ),
    'id'        => 'shoestrap_gridder_end_text',
    'default'   => 'End of list',
    'type'      => 'text'
  );

  $fields[] = array( 
    'title'     => __( 'Loading progress bar color', 'shoestrap' ),
    'desc'      => __( 'Select between standard Bootstrap\'s progress bars classes', 'shoestrap' ),
    'id'        => 'shoestrap_gridder_loading_color',
    'default'   => ' ',
    'type'      => 'select',
    'customizer'=> array(),
    'options'   => array( 
      'default' => 'Default',
      'info'    => 'Info',
      'success' => 'Success',
      'warning' => 'Warning',
      'danger'  => 'Danger'
    )
  );

  $fields[] = array( 
    'title'     => __( 'End progress bar color', 'shoestrap' ),
    'desc'      => __( 'Select between standard Bootstrap\'s progress bars classes', 'shoestrap' ),
    'id'        => 'shoestrap_gridder_end_color',
    'default'   => ' ',
    'type'      => 'select',
    'customizer'=> array(),
    'options'   => array( 
      'default' => 'Default',
      'info'    => 'Info',
      'success' => 'Success',
      'warning' => 'Warning',
      'danger'  => 'Danger'
    )
  );

  $fields[] = array( 
    'title'     => __( 'Post Width', 'shoestrap' ),
    'desc'      => __( 'Select the width of a single post. This eventually changes the number of columns.', 'shoestrap' ),
    'id'        => 'shoestrap_gridder_posts_columns',
    'default'   => 'normal',
    'type'      => 'select',
    'customizer'=> array(),
    'options'   => array( 
      'narrow' => 'Narrow',
      'normal' => 'Normal',
      'wide'   => 'Wide'
    )
  );

  $section['fields'] = $fields;

  $section = apply_filters( 'shoestrap_module_gridder_options_modifier', $section );
  
  $sections[] = $section;
  return $sections;
}
endif;
add_filter( 'redux-sections-'.REDUX_OPT_NAME, 'shoestrap_module_gridder_options', 1 );