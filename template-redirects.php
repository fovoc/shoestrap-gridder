<?php
  
function shoestrap_blog_load_single_template($template) {
  global $wp_query, $post;
  
  $frontpage_mode = get_theme_mod( 'shoestrap_blog_frontpage' );

  // Frontpage Posts list (if selected so in the customizer)
  if ( !is_singular() ) {
    return dirname(__FILE__) . '/templates/content.php';
  } elseif ( is_page() ) {
    return dirname(__FILE__) . '/templates/page.php';
  } else {
    return dirname(__FILE__) . '/templates/single.php';
  }
}
add_filter('template_include', 'shoestrap_blog_load_single_template', 1, 1);
