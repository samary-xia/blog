<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage khaown
 * @since 1.0.0
 */

get_header();
?>

<main id="main-container" >
	<?php
		/* Start the Loop */
		while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php if ( has_post_thumbnail() ) : ?>
					<section class="fullscreen image-bg overlay parallax parallax-background-container">
						<div class="background-image-holder section-bg parallax-object">
							<?php the_post_thumbnail(); ?>
						</div>
					</section>
					
				<?php endif; ?>
				
				<div id="single-content">
					<div class="container">
						<div class="row">
							<div class="col-md-8 col-md-offset-2 openst">
                                <?php
                                if ( function_exists('yoast_breadcrumb') ) {
                                    //面包屑导航
                                    yoast_breadcrumb( '<span id="breadcrumbs" class="container">','</span>' );
                                }
                                ?>
								<?php get_template_part( 'template-parts/content/content', 'single' );

								if ( is_singular( 'attachment' ) ) {
									// Parent post navigation.
									the_post_navigation(
										array(
											/* translators: %s: parent post link */
											'prev_text' => sprintf( __( '<span class="meta-nav">Published in</span><span class="khaown-post-title">%s</span>', 'khaown' ), '%title' ),
										)
									);
								} elseif ( is_singular( 'post' ) ) {
									// Previous/next post navigation.
									the_post_navigation(
										array(
											'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( '下一篇', 'khaown' ) . '</span> ' .
												'<span class="screen-reader-text">' . __( '下一篇:', 'khaown' ) . '</span> <br/>' .
												'<span class="khaown-post-title">%title</span>',
											'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( '上一篇', 'khaown' ) . '</span> ' .
												'<span class="screen-reader-text">' . __( '上一篇:', 'khaown' ) . '</span> <br/>' .
												'<span class="khaown-post-title">%title</span>',
										)
									);
								}
								?>
							
								<!-- If comments are open or we have at least one comment, load up the comment template. -->
								<?php if ( comments_open() || get_comments_number() ) { ?>
									<div id="comments" class="comm em_comment mb-80">
										<?php comments_template(); ?>
										<?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>
										<?php paginate_comments_links( ) ?>
									</div>
								<?php } ?>

							</div>
						</div>
						<!--end of row-->
					</div>
					<!--end of container-->
				</div><!-- .entry-content -->
			</article><!-- #post-<?php the_ID(); ?> -->

		 <?php endwhile; ?> <!-- End of the loop. -->
		<section class="related-news mt80">
            <div class="container">
                <div class="row">
                <?php
                    $tags = wp_get_post_tags($post->ID);
                    if ($tags) {
                        $first_tag = $tags[0]->term_id;
                        $args=array(
                            'tag__in' => array($first_tag),
                            'post__not_in' => array($post->ID),
                            'posts_per_page'=>4,
                            'ignore_sticky_posts'=>1
                        );
                        $my_query = new WP_Query($args);
                        if( $my_query->have_posts() ) { ?>
							<h4 class="ml16"> <?php _e('You May Also Like:', 'khaown'); ?></h4>
							<?php	while ($my_query->have_posts()) : $my_query->the_post(); ?>	
                                <div class="col-sm-3">
                                    <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                                        <?php the_post_thumbnail(); ?>
                                        <h5 class="mt8 mb8">
                                            <?php the_title(); ?>
                                        </h5>                                        
                                    </a>
                                </div>
                            <?php
                            endwhile;
                        }
                        wp_reset_query();
                    }
                    ?>
                </div>
            </div>
        </section>

</main><!-- #main -->


<?php
get_footer();
