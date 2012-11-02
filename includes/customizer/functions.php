<?php

function shoestrap_blog_posts_column( $echo = true ) {
  
  $columns = get_theme_mod( 'shoestrap_blog_posts_columns' );
  
  if ( $columns == '1' ) {
    $class = 'spn1';
  } elseif ( $columns == '2' ) {
    $class = 'spn2';
  } elseif ( $columns == '4' ) {
    $class = 'spn4';
  } else {
    $class = 'spn3';
  }
  
  if ( $echo == true ) {
    echo $class;
  } else {
    return $class;
  }
}

function shoestrap_blog_nnth_child_margins() {
  
  $n = get_theme_mod( 'shoestrap_blog_posts_columns' );
  ?>
  <style>
    .entry:first-child{margin-left: 0;}
    .entry:nth-child(<?php echo $n; ?>n+1){margin-left: 0;}
  </style>
  
<?php }
if ( get_theme_mod( 'shoestrap_blog_frontpage' ) != 'default' ) {
  add_action( 'wp_head', 'shoestrap_blog_nnth_child_margins', 120 );
}
