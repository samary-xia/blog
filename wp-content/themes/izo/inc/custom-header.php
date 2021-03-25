<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Izo
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses izo_header_style()
 */
function izo_custom_header_setup() {
	add_theme_support(
		'custom-header',
		apply_filters(
			'izo_custom_header_args',
			array(
				'default-image'      => '',
				'header-text'        => false,
				'width'              => 1920,
				'height'             => 500,
				'flex-height'        => true,
				'flex-width'        => true,
			)
		)
	);
}
add_action( 'after_setup_theme', 'izo_custom_header_setup' );