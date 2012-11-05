<?php

function shoestrap_gridder_customizer_output() {
  
  $background_color = get_theme_mod( 'shoestrap_background_color' );
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
add_action( 'wp_head', 'shoestrap_gridder_customizer_output' );
