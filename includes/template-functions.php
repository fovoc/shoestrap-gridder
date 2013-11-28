<?php


/*
 * Add classes to single posts
 */
if ( !function_exists( 'shoestrap_gridder_post_classes' ) ) :
function shoestrap_gridder_post_classes( $classes ) {
	global $post;
	// get the specified width ( narrow/normal/wide )
	$mode = shoestrap_getVariable( 'shoestrap_gridder_posts_columns', 'normal' );
	
	// Remove unnecessary classes
	foreach (range(0, 12) as $number) :
		$remove_classes[] = 'col-xs-'.$number.'';
		$remove_classes[] = 'col-sm-'.$number.'';
		$remove_classes[] = 'col-md-'.$number.'';
		$remove_classes[] = 'col-lg-'.$number.'';
	endforeach;

	$classes = array_diff( $classes, $remove_classes );

	$classes[] = '';
	// calculate the css classes based on the above selection
	if ( $mode == 'narrow' ) :
		$classes[] = 'col-lg-3';
		$classes[] = 'col-md-4';
		$classes[] = 'col-sm-6';
		$classes[] = 'col-xs-12';
	elseif ( $mode == 'normal' ) :
		$classes[] = 'col-lg-4';
		$classes[] = 'col-md-6';
		$classes[] = 'col-sm-6';
		$classes[] = 'col-xs-12';
	else :
		$classes[] = 'col-lg-6';
		$classes[] = 'col-md-6';
		$classes[] = 'col-sm-12';
		$classes[] = 'col-xs-12';
	endif;

	// If this is NOT a singular post/page etc, return the classes
	if ( !is_singular() ) :
		return $classes;
	endif;
}
endif;


/*
 * Add an extra div for wells or panels
 */
if ( !function_exists( 'shoestrap_gridder_article_in_top' ) ) :
function shoestrap_gridder_article_in_top() {
	$class = '';
	if ( shoestrap_getVariable( 'shoestrap_gridder_box_style' ) == 'well' ) :
		$class = 'well well-sm';
	elseif ( shoestrap_getVariable( 'shoestrap_gridder_box_style' ) == 'panel' ) :
		$class = 'panel panel-default';
	endif;

	echo '<div class="' .$class . '">';
}
endif;


/*
 * Override the header for panels
 */
if ( !function_exists( 'shoestrap_gridder_override_header_panel' ) ) :
function shoestrap_gridder_override_header_panel() { ?>
	<header class="panel-heading">
		<h4 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	</header>
	<?php do_action( 'shoestrap_after_entry_meta' ); ?>
	<div class="panel-body">
	<?php
}
endif;


/*
 * Override the header for wells
 */
if ( !function_exists( 'shoestrap_gridder_override_header_well' ) ) :
function shoestrap_gridder_override_header_well() { ?>
	<header>
		<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	</header>
	<?php do_action( 'shoestrap_after_entry_meta' ); ?>
	<?php
}
endif;


/*
 * Wrap the content without the page header into a div
 */
if ( !function_exists( 'shoestrap_gridder_open_wrapper_div' ) ) :
function shoestrap_gridder_open_wrapper_div() {
	echo '<div class="wrapperdiv row">';
}
endif;

if ( !function_exists( 'shoestrap_gridder_close_wrapper_div' ) ) :
function shoestrap_gridder_close_wrapper_div() {
	echo '</div>';
}
endif;