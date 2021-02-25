<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package new_blog
 */

get_header();
?>

<div id="primary" class="content-area" onLoad="window.scroll(0, 500)">
	<main id="main" class="site-main">
	<?php
		if(absint(get_theme_mod('new_blog_sidebar_enable','1')) == 1) : 
		$modes1 = 8;
		elseif (absint(get_theme_mod('new_blog_sidebar_enable','1')) == 0) :
		$modes1 = 12;
		endif ;
		?>
	<section  class="middle-content inner-content">
		<div class="container-fluid">
			<div id ="scroll-top" class="row">
			<div class="col-lg-<?php echo absint($modes1) ?>">
						<?php
						while ( have_posts() ) :
							the_post();
						?>
						<div class="detail-block">
							<section>
								<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

									<div class="thumb">
										<?php the_post_thumbnail(); ?>
										<div class="thumb-body text-justify">
											<header class="entry-header">
												<span class ="mt-4 cat"> <?php the_category( ' / ' ); ?> </span>
												<?php the_title( '<h1 class="entry-title card-title">', '</h1>' ); ?>
											</header>
											<?php the_content();
											wp_link_pages( array(
													'before'            => '<div class="text-center">'.__( 'Pages :', 'new-blog' ),
													'after'             => '</div>',
													'link_before'       => '',
													'link_after'        => ''
											) ); ?>
											<div class="clearfix"> </div>
											<footer>
												<div class="coment-share">
													<div class="tag-date-comment">
														<ul class="date-comment">
														<li> <?php new_blog_posted_on() ?></li>
														<li><?php new_blog_post_comment() ?></li>
														
														<?php if ( absint(get_theme_mod('new_blog_single_page_post_taxonomy_TimeAgo','1'))==1) : ?>	
															<li> 
																<span class="date"><a><i class="fa fa-clock-o"></i><span class="pl-1"> <?php new_blog_time_ago() ?>
																</span></a></span>
															</li>
														<?php endif;?>	
														
														<li><?php  new_blog_edit_post() ?></li>
														
														</ul>
														<span class ="tag"> <?php new_blog_post_tag() ?></span>

													</div>
													
												</div>
											</footer>
										</div>
									</div>
								</article><!-- #post-<?php the_ID(); ?> -->

							</section>
							<div class =" mt-5 mb-5"> 
							<?php // Previous/next post navigation. 
							the_post_navigation( array( 
								'next_text' =>  __( 'Next post', 'new-blog' ), 
								'prev_text' =>  __( 'Previous post', 'new-blog' ) ) ); 
							?> 
							</div>
							<?php if ( absint(get_theme_mod('new_blog_single_page_post_taxonomy_AuthorSection','1'))==1) : ?>
							<section>
							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

								<div class="author">
									<div class="title-holder text-center other-title">
										<h2><?php echo esc_html(get_theme_mod('new_blog_single_page_author_title',__('Author','new-blog'))); ?></h2>
									</div>
									<div class="media">
										<?php if (absint(get_theme_mod('new_blog_single_page_post_taxonomy_Avatar','1'))==1) : ?>
										<div class="img-holder mr-4">
										<?php echo get_avatar( get_the_author_meta('ID'), 100); ?>
										</div>
										<?php endif ; ?>
										<div class="media-body">
											<header class="entry-header">
											<div class="title-share">
												<div class= "w-100">
													<?php new_blog_posted_by(); ?> 
												</div>
												<?php if (absint(get_theme_mod('new_blog_single_page_post_taxonomy_Email','1'))==1) : ?>
												<div>
												<?php the_author_meta('user_email');?>
												</div>
												<?php endif ; ?>
											</div>
											</header>
											<?php if (absint(get_theme_mod('new_blog_single_page_post_taxonomy_Description','1'))==1) : ?>
											<div >
											<?php echo the_author_meta('description'); ?>
											</div>
											<?php endif ; ?>
										</div>
									</div>
								</div>
							</article>
							</section>
							<?php endif ;
							if (absint(get_theme_mod('new_blog_related_post_enable','1')) ==1) : ?>
							<section>
							<?php $orig_post = $post;
							$categories = get_the_category($post->ID);
							if ($categories) {
							$category_ids = array();
							foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
							$args=array(
							'category__in' => $category_ids,
							'orderby' => array( esc_attr(get_theme_mod('new_blog_related_post_order', 'date')) => 'DSC', 'date' => 'DSC'),
							'post__not_in' => array($post->ID),
							'posts_per_page'=> 4, // Number of related posts that will be shown.
							'ignore_sticky_posts'=>1
							);

							$my_query = new wp_query( $args );
							if( $my_query->have_posts() ) { ?> 
							<div class="related-posts">
								<div class="title-holder text-center other-title">
									<h2><?php echo esc_html(get_theme_mod('new_blog_related_post_title',__('Related Posts','new-blog'))); ?></h2>
								</div>
								<div class="row">
								<?php while( $my_query->have_posts() ) {
									$my_query->the_post();?>
									<div class="col-md-6">
										<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
											<div class="card">
											<?php new_blog_post_thumbnail(); ?>
												<div class="card-body">
													<header class="entry-header">
														<div class="tag-date-comment">
															<?php if (absint(get_theme_mod('new_blog_related_post_post_taxonomy_Category','1')) ==1) : ?>
																<span class ="cat"> <?php the_category( ' / ' ); ?> </span>
															<?php endif; ?>
															<ul class="date-comment">
																<?php if (absint(get_theme_mod('new_blog_related_post_post_taxonomy_Date','1')) ==1) : ?>
																	<li> <?php new_blog_posted_on() ?></li>
																<?php endif; ?>

																<?php if (absint(get_theme_mod('new_blog_related_post_post_taxonomy_TimeAgo','1')) ==1) : ?>
																	<li> 
																	<span class="date"><a><i class="fa fa-clock-o"></i><span class="pl-1"> <?php new_blog_time_ago() ?>
																	</span></a></span>
																	</li>										
																<?php endif; ?>

																	<li><?php  new_blog_edit_post() ?></li>
															</ul>
															<?php if (absint(get_theme_mod('new_blog_related_post_post_taxonomy_Tag','1')) ==1) : ?>
															<span class ="tag"> <?php new_blog_post_tag() ?></span>
															<?php endif; ?>
														</div>
														<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
													</header>
													<?php if (absint(get_theme_mod('new_blog_related_post_post_taxonomy_Excerpt','1')) ==1) : ?>

														<?php the_excerpt(); ?>
														<?php endif; ?>
													<?php if (absint(get_theme_mod('new_blog_related_post_post_taxonomy_ReadMore','1')) ==1) : ?>
													<footer>
														<a class=" btn" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'new-blog'); ?></a>
													</footer>
													<?php endif; ?>

												</div>
											</div>
										</article><!-- #post-<?php the_ID(); ?> -->
									</div>
								<?php }
								wp_reset_query(); ?>
								</div>
							</div>
							<?php }
							}
							$post = $orig_post;
							?></section>
							<?php endif ; ?>

							<?php if (  comments_open() || get_comments_number() ) :
									comments_template();
							endif; ?>
							
						</div>
						<?php endwhile; ?> 

				</div>
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
	if ( absint(get_theme_mod('new_blog_single_page_post_taxonomy_NextPostFloat','1'))==1) :

	$nextPost = get_previous_post();

	if(!empty($nextPost) && ($nextPost->ID != get_the_ID())):

?>
<div class="left-float-post">
	<div class="media">
		<img class="mr-3" src="<?php echo esc_url(get_the_post_thumbnail_url($nextPost->ID,'new-blog-155-125'));?>">
		<div class="media-body">
			<span class="post-close" id="left-float-post"><i class="fa fa-times"></i></span>
		  <span class="post-arrow "><i class="fa fa-backward"></i></span>
		  <h3 class="mt-0 mb-1"><a href="<?php echo esc_url(get_permalink($nextPost->ID));?>"><?php echo esc_html(get_post($nextPost->ID)->post_title);?></a></h3>
		  <p><?php echo esc_html(get_the_date('',$nextPost->ID));?></p>
		</div>
	</div>
</div>
<?php 
endif;
endif;?>

<?php 
if ( absint(get_theme_mod('new_blog_single_page_post_taxonomy_PreviousPostFloat','1'))==1) :
    $prevPost = get_next_post();
	if(!empty($prevPost) && ($prevPost->ID != get_the_ID())):
?>
<div class="right-float-post">
	<div class="media">
		<img class="mr-3" src="<?php echo esc_url(get_the_post_thumbnail_url($prevPost->ID,'new-blog-155-125'));?>">
		<div class="media-body">
			<span class="post-close" id="right-float-post"><i class="fa fa-times"></i></span>
			<span class="post-arrow " ><i class="fa fa-forward"></i></span>
			<h3 class="mt-0 mb-1"><a href="<?php echo esc_url(get_permalink($prevPost->ID));?>"><?php echo esc_html(get_post($prevPost->ID)->post_title);?></a></h3>
		  	<p><?php echo esc_html(get_the_date('',$prevPost->ID));?></p> 		
		</div>
	</div>
</div>
<?php 
endif;
endif;?>



<?php
get_footer();
