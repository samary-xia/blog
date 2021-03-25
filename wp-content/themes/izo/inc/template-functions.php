<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Izo
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function izo_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';	
	}

	//Sidebars
	$sidebar_position 	= get_theme_mod( 'sidebar_position' , 'sidebar-right' ); //Customizer option
	global $post;
	if ( is_singular() ) {
		$sidebar_position_page 	= get_post_meta( $post->ID, '_izo_sidebar_layout', true ); //Meta option
	
		if ( $sidebar_position_page && ( 'customizer' !== $sidebar_position_page ) ) {
			$classes[] = esc_attr( $sidebar_position_page );
		} else {
			$classes[] = esc_attr( $sidebar_position );
		}

		//Page layout
		$page_layout 		= get_theme_mod( 'single_page_layout' , 'boxed' ); //Customizer option
		$post_layout 		= get_theme_mod( 'single_post_layout' , 'boxed' ); //Customizer option
		$page_layout_meta 	= get_post_meta( $post->ID, '_izo_page_layout', true ); //Meta option	

		if ( 'post' === get_post_type() ) { //For single posts

			if ( 'customizer' !== $page_layout_meta ) {
				$classes[] = esc_attr( $page_layout_meta );	//set from page meta
			} else {
				$classes[] = $post_layout; //set from customizer
			}

			//Post banner for single posts
			$post_banner = get_theme_mod( 'single_post_banner', 'default' );
			if ( 'banner' == $post_banner ) {
				$classes[] = 'has-page-banner';
			}
		}

		if ( 'page' === get_post_type() ) { //For single pages
			if ( 'customizer' !== $page_layout_meta ) {
				$classes[] = esc_attr( $page_layout_meta );	//set from page meta
			} else {
				$classes[] = $page_layout; //set from customizer
			}

			//Post banner for single pages
			$page_banner = get_theme_mod( 'single_page_banner', 'default' );
			if ( 'banner' == $page_banner ) {
				$classes[] = 'has-page-banner';
			}			
		}
	} else {
		$classes[] = esc_attr( $sidebar_position );
	}

	if ( class_exists( 'WooCommerce' ) ) {
		//Shop archives
		$shop_archive_layout = get_theme_mod( 'shop_archive_layout' , 'no-sidebar' );
		if ( is_shop() || is_product_category() || is_product_tag() ) {
			$classes = array_diff( $classes, array( 'no-sidebar', 'sidebar-left', 'sidebar-right' ) );
			$classes[] = $shop_archive_layout;
		}
		
		//Single products
		$single_product_layout = get_theme_mod( 'single_product_layout' , 'no-sidebar' );
		if ( is_product() ) {
			$classes = array_diff( $classes, array( 'no-sidebar', 'sidebar-left', 'sidebar-right' ) );
			$classes[] = $single_product_layout;
		}		
	}

	//Sticky menu
	$is_sticky = get_theme_mod( 'enable_sticky_menu', 0 );
	$disable_sticky_mobiles = get_theme_mod( 'disable_sticky_mobiles', 1 );
	if ( $is_sticky ) {
		$classes[] = 'has-sticky-menu';
	}
	if ( $disable_sticky_mobiles ) {
		$classes[] = 'disable-sticky-mobiles';
	}	

	$always_mobile_menu = get_theme_mod( 'always_display_mobile_menu' );
	if ( $always_mobile_menu ) {
		$classes[] = 'always-mobile-menu';
	}


	return $classes;
}
add_filter( 'body_class', 'izo_body_classes' );

/**
 * Custom single post classes
 *
 */
