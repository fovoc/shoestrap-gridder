jQuery(window).load(function() {
  var $container = $('#product_grid');
  
    // $container.masonry({
// 
      // itemSelector: '.product',
      // columnWidth: function( containerWidth ) {
        // return containerWidth / 12;
      // },
      // // gutterWidth: 20,
      // isResizable: true,
      // isAnimated: !Modernizr.csstransitions
  // });

  $container.infinitescroll({
    navSelector  : '.pagination',    // selector for the paged navigation
    nextSelector : '.pagination .next a',  // selector for the NEXT link (to page 2)
    itemSelector : '.product',     // selector for all items you'll retrieve
    loading: {
        finishedMsg: 'No more pages to load.',
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