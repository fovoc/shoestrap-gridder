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


function shoestrap_gridder_infinitescroll_script() {
	$infinitescroll = shoestrap_getVariable( 'shoestrap_gridder_infinite_scroll' );
	$masonry        = shoestrap_getVariable( 'shoestrap_gridder_masorny' );

	$finishedMsg = '';
	$finishedMsg .= '<div class="progress progress-striped active" style="width:220px;margin-bottom:0px;">';
		$finishedMsg .= '<div class="progress-bar progress-bar-' . __( shoestrap_getVariable( 'shoestrap_gridder_end_color' ) ) . '" style="width: 100%;">';
			$finishedMsg .= '<span class="gridder_bar_text">' . __( shoestrap_getVariable( 'shoestrap_gridder_end_text' ) ) . '<span>';
		$finishedMsg .= '</div>';
	$finishedMsg .= '</div>';

	$msgText = shoestrap_getVariable( 'shoestrap_gridder_loading_text' );
	// selector for the paged navigation
    $navSelector  = '.pager';
    // selector for the NEXT link (to page 2)
    $nextSelector = '.pager .previous a';
    // selector for all items you'll retrieve
    $itemSelector = '.hentry';
	?>

	<?php if ( $masonry == 1 && $infinitescroll == 1 ) : ?>
		<script>
		// Using jQuery.noConflict
		var $j = jQuery.noConflict();

		$j(window).load(function(){
			var container = $j('.row .main');
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
			<?php if ( $infinitescroll == 1 ) : ?>
				$j(container).infinitescroll({
					navSelector  : '<?php echo $navSelector; ?>',
					nextSelector : '<?php echo $nextSelector; ?>',
					itemSelector : '<?php echo $itemSelector; ?>',
					loading: {
						finishedMsg: '<?php echo $finishedMsg; ?>',
					}
				},
			<?php endif; ?>
			<?php if ( $masonry == 1 && $infinitescroll == 1 ) : ?>
				// trigger Masonry as a callback
				function( newElements ) {
					// hide new items while they are loading
					var newElems = $j( newElements ).css({ opacity: 0 });
					// ensure that images load before adding to masonry layout
					$j(newElems).imagesLoaded(function(){
						// show elems now they're ready
						$j(newElems).animate({ opacity: 1 });
						$j(container).masonry( 'appended', $j(newElems), true );
					});
				});
			<?php endif; ?>
		});
		</script>
	<?php endif;
}
add_action( 'wp_footer', 'shoestrap_gridder_infinitescroll_script' );