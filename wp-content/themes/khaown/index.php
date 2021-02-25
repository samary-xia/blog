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
 * @package WordPress
 * @subpackage khaown
 * @since 1.0.0
 */

get_header();
?>

<div class="main-container">
	<?php
		$sidebar_position = get_theme_mod("top_header_display_or_not", "show_header"); 
		if($sidebar_position === "show_header"){ 
		
		?>

		<section class="page-title page-title-4 bg-menu-4">
			<?php 
				$header_bg_image_1 = get_template_directory_uri() ."/assets/images/header-bg-img-1.png";
				$header_bg_image_2 = get_template_directory_uri() ."/assets/images/header-bg-img-2.png";
				$header_bg_image_3 = get_template_directory_uri() ."/assets/images/header-bg-img-3.png";
				$header_bg_image_4 = get_template_directory_uri() ."/assets/images/header-bg-img-4.png";
			?>
			<div class="khaown-clouds">
				<div class="khaown-header-bg-image-1 khaown-header-bg-image">
					<img src="<?php echo $header_bg_image_1; ?>" alt="bg" class="bg-image bg-image-1">
				</div>
				<div class="khaown-header-bg-image-2 khaown-header-bg-image">
					<img src="<?php echo $header_bg_image_2; ?>" alt="bg" class="bg-image bg-image-2">
				</div>
				<div class="khaown-header-bg-image-3 khaown-header-bg-image">
					<img src="<?php echo $header_bg_image_3; ?>" alt="bg" class="bg-image bg-image-3">
				</div>
				<div class="khaown-header-bg-image-4 khaown-header-bg-image">
					<img src="<?php echo $header_bg_image_4; ?>" alt="bg" class="bg-image bg-image-4">
				</div>
			</div>
			
			<div class="khaown-main-container px16 container">
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
	<?php } else { ?>
		<div class="khaown-spacer py16">

		</div>
	<?php } ?>
	<section id="main" class="page-template">
        <div class="khaown-main-container px16">
            <div class="blog-posts em-site-content">
                <div class="row mt48">
					<?php 
						$sidebar_position = get_theme_mod("blog_page_sidebar_position", "no-sidebar"); 

						$grid_or_default_view = get_theme_mod("grid_or_default_view", "grid_view"); 

						if( ($sidebar_position === "right-sidebar") && is_active_sidebar( 'sidebar-2' ) ) { ?>

						<div class="col-md-9 col-xs-12">
							<main id="khaown-main" class="khaown-site-main pd-right-32">
								<div class="row">
								<?php
									if ( have_posts() ) {
										// Load posts loop.
										while ( have_posts() ) {
											the_post();
											if($grid_or_default_view === "grid_view"){
												get_template_part( 'template-parts/content/content', 'twogridexcerpt');
											} else {
												get_template_part( 'template-parts/content/content', 'excerpt');
											}
											
										}

									} else {
										// If no content, include the "No posts found" template.
										get_template_part( 'template-parts/content/content', 'none' );
									}
								?>
								</div>
								<div class="row">
									<div class="col-xs-12">
										<?php 
											// Previous/next page navigation.
											khaown_the_posts_navigation(); 
										?>
									</div>
								</div>
							</main><!-- .site-main -->
						</div>
						
						<div class="col-md-3 col-xs-12 mx-md-16 text-center feature bordered bg-color-blog-posts">
							<?php dynamic_sidebar( 'sidebar-2' ); ?>
						</div> 
						
					<?php } else if(($sidebar_position === "left-sidebar") && is_active_sidebar( 'sidebar-1' ) ) { ?>
						<div class="col-md-9 col-md-push-3 col-xs-12">
							<main id="khaown-main" class="khaown-site-main pd-left-32">
								<div class="row">
									<?php
										if ( have_posts() ) { ?>
											<?php 
												// Load posts loop.
												while ( have_posts() ) {
													the_post();
													if($grid_or_default_view === "grid_view"){
														get_template_part( 'template-parts/content/content', 'twogridexcerpt');
													} else {
														get_template_part( 'template-parts/content/content', 'excerpt');
													}
												}
											?>
									<?php
									} else {
										// If no content, include the "No posts found" template.
										get_template_part( 'template-parts/content/content', 'none' );
									}
								?>
								</div>
								<div class="row">
									<div class="col-xs-12">
										<?php 
											// Previous/next page navigation.
											khaown_the_posts_navigation(); 
										?>
									</div>
								</div>
							</main><!-- .site-main -->
						</div>

						<div class="col-md-3 col-md-pull-9 col-xs-12 mx-md-16 text-center feature bordered bg-color-blog-posts">
							<?php dynamic_sidebar( 'sidebar-1' ); ?>
						</div> 

					<?php } else if($sidebar_position === "both-sidebar") { ?>
						<div class="col-md-6 col-md-push-3 col-xs-12">
							<main id="khaown-main" class="khaown-site-main pl16 pr16">
								<div class="row">
									<?php
										if ( have_posts() ) { ?>
											<?php 
												// Load posts loop.
												while ( have_posts() ) {
													the_post();
													if($grid_or_default_view === "grid_view"){
														get_template_part( 'template-parts/content/content', 'twogridexcerpt');
													} else {
														get_template_part( 'template-parts/content/content', 'excerpttopphoto');
													}
												}
											?>
									<?php
									} else {
										// If no content, include the "No posts found" template.
										get_template_part( 'template-parts/content/content', 'none' );
									}
								?>
								</div>
								<div class="row">
									<div class="col-xs-12">
										<?php 
											// Previous/next page navigation.
											khaown_the_posts_navigation(); 
										?>
									</div>
								</div>
							</main><!-- .site-main -->
						</div>
						
						
						<?php if(is_active_sidebar( 'sidebar-1' )){ ?>
							<div class="col-md-3 col-md-pull-6 col-xs-12 mx-md-16 text-center feature bordered bg-color-blog-posts">
								<?php dynamic_sidebar( 'sidebar-1' ); ?>
							</div>
						<?php } ?>

						<?php if(is_active_sidebar( 'sidebar-2' )){ ?>
							<div class="col-md-3 col-xs-12 mx-md-16 text-center feature bordered bg-color-blog-posts">
								<?php dynamic_sidebar( 'sidebar-2' ); ?>
							</div>
						<?php } ?>
						

					<?php } else {  ?>
							<?php if($grid_or_default_view === "grid_view"){ ?>
								<div class="row">
									<div class="col-md-10 col-md-offset-1 col-xs-12">
										<main id="khaown-main" class="khaown-site-main">
											<div class="row">
												<?php
													if ( have_posts() ) {
														// Load posts loop.
														while ( have_posts() ) {
															the_post();
															get_template_part( 'template-parts/content/content', 'threegridexcerpt');
														}
														
													} else {
														// If no content, include the "No posts found" template.
														get_template_part( 'template-parts/content/content', 'none' );
													}
												?>
											</div>

											<div class="row">
												<div class="col-xs-12">
													<?php 
														// Previous/next page navigation.
														khaown_the_posts_navigation(); 
													?>
												</div>
											</div>
											
										</main><!-- .site-main -->
									</div>
								</div>
								
							<?php } else { ?>
								<div class="col-xs-12 col-sm-8 col-sm-offset-2">
									<main id="khaown-main" class="khaown-site-main">
										<div class="row">
										<?php
											if ( have_posts() ) {
												// Load posts loop.
												while ( have_posts() ) {
													the_post();
													get_template_part( 'template-parts/content/content', 'excerpt');
												}
												
											} else {
												// If no content, include the "No posts found" template.
												get_template_part( 'template-parts/content/content', 'none' );
											}
										?>
										</div>
										<div class="row">
											<div class="col-xs-12">
												<?php 
													// Previous/next page navigation.
													khaown_the_posts_navigation(); 
												?>
											</div>
										</div>
										
									</main><!-- .site-main -->
								</div>
							<?php } ?>
						
					<?php }; ?>
				</div>
			</div>
		</div>
	</section>


	
</div>

<?php get_footer(); ?>