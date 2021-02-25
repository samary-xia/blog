<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package new_blog
 */

get_header();
?>
<div>
<section>
<div class="page_404">
	<div class="container">
	<div class="row">
		<div class="col-lg-6">
		<h1><?php esc_html_e('404','new-blog') ?></h1>
		<span class="text"> <?php esc_html_e('Page Not Found','new-blog') ?></span>
		<p><?php esc_html_e('The page you are looking for was moved, removed, renamed or might never existed.','new-blog') ?></p>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn"><?php esc_html_e('Go Home','new-blog') ?> <span class="fa fa-home" aria-hidden="true"></span></a>
		</div>
		<div class="col-lg-6">
		<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/404.png " alt="">
		</div>
	</div>
	</div>
</div>
</section>
<div>
<?php

get_footer();
