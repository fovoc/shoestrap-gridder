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
		'title'     => __( 'Enable Isotope', 'shoestrap' ),
		'desc'      => __( 'Default: On.', 'shoestrap' ),
		'id'        => 'shoestrap_gridder_isotope',
		'default'   => 1,
		'type'      => 'switch'
	);

	$fields[] = array( 
		'title'     => __( 'Select between box styles', 'shoestrap' ),
		'desc'      => __( 'Select between box styles.', 'shoestrap' ),
		'id'        => 'shoestrap_gridder_box_style',
		'type'      => 'button_set',
		'options'   => array(
			' '       => 'Default',
			'well'    => 'Well',
			'panel'   => 'Panel'
		),
		'default' => ' ',
		'required'  => array( 'shoestrap_gridder_isotope','=',array( '1' ) ),
	);

	$fields[] = array(
		'title'     => __( 'Post Width', 'shoestrap' ),
		'desc'      => __( 'Select the width of a single post. This eventually changes the number of columns.', 'shoestrap' ),
		'id'        => 'shoestrap_gridder_posts_columns',
		'default'   => 'normal',
		'type'      => 'select',
		'options'   => array(
			'narrow' => 'Narrow',
			'normal' => 'Normal',
			'wide'   => 'Wide'
		),
		'required'  => array( 'shoestrap_gridder_isotope','=',array( '1' ) ),
	);

	$fields[] = array( 
		'title'     => __( 'Enable Infinite Scroll', 'shoestrap' ),
		'desc'      => __( 'Default: On.', 'shoestrap' ),
		'id'        => 'shoestrap_gridder_infinite_scroll',
		'default'   => 1,
		'type'      => 'switch'
	);

	$fields[] = array( 
		'title'     => __( 'Loading text', 'shoestrap' ),
		'desc'      => __( 'The text inside the progress bar as next set is loading.', 'shoestrap' ),
		'id'        => 'shoestrap_gridder_loading_text',
		'default'   => 'Loading...',
		'type'      => 'text',
		'required'  => array( 'shoestrap_gridder_infinite_scroll','=',array( '1' ) ),
	);

	$fields[] = array( 
		'title'     => __( 'End text', 'shoestrap' ),
		'desc'      => __( 'The text inside the progress bar when no more posts are available.', 'shoestrap' ),
		'id'        => 'shoestrap_gridder_end_text',
		'default'   => 'End of list',
		'type'      => 'text',
		'required'  => array( 'shoestrap_gridder_infinite_scroll','=',array( '1' ) ),
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
		),
		'required'  => array( 'shoestrap_gridder_infinite_scroll','=',array( '1' ) ),
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
		),
		'required'  => array( 'shoestrap_gridder_infinite_scroll','=',array( '1' ) ),
	);

	$section['fields'] = $fields;

	$section = apply_filters( 'shoestrap_module_gridder_options_modifier', $section );
	
	$sections[] = $section;
	return $sections;
}
endif;
add_filter( 'redux-sections-'.REDUX_OPT_NAME, 'shoestrap_module_gridder_options', 93 );


if ( !function_exists( 'shoestrap_addong_gridder_licensing' ) ) :
function shoestrap_addong_gridder_licensing($section) {
	$section['fields'][] = array( 
		'title'            => __( 'Shoestrap Gridder Licence', 'shoestrap' ),
		'id'              => 'shoestrap_gridder_license_key',
		'default'         => '',
		'type'            => 'edd_license',
		'mode'            => 'plugin', // theme|plugin
		'path'            => SHOESTRAPGRIDDERFILE, // Path to the plugin/template main file
		'remote_api_url'  => 'http://shoestrap.org',    // our store URL that is running EDD
		'field_id'        => "shoestrap_license_key", // ID of the field used by EDD
	); 
	return $section;
}
endif;
add_filter( 'shoestrap_module_licencing_options_modifier', 'shoestrap_addong_gridder_licensing' );