<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package new_blog
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
		<?php
			if(absint(get_theme_mod('new_blog_sidebar_enable_page','1')) == 1) : 
			$modes1 = 8;
			elseif (absint(get_theme_mod('new_blog_sidebar_enable_page','1')) == 0) :
			$modes1 = 12;
			endif ;
			?>
			<section class="outer-categories">
				<div class="container-fluid">
					<div id ="scroll-top" class="row text-justify">

						<div class="col-lg-<?php echo absint($modes1) ?>">
							<?php
							while ( have_posts() ) :
								the_post();

								get_template_part( 'template-parts/content', 'page' );

								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;

							endwhile; // End of the loop.
							?>
						</div>
						<?php if(esc_attr(get_theme_mod('new_blog_sidebar_enable_page','1')) == 1) : ?>
						<div class="col-lg-4">
								<?php get_sidebar()?>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</section>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
