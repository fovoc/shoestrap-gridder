<?php

function shoestrap_blog_posts_column_class( $echo = true ) {
  
  $columns = get_theme_mod( 'shoestrap_blog_posts_columns' );
  
  if ( $columns == '1' ) {
    $class = 'span12';
  } elseif ( $columns == '2' ) {
    $class = 'span6';
  } elseif ( $columns == '4' ) {
    $class = 'span3';
  } else {
    $class = 'span4';
  }
  
  if ( $echo == true ) {
    echo $class;
  } else {
    return $class;
  }
}
