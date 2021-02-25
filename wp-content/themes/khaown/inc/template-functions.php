<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package WordPress
 * @subpackage khaown
 * @since 1.0.0
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function khaown_body_classes( $classes ) {

	if ( is_singular() ) {
		// Adds `singular` to singular pages.
		$classes[] = 'singular';
	} else {
		// Adds `hfeed` to non singular pages.
		$classes[] = 'hfeed';
	}

	// Adds a class if image filters are enabled.
	if ( khaown_image_filters_enabled() ) {
		$classes[] = 'image-filters-enabled';
	}

	return $classes;
}
add_filter( 'body_class', 'khaown_body_classes' );

/**
 * Adds custom class to the array of posts classes.
 */
function khaown_post_classes( $classes, $class, $post_id ) {
	$classes[] = 'entry';

	return $classes;
}
add_filter( 'post_class', 'khaown_post_classes', 10, 3 );


/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function khaown_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'khaown_pingback_header' );


/*=====================
* Comment functions
======================*/
/**
 * Customize comment form default fields.
 * Move the comment_field below the author, email, and url fields.
 */
function khaown_comment_form_default_fields( $fields ) {
	$commenter     = wp_get_current_commenter();
	$user          = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';
	$req           = get_option( 'require_name_email' );
	$aria_req      = ( $req ? " aria-required='true'" : '' );
  
	$fields = [
		'comment_field' => '<p class="comment-form-comment"> 
				<textarea placeholder="'. esc_attr__( '* Your comment...', 'khaown' ) .'" id="comment" name="comment" cols="45" rows="4" maxlength="65525" aria-required="true" required="required"></textarea>
			  </p>',
		'author' => '<p class="comment-form-author">' .
					'<input placeholder="'. esc_attr__( '* Your Name... ', 'khaown' ) .'"  required="required" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245"' . ' />
		  </p>',
		'email'  => '<p class="comment-form-email">' .
					'<input placeholder="'. esc_attr__( '* Your Email...', 'khaown' ) .'"  required="required" id="email" name="email" type="email" type="text"'  . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes"'   . ' />
		  </p>',
		'url'    => '<p class="comment-form-url">' .
					'<input placeholder="'. esc_attr__( '( Optional ) Your Url : http://example.com/...', 'khaown' ) .'"  id="url" name="url" type="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="200" />
		  </p>',
  
	];
  
	return $fields;
}

add_filter( 'comment_form_default_fields', 'khaown_comment_form_default_fields' );

/**
 * Remove the original comment field because we've added it to the default fields
* using khaown_comment_form_default_fields(). If we don't do this, the comment
* field will appear twice.
*/
function khaown_comment_form_defaults( $defaults ) {
	if ( isset( $defaults[ 'comment_field' ] ) ) {
		$defaults[ 'comment_field' ] = '';
	}

	return $defaults;
}
add_filter( 'comment_form_defaults', 'khaown_comment_form_defaults', 10, 1 );

/*=====================
* Comment functions Ends
======================*/

/**
 * Filters the default archive titles.
 */
