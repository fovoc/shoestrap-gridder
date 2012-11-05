<?php
$excerpt_visibility           = get_theme_mod( 'shoestrap_gridder_show_text_in_lists' );
$shoestrap_gridder_post_class = shoestrap_gridder_posts_column( false );
$columns                      = get_theme_mod( 'shoestrap_gridder_posts_columns' );
$list_title_size              = get_theme_mod( 'shoestrap_gridder_list_title_size' );

$responsive                   = get_theme_mod( 'shoestrap_responsive' );
if ( $responsive == '0' ) { $layout = 'fixed'; } else { $layout = 'responsive'; }
?>

<?php if (!have_posts()) : ?>
  <div class="alert alert-block fade in">
    <a class="close" data-dismiss="alert">&times;</a>
    <p><?php _e('Sorry, no results were found.', 'shoestrap'); ?></p>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<?php while (have_posts()) : the_post(); ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class( $shoestrap_gridder_post_class . ' entry ' . $layout ); ?>>
    <header>
      <<?php echo $list_title_size; ?>><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></<?php echo $list_title_size; ?>>
      
    </header>
    <div class="entry-content">
      <?php if (has_post_thumbnail()) { ?>
        <div class="pull-left">
          <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('shoestrap-gridder-grid'); ?></a>
        </div>
      <?php }?>

      <?php if ( $excerpt_visibility != 'hide' )
        the_excerpt();
      ?>
    </div>
    <footer>
      <?php the_tags('<ul class="entry-tags"><li>','</li><li>','</li></ul>'); ?>
    </footer>
  </article>
<?php endwhile; ?>

<?php if ($wp_query->max_num_pages > 1) : ?>
  <nav id="post-nav" class="pager" style="clear: both;">
    <div class="previous"><?php next_posts_link(__('&larr; Older posts', 'shoestrap')); ?></div>
    <div class="next"><?php previous_posts_link(__('Newer posts &rarr;', 'shoestrap')); ?></div>
  </nav>
<?php endif; ?>

<script>
  jQuery(document).ready(function($){
    var $container = $('#main');
    
    $container.imagesLoaded( function(){
      $container.masonry({

        itemSelector: '.entry',
        columnWidth: function( containerWidth ) {
          return containerWidth / 12;
        },
        // gutterWidth: 20,
        isResizable: true,
        isAnimated: !Modernizr.csstransitions
      });
    });
    
    $container.imagesLoaded(function(){
      $container.masonry({
        itemSelector: '.entry',
        columnWidth: 100
      });
    });
    
    $container.infinitescroll({
      navSelector  : '#post-nav',    // selector for the paged navigation 
      nextSelector : '#post-nav .previous a',  // selector for the NEXT link (to page 2)
      itemSelector : '.entry',     // selector for all items you'll retrieve
      loading: {
          finishedMsg: 'No more pages to load.',
          img: 'http://i.imgur.com/6RMhx.gif'
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
    
</script>