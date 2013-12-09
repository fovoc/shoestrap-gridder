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
				add_action( 'shoestrap_in_article_bottom', function() { echo '</div></div>'; } );
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


if ( !function_exists( 'shoestrap_gridder_script' ) ) :
function shoestrap_gridder_script() {
	$infinitescroll = shoestrap_getVariable( 'shoestrap_gridder_infinite_scroll' );
	$isotope        = shoestrap_getVariable( 'shoestrap_gridder_isotope' );

	$msgText = "";
	$msgText .= "<div class='progress progress-striped active' style='width:220px;margin-bottom:0px;'>";
		$msgText .= "<div class='progress-bar progress-bar-" . __( shoestrap_getVariable( 'shoestrap_gridder_loading_color' ) ) . "' style='width: 100%;'>";
			$msgText .= "<span class='gridder_bar_text'>" . __( shoestrap_getVariable( 'shoestrap_gridder_loading_text' ) ) . "<span>";
		$msgText .= "</div>";
	$msgText .= "</div>";

	$finishedMsg = "";
	$finishedMsg .= "<div class='progress progress-striped active' style='width:220px;margin-bottom:0px;'>";
		$finishedMsg .= "<div class='progress-bar progress-bar-" . __( shoestrap_getVariable( 'shoestrap_gridder_end_color' ) ) . "' style='width: 100%;'>";
			$finishedMsg .= "<span class='gridder_bar_text'>" . __( shoestrap_getVariable( 'shoestrap_gridder_end_text' ) ) . "<span>";
		$finishedMsg .= "</div>";
	$finishedMsg .= "</div>";

	// selector for the paged navigation
		$navSelector  = '.pager';
		// selector for the NEXT link (to page 2)
		$nextSelector = '.pager .previous a';
		// selector for all items you'll retrieve
		$itemSelector = ".hentry";
	?>

	<?php if ( $isotope == 1 || $infinitescroll == 1 ) : ?>
		<script>
		// Using jQuery.noConflict
		var $j = jQuery.noConflict();

		$j(window).load(function(){
			var container = $j('.row .main .wrapperdiv');
			
			// Isotope
			<?php if ( $isotope == 1 ) : ?>
				$j(container).isotope({
					animationEngine: "best-available"
				});
				// SLOPPY
				$j(container).isotope({
				    layoutMode: "sloppyMasonry",
				    itemSelector: ".hentry"
				});
			<?php endif; ?>

			// Infinite
			<?php if ( $infinitescroll == 1 ) : ?>
				$j(container).infinitescroll({
					navSelector  : "<?php echo $navSelector; ?>",
					nextSelector : "<?php echo $nextSelector; ?>",
					itemSelector : "<?php echo $itemSelector; ?>",
					loading: {
						msgText: "<?php echo $msgText; ?>",
						finishedMsg: "<?php echo $finishedMsg; ?>"
					}
			<?php endif; ?>
				<?php if ( $isotope == 1 && $infinitescroll == 1 ) : ?>
					// trigger Masonry as a callback
					},function( newElements ) {
						// hide new items while they are loading
						var newElems = $j( newElements ).css({ opacity: 0 });
						// ensure that images load before adding to masonry layout
						$j(newElems).imagesLoaded(function(){
							// show elems now they're ready
							$j(newElems).animate({ opacity: 1 });
							$j(container).isotope( 'appended', $j(newElems), true );
						});
					});
				<?php elseif ( $isotope == 0 && $infinitescroll == 1 ): ?>
					});
				<?php endif; ?>

		});
		</script>
	<?php endif;
}
endif;


/*
 * Only add the scripts if the user is not seing a single post, page or other custom post type.
 */
if ( !function_exists( 'shoestrap_gridder_enqueue_resources_checked' ) ) :
function shoestrap_gridder_enqueue_resources_checked() {
	if ( !is_singular() ) :
		add_action('wp_enqueue_scripts', 'shoestrap_gridder_enqueue_resources', 201);
		add_action( 'wp_footer', 'shoestrap_gridder_script' );
	endif;
}
endif;
add_action( 'wp', 'shoestrap_gridder_enqueue_resources_checked' );