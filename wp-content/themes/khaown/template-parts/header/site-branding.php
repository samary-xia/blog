<?php
/**
 * Displays header site branding
 *
 * @package WordPress
 * @subpackage khaown
 * @since 1.0.0
 */
?>
<div class="module left site-branding">
	<?php if ( has_custom_logo() ) { ?>
		<div class="logo logo-dark"><?php the_custom_logo(); ?></div>
	<?php } else { ?>
		<?php $blog_info = get_bloginfo( 'name' ); ?>
		<?php if ( ! empty( $blog_info ) ) : ?>
			<h1 class="site-title khaown-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="<?php esc_attr_e('home', 'khaown'); ?>"><?php echo bloginfo( 'name' ); ?></a></h1>
	<?php endif; ?>
	<?php } ?>
</div>