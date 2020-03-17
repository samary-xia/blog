<?php
/**
 * Template Name: Khawon Page with Top Header
 *
 *
 * @package WordPress
 * @subpackage khaown
 * @since 1.0.0
 */

get_header();
?>
<main id="main-container ">
    <section class="page-title page-title-4 bg-menu-4">
        <div class="container">
            <div class="row">
				<?php $blog_info = get_bloginfo( 'name' ); ?>
					<?php if ( ! empty( $blog_info ) ) : ?>
						<div class="col-sm-7 text-left">							
							<?php if ( is_front_page() && is_home() ) : ?>
								<h1 class="khaown-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
								<?php $description = get_bloginfo( 'description', 'display' );
									if ( $description || is_customize_preview() ) : ?>
										<p class="khaown-site-description">
											<?php echo $description; ?>
										</p>
								<?php endif; ?>
							<?php else : ?>
								<h1 class="khaown-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php endif; ?>

						</div>
						<div class="col-sm-5 col-xs-12 text-right">
							<?php echo get_search_form(); ?>
						</div>
						<?php else : ?>
							<div class="col-xs-8 col-xs-offset-2 text-center">
								<?php echo get_search_form(); ?>
							</div>
				<?php endif; ?>
            </div>
            <!--end of row-->
        </div>
        <!--end of container-->
    </section>
    <div class="container">
		<div class="row mt48">
			<div class="col-md-8 col-md-offset-2">
                <?php
                /* Start the Loop */
                while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div id="single-content">	
                            <div class="khaown-page-thumbnail">
                                <?php the_post_thumbnail(); ?>
                            </div>
                            <?php get_template_part( 'template-parts/content/content', 'single' ); ?>
                            <!-- If comments are open or we have at least one comment, load up the comment template. -->
                            <?php if ( comments_open() || get_comments_number() ) { ?>
                                <div class="comm em_comment mb-80">
                                    <?php comments_template(); ?>
                                    <?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>
                                    <?php paginate_comments_links( ) ?>
                                </div>
                            <?php } ?>

                        </div>
                    </article><!-- #post-<?php the_ID(); ?> -->
                
                <?php endwhile; ?> <!-- End of the loop. -->
            </div>
        </div>
        <!--end of row-->
    </div>
    <!--end of container-->

</main><!-- #main -->
<?php
get_footer();

