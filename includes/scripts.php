<?php

/*
 * Enqueue the necessary javascript and css resources
 */
function shoestrap_gridder_enqueue_resources() {
	$infinitescroll = shoestrap_getVariable( 'shoestrap_gridder_infinite_scroll' );
	$masonry        = shoestrap_getVariable( 'shoestrap_gridder_masorny' );

	if ( $masonry == 1 ) :
		wp_enqueue_style( 'shoestrap_gridder_styles', SHOESTRAPGRIDDERURL . '/assets/css/style.css', false, null );
		wp_register_script( 'shoestrap_gridder_masonry', SHOESTRAPGRIDDERURL . '/assets/js/jquery.masonry.min.js', false, null, true );
		wp_enqueue_script( 'shoestrap_gridder_masonry' );
	endif;

	if ( $infinitescroll == 1 ) :
		wp_register_script( 'shoestrap_gridder_infinitescroll', SHOESTRAPGRIDDERURL . '/assets/js/jquery.infinitescroll.min.js', false, null, true );
		wp_enqueue_script( 'shoestrap_gridder_infinitescroll' );
	endif;
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