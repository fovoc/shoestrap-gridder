<?php

/*
 * Enqueue the necessary javascript and css resources
 */
if ( !function_exists( 'shoestrap_gridder_enqueue_resources' ) ) :
function shoestrap_gridder_enqueue_resources() {
	$infinitescroll = shoestrap_getVariable( 'shoestrap_gridder_infinite_scroll' );
	$isotope        = shoestrap_getVariable( 'shoestrap_gridder_isotope' );

	if ( $isotope == 1 || $infinitescroll == 1 ) :
		// Enqueue the styles
		wp_register_style( 'shoestrap_gridder_styles', SHOESTRAPGRIDDERURL . '/assets/css/style.css' );
		wp_enqueue_style( 'shoestrap_gridder_styles' );
		// Wrap the content without the page header into a div
		add_action( 'shoestrap_index_begin', 'shoestrap_gridder_open_wrapper_div', 10 );
		add_action( 'shoestrap_index_end', 'shoestrap_gridder_close_wrapper_div', 10 );

		if ( $isotope == 1 ) :
			// Register && Enqueue Isotope
			wp_enqueue_style( 'shoestrap_gridder_styles', SHOESTRAPGRIDDERURL . '/assets/css/style.css', false, null );
			wp_register_script( 'shoestrap_gridder_isotope', SHOESTRAPGRIDDERURL . '/assets/js/jquery.isotope.min.js', false, null, true );
			wp_enqueue_script( 'shoestrap_gridder_isotope' );
			// Register && Enqueue Isotope Sloppy Masonry
			wp_enqueue_style( 'shoestrap_gridder_styles', SHOESTRAPGRIDDERURL . '/assets/css/style.css', false, null );
			wp_register_script( 'shoestrap_gridder_sloppy', SHOESTRAPGRIDDERURL . '/assets/js/jquery.isotope.sloppy-masonry.min.js', false, null, true );
			wp_enqueue_script( 'shoestrap_gridder_sloppy' );
			// Insert the Well or Panel class
			add_action( 'shoestrap_in_article_top', 'shoestrap_gridder_article_in_top' );
			// Insert the appropriate classes for grid
			add_filter( 'post_class', 'shoestrap_gridder_post_classes' );
			// Insert specific Panel actions
			if ( shoestrap_getVariable( 'shoestrap_gridder_box_style' ) == 'panel' ) :
				add_action( 'shoestrap_override_header', 'shoestrap_gridder_override_header_panel' );
				add_action( 'shoestrap_in_article_bottom', 'shoestrap_gridder_dummy_close_divs' );
			endif;

			// Insert specific Well actions
			if ( shoestrap_getVariable( 'shoestrap_gridder_box_style' ) == 'well' ) :
				add_action( 'shoestrap_override_header', 'shoestrap_gridder_override_header_well' );
			endif;
		endif;

		if ( $infinitescroll == 1 ) :
			wp_register_script( 'shoestrap_gridder_infinitescroll', SHOESTRAPGRIDDERURL . '/assets/js/jquery.infinitescroll.min.js', false, null, true );
			wp_enqueue_script( 'shoestrap_gridder_infinitescroll' );
			wp_register_script( 'shoestrap_gridder_imagesloaded', SHOESTRAPGRIDDERURL . '/assets/js/imagesloaded.pkgd.min.js', false, null, true );
			wp_enqueue_script( 'shoestrap_gridder_imagesloaded' );
		endif;
	endif;
}
endif;


/*
 * Load our custom scripts
 */
if ( !function_exists( 'shoestrap_gridder_load_scripts' ) ) :
	function shoestrap_gridder_load_scripts() {
		$selectors = shoestrap_getVariable( 'shoestrap_gridder_selectors' );
		if ( $selectors == 1 ) :
			$navSelector  = shoestrap_getVariable( 'shoestrap_gridder_navigation' );
			$nextSelector = shoestrap_getVariable( 'shoestrap_gridder_nextpage' );
			$itemSelector = shoestrap_getVariable( 'shoestrap_gridder_item' );
			$container 		= shoestrap_getVariable( 'shoestrap_gridder_container' );
		else :
			$navSelector  = '.pager';
			$nextSelector = '.pager .previous a';
			$itemSelector = '.hentry';
			$container  	= '.row .main .wrapperdiv';
		endif;
		wp_enqueue_script('shoestrap_gridder_script', SHOESTRAPGRIDDERURL . '/assets/js/scripts.js');
		wp_localize_script('shoestrap_gridder_script', 'shoestrap_gridder_vars', array(
				'isotope' 				=> shoestrap_getVariable( 'shoestrap_gridder_isotope' ),
				'infinitescroll' 	=> shoestrap_getVariable( 'shoestrap_gridder_infinite_scroll' ),
				'msgText' 				=> "<div class='progress progress-striped active' style='width:220px;margin-bottom:0px;'><div class='progress-bar progress-bar-" . __( shoestrap_getVariable( 'shoestrap_gridder_loading_color' ) ) . "' style='width: 100%;'><span class='edd_bar_text'>" . __( shoestrap_getVariable( 'shoestrap_gridder_loading_text' ) ) . "<span></div></div>",
				'finishedMsg' 		=> "<div class='progress progress-striped active' style='width:220px;margin-bottom:0px;'><div class='progress-bar progress-bar-" . __( shoestrap_getVariable( 'shoestrap_gridder_end_color' ) ) . "' style='width: 100%;'><span class='edd_bar_text'>" . __( shoestrap_getVariable( 'shoestrap_gridder_end_text' ) ) . "<span></div></div>",
				'navSelector'			=> $navSelector,
				'nextSelector'		=> $nextSelector,
				'itemSelector'		=> $itemSelector,
				'container'				=> $container
			)
		);
	}
endif;
add_action('wp_enqueue_scripts', 'shoestrap_gridder_load_scripts', 101 );


/*
 * Only add the scripts if the user is not seing a single post, page or other custom post type.
 */
if ( !function_exists( 'shoestrap_gridder_enqueue_resources_checked' ) ) :
function shoestrap_gridder_enqueue_resources_checked() {
	if ( !is_singular() ) :
		add_action('wp_enqueue_scripts', 'shoestrap_gridder_enqueue_resources', 201);
	endif;
}
endif;
add_action( 'wp', 'shoestrap_gridder_enqueue_resources_checked' );

function shoestrap_gridder_dummy_close_divs() {
	echo '</div></div>';
}