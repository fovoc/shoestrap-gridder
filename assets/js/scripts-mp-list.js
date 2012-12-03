jQuery(window).load(function() {
  var $container = $('#product_list');
  
  $container.infinitescroll({
    navSelector  : '.pagination',    // selector for the paged navigation
    nextSelector : '.pagination .next a',  // selector for the NEXT link (to page 2)
    itemSelector : '.product',     // selector for all items you'll retrieve
    loading: {
        finishedMsg: 'No more pages to load.',
      }
  });
});