<?php


if ( !class_exists( 'ShoestrapGridder' ) ) {

	/**
	* The main plugin class
	*/
	class ShoestrapGridder {

		function __construct() {
			$settings = get_option( SHOESTRAP_OPT_NAME );

			// compatibility for Shoestrap version < 3.0.3.02
			if ( defined( 'SHOESTRAP_OPT_NAME' ) ) {
				$option_name = SHOESTRAP_OPT_NAME;
			} else if ( defined( 'REDUX_OPT_NAME' ) ) {
				$option_name = REDUX_OPT_NAME;
			}
			add_filter( 'redux/options/' . $option_name . '/sections', array( $this, 'options' ), 187 );

			// Add the CSS
			add_action( 'wp_enqueue_scripts', array( $this, 'css' ), 101 );

			// Load scripts
			add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ), 101 );

			// Only add the scripts if the user is not seing a single post, page or other custom post type.
			if ( !is_singular() ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ), 201 );

				if ( $settings['shoestrap_gridder_box_style'] == 'panel' || $settings['shoestrap_gridder_box_style'] == 'well' ) {
					add_filter( 'shoestrap_title_section', array( $this, 'title' ) );

					if ( $settings['shoestrap_gridder_box_style'] == 'panel' )
						add_action( 'shoestrap_in_article_bottom', array( $this, 'dummy_close_div' ) );
				}
			}

			$infinitescroll = $settings['shoestrap_gridder_infinite_scroll'];
			$isotope        = $settings['shoestrap_gridder_isotope'];

			if ( $isotope == 1 || $infinitescroll == 1 ) {

				// Wrap the content without the page header into a div
				add_action( 'shoestrap_index_begin', array( $this, 'open_wrapper_div' ), 10 );
				add_action( 'shoestrap_index_end', array( $this, 'close_wrapper_div' ), 10 );

				if ( $isotope == 1 ) {

					// Insert the Well or Panel class
					add_action( 'shoestrap_in_article_top', array( $this, 'article_in_top' ) );

					// Insert the appropriate classes for grid
					add_filter( 'post_class', array( $this, 'post_classes' ) );
				}
			}
		}

		/*
		 * Gridder Addon admin options
		 */
		function options( $sections ) {
			global $redux;

			$section = array(
				'title' => __( 'Gridder', 'shoestrap' ),
				'icon'  => 'el-icon-th'
			);

			$fields[] = array( 
				'title'     => __( 'Enable Isotope (Masonry)', 'shoestrap' ),
				'desc'      => __( 'Default: On.', 'shoestrap' ),
				'id'        => 'shoestrap_gridder_isotope',
				'default'   => 1,
				'type'      => 'switch'
			);

			$fields[] = array( 
				'title'     => __( 'Select between box styles', 'shoestrap' ),
				'desc'      => __( 'Select between box styles.', 'shoestrap' ),
				'id'        => 'shoestrap_gridder_box_style',
				'type'      => 'button_set',
				'options'   => array(
					' '       => 'Default',
					'well'    => 'Well',
					'panel'   => 'Panel'
				),
				'default' => ' ',
				'required'  => array( 'shoestrap_gridder_isotope','=',array( '1' ) ),
			);

			$fields[] = array(
				'title'     => __( 'Post Width', 'shoestrap' ),
				'desc'      => __( 'Select the width of a single post. This eventually changes the number of columns.', 'shoestrap' ),
				'id'        => 'shoestrap_gridder_posts_columns',
				'type'      => 'select',
				'options'   => array(
					'narrow' => 'Narrow',
					'normal' => 'Normal',
					'wide'   => 'Wide'
				),
				'default' => 'normal',
				'required'  => array( 'shoestrap_gridder_isotope','=',array( '1' ) ),
			);

			$fields[] = array( 
				'title'     => __( 'Enable Infinite Scroll', 'shoestrap' ),
				'desc'      => __( 'Default: On.', 'shoestrap' ),
				'id'        => 'shoestrap_gridder_infinite_scroll',
				'default'   => 1,
				'type'      => 'switch'
			);

			$fields[] = array( 
				'title'     => __( 'Loading text', 'shoestrap' ),
				'desc'      => __( 'The text inside the progress bar as next set is loading.', 'shoestrap' ),
				'id'        => 'shoestrap_gridder_loading_text',
				'default'   => 'Loading...',
				'type'      => 'text',
				'required'  => array( 'shoestrap_gridder_infinite_scroll','=',array( '1' ) ),
			);

			$fields[] = array( 
				'title'     => __( 'End text', 'shoestrap' ),
				'desc'      => __( 'The text inside the progress bar when no more posts are available.', 'shoestrap' ),
				'id'        => 'shoestrap_gridder_end_text',
				'default'   => 'End of list',
				'type'      => 'text',
				'required'  => array( 'shoestrap_gridder_infinite_scroll','=',array( '1' ) ),
			);

			$fields[] = array( 
				'title'     => __( 'Loading progress bar color', 'shoestrap' ),
				'desc'      => __( 'Select between standard Bootstrap\'s progress bars classes', 'shoestrap' ),
				'id'        => 'shoestrap_gridder_loading_color',
				'default'   => 'default',
				'type'      => 'select',
				'customizer'=> array(),
				'options'   => array( 
					'default' => 'Default',
					'info'    => 'Info',
					'success' => 'Success',
					'warning' => 'Warning',
					'danger'  => 'Danger'
				),
				'required'  => array( 'shoestrap_gridder_infinite_scroll','=',array( '1' ) ),
			);

			$fields[] = array( 
				'title'     => __( 'End progress bar color', 'shoestrap' ),
				'desc'      => __( 'Select between standard Bootstrap\'s progress bars classes', 'shoestrap' ),
				'id'        => 'shoestrap_gridder_end_color',
				'default'   => 'default',
				'type'      => 'select',
				'customizer'=> array(),
				'options'   => array( 
					'default' => 'Default',
					'info'    => 'Info',
					'success' => 'Success',
					'warning' => 'Warning',
					'danger'  => 'Danger'
				),
				'required'  => array( 'shoestrap_gridder_infinite_scroll','=',array( '1' ) ),
			);

			$fields[] = array( 
				'title' 		=> __( 'Gridder Selectors', 'shoestrap' ),
				'desc'      => __( 'Change the selectors that triggers Isotope(Masonry) and Infinite Scroll. Use at your own risk.', 'shoestrap' ),
				'id'        => 'shoestrap_gridder_selectors',
				'default'   => 0,
				'type'      => 'switch'
			);

			$fields[] = array( 
				'title'     => __( 'Masonry Container', 'shoestrap' ),
				'desc'      => __( 'Select the container that contains your items. (e.g. #grid or .product-list)', 'shoestrap' ),
				'id'        => 'shoestrap_gridder_container',
				'default'   => '.row .main .wrapperdiv',
				'type'      => 'text',
				'required'  => array( 'shoestrap_gridder_selectors','=',array( '1' ) ),
			);

			$fields[] = array( 
				'title'     => __( 'Masonry && Infinite Scroll Item', 'shoestrap' ),
				'desc'      => __( 'Select your items with a class (e.g. .products)', 'shoestrap' ),
				'id'        => 'shoestrap_gridder_item',
				'default'   => '.hentry',
				'type'      => 'text',
				'required'  => array( 'shoestrap_gridder_selectors','=',array( '1' ) ),
			);

			$fields[] = array( 
				'title'     => __( 'Infinite Scroll Navigation Selector', 'shoestrap' ),
				'desc'      => __( 'Select your Navigation. (e.g. .pager or .pagination)', 'shoestrap' ),
				'id'        => 'shoestrap_gridder_navigation',
				'default'   => '.pagination',
				'type'      => 'text',
				'required'  => array( 'shoestrap_gridder_selectors','=',array( '1' ) ),
			);

			$fields[] = array( 
				'title'     => __( 'Infinite Scroll Next-Page Selector', 'shoestrap' ),
				'desc'      => __( 'Select your Next-Page. (e.g. .pager .previous a)', 'shoestrap' ),
				'id'        => 'shoestrap_gridder_nextpage',
				'default'   => '.pagination li a.next',
				'type'      => 'text',
				'required'  => array( 'shoestrap_gridder_selectors','=',array( '1' ) ),
			);


			$section['fields'] = $fields;

			$section = apply_filters( 'shoestrap_module_gridder_options_modifier', $section );
			
			$sections[] = $section;
			return $sections;
		}

		function posts_columns( $echo = true ) {
			$settings = get_option( SHOESTRAP_OPT_NAME );

			$class = $settings['shoestrap_gridder_posts_columns'];

			if ( $echo == true )
				echo $class;
			else
				return $class;
		}

		function css() {

			// Do not continue if is_singular
			if ( is_singular() )
				return;

			$settings = get_option( SHOESTRAP_OPT_NAME );

			$background_color = null;

			$body_bg =  $settings['body_bg'];
			if ( isset( $body_bg['background-color'] ) )
				$background_color = '#' . str_replace( '#', '', $body_bg['background-color'] );

			// Do not proceed if not needed.
			if ( is_null( $background_color ) )
				return;

			$css = '';
			if ( class_exists( 'ShoestrapColor' ) ) {
				$css = '#main .hentry {';

				if ( ShoestrapColor::get_brightness( $background_color ) >= 160 ) {

					$css .= 'color: ' . ShoestrapColor::adjust_brightness( $background_color, -180 ) . ';';
					$css .= 'background-color: ' . ShoestrapColor::adjust_brightness( $background_color, 20 ) . ';';

				} else {

					$css .= 'color: ' . ShoestrapColor::adjust_brightness( $background_color, 180 ) . ';';
					$css .= 'background-color: ' . ShoestrapColor::adjust_brightness( $background_color, -20 ) . ';';
				}

				$css .= '}';
			}

			wp_add_inline_style( 'shoestrap_css', $css );
		}

		function dummy_close_div() {
			// Do not continue if is_singular
			if ( is_singular() )
				return;

			echo '</div>';
		}

		/*
		 * Add classes to single posts
		 */
		function post_classes( $classes ) {
			global $post, $ss_framework;

			// Do not continue if is_singular
			if ( !is_singular() && !is_post_type_archive('tribe_events') ) {

				$settings = get_option( SHOESTRAP_OPT_NAME );
				// get the specified width ( narrow/normal/wide )
				$mode = $settings['shoestrap_gridder_posts_columns'];
				
				// Remove unnecessary classes
				foreach ( range( 0, 12 ) as $number) {
					$remove_classes[] = $ss_framework->column_classes( array( 'mobile' => $number, 'tablet' => $number, 'medium' => $number, 'large' => $number ), null );
				}

				$classes = array_diff( $classes, $remove_classes );

				// calculate the css classes based on the above selection
				if ( $mode == 'narrow' ) {
					
					$classes[] = $ss_framework->column_classes( array( 'mobile' => 12, 'tablet' => 6, 'medium' => 4, 'large' => 3 ), null );

				} elseif ( $mode == 'normal' ) {

					$classes[] = $ss_framework->column_classes( array( 'mobile' => 12, 'tablet' => 6, 'medium' => 6, 'large' => 4 ), null );

				} else {

					$classes[] = $ss_framework->column_classes( array( 'mobile' => 12, 'tablet' => 12, 'medium' => 6, 'large' => 6 ), null );

				}
			}
			return $classes;
		}

		/*
		 * Add an extra div for wells or panels
		 */
		function article_in_top() {

			// Do not continue if is_singular
			if ( is_singular() )
				return;

			$settings = get_option( SHOESTRAP_OPT_NAME );

			$class = '';

			if ( $settings['shoestrap_gridder_box_style'] == 'well' )
				$class = 'well well-sm';
			elseif ( $settings['shoestrap_gridder_box_style'] == 'panel' )
				$class = 'panel panel-default';

			echo '<div class="' . $class . '">';
		}

		/*
		 * Wrap the content without the page header into a div
		 */
		function open_wrapper_div() {
			// Do not continue if is_singular
			if ( is_singular() )
				return;

			global $ss_framework;
			echo $ss_framework->open_row( 'div', null, 'wrapperdiv', null );
		}

		function close_wrapper_div() {
			// Do not continue if is_singular
			if ( is_singular() )
				return;

			global $ss_framework;
			echo $ss_framework->close_row( 'div' );
		}

		/*
		 * Enqueue the necessary javascript and css resources
		 */
		function enqueue_assets() {
			// Do not continue if is_singular
			if ( is_singular() )
				return;

			$settings = get_option( SHOESTRAP_OPT_NAME );

			$infinitescroll = $settings['shoestrap_gridder_infinite_scroll'];
			$isotope        = $settings['shoestrap_gridder_isotope'];

			if ( $isotope == 1 || $infinitescroll == 1 ) {

				// Enqueue the styles
				wp_register_style( 'shoestrap_gridder_styles', SHOESTRAPGRIDDERURL . '/assets/css/style.css' );
				wp_enqueue_style( 'shoestrap_gridder_styles' );

				if ( $isotope == 1 ) {

					// Register && Enqueue Isotope
					wp_enqueue_style( 'shoestrap_gridder_styles', SHOESTRAPGRIDDERURL . '/assets/css/style.css', false, null );
					wp_register_script( 'shoestrap_gridder_isotope', SHOESTRAPGRIDDERURL . '/assets/js/jquery.isotope.min.js', false, null, true );
					wp_enqueue_script( 'shoestrap_gridder_isotope' );

					// Register && Enqueue Isotope Sloppy Masonry
					wp_enqueue_style( 'shoestrap_gridder_styles', SHOESTRAPGRIDDERURL . '/assets/css/style.css', false, null );
					wp_register_script( 'shoestrap_gridder_sloppy', SHOESTRAPGRIDDERURL . '/assets/js/jquery.isotope.sloppy-masonry.min.js', false, null, true );
					wp_enqueue_script( 'shoestrap_gridder_sloppy' );

				}

				if ( $infinitescroll == 1 ) {
					wp_register_script( 'shoestrap_gridder_infinitescroll', SHOESTRAPGRIDDERURL . '/assets/js/jquery.infinitescroll.min.js', false, null, true );
					wp_enqueue_script( 'shoestrap_gridder_infinitescroll' );
					wp_register_script( 'shoestrap_gridder_imagesloaded', SHOESTRAPGRIDDERURL . '/assets/js/imagesloaded.pkgd.min.js', false, null, true );
					wp_enqueue_script( 'shoestrap_gridder_imagesloaded' );
				}
			}
		}

		/*
		 * Load our custom scripts
		 */
		function load_scripts() {
			// Do not continue if is_singular
			if ( is_singular() )
				return;

			$settings = get_option( SHOESTRAP_OPT_NAME );

			$selectors = $settings['shoestrap_gridder_selectors'];

			if ( $selectors == 1 ) {

				$navSelector  = $settings['shoestrap_gridder_navigation'];
				$nextSelector = $settings['shoestrap_gridder_nextpage'];
				$itemSelector = $settings['shoestrap_gridder_item'];
				$container    = $settings['shoestrap_gridder_container'];

			} else {

				$navSelector  = '.pagination';
				$nextSelector = '.pagination li a.next';
				$itemSelector = '.hentry';
				$container    = '.row .main .wrapperdiv';

			}

			wp_enqueue_script( 'shoestrap_gridder_script', SHOESTRAPGRIDDERURL . '/assets/js/scripts.js' );

			wp_localize_script( 'shoestrap_gridder_script', 'shoestrap_gridder_vars', array(
				'isotope'        => $settings['shoestrap_gridder_isotope'],
				'infinitescroll' => $settings['shoestrap_gridder_infinite_scroll'],
				'msgText'        => "<div class='progress progress-striped active' style='width:220px;margin-bottom:0px;'><div class='progress-bar progress-bar-" . __( $settings['shoestrap_gridder_loading_color'] ) . "' style='width: 100%;'><span class='edd_bar_text'>" . __( $settings['shoestrap_gridder_loading_text'] ) . "<span></div></div>",
				'finishedMsg'    => "<div class='progress progress-striped active' style='width:220px;margin-bottom:0px;'><div class='progress-bar progress-bar-" . __( $settings['shoestrap_gridder_end_color'] ) . "' style='width: 100%;'><span class='edd_bar_text'>" . __( $settings['shoestrap_gridder_end_text'] ) . "<span></div></div>",
				'navSelector'    => $navSelector,
				'nextSelector'   => $nextSelector,
				'itemSelector'   => $itemSelector,
				'container'      => $container
			) );
		}

		/**
		 * The title secion.
		 * Overrides the default one included in the theme.
		 */
		function title( $title ) {
			// Do not continue if is_singular
			if ( !is_singular() ) {
				global $ss_framework;
				$settings = get_option( SHOESTRAP_OPT_NAME );

				$mode = $settings['shoestrap_gridder_box_style'];

				if ( $mode == 'panel' ) {
					$header  = $ss_framework->open_panel_heading( null );
					$element = 'h4';
					$after   = $ss_framework->open_panel_body( null );
				} elseif ( $mode == 'well' ) {
					$header  = '<div>';
					$element = 'h3';
					$after   = '<div class="entry-body">';
				}

				$content  = $header . '<title>' . get_the_title() . '</title><' . $element . ' class="entry-title">';
				$content .= '<a href="' . get_permalink() . '">' . apply_filters( 'shoestrap_title', get_the_title() ) . '</a>';
				$content .= '</' . $element . '></div>' . $after;

				return $content;
			} else {
				return $title;
			}
		}
	}
	$gridder = new ShoestrapGridder();
}