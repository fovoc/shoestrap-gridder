<?php

function shoestrap_gridder_posts_column( $echo = true ) {
  
  $class = shoestrap_getVariable( 'shoestrap_gridder_posts_columns', 'normal' );
  
  if ( $echo == true ) {
    echo $class;
  } else {
    return $class;
  }
}

function shoestrap_gridder_output() {
  
  $background_color = shoestrap_getVariable( 'color_body_bg' );
  $background_color = '#' . str_replace( '#', '', $background_color );
  ?>
  <style>
    #main .entry{
      <?php if ( shoestrap_get_brightness( $background_color ) >= 160 ) {
        echo 'color: ' . shoestrap_adjust_brightness( $background_color, -180 ) . ';';
        echo 'background: ' . shoestrap_adjust_brightness( $background_color, 20 ) . ';';
      } else {
        echo 'color: ' . shoestrap_adjust_brightness( $background_color, 180 ) . ';';
        echo 'background: ' . shoestrap_adjust_brightness( $background_color, -20 ) . ';';
      }?>
    }
  </style>

<?php }
add_action( 'wp_head', 'shoestrap_gridder_output' );