<?php


/*
 * The template modifications for posts on archives
 */
function shoestrap_gridder_template_mods() {
  $excerpt_visibility           = shoestrap_getVariable( 'shoestrap_gridder_show_text_in_lists' );
  $shoestrap_gridder_post_class = shoestrap_gridder_posts_column( false );
  $columns                      = shoestrap_getVariable( 'shoestrap_gridder_posts_columns' );
  $list_title_size              = shoestrap_getVariable( 'shoestrap_gridder_list_title_size' );
  $responsive                   = shoestrap_getVariable( 'site_style' );
  $box_style                    = shoestrap_getVariable( 'shoestrap_gridder_box_style' );

  // Set the layout class (fixed/responsive)
  if ( $responsive != 'fluid' )
    $layout = 'fixed';
  else
    $layout = 'responsive';
  
  // Set the heading size
  if ( $list_title_size == 1 )
    $heading = 'h3';
  else
    $heading = 'h4';
  ?>

  <article id="post-<?php the_ID(); ?>" <?php post_class( $shoestrap_gridder_post_class . ' '. $box_style .' '. $layout ); ?>>
    <header>
      <<?php echo $heading; ?>><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></<?php echo $heading; ?>>
    </header>
    <div class="entry-content">
      <?php if (has_post_thumbnail()) { ?>
        <div class="pull-left">
          <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('shoestrap-gridder-grid'); ?></a>
        </div>
      <?php }?>

      <?php if ( $excerpt_visibility == 1 )
        the_excerpt();
      ?>
    </div>
    <footer>
      <?php get_template_part('templates/entry-meta'); ?>
    </footer>
  </article>
  <?php
}

/*
 * Wrap the content without the page header into a div
 */

function shoestrap_gridder_open_wrapper_div() {
  echo '<div class="wrapperdiv">';
}
add_action( 'shoestrap_index_begin', 'shoestrap_gridder_open_wrapper_div', 10 );

function shoestrap_gridder_close_wrapper_div() {
  echo '</div>';
}
add_action( 'shoestrap_index_end', 'shoestrap_gridder_close_wrapper_div', 10 );

