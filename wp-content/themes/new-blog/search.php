<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package new_blog
 */

get_header();
?>

<section id="primary" class="content-area">
	<main id="main" class="site-main">
	<?php
		if(absint(get_theme_mod('new_blog_sidebar_enable','1')) == 1) : 
		$modes1 = 8;
		elseif (absint(get_theme_mod('new_blog_sidebar_enable','1')) == 0) :
		$modes1 = 12;
		endif ;
		?>
		<?php if ( have_posts() ) : ?>
		<header id ="scroll-top" class="page-header">
			<section class="search-result">
				<div class="container-fluid">
					<div class="result-holder">
						<h1 class="page-title search-result">
						<?php
						/* translators: %s: search query. */
						printf( esc_html__( 'Search Results for: %s', 'new-blog' ), '<span class="highlight">' . get_search_query() . '</span>' );
						?>
						</h1>
					</div>
				</div>
			</section>
		</header><!-- .page-header -->
		<section class="middle-content inner-content">
			<div class="container-fluid">
				<div class="row">
				<div class="col-lg-<?php echo absint($modes1) ?>">
						<?php if (absint(get_theme_mod('new_blog_blog_post_layout','2'))==2): ?>
						<div class="grid-blog">
						<section>
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
						</section>
						</div>
						<?php endif;?>
						
						<?php if (absint(get_theme_mod('new_blog_blog_post_layout','2'))==1): ?>
						<div class="thumb-blog">
						<section>
							<div class="row">
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
						</section>
						</div>
						<?php endif;?>
						</div>
						<?php if(esc_attr(get_theme_mod('new_blog_sidebar_enable','1')) == 1) : ?>
						<div class="col-lg-4">
								<?php get_sidebar()?>
						</div>
						<?php endif; ?>
				</div>
			</div>
		</section>
		<?php else : 
			get_template_part( 'template-parts/content', 'none' );
		endif; ?>
	</main><!-- #main -->
</section><!-- #primary -->
<?php
get_footer();
