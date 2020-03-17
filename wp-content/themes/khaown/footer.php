<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage khaown
 * @since 1.0.0
 */
?>
<footer id="footer" class="site-footer container">
	<div class="row">
		<div class="col-md-4">
			<div class="site-info">
					<?php if ( has_custom_logo() ) { ?>
						<div class="logo logo-dark"><?php the_custom_logo(); ?></div>
					<?php } else { ?>
						<?php $blog_info = get_bloginfo( 'name' ); ?>
						<?php if ( ! empty( $blog_info ) ) : ?>
							<h1 class="site-title khaown-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo bloginfo( 'name' ); ?></a></h1>
					<?php endif; ?>
					<?php } ?>
				<div class="social-accounts">
					<?php if(get_theme_mod("social_account_twitter", "")) { ?>
						<a target="_blank" href="<?php echo esc_url(get_theme_mod("social_account_twitter", "")); ?>"><i class="ti-twitter-alt"></i></a> 
					<?php } ?>
					<?php if(get_theme_mod("social_account_facebook", "")) { ?>
						<a target="_blank" href="<?php echo esc_url(get_theme_mod("social_account_facebook", "")); ?>"><i class="ti-facebook"></i></a>
					<?php } ?>
					<?php if(get_theme_mod("social_account_Instagram", "")) { ?>
					<a target="_blank" href="<?php echo esc_url(get_theme_mod("social_account_Instagram", "")); ?>"><i class="ti-instagram"></i></a>
					<?php } ?>
					<?php if(get_theme_mod("social_account_Pinterest", "")) { ?>
					<a target="_blank" href="<?php echo esc_url(get_theme_mod("social_account_Pinterest", "")); ?>"><i class="ti-pinterest-alt"></i></a>
					<?php } ?>
					<?php if(get_theme_mod("social_account_Dribbble", "")) { ?>
					<a target="_blank" href="<?php echo esc_url(get_theme_mod("social_account_Dribbble", "")); ?>"><i class="ti-dribbble"></i></a>
					<?php } ?>
					<?php if(get_theme_mod("social_account_LinkedIn", "")) { ?>
					<a target="_blank" href="<?php echo esc_url(get_theme_mod("social_account_LinkedIn", "")); ?>"><i class="ti-linkedin"></i></a>
					<?php } ?>
					<?php if(get_theme_mod("social_account_Tumblr", "")) { ?>
					<a target="_blank" href="<?php echo esc_url(get_theme_mod("social_account_Tumblr", "")); ?>"><i class="ti-tumblr-alt"></i></a>
					<?php } ?>
					<?php if(get_theme_mod("social_account_Youtube", "")) { ?>
					<a target="_blank" href="<?php echo esc_url(get_theme_mod("social_account_Youtube", "")); ?>"><i class="ti-youtube"></i></a>
					<?php } ?>
					<?php if(get_theme_mod("social_account_Vimeo", "")) { ?>
					<a target="_blank" href="<?php echo esc_url(get_theme_mod("social_account_Vimeo", "")); ?>"><i class="ti-vimeo"></i></a>
					<?php } ?>
					<?php if(get_theme_mod("social_account_RSS", "")) { ?>
					<a target="_blank" href="<?php echo esc_url(get_theme_mod("social_account_RSS", "")); ?>"><i class="ti-rss"></i></a>
					<?php } ?>
					<?php if(get_theme_mod("social_account_Email", "")) { ?>
					<a target="_blank" href="<?php echo esc_url(get_theme_mod("social_account_Email", "")); ?>"><i class="ti-email"></i></a>
					<?php } ?>
				</div>
		</div><!-- .site-info -->
		</div>
		<div class="col-md-8">
			<div class="site-info">
			<?php if ( has_nav_menu( 'footer' ) ) : ?>
				<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'khaown' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'menu_class'     => 'footer-menu',
							'depth'          => 1,
						)
					);
					?>
				</nav><!-- .footer-navigation -->
			<?php endif; ?>
		</div>
	</div>
	<a class="btn btn-sm fade-half back-to-top inner-link" href="#top"> <?php _e('Top', 'khaown'); ?> </a>
</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
