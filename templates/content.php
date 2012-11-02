<?php
$excerpt_visibility         = get_theme_mod( 'shoestrap_blog_show_text_in_lists' );
$shoestrap_blog_post_class  = shoestrap_blog_posts_column_class( false );

?>

<?php if (!have_posts()) : ?>
  <div class="alert alert-block fade in">
    <a class="close" data-dismiss="alert">&times;</a>
    <p><?php _e('Sorry, no results were found.', 'shoestrap'); ?></p>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<?php while (have_posts()) : the_post(); ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class( $shoestrap_blog_post_class ); ?>>
    <header>
      <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <?php get_template_part('templates/entry-meta'); ?>
    </header>
    <div class="entry-content">
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
  <nav id="post-nav" class="pager">
    <div class="previous"><?php next_posts_link(__('&larr; Older posts', 'shoestrap')); ?></div>
    <div class="next"><?php previous_posts_link(__('Newer posts &rarr;', 'shoestrap')); ?></div>
  </nav>
<?php endif; ?>
