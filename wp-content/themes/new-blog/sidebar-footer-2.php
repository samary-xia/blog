<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package new_blog
 */

if ( ! is_active_sidebar( 'sidebar-3' ) ) {
	return;
}
?>

<aside id="footer-2" class="widget-area sidebar">
	<?php dynamic_sidebar( 'sidebar-3' ); ?>
</aside><!-- #secondary -->
