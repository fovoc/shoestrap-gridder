<?php
  
function shoestrap_gridder_load_single_template($template) {
  global $wp_query, $post;
  
  if ( !is_singular() ) {
    return dirname(__FILE__) . '/templates/content.php';
  } elseif ( is_page() ) {
    return dirname(__FILE__) . '/templates/page.php';
  } else {
    return dirname(__FILE__) . '/templates/single.php';
  }
}
add_filter('template_include', 'shoestrap_gridder_load_single_template', 1, 1);