function izo_post_classes( $classes ) {

	//Remove hentry class from single pages
	if ( 'page' == get_post_type() ) {
		$classes = array_diff( $classes, array( 'hentry' ) );
	}

	return $classes;
}
add_filter( 'post_class', 'izo_post_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function izo_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'izo_pingback_header' );

/**
 * Theme main container start
 */
function izo_main_container_start() {

	$has_sidebar = apply_filters( 'izo_has_sidebar', 'has-sidebar' );

	echo '<div class="izo-container ' . esc_attr( $has_sidebar ) . '">';
}
add_action( 'izo_main_container_start', 'izo_main_container_start' );

/**
 * Theme main container end
 */
function izo_main_container_end() {
	echo '</div>';
}
add_action( 'izo_main_container_end', 'izo_main_container_end' );

/**
 * Get SVG code. From TwentTwenty
 */
function izo_get_svg_icon( $icon, $echo = false ) {
	$svg_code = wp_kses(
		Izo_SVG_Icons::get_svg_icon( $icon ),
		array(
			'svg'     => array(
				'class'       => true,
				'xmlns'       => true,
				'width'       => true,
				'height'      => true,
				'viewbox'     => true,
				'aria-hidden' => true,
				'role'        => true,
				'focusable'   => true,
			),
			'path'    => array(
				'fill'      => true,
				'fill-rule' => true,
				'd'         => true,
				'transform' => true,
			),
			'polygon' => array(
				'fill'      => true,
				'fill-rule' => true,
				'points'    => true,
				'transform' => true,
				'focusable' => true,
			),
		)
	);	

	if ( $echo != false ) {
		echo '<span class="izo-icon">' . $svg_code . '</span>'; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} else {
		return '<span class="izo-icon">' . $svg_code . '</span>';
	}
}

/**
 * Manage sidebars
 */
function izo_get_sidebar() {

	$enable_sidebar = apply_filters( 'izo_enable_sidebar', true );

	if ( $enable_sidebar ) {
		get_sidebar();
	}
}
add_action( 'izo_sidebar', 'izo_get_sidebar' );

//Disable where we don't need it
function izo_disable_sidebars() {

	if ( is_admin() || is_404() ) {
		return;
	}

	global $post;
	$sidebar_position 		= get_theme_mod( 'sidebar_position', 'sidebar-right' ); //Customizer option
	$sidebar_position_page 	= get_post_meta( $post->ID, '_izo_sidebar_layout', true ); //Meta option
	$page_layout 			= get_theme_mod( 'single_page_layout', 'boxed' ); //Customizer option
	$post_layout 			= get_theme_mod( 'single_post_layout', 'boxed' ); //Customizer option
	$page_layout_meta 		= get_post_meta( $post->ID, '_izo_page_layout', true ); //Meta option		

	if ( is_singular() ) {
		if ( $sidebar_position_page ) {
			if ( 'no-sidebar' === $sidebar_position_page || ( 'customizer' === $sidebar_position_page && 'no-sidebar' === $sidebar_position ) ) {
				add_filter( 'izo_enable_sidebar', '__return_false' );
			}
		} elseif ( 'no-sidebar' === $sidebar_position ) {
			add_filter( 'izo_enable_sidebar', '__return_false' );
		}

		if ( $page_layout_meta ) {
			if ( 'page' === get_post_type() ) {
				if ( ( 'customizer' === $page_layout_meta && 'layout-wide' === $page_layout ) || ( 'layout-wide' === $page_layout_meta ) ) {
					add_filter( 'izo_enable_sidebar', '__return_false' );
				}		
			} elseif ( 'post' === get_post_type() ) {
				if ( ( 'customizer' === $page_layout_meta && 'layout-wide' === $post_layout  ) || ( 'layout-wide' === $page_layout_meta ) ) {
					add_filter( 'izo_enable_sidebar', '__return_false' );
				}
			}
		}
	} elseif ( 'no-sidebar' === $sidebar_position ) {
		add_filter( 'izo_enable_sidebar', '__return_false' );
	}
}
add_action( 'wp', 'izo_disable_sidebars' );

/**
 * Build fonts URL
 */
function izo_generate_fonts_url() {
	$fonts_url = '';
	$subsets = 'latin';

	$defaults 	= json_encode(
		array(
			'font' 			=> 'System default',
			'regularweight' => 'regular',
			'italicweight' 	=> 'italic',
			'boldweight' 	=> 'bold',
			'category' 		=> 'sans-serif'
		)
	);

	$body_font		= get_theme_mod( 'izo_body_font', $defaults );
	$headings_font 	= get_theme_mod( 'izo_headings_font', $defaults );

	$body_font 		= json_decode( $body_font, true );
	$headings_font 	= json_decode( $headings_font, true );

	if ( 'System default' === $body_font['font'] && 'System default' === $headings_font['font'] ) {
		return; //Return if we don't need to enqueue Google fonts
	}
		
	$font_families = array();

	//Check and add the body font styles to the array
	if ( 'System default' !== $body_font['font'] ) {
		$font_families[] = $body_font['font'] . ':' . $body_font['regularweight'] . ',' . $body_font['italicweight'] . ',' . $body_font['boldweight'];
	}
		
	//Check and add the headings font styles to the array
	if ( 'System default' !== $headings_font['font'] ) {
		$font_families[] = $headings_font['font'] . ':' . $headings_font['italicweight'] . ',' . $headings_font['boldweight'];
	}

	$query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
		'subset' => urlencode( $subsets ),
		'display' => urlencode( 'swap' ),
	);

	$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );

	return esc_url_raw( $fonts_url );
}

/**
 * Get social network
 */
function izo_get_social_network( $social ) {

	//Available networks
	$networks = array( 'facebook', 'twitter', 'instagram', 'github', 'linkedin', 'youtube', 'xing', 'instagram', 'flickr', 'dribbble', 'vk', 'weibo', 'vimeo', 'mix', 'behance', 'spotify', 'soundcloud', 'twitch', 'bandcamp', 'etsy', 'pinterest' );

	//Loop through the networks and find the current one
	foreach ( $networks as $network ) {
		$found = strpos( $social, $network );

		if ( $found !== false ) {
			return $network;
		}
	}
}

/**
 * Back to top
 */
function izo_back_to_top() {
	echo '<div id="backtotop" class="backtotop">' . izo_get_svg_icon( 'icon-up', false ) . '</div>';  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'izo_footer_after', 'izo_back_to_top' );

/**
 * Menu fallback
 */
function izo_main_nav_fallback() {
	if ( current_user_can( 'edit_theme_options' ) ) {
		echo '<a class="nav-fallback" href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Click here to create your menu', 'izo' ) . '</a>';
	}
}

