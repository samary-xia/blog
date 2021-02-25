<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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
			if(absint(get_theme_mod('new_blog_sidebar_enable','1')) == 1) : 
			$modes1 = 8;
			elseif (absint(get_theme_mod('new_blog_sidebar_enable','1')) == 0) :
			$modes1 = 12;
			endif ;
			?>
			<section class="middle-content homepage1">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-<?php echo absint($modes1) ?>">
						<!-- feature post -->
						<?php if (absint(get_theme_mod('new_blog_feature_post_enable','1')) == 1) : ?>
						<section class="outer-categories">
							<div >
								<div class="row">
								<?php $args = array( 
									'post_type' => 'post',
									'category_name' => esc_attr(get_theme_mod('new_blog_feature_post_categorylist','')),
									'orderby' => array( esc_attr(get_theme_mod('new_blog_feature_post_order', 'date')) => 'DSC', 'date' => 'DSC'),
									'order'     => 'DSC',
									'posts_per_page' => 4,
									'ignore_sticky_posts' => 1,
									);
									$listings = new WP_Query( $args );
									if ( $listings->have_posts() ) :

									/* Start the Loop */
									while ( $listings->have_posts() ) :
											$listings->the_post();
											
										?>
											<div class="col-md-6 mb-4">
												<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

													<div class="cat-holder ">
														<div class="img-holder">
														<?php
														if ( ! has_post_thumbnail() ) {
															if ( get_theme_mod('new_blog_feature_post_post_taxonomy_UseBlankImage','1') ==1) { ?>
															
															<div>
																<img  src = "<?php echo esc_url( get_template_directory_uri() ); ?>/images/woman-3208045_1920-361x175.jpg " >
															</div>
															<?php } 
															
														} else if ( has_post_thumbnail() ) {
															new_blog_feature_display_thumbnail();
														}
														?>
														</div>
														<?php 
														if (absint(get_theme_mod('new_blog_feature_post_post_taxonomy_Category','1')) == 1) {
														$categories = get_the_category();
																foreach($categories as $value ){
																	if ($value->name == $args['category_name']){
																		if ( ! empty( $categories ) ) {
																			echo '<a class=" btn" href="' . esc_url( get_category_link( $value->term_id ) ) . '">' . esc_html( $value->name ) . '</a>';
																		}
																	}
																}
														 }

														?>
													</div>
												</article><!-- #post-<?php the_ID(); ?> -->

											</div>
											<?php 
										endwhile;
										wp_reset_postdata();

									else :

										get_template_part( 'template-parts/content', 'none' );

									endif;
									?>
								</div>
							</div>
						</section>
						<?php endif; 
						if (absint(get_theme_mod('new_blog_blog_post_enable','1'))==1):

							if (absint(get_theme_mod('new_blog_blog_post_layout','2'))==2): ?>
							<section class="mt-5">
							<div class="grid-blog">
							
								<div class="row">
									<?php if ( have_posts() ) :
										/* Start the Loop */
										while ( have_posts() ) :
										the_post();
										?>
										<div class="col-md-6">
										<?php get_template_part( 'template-parts/content' ); ?>

										</div>
									<?php endwhile;
									else :
									get_template_part( 'template-parts/content', 'none' );
									endif;
									?>
								</div>
								<div class=" text-center">
									<?php 
									
										the_posts_pagination( array(
											'pre_text' => __('Previous', 'new-blog'),
											'next_text' => __('Next', 'new-blog'),
										)); 
									
									?>
								</div>
							
							</div>
							</section>
							<?php endif;?>
							
							<?php if (esc_attr(get_theme_mod('new_blog_blog_post_layout','2'))==1): ?>
							<section class="mt-5">
							<div class="thumb-blog ">
							
								<div class="row ">
									<?php if ( have_posts() ) :
										/* Start the Loop */
										while ( have_posts() ) :
										the_post();
										?>
										<div class="col-md-12">
										<?php get_template_part( 'template-parts/content-1colume' ); ?>

										</div>
									<?php endwhile;
									else :
									get_template_part( 'template-parts/content', 'none' );
									endif;
									?>
								</div>
								<div class=" text-center">
									<?php 
									
										the_posts_pagination( array(
											'pre_text' => __('Previous', 'new-blog'),
											'next_text' => __('Next', 'new-blog'),
										)); 
									
									?>
								</div>
							</div>
							</section>

							<?php endif;?>
						<?php endif;?>

						</div> <!-- End col -->
			<!-- End Blog post -->
						<?php if(esc_attr(get_theme_mod('new_blog_sidebar_enable','1')) == 1) : ?>
						<div class=" sidebar-1 col-lg-4">
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