function khaown_get_the_archive_title() {
	if ( is_category() ) {
		$title = __( 'Category Archives: ', 'khaown' ) . '<strong class="page-description">' . single_term_title( '', false ) . '</strong>';
	} elseif ( is_tag() ) {
		$title = __( 'Tag Archives: ', 'khaown' ) . '<strong class="page-description">' . single_term_title( '', false ) . '</strong>';
	} elseif ( is_author() ) {
		$title = __( 'Author Archives: ', 'khaown' ) . '<strong class="page-description">' .  esc_html(get_the_author_meta( 'display_name' )) . '</strong>';
	} elseif ( is_year() ) {
		$title = __( 'Yearly Archives: ', 'khaown' ) . '<strong class="page-description">' . esc_html(get_the_date( _x( 'Y', 'yearly archives date format', 'khaown' ) )) . '</strong>';
	} elseif ( is_month() ) {
		$title = __( 'Monthly Archives: ', 'khaown' ) . '<strong class="page-description">' . esc_html(get_the_date( _x( 'F Y', 'monthly archives date format', 'khaown' ) )) . '</strong>';
	} elseif ( is_day() ) {
		$title = __( 'Daily Archives: ', 'khaown' ) . '<strong class="page-description">' . esc_html(get_the_date()) . '</strong>';
	} elseif ( is_post_type_archive() ) {
		$title = __( 'Post Type Archives: ', 'khaown' ) . '<strong class="page-description">' . post_type_archive_title( '', false ) . '</strong>';
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: %s: Taxonomy singular name */
		$title = sprintf( esc_html__( '%s Archives:', 'khaown' ), $tax->labels->singular_name );
	} else {
		$title = __( 'Archives:', 'khaown' );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'khaown_get_the_archive_title' );

/**
 * Determines if post thumbnail can be displayed.
 */
function khaown_can_show_post_thumbnail() {
	return apply_filters( 'khaown_can_show_post_thumbnail', ! post_password_required() && ! is_attachment() && has_post_thumbnail() );
}

/**
 * Returns true if image filters are enabled on the theme options.
 */
function khaown_image_filters_enabled() {
	return 0 !== get_theme_mod( 'image_filter', 1 );
}

/**
 * Add custom sizes attribute to responsive image functionality for post thumbnails.
 *
 * @origin khaown 1.0
 *
 * @param array $attr  Attributes for the image markup.
 * @return string Value for use in post thumbnail 'sizes' attribute.
 */
function khaown_post_thumbnail_sizes_attr( $attr ) {

	if ( is_admin() ) {
		return $attr;
	}

	if ( ! is_singular() ) {
		$attr['sizes'] = '(max-width: 34.9rem) calc(100vw - 2rem), (max-width: 53rem) calc(8 * (100vw / 12)), (min-width: 53rem) calc(6 * (100vw / 12)), 100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'khaown_post_thumbnail_sizes_attr', 10, 1 );

/**
 * Returns the size for avatars used in the theme.
 */
function khaown_get_avatar_size() {
	return 60;
}

/**
 * Returns true if comment is by author of the post.
 *
 * @see get_comment_class()
 */
function khaown_is_comment_by_post_author( $comment = null ) {
	if ( is_object( $comment ) && $comment->user_id > 0 ) {
		$user = get_userdata( $comment->user_id );
		$post = get_post( $comment->comment_post_ID );
		if ( ! empty( $user ) && ! empty( $post ) ) {
			return $comment->user_id === $post->post_author;
		}
	}
	return false;
}

/**
 * Returns information about the current post's discussion, with cache support.
 */
function khaown_get_discussion_data() {
	static $discussion, $post_id;

	$current_post_id = get_the_ID();
	if ( $current_post_id === $post_id ) {
		return $discussion; /* If we have discussion information for post ID, return cached object */
	} else {
		$post_id = $current_post_id;
	}

	$comments = get_comments(
		array(
			'post_id' => $current_post_id,
			'orderby' => 'comment_date_gmt',
			'order'   => get_option( 'comment_order', 'asc' ), /* Respect comment order from Settings » Discussion. */
			'status'  => 'approve',
			'number'  => 20, /* Only retrieve the last 20 comments, as the end goal is just 6 unique authors */
		)
	);

	$authors = array();
	foreach ( $comments as $comment ) {
		$authors[] = ( (int) $comment->user_id > 0 ) ? (int) $comment->user_id : $comment->comment_author_email;
	}

	$authors    = array_unique( $authors );
	$discussion = (object) array(
		'authors'   => array_slice( $authors, 0, 6 ),           /* Six unique authors commenting on the post. */
		'responses' => get_comments_number( $current_post_id ), /* Number of responses. */
	);

	return $discussion;
}

/**
 * WCAG 2.0 Attributes for Dropdown Menus
 *
 * Adjustments to menu attributes tot support WCAG 2.0 recommendations
 * for flyout and dropdown menus.
 *
 * @ref https://www.w3.org/WAI/tutorials/menus/flyout/
 */
function khaown_nav_menu_link_attributes( $atts, $item, $args, $depth ) {

	// Add [aria-haspopup] and [aria-expanded] to menu items that have children
	$item_has_children = in_array( 'menu-item-has-children', $item->classes );
	if ( $item_has_children ) {
		$atts['aria-haspopup'] = 'true';
		$atts['aria-expanded'] = 'false';
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'khaown_nav_menu_link_attributes', 10, 4 );


/**
 * Convert HSL to HEX colors
 */
function khaown_hsl_hex( $h, $s, $l, $to_hex = true ) {

	$h /= 360;
	$s /= 100;
	$l /= 100;

	$r = $l;
	$g = $l;
	$b = $l;
	$v = ( $l <= 0.5 ) ? ( $l * ( 1.0 + $s ) ) : ( $l + $s - $l * $s );
	if ( $v > 0 ) {
		$m;
		$sv;
		$sextant;
		$fract;
		$vsf;
		$mid1;
		$mid2;

		$m       = $l + $l - $v;
		$sv      = ( $v - $m ) / $v;
		$h      *= 6.0;
		$sextant = floor( $h );
		$fract   = $h - $sextant;
		$vsf     = $v * $sv * $fract;
		$mid1    = $m + $vsf;
		$mid2    = $v - $vsf;

		switch ( $sextant ) {
			case 0:
				$r = $v;
				$g = $mid1;
				$b = $m;
				break;
			case 1:
				$r = $mid2;
				$g = $v;
				$b = $m;
				break;
			case 2:
				$r = $m;
				$g = $v;
				$b = $mid1;
				break;
			case 3:
				$r = $m;
				$g = $mid2;
				$b = $v;
				break;
			case 4:
				$r = $mid1;
				$g = $m;
				$b = $v;
				break;
			case 5:
				$r = $v;
				$g = $m;
				$b = $mid2;
				break;
		}
	}
	$r = round( $r * 255, 0 );
	$g = round( $g * 255, 0 );
	$b = round( $b * 255, 0 );

	if ( $to_hex ) {

		$r = ( $r < 15 ) ? '0' . dechex( $r ) : dechex( $r );
		$g = ( $g < 15 ) ? '0' . dechex( $g ) : dechex( $g );
		$b = ( $b < 15 ) ? '0' . dechex( $b ) : dechex( $b );

		return "#$r$g$b";

	}

	return "rgb($r, $g, $b)";
}
