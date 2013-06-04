<?php

/*
 * The Gridder core options
 */
if ( !function_exists( 'shoestrap_gridder_module_options' ) ) {
  function shoestrap_gridder_module_options() {

  /*-----------------------------------------------------------------------------------*/
  /* The Options Array */
  /*-----------------------------------------------------------------------------------*/

  // Set the Options Array
  global $of_options, $smof_details;

  // Gridder Options
  $of_options[] = array(
    "name"      => __("Gridder Options", "shoestrap"),
    "type"      => "heading"
  );

  $of_options[] = array(
    "name"      => "",
    "desc"      => "",
    "id"        => "shoestrap_gridder_info",
    "std"       => "<h3 style=\"margin: 0 0 10px;\">Gridder Options</h3>
                    <p>Here you change options considering the Shoestrap Gridder plugin.</p><p><strong>Notice: </strong>In order to control the flow of incoming posts through the infinite scroll plugin, you can do so under <i>Setting->Reading->Blog pages show at most<i>.</p>",
    "icon"      => true,
    "type"      => "info"
  );

  $of_options[] = array(
      "name"      => __("Show text in lists", "shoestrap"),
      "id"        => "shoestrap_gridder_show_text_in_lists",
      "std"       => 1,
      "on"        => __("Show", "shoestrap"),
      "off"       => __("Hide", "shoestrap"),
      "type"      => "switch"
    );

  $of_options[] = array(
      "name"      => __("Select list title size", "shoestrap"),
      "id"        => "shoestrap_gridder_list_title_size",
      "std"       => 1,
      "on"        => __("h3", "shoestrap"),
      "off"       => __("h4", "shoestrap"),
      "type"      => "switch",
    );

  $of_options[] = array(
      "name"      => __("Loading text", "shoestrap"),
      "desc"      => __("The text inside the progress bar as next set is loading.", "shoestrap"),
      "id"        => "shoestrap_gridder_loading_text",
      "std"       => "Loading...",
      "type"      => "text",
    );

  $of_options[] = array(
      "name"      => __("End text", "shoestrap"),
      "desc"      => __("The text inside the progress bar when no more posts are available.", "shoestrap"),
      "id"        => "shoestrap_gridder_end_text",
      "std"       => "End of list",
      "type"      => "text",
    );

  $of_options[] = array(
      "name"      => __("Loading progress bar color", "shoestrap"),
      "desc"      => __("Select the color of progress bar as next set is loading.", "shoestrap"),
      "id"        => "shoestrap_gridder_loading_color",
      "std"       => "info",
      "type"      => "select",
      "options"   => array(
        "info"      => "info",
        "success"   => "success",
        "warning"   => "warning",
        "danger"    => "danger",
      )
    );

  $of_options[] = array(
      "name"      => __("End progress bar color", "shoestrap"),
      "desc"      => __("Select the color of progress bar when no more posts are available.", "shoestrap"),
      "id"        => "shoestrap_gridder_end_color",
      "std"       => "success",
      "type"      => "select",
      "options"   => array(
        "info"      => "info",
        "success"   => "success",
        "warning"   => "warning",
        "danger"    => "danger",
      )
    );

  $of_options[] = array(
      "name"      => __("Post width", "shoestrap"),
      "desc"      => __("Select the width of a single post. This eventually changes the number of columns.", "shoestrap"),
      "id"        => "shoestrap_gridder_posts_columns",
      "std"       => "normal",
      "type"      => "select",
      "options"   => array(
        "narrow"    => "narrow",
        "normal"    => "normal",
        "wide"      => "wide",
      )
    );

  $of_options[] = array(
      "name"      => __("Show entry metadata", "shoestrap"),
      "desc"      => __("Enable this option to show the entry metadata of posts. Default: OFF.", "shoestrap"),
      "id"        => "entry_meta",
      "std"       => 0,
      "type"      => "switch"
    );

  do_action( 'shoestrap_gridder_module_options_modifier' );

  $smof_details = array();
    foreach( $of_options as $option ) {
      $smof_details[$option['id']] = $option;
    }
  }

}
add_action( 'init','shoestrap_gridder_module_options', 55 );

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
