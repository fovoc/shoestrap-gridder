jQuery(window).load(function() {
  var $container = $('#main');
  
    $container.masonry({

      itemSelector: '.entry',
      columnWidth: function( containerWidth ) {
        return containerWidth / 12;
      },
      isResizable: true,
      isAnimated: Modernizr.csstransitions
  });
	
  $container.infinitescroll({
    navSelector  : '#post-nav',    // selector for the paged navigation
    nextSelector : '#post-nav .previous a',  // selector for the NEXT link (to page 2)
    itemSelector : '.entry',     // selector for all items you'll retrieve
	    loading: {
	        finishedMsg: shoestrapScript.end,
	      }
    },
    // trigger Masonry as a callback
    function( newElements ) {
      // hide new items while they are loading
      var $newElems = $( newElements ).css({ opacity: 0 });
      // ensure that images load before adding to masonry layout
      $newElems.imagesLoaded(function(){
        // show elems now they're ready
        $newElems.animate({ opacity: 1 });
        $container.masonry( 'appended', $newElems, true );
      });
    }
  );
});