if ( shoestrap_gridder_vars.isotope == 1 || shoestrap_gridder_vars.infinitescroll == 1 ) {
	// Using jQuery.noConflict
	var $j = jQuery.noConflict();

	$j(window).load(function(){
		var container = $j(shoestrap_gridder_vars.container);
			
		// Isotope
		if ( shoestrap_gridder_vars.isotope == 1 ) {
			$j(container).isotope({
				animationEngine: "best-available"
			});
			// Sloppy Masonry
			$j(container).isotope({
			    layoutMode: "sloppyMasonry",
			    itemSelector: shoestrap_gridder_vars.itemSelector
			});
		}

		// Infinite Scroll && Masonry
		if (  shoestrap_gridder_vars.isotope == 1 && shoestrap_gridder_vars.infinitescroll == 1 ) {
			$j(container).infinitescroll({
				navSelector  : shoestrap_gridder_vars.navSelector,
				nextSelector : shoestrap_gridder_vars.nextSelector,
				itemSelector : shoestrap_gridder_vars.itemSelector,
				loading: {
					msgText: 			shoestrap_gridder_vars.msgText,
					finishedMsg: 	shoestrap_gridder_vars.finishedMsg
				}
			// trigger Masonry as a callback
			},function( newElements ) {
				// hide new items while they are loading
				var newElems = $j( newElements ).css({ opacity: 0 });
				// ensure that images load before adding to masonry layout
				$j(newElems).imagesLoaded(function(){
					// show elems now they're ready
					$j(newElems).animate({ opacity: 1 });
					$j(container).isotope( 'insert', $j(newElems), true );
				});
			});
		} 
		// Infinite Scroll only
		else if ( shoestrap_gridder_vars.isotope == 0 && shoestrap_gridder_vars.infinitescroll == 1 ) {
			$j(container).infinitescroll({
				navSelector  : shoestrap_gridder_vars.navSelector,
				nextSelector : shoestrap_gridder_vars.nextSelector,
				itemSelector : shoestrap_gridder_vars.itemSelector,
				loading: {
					msgText: 		 shoestrap_gridder_vars.msgText,
					finishedMsg: shoestrap_gridder_vars.finishedMsg
				}
			});
		}

	});

}