<?php

/*
 * Enqueue the necessary javascript and css resources
 */
function shoestrap_gridder_enqueue_resources() {
	// Enqueue the styles
	wp_enqueue_style( 'shoestrap_gridder_styles', SHOESTRAPGRIDDERURL . '/assets/css/style.css', false, null );

	// Infinite scroll jQuery Plugin
	wp_register_script( 'shoestrap_gridder_infinitescroll', SHOESTRAPGRIDDERURL . '/assets/js/jquery.infinitescroll.min.js', false, null, true );
	wp_enqueue_script( 'shoestrap_gridder_infinitescroll' );

	// Masonry jQuery Plugin
	wp_register_script( 'shoestrap_gridder_masonry', SHOESTRAPGRIDDERURL . '/assets/js/jquery.masonry.min.js', false, null, true );
	wp_enqueue_script( 'shoestrap_gridder_masonry' );

	// Plugin-specific script
	wp_register_script( 'shoestrap_gridder_script', SHOESTRAPGRIDDERURL . '/assets/js/scripts.js', false, null, true );
	wp_localize_script( 'shoestrap_gridder_script', 'shoestrapScript', array(
		'loadingImg'    => '/assets/images/empty.gif',
		'end'           => '<div class="progress progress-striped active" style="width:220px;margin-bottom:0px;"><div class="progress-bar progress-bar-' . __( shoestrap_getVariable( 'shoestrap_gridder_end_color' ) ) . '" style="width: 100%;"><span class="gridder_bar_text">' . __( shoestrap_getVariable( 'shoestrap_gridder_end_text' ) ) . '<span></div></div>'
	) );
	$translation_array = array( 'text' => '<div class="progress progress-striped active" style="width:220px;margin-bottom:0px;"><div class="progress-bar progress-bar-' . __( shoestrap_getVariable( 'shoestrap_gridder_loading_color' ) ) . '" style="width: 100%;"><span class="gridder_bar_text">' . __( shoestrap_getVariable( 'shoestrap_gridder_loading_text' ) ) . '</span></div></div>' );
	wp_localize_script( 'shoestrap_gridder_infinitescroll', 'msg', $translation_array );
	//wp_enqueue_script( 'shoestrap_gridder_script' );
}


/*
 * Only add the scripts if the user is not seing a single post, page or other custom post type.
 */
function shoestrap_gridder_enqueue_resources_checked() {
	if ( !is_singular() ) {
		add_action('wp_enqueue_scripts', 'shoestrap_gridder_enqueue_resources', 201);
	}
}
add_action( 'wp', 'shoestrap_gridder_enqueue_resources_checked' );