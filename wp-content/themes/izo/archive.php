<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Izo
 */

get_header();

$blog_layout = get_theme_mod( 'blog_layout', 'layout-default' );

?>

	<main id="primary" class="site-main">

		<?php if ( have_posts() ) : ?>

			<?php if ( !apply_filters( 'izo_disable_component', false ) ) : ?>
			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->
			<?php endif; ?>

			<div <?php echo wp_kses_post( izo_blog_attrs() ); ?> class="posts-loop <?php echo esc_attr( apply_filters( 'izo_blog_layout', 'layout-default' ) ); ?>">
				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/*
					* Include the Post-Type-specific template for the content.
					* If you want to override this in a child theme, then include a file
					* called content-___.php (where ___ is the Post Type name) and that will be used instead.
					*/
					get_template_part( 'template-parts/content', get_post_type() );

				endwhile; ?>
			</div>
			
			<?php
			izo_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</main><!-- #main -->

<?php
if ( 'layout-3cols' != $blog_layout && 'layout-3colsmas' != $blog_layout ) {
	do_action( 'izo_sidebar' );
}
get_footer();
