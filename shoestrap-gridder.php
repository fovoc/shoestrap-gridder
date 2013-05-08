<?php
/*
Plugin Name: Shoestrap Gridder Addon
Plugin URI: http://bootstrap-commerce.com
Description: This plugin adds the necessary templates and functions to the shoestrap theme
Version: 1.15
Author: Aristeides Stathopoulos
Author URI: http://aristeides.com
*/

add_image_size( 'shoestrap-gridder-grid', 350 );

require_once dirname( __FILE__ ) . '/includes/licencing.php';
require_once dirname( __FILE__ ) . '/includes/customizer.php';

/*
 * Enqueue the necessary javascript and css resources
 */
function shoestrap_gridder_enqueue_resources() {

  // Enqueue the styles
  wp_enqueue_style('shoestrap_gridder_styles', plugins_url('assets/css/style.css', __FILE__), false, null);

  // Infinite scroll jQuery Plugin
  wp_register_script('shoestrap_gridder_infinitescroll', plugins_url( 'assets/js/jquery.infinitescroll.min.js', __FILE__ ), false, null, true);
  wp_enqueue_script('shoestrap_gridder_infinitescroll');

	// Masonry jQuery Plugin
  wp_register_script('shoestrap_gridder_masonry', plugins_url( 'assets/js/jquery.masonry.min.js', __FILE__ ), false, null, true);
  wp_enqueue_script('shoestrap_gridder_masonry');
  
  // Plugin-specific script
  wp_register_script('shoestrap_gridder_script', plugins_url( 'assets/js/scripts.js', __FILE__ ), false, null, true);

  wp_localize_script( 'shoestrap_gridder_script', 'shoestrapScript', array(
    'loadingImg'    => '/assets/images/empty.gif',
    'end' 					=> '<div class="progress '.__( get_theme_mod('shoestrap_gridder_end_color')).' progress-striped active" style="width:220px;margin-bottom:0px;"><div class="bar" style="width: 100%;">'.__( get_theme_mod('shoestrap_gridder_end_text')).'</div></div>'
  ) );

	$translation_array = array( 'text' => '<div class="progress '.__( get_theme_mod('shoestrap_gridder_loading_color')).' progress-striped active" style="width:220px;margin-bottom:0px;"><div class="bar" style="width: 100%;">'.__( get_theme_mod('shoestrap_gridder_loading_text')).'</div></div>' );
	wp_localize_script( 'shoestrap_gridder_infinitescroll', 'msg', $translation_array );
	
  wp_enqueue_script('shoestrap_gridder_script');
}

/*
 * Only add the scripts if the user is not seing a single post, page or other custom post type.
 */
function shoestrap_gridder_enqueue_resources_checked() {
  if ( !is_singular() ) {
    add_action('wp_enqueue_scripts', 'shoestrap_gridder_enqueue_resources', 201);
  }
}
add_action( 'wp', 'shoestrap_gridder_enqueue_resources_checked' );

/*
 * The template modifications for posts on archives
 */
function shoestrap_gridder_template_mods() {
  $excerpt_visibility           = get_theme_mod( 'shoestrap_gridder_show_text_in_lists' );
  $shoestrap_gridder_post_class = shoestrap_gridder_posts_column( false );
  $columns                      = get_theme_mod( 'shoestrap_gridder_posts_columns' );
  $list_title_size              = get_theme_mod( 'shoestrap_gridder_list_title_size' );
  $responsive                   = get_theme_mod( 'shoestrap_responsive' );

  // Set the layout class (fixed/responsive)
  if ( $responsive == '0' )
    $layout = 'fixed';
  else
    $layout = 'responsive';
  ?>

  <article id="post-<?php the_ID(); ?>" <?php post_class( $shoestrap_gridder_post_class . ' entry ' . $layout ); ?>>
    <header>
      <<?php echo $list_title_size; ?>><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></<?php echo $list_title_size; ?>>
    </header>
    <div class="entry-content">
      <?php if (has_post_thumbnail()) { ?>
        <div class="pull-left">
          <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('shoestrap-gridder-grid'); ?></a>
        </div>
      <?php }?>

      <?php if ( $excerpt_visibility != 'hide' )
        the_excerpt();
      ?>
    </div>
    <footer>
      <?php the_tags('<ul class="entry-tags"><li>','</li><li>','</li></ul>'); ?>
    </footer>
  </article>
  <?php
}

/*
 * Use our custom template instead of the default
 */
function shoestrap_gridder_template_mods_actions() {
  remove_action( 'shoestrap_article_content', 'shoestrap_article_content_action', 10 );
  add_action( 'shoestrap_article_content', 'shoestrap_gridder_template_mods', 10 );
}
add_action( 'shoestrap_article_content', 'shoestrap_gridder_template_mods_actions', 1 );

function shoestrap_gridder_open_wrapper_div() {
  echo '<div class="wrapperdiv">';
}
add_action( 'shoestrap_index_begin', 'shoestrap_gridder_open_wrapper_div', 10 );

function shoestrap_gridder_close_wrapper_div() {
  echo '</div>';
}
add_action( 'shoestrap_index_end', 'shoestrap_gridder_close_wrapper_div', 10 );

