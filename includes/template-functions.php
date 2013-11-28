<?php


/*
 * Add classes to single posts
 */
function shoestrap_gridder_post_classes( $classes ) {
  global $post;
  // get the specified width ( narrow/normal/wide )
  $mode = shoestrap_getVariable( 'shoestrap_gridder_posts_columns', 'normal' );
  
  // Remove unnecessary classes
  foreach (range(0, 12) as $number) {
    $remove_classes[] = 'col-xs-'.$number.'';
    $remove_classes[] = 'col-sm-'.$number.'';
    $remove_classes[] = 'col-md-'.$number.'';
    $remove_classes[] = 'col-lg-'.$number.'';
  }
  $classes = array_diff($classes, $remove_classes);

  $classes[] = '';
  // calculate the css classes based on the above selection
  if ( $mode == 'narrow' ) :
    $classes[] = 'col-lg-3';
    $classes[] = 'col-md-4';
    $classes[] = 'col-sm-6';
    $classes[] = 'col-xs-12';
  elseif ( $mode == 'normal' ) :
    $classes[] = 'col-lg-4';
    $classes[] = 'col-md-6';
    $classes[] = 'col-sm-6';
    $classes[] = 'col-xs-12';
  else :
    $classes[] = 'col-lg-6';
    $classes[] = 'col-md-6';
    $classes[] = 'col-sm-12';
    $classes[] = 'col-xs-12';
  endif;

  // If this is NOT a singular post/page etc, return the classes
  if ( !is_singular() ) :
    return $classes;
  endif;
}

/*
 * Add an extra div for wells or panels
 */
function shoestrap_gridder_article_in_top() {
  $class = '';
  if ( shoestrap_getVariable( 'shoestrap_gridder_box_style' ) == 'well' ) :
    $class = 'well well-sm';
  elseif ( shoestrap_getVariable( 'shoestrap_gridder_box_style' ) == 'panel' ) :
    $class = 'panel panel-default';
  endif;

  echo '<div class="' .$class . '">';
}

/*
 * Override the header for panels
 */
function shoestrap_gridder_override_header_panel() { ?>
  <header class="panel-heading">
    <h4 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
  </header>
  <?php do_action( 'shoestrap_after_entry_meta' ); ?>
  <div class="panel-body">
  <?php
}

/*
 * Override the header for wells
 */
function shoestrap_gridder_override_header_well() { ?>
  <header>
    <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
  </header>
  <?php do_action( 'shoestrap_after_entry_meta' ); ?>
  <?php
}

/*
 * Wrap the content without the page header into a div
 */
function shoestrap_gridder_open_wrapper_div() {
  echo '<div class="wrapperdiv row">';
}
function shoestrap_gridder_close_wrapper_div() {
  echo '</div>';
}
