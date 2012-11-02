<?php
  
function shoestrap_blog_load_single_template($template) {
  global $wp_query, $post;
  
  $frontpage_mode = get_theme_mod( 'shoestrap_blog_frontpage' );

  // Frontpage Posts list (if selected so in the customizer)
  if ( is_front_page() && $frontpage_mode == 'blog_list' ) {
    return dirname(__FILE__) . '/templates/index.php';
  }
  
  return $template;
}
add_filter('template_include', 'shoestrap_blog_load_single_template', 1, 1);
