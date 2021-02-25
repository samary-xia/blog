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
			<?php if(absint(get_theme_mod('new_blog_sidebar_enable','1')) == 1) : 
			$modes1 = 8;
			elseif (absint(get_theme_mod('new_blog_sidebar_enable','1')) == 0) :
			$modes1 = 12;
			endif ; ?>
			<section class="outer-categories">
				<div class="container-fluid">
					<div class="row">

						<div class="col-lg-<?php echo absint($modes1) ?>">
                            <?php
                            woocommerce_content();
							?>
						</div>
						<?php if(esc_attr(get_theme_mod('new_blog_sidebar_enable','1')) == 1) : ?>
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
