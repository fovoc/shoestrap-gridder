<?php

if ( !function_exists( 'shoestrap_gridder_posts_column' ) ) :
function shoestrap_gridder_posts_column( $echo = true ) {
	
	$class = function_exists( 'shoestrap_getVariable' ) ? shoestrap_getVariable( 'shoestrap_gridder_posts_columns', 'normal' ) : '';
	
	if ( $echo == true ) :
		echo $class;
	else :
		return $class;
	endif;
}
endif;


if ( !function_exists( 'shoestrap_gridder_output' ) ) :
function shoestrap_gridder_output() {
	$background_color = function_exists( 'shoestrap_getVariable' ) ? '#' . str_replace( '#', '', shoestrap_getVariable( 'color_body_bg' ) ) : '';
	echo '<style>';
	echo '#main .hentry {';
	if ( function_exists( 'shoestrap_get_brightness' ) && function_exists( 'shoestrap_adjust_brightness' ) ) :
		if ( shoestrap_get_brightness( $background_color ) >= 160 ) :
			echo 'color: ' . shoestrap_adjust_brightness( $background_color, -180 ) . ';';
			echo 'background: ' . shoestrap_adjust_brightness( $background_color, 20 ) . ';';
		else :
			echo 'color: ' . shoestrap_adjust_brightness( $background_color, 180 ) . ';';
			echo 'background: ' . shoestrap_adjust_brightness( $background_color, -20 ) . ';';
		endif;
	endif;
	echo '}';
	echo '</style>';
}
endif;
add_action( 'wp_head', 'shoestrap_gridder_output' );