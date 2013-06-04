// Using jQuery.noConflict
var $j = jQuery.noConflict();

$j(window).load(function(){
  
  var container = $j('.main .wrapperdiv');
  
  $j(container).masonry({
    itemSelector: '.entry',
    columnWidth: function( containerWidth ) {
      return containerWidth / 12;
    },
    isResizable: true,
    isAnimated: Modernizr.csstransitions
  });
  
  $j(container).infinitescroll({
    navSelector  : '.post-nav .pager',    // selector for the paged navigation
    nextSelector : '.post-nav .pager .previous a',  // selector for the NEXT link (to page 2)
    itemSelector : '.entry',     // selector for all items you'll retrieve
      loading: {
          finishedMsg: shoestrapScript.end,
        }
    },
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
    }
  );
});
