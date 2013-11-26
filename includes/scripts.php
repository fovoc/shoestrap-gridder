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
 		// Use our custom template instead of the default
 		remove_action( 'shoestrap_content_override', 'shoestrap_content_single_override', 10 );
		add_action( 'shoestrap_content_override', 'shoestrap_gridder_template_mods', 10 );
	endif;

	if ( $infinitescroll == 1 ) :
		wp_register_script( 'shoestrap_gridder_infinitescroll', SHOESTRAPGRIDDERURL . '/assets/js/jquery.infinitescroll.min.js', false, null, true );
		wp_enqueue_script( 'shoestrap_gridder_infinitescroll' );
	endif;

	if ( $masonry == 1 || $infinitescroll == 1 ) :
		// Enqueue the styles
		wp_register_style( 'shoestrap_gridder_styles', SHOESTRAPGRIDDERURL . '/assets/css/style.css' );
		wp_enqueue_style( 'shoestrap_gridder_styles' );
		// Wrap the content without the page header into a div
		add_action( 'shoestrap_index_begin', 'shoestrap_gridder_open_wrapper_div', 10 );
		add_action( 'shoestrap_index_end', 'shoestrap_gridder_close_wrapper_div', 10 );
	endif;
}



function shoestrap_gridder_script() {
	$infinitescroll = shoestrap_getVariable( 'shoestrap_gridder_infinite_scroll' );
	$masonry        = shoestrap_getVariable( 'shoestrap_gridder_masorny' );

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
		$itemSelector = '.hentry';
	?>

	<?php if ( $masonry == 1 || $infinitescroll == 1 ) : ?>
		<script>
		// Using jQuery.noConflict
		var $j = jQuery.noConflict();

		$j(window).load(function(){
			var container = $j('.row .main .wrapperdiv');
			
			// Masonry
			<?php if ( $masonry == 1 ) : ?>
				$j(container).masonry({
					itemSelector: '<?php echo $itemSelector; ?>',
					columnWidth: function( containerWidth ) {
						return containerWidth / 12;
					},
					isResizable: true,
					isAnimated: Modernizr.csstransitions
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
				<?php if ( $masonry == 1 && $infinitescroll == 1 ) : ?>
					// trigger Masonry as a callback
					},function( newElements ) {
						// hide new items while they are loading
						var newElems = $j( newElements ).css({ opacity: 0 });
						// ensure that images load before adding to masonry layout
						$j(newElems).imagesLoaded(function(){
							// show elems now they're ready
							$j(newElems).animate({ opacity: 1 });
							$j(container).masonry( 'appended', $j(newElems), true );
						});
					});
				<?php elseif ( $masonry == 0 && $infinitescroll == 1 ): ?>
					});
				<?php endif; ?>

		});
		</script>
	<?php endif;
}

/*
 * Only add the scripts if the user is not seing a single post, page or other custom post type.
 */
function shoestrap_gridder_enqueue_resources_checked() {
	if ( !is_singular() ) {
		add_action('wp_enqueue_scripts', 'shoestrap_gridder_enqueue_resources', 201);
		add_action( 'wp_footer', 'shoestrap_gridder_script' );
	}
}
add_action( 'wp', 'shoestrap_gridder_enqueue_resources_checked' );