jQuery(window).load(function() {
  var $container = $('#product_grid');
  
  $container.infinitescroll({
    navSelector  : '.pagination',    // selector for the paged navigation
    nextSelector : '.pagination .next a',  // selector for the NEXT link (to page 2)
    itemSelector : '.product',     // selector for all items you'll retrieve
    loading: {
        finishedMsg: 'No more pages to load.',
      }
    },
    function( newElements ) {
        $("a.mp_link_buynow, a.mp_link_addcart, input[type='submit'], .mp_button_addcart, .mp_button_buynow").addClass("btn btn-primary");
    }
  );
});