/**
 * Blog attributes
 */
function izo_blog_attrs() {

	$blog_layout = get_theme_mod( 'blog_layout', 'layout-default' );

	if ( 'layout-3colsmas' === $blog_layout || 'layout-2colsmas' === $blog_layout ) {
		return 'data-masonry=\'{ "gutter": 30, "itemSelector": ".posts-loop article" }\'';
	}
}

/**
 * Remove archive labels
 */
function izo_remove_archive_labels( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    } elseif ( is_tax() ) {
        $title = single_term_title( '', false );
    }
  
    return $title;
}
 
add_filter( 'get_the_archive_title', 'izo_remove_archive_labels' );

/**
 * Mega menu support
 */
function izo_megamenu_override_default_theme( $value ) {
	if ( !isset($value['primary-menu']['theme']) ) {
		$value['primary-menu']['theme'] = 'izo';
	}
   
	return $value;
  }
  add_filter( 'default_option_megamenu_settings', 'izo_megamenu_override_default_theme' );

  function izo_megamenu_theme( $themes ) {
    $themes['izo'] = array(
        'title' => 'Izo',
        'container_background_from' => 'rgba(0, 0, 0, 0)',
        'container_background_to' => 'rgba(0, 0, 0, 0)',
        'menu_item_background_hover_from' => 'rgba(51, 51, 51, 0)',
        'menu_item_background_hover_to' => 'rgba(51, 51, 51, 0)',
        'menu_item_link_font_size' => '16px',
        'menu_item_link_color' => 'rgb(29, 29, 31)',
        'menu_item_link_color_hover' => 'rgb(29, 29, 31)',
        'menu_item_link_padding_left' => '15px',
        'menu_item_link_padding_right' => '15px',
        'panel_font_size' => '14px',
        'panel_font_color' => '#666',
        'panel_font_family' => 'inherit',
        'panel_second_level_font_color' => '#555',
        'panel_second_level_font_color_hover' => '#555',
        'panel_second_level_text_transform' => 'uppercase',
        'panel_second_level_font' => 'inherit',
        'panel_second_level_font_size' => '16px',
        'panel_second_level_font_weight' => 'bold',
        'panel_second_level_font_weight_hover' => 'bold',
        'panel_second_level_text_decoration' => 'none',
        'panel_second_level_text_decoration_hover' => 'none',
        'panel_third_level_font_color' => '#666',
        'panel_third_level_font_color_hover' => '#666',
        'panel_third_level_font' => 'inherit',
        'panel_third_level_font_size' => '14px',
        'flyout_link_size' => '14px',
        'flyout_link_color' => '#666',
        'flyout_link_color_hover' => '#666',
        'flyout_link_family' => 'inherit',
        'responsive_breakpoint' => '991px',
        'toggle_background_from' => 'rgba(34, 34, 34, 0)',
        'toggle_background_to' => 'rgba(34, 34, 34, 0)',
        'toggle_bar_height' => '70px',
        'mobile_menu_padding_left' => '5px',
        'mobile_menu_padding_right' => '5px',
        'mobile_menu_overlay' => 'on',
        'mobile_menu_force_width' => 'on',
        'mobile_background_from' => 'rgb(255, 255, 255)',
        'mobile_background_to' => 'rgb(255, 255, 255)',
        'mobile_menu_item_link_font_size' => '16px',
        'mobile_menu_item_link_color' => 'rgb(30, 30, 30)',
        'mobile_menu_item_link_text_align' => 'left',
        'mobile_menu_item_link_color_hover' => 'rgb(30, 30, 30)',
        'mobile_menu_item_background_hover_from' => 'rgba(255, 255, 255, 0)',
        'mobile_menu_item_background_hover_to' => 'rgb(255, 255, 255)',
        'custom_css' => '/** Push menu onto new line **/ 
#{$wrap} { 
    clear: both; 
}',
    );
    return $themes;
}
add_filter('megamenu_themes', 'izo_megamenu_theme');

/**
 * AMP
 */
function izo_is_amp() {
	return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
}

function izo_blog_featured_area() {

	$display = get_theme_mod( 'blog_featured_area', 0 );

	if ( !is_home() || !$display ) {
		return;
	}

	$args = array(
		'post_type'              => array( 'post' ),
		'post_status'            => array( 'publish' ),
		'posts_per_page'         => '5',
		'ignore_sticky_posts'    => true,
	);

	$query = new WP_Query( $args );

	// The Loop
	if ( $query->have_posts() ) {
		echo '<div class="blog-featured-area">';
		while ( $query->have_posts() ) {
			$query->the_post();

			global $post;

			$image = get_the_post_thumbnail_url( $post->ID, 'large' );

			echo '<div class="featured-post" style="background-image:url(' . esc_url( $image ) . ');">';
				echo '<div class="post-content">';
					izo_posted_on();
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
					izo_entry_categories();
				echo '</div>';
				echo '<div class="overlay"></div>';
			echo '</div>';
		}
		echo '</div>';
	}

	wp_reset_postdata();	

}
add_action( 'izo_header_after', 'izo_blog_featured_area' );