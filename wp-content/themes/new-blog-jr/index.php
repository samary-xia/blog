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
 * @package new_blog_jr
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
					<!-- feature post new for new blog jr only -->
					<?php if (absint(get_theme_mod('new_blog_feature_post_enable','1')) == 1) : ?>
						<section class="outer-categories pb-5">
							<div >
								<div class="row">
								<?php $args = array( 
									array( 
										'post_type' => 'post',
										'category_name' => esc_attr(get_theme_mod('new_blog_jr_categorylist1','')),
										'posts_per_page' => 1,
										'ignore_sticky_posts' => 1,
										'orderby' => array( esc_attr(get_theme_mod('new_blog_feature_post_order', 'date')) => 'DSC', 'date' => 'DSC'),
										'order'     => 'DSC',
											),
									array( 
										'post_type' => 'post',
										'category_name' => esc_attr(get_theme_mod('new_blog_jr_categorylist2','')),
										'posts_per_page' => 1,
										'ignore_sticky_posts' => 1,
										'orderby' => array( esc_attr(get_theme_mod('new_blog_feature_post_order', 'date')) => 'DSC', 'date' => 'DSC'),
										'order'     => 'DSC',
											),
									array( 
										'post_type' => 'post',
										'category_name' => esc_attr(get_theme_mod('new_blog_jr_categorylist3','')),
										'posts_per_page' => 1,
										'ignore_sticky_posts' => 1,
										'orderby' => array( esc_attr(get_theme_mod('new_blog_feature_post_order', 'date')) => 'DSC', 'date' => 'DSC'),
										'order'     => 'DSC',
											),
									);
									foreach ($args as $args_cat ) {
										$listings = new WP_Query( $args_cat );
										if ( $listings->have_posts() ) :

										/* Start the Loop */
										while ( $listings->have_posts() ) :
												$listings->the_post();
							
											?>
												<div class="col-md-4 mb-4">
													<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

														<div class="cat-holder">
															<div class="img-holder">
															<?php
															if ( ! has_post_thumbnail() ) {
																if ( get_theme_mod('new_blog_feature_post_post_taxonomy_UseBlankImage','1') ==1) { ?>
																
																<div>
																	<img  src = "<?php echo esc_url( get_theme_file_uri() ); ?>/images/blank-feature-post-first.jpg " >
																</div>
																<?php } 
																
															} else if ( has_post_thumbnail() ) {
																new_blog_jr_new_banner_thumbnail();
															}
															?>
															</div>
															<?php 
															if (absint(get_theme_mod('new_blog_feature_post_post_taxonomy_Category','1')) == 1) {
																$categories = get_the_category();
																foreach($categories as $value ){
																	if ($value->name == $args_cat['category_name']){
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

											// get_template_part( 'template-parts/content', 'none' );

										endif;
									} ?>
								</div>
							</div>
						</section>
						<?php endif; ?>
					<div class="row">
						<div class="col-lg-<?php echo absint($modes1) ?>">
		
						<?php if (absint(get_theme_mod('new_blog_blog_post_enable','1'))==1):

							if (absint(get_theme_mod('new_blog_jr_post_layout','1'))==2): ?>
							<section class="mt-5">
							<div class="grid-blog">
							
								<div class="row">
									<?php if ( have_posts() ) :
										/* Start the Loop */
										while ( have_posts() ) :
										the_post();
										?>
										<div class="col-lg-4 col-md-6">
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
											'pre_text' => __('Previous', 'new-blog-jr'),
											'next_text' => __('Next', 'new-blog-jr'),
										)); 
	
									?>
								</div>
							</div>
							</section>
							<?php endif;?>
							
							<?php if (esc_attr(get_theme_mod('new_blog_jr_post_layout','1'))==1): ?>
							<section class="mt-5">
							<div class="thumb-blog ">
							
								<div class="row ">
									<?php if ( have_posts() ) :
										/* Start the Loop */
										while ( have_posts() ) :
										the_post();
										?>
										<div class="col-md-12">
											<?php get_template_part( 'template-parts/content-1colume' ); 
											if (absint(get_theme_mod('new_blog_jr_blog_post_related_post_front','1'))==1):
												get_template_part( 'inc/related-posts-front' ); 
											endif;
											?>
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
											'pre_text' => __('Previous', 'new-blog-jr'),
											'next_text' => __('Next', 'new-blog-jr'),
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