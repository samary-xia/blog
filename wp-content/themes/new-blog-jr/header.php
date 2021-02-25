<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package new_blog
 */

?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>  >
<?php 
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
}
?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'new-blog-jr' ); ?></a>

	<header id="masthead" class="site-header ">
<!-- Logo -->
		<?php if ( function_exists(  "the_custom_logo" ) ) { 
			?> 
			<div>
			<?php the_custom_logo();
			?> </div> <?php
		} ?>
		<?php if ( has_header_image() ) { ?>
			<div class="container-header">
				<div class="min-height-150">
				<?php the_custom_header_markup(); ?>	
				</div>
				<!-- Title -->
				<div class=" logo text-center mx-auto overlays ">
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
					$new_blog_description = get_bloginfo( 'description', 'display' );
					if ( $new_blog_description || is_customize_preview() ) :
					?>
					<p class="site-description"><?php echo $new_blog_description; /* WPCS: xss ok. */ ?></p>
					<?php endif; ?>
					<!-- social icon new location -->
					<div id= "social-icon-top-new" class="text-center">
					
						<?php if(absint(get_theme_mod('new_blog_social_top_enable','0'))==1) : ?>
							<ul class="social-icon  ">
								<?php if(absint(get_theme_mod('new_blog_facebook_url_enable','1'))==1) : ?>
									<li ><a href="<?php echo esc_url(get_theme_mod( 'new_blog_social_url_'.'Facebook'))?>"target="_blank"><span class="fa fa-facebook" aria-hidden="true"></span></a></li>
								<?php endif ; ?>
								<?php if(absint(get_theme_mod('new_blog_twitter_url_enable','1'))==1) : ?>
									<li><a href="<?php echo esc_url(get_theme_mod( 'new_blog_social_url_'.'Twitter'))?>"target="_blank"><span class="fa fa-twitter" aria-hidden="true"></span></a></li>
								<?php endif ; ?>
								<?php if(absint(get_theme_mod('new_blog_youtube_url_enable','1'))==1) : ?>
									<li><a href="<?php echo esc_url(get_theme_mod( 'new_blog_social_url_'.'Youtube'))?>"target="_blank"><span class="fa fa-youtube" aria-hidden="true"></span></a></li>
								<?php endif ; ?>
								<?php if(absint(get_theme_mod('new_blog_pinterest_url_enable','1'))==1) : ?>
									<li><a href="<?php echo esc_url(get_theme_mod( 'new_blog_social_url_'.'Pinterest'))?>"target="_blank"><span class="fa fa-pinterest" aria-hidden="true"></span></a></li>
								<?php endif ; ?>
								
							</ul>
						<?php endif ; ?>
					</div>
					<!-- social icon new location end-->
					
				</div>
			</div>
			<?php } elseif ( ! has_header_image() ) { ?>
			<!-- Title -->
			<div class=" text-center mx-auto logo  ">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
				$new_blog_description = get_bloginfo( 'description', 'display' );
				if ( $new_blog_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $new_blog_description; /* WPCS: xss ok. */ ?></p>
				<?php endif; ?>
			</div>
		<?php } ?>

		<div class="text-center pt-3 pb-3 navbar-expand-lg" > 
			<!-- Navbar -->
			<nav class="navbar ">
        		<div class="container">
						<div class="clearfix"> </div>
						<div class='float-right'>
							<!-- Right nav -->
							<ul class="search-tab">
								<li><a href="javascript:;" class="toggle" id="sidenav-toggle" ><span class="fa fa-bars" aria-hidden="true"></span></a></li>
							</ul>
						</div>			
			  </div>
			</nav>
		</div>

    <!-- side nav -->

    <nav class="sidenav" data-sidenav data-sidenav-toggle="#sidenav-toggle">
	<a id ="closebtn" href="javascript:void(0)" class="closebtn">&times;</a>

      <div class="sidenav-brand logo text-left">
          <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
      </div>
        <?php get_search_form(); ?>
			<nav id ="side_nav" class=" navbar navbar-expand-sm " role="navigation">
						<?php
						wp_nav_menu( array(
							'theme_location'    => 'menu-2',
							'depth'             => 1,
              				'container'         => 'div',
							'container_id'      => 'bs-example-navbar-collapse-1',
							'menu_class'        => 'nav flex-column sidenav-menu',
							'fallback_cb'       => 'New_Blog_WP_Bootstrap_Navwalker::fallback',
							'walker'            => new New_Blog_WP_Bootstrap_Navwalker(),
						) );
						?>
			</nav>
 
    </nav>

		<!-- end side nav -->

	<!-- banner slider -->

	<?php if( absint(get_theme_mod( 'new_blog_banner_slider_enable','1' )) == 1 ) :?>

		<?php if ( is_home() or is_front_page() ) : ?>
			<section class="banner-holder block-2 " >
					<div class="banner multiple-items-js container-fluid">
					<?php $args = array( 
					'post_type' => 'post',
					'category_name' => esc_attr(get_theme_mod('new_blog_banner_slider_categorylist','')),
					'orderby' => array( esc_attr(get_theme_mod('new_blog_banner_slider_order', 'date')) => 'DSC', 'date' => 'DSC'),
					'order'     => 'DSC',
					'posts_per_page' => absint(get_theme_mod( 'new_blog_banner_slider_noofpost' )),
					'ignore_sticky_posts' => 1,

					);
					$listings = new WP_Query( $args );
					if ( $listings->have_posts() ) :

						/* Start the Loop */
						while ( $listings->have_posts() ) :
								$listings->the_post();
												
								get_template_part( 'template-parts/content-banner' );
								
						endwhile;
					
					else :
						get_template_part( 'template-parts/content', 'none' );
					endif;
					wp_reset_postdata();
				?> </div>
			</section>
		<?php endif; ?>
	<?php endif; ?>

		<!-- end banner slider -->

		
  </header><!-- #masthead -->
	
<div id="content" class="site-content">
	<!-- Main menu -->
	<nav id="site-navigation" class="sticky-top navbar navbar-expand-lg <?php if ( ! is_single() && wp_get_nav_menu_name ('menu-1') ) { echo 'mt-5' ;} ?> main-navigation" role="navigation">
		<!-- Brand and toggle get grouped for better mobile display -->
		<?php 
		if (wp_get_nav_menu_name ('menu-1')) { ?>
			<button class="menu-toggle navbar-toggler" type="button" data-toggle="collapse" data-target="#collapse-1" aria-controls="bs-example-navbar-collapse-1" aria-expanded="false" aria-label= "<?php esc_attr_e('Toggle navigation','new-blog-jr');?>">
				<span class="fa fa-bars"></span>
			</button>
		<?php } else { ?>
			<style>
				.navbar {
					border-bottom: none;
					
				} 
				.middle-content {
					padding: initial;
				}
			</style>
		<?php }
			wp_nav_menu( array(
				'theme_location'    => 'menu-1',
				'depth'             => 3,
				'container'         => 'div',
				'container_class'   => 'collapse navbar-collapse',
				'container_id'      => 'collapse-1',
				'menu_class'        => 'nav unique-main-menu navbar-nav mx-auto',
				'fallback_cb'       => 'New_Blog_WP_Bootstrap_Navwalker::fallback',
				'walker'            => new New_Blog_WP_Bootstrap_Navwalker(),
			) );
			?>
	</nav>
	<!-- End Main menu -->
