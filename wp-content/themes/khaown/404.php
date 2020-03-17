<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage khaown
 * @since 1.0.0
 */

get_header();
?>


<div class="main-container">
    <section class="page-title page-title-4 bg-menu-4">
        <div class="container">
            <div class="row">
				<div class="col-sm-7 text-left">	
					<h2 class="mb0">
						<strong> <?php _e('Page Not Found', 'khaown'); ?> </strong>
					</h2>					
				</div>
				<div class="col-sm-5 col-xs-12 text-right">
					<?php echo get_search_form(); ?>
				</div>
            </div>
            <!--end of row-->
        </div>
        <!--end of container-->
    </section>

	<section id="main" class="page-template">
        <div class="container">
            <div class="blog-posts em-site-content">
                <div class="row">
                    <div class="col-xs-12">
						<main id="khaown-main" class="khaown-site-main">
							<div class="text-center">
								<h4> <?php _e('Nothing found related to your query.', 'khaown'); ?> </h4>
								<p><?php _e('There is no page or post related to this search term. Please search with another term. Nothing found related to your query.', 'khaown'); ?></p>
								<h3><a href="<?php echo esc_url( home_url() ); ?>"> <?php _e('Go to Homepage', 'khaown'); ?></a></h3>
							</div>
						</main><!-- .site-main -->
					</div>
				</div>
			</div>
		</div>
	</div>

<?php get_footer();
