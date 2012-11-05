<?php

function shoestrap_gridder_posts_column( $echo = true ) {
  
  $class = get_theme_mod( 'shoestrap_gridder_posts_columns' );
  
  if ( $echo == true ) {
    echo $class;
  } else {
    return $class;
  }
}
