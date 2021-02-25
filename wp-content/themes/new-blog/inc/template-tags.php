<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package new_blog
 */

if ( ! function_exists( 'new_blog_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function new_blog_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		$time_string = sprintf( $time_string,
		esc_attr( get_the_date( get_option('date_format') ) ),
		esc_html( get_the_date(get_option('date_format')) )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html( '%s', 'post date' ),
			'<a href="' . esc_url( get_month_link(esc_html(get_the_time('Y')), esc_html(get_the_time('m')) ) ) . '" rel="bookmark">' .$time_string. '</a>'
		);

		echo '<span class="posted-on ">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'new_blog_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function new_blog_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'new-blog' ),
			'<span class="author vcard mr-auto">
			<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);
		

		echo '<span class="byline"> ' . $byline .'&nbsp'. '</span>'; // WPCS: XSS OK.
		

	}
endif;


	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function new_blog_post_comment() {
 	
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( '/ Leave a Comment<span class="screen-reader-text"> on %s</span>', 'new-blog' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo  '</span>';
		}
	}
	function new_blog_post_tag() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'new-blog' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s ', 'new-blog' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}
	}
	function new_blog_edit_post() {

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'new-blog' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}

// *****  below for blog post in frontpage and also in singular page

if ( ! function_exists( 'new_blog_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function new_blog_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		} ?>

		<a class="post-thumbnail img-holder" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'new-blog-blog-display-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
					
				) ),
				'class' => 'card-img-top',
			) );
			?>
		</a>
		<?php
	}
endif;

if ( ! function_exists( 'new_blog_blog_1colume_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function new_blog_blog_1colume_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		} ?>

		<a class="post-thumbnail img-holder" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'new-blog-blog-1colume-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
					
				) ),
				'class' => 'card-img-top',
			) );
			?>
		</a>
		<?php
	}
endif;

// *****  below for feature display post below banner

if ( ! function_exists( 'new_blog_feature_display_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function new_blog_feature_display_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		
		?>
		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'new-blog-feature-display-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
					
				) ),
			) );
			?>
		</a>

		
	<?php }
endif;


// *****  below for banner post

if ( ! function_exists( 'new_blog_banner_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function new_blog_banner_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		
		?>
		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'new-blog-banner-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
					
				) ),
			) );
			?>
		</a>

		
	<?php }
endif;

// *****  below for footer slider

if ( ! function_exists( 'new_blog_footer_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function new_blog_footer_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}
		?>
		<a class="post-thumbnail img-holder" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'new-blog-footer-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
					
				) ),
			) );
			?>
		</a>

		
	<?php }
endif;

// *****  below for sidebar image dislay only ppost

if ( ! function_exists( 'new_blog_sidebar_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function new_blog_sidebar_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}
		?>
		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'new-blog-sidebar-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
					
				) ),
			) );
			?>
		</a>

		
	<?php }
endif;

// *****  below for sidebar latestpost

if ( ! function_exists( 'new_blog_sidebar_latestpost_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function new_blog_sidebar_latestpost_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}
		?>
		<a class="post-thumbnail img-holder mr-3" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'new-blog-sidebar-latestpost-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
					
				) ),
			) );
			?>
		</a>

		
	<?php }
endif;
