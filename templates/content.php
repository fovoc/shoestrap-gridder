<?php
$excerpt_visibility         = get_theme_mod( 'shoestrap_blog_show_text_in_lists' );
$shoestrap_blog_post_class  = shoestrap_blog_posts_column( false );
$columns = get_theme_mod( 'shoestrap_blog_posts_columns' );

?>

<?php if (!have_posts()) : ?>
  <div class="alert alert-block fade in">
    <a class="close" data-dismiss="alert">&times;</a>
    <p><?php _e('Sorry, no results were found.', 'shoestrap'); ?></p>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<?php while (have_posts()) : the_post(); ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class( $shoestrap_blog_post_class . ' entry' ); ?>>
    <header>
      <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
      <?php get_template_part('templates/entry-meta'); ?>
    </header>
    <div class="entry-content">
      <?php if (has_post_thumbnail()) {
        the_post_thumbnail('thumbnail');
      }?>

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
          return containerWidth / <?php echo $columns; ?>;
        }
      });
    });
  });
</script>
