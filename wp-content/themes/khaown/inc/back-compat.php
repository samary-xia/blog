<?php
/**
 * khaown back compat functionality
 *
 * Prevents khaown from running on WordPress versions prior to 4.7,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.7.
 *
 * @package WordPress
 * @subpackage khaown
 * @since khaown 1.0.0
 */

/**
 * Prevent switching to khaown on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since khaown 1.0.0
 */
function khaown_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'khaown_upgrade_notice' );
}
add_action( 'after_switch_theme', 'khaown_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * khaown on WordPress versions prior to 4.7.
 *
 * @since khaown 1.0.0
 *
 * @global string $wp_version WordPress version.
 */
function khaown_upgrade_notice() {
	$message = sprintf( __( 'khaown requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'khaown' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.7.
 *
 * @since khaown 1.0.0
 *
 * @global string $wp_version WordPress version.
 */
function khaown_customize() {
	wp_die(
		sprintf(
			__( 'khaown requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'khaown' ),
			$GLOBALS['wp_version']
		),
		'',
		array(
			'back_link' => true,
		)
	);
}
add_action( 'load-customize.php', 'khaown_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.
 *
 * @since khaown 1.0.0
 *
 * @global string $wp_version WordPress version.
 */
function khaown_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'khaown requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'khaown' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'khaown_preview' );
