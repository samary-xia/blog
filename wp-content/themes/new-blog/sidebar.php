<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package new_blog
 */

?>
<aside id="sidebar-1" class="widget-area">
	<div class="sidebar">

	<?php if( absint(get_theme_mod('new_blog_sidebar_about_enable','0')) ==1) : ?>
	<div class="about-me block">
		<div class="side-title">
			<h4><?php echo esc_html(get_theme_mod('new_blog_sidebar_about_title',__('About Me','new-blog')) ); ?></h4>
		</div>
		<div class="img-holder">
			<img src="<?php echo esc_html(get_theme_mod( 'new_blog_sidebar_about_image') ) ?> " alt="">
		</div> 
		<p><?php echo esc_html(get_theme_mod('new_blog_sidebar_about_textarea'),__('Mauris eget pharetra lectus','new-blog') ) ?></p>
	</div>
	<?php endif ;
	if(absint(get_theme_mod('new_blog_social_sidebar_enable','0'))==1) :?>
		<div class="get-connected block">
			<div class="side-title">
				<h4><?php echo esc_html(get_theme_mod('new_blog_social_sidebar_title',__('Stay Connected','new-blog'))) ?></h4>
			</div>
			<ul class="social-icon">
				<?php if(absint(get_theme_mod('new_blog_facebook_url_enable','1'))==1) : ?>
					<li><a href="<?php echo esc_url(get_theme_mod( 'new_blog_social_url_'.'Facebook'))?>"target="_blank"><span class="fa fa-facebook" aria-hidden="true"></span></a></li>
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
		</div>
	<?php endif ; 
	if (absint(get_theme_mod('new_blog_sidebar_slider_enable','1')) == 1) : ?>
	<div class="post-slider block">
		<?php $args = array( 
		'post_type' => 'post',
		'category_name' => esc_attr(get_theme_mod('new_blog_sidebar_slider_categorylist','')),
		'orderby' => array( esc_attr(get_theme_mod('new_blog_sidebar_slider_order', 'date')) => 'DSC', 'date' => 'DSC'),
		'order'     => 'DSC',
		'posts_per_page' => absint(get_theme_mod( 'new_blog_sidebar_slider_noofpost','1' )),
		);
		$listings = new WP_Query( $args );
		if ( $listings->have_posts() ) :

		/* Start the Loop */
		while ( $listings->have_posts() ) :
				$listings->the_post();
		?>
		<div class="item">
			<div class="img-holder">
			<?php if ( ! has_post_thumbnail() ) {
				if ( absint(get_theme_mod('new_blog_sidebar_slider_post_taxonomy_UseBlankImage','1'))==1) { 
				?>
				<div>
					<img  src = "<?php echo esc_url( get_template_directory_uri() ); ?>/images/woman-3208045_1920-450x401.jpg " >
				</div>

				<?php } 
			} else if ( has_post_thumbnail() ) {
				new_blog_sidebar_thumbnail();
			}
			?>
				<div class="caption">
					<?php if (absint(get_theme_mod('new_blog_sidebar_slider_post_taxonomy_Category','1')) == 1) : ?>
					<span class ="cat"> <?php the_category( ' / ' ); ?> </span>
					<?php endif ; ?>
					<?php the_title( '<h5><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h5>' ); ?>
				</div>
			</div>
		</div>
		<?php endwhile;
		wp_reset_query(); 
		endif; ?>
	</div>
	<?php endif; ?>
	<?php if (absint(get_theme_mod('new_blog_sidebar_post_enable','1'))== 1) : ?>
	<div class="latest-post block">
		<div class="side-title">
			<h4><?php echo esc_html(get_theme_mod('new_blog_sidebar_post_title',__('Latest Posts','new-blog')) ); ?></h4>
		</div>
		<?php $args = array( 
		'post_type' => 'post',
		'category_name' => esc_attr(get_theme_mod('new_blog_sidebar_post_categorylist','')),
		'orderby' => array( esc_attr(get_theme_mod('new_blog_sidebar_post_order', 'date')) => 'DSC', 'date' => 'DSC'),
		'order'     => 'DSC',
		'posts_per_page' => absint(get_theme_mod( 'new_blog_sidebar_post_noofpost','4' )),
		);
		$listings = new WP_Query( $args );
		if ( $listings->have_posts() ) :
			/* Start the Loop */
			while ( $listings->have_posts() ) :
					$listings->the_post(); 
			?>
			<div class="media">
			
			<?php new_blog_sidebar_latestpost_thumbnail(); ?>
				<div class="media-body">
					<?php the_title( '<h5 class="mt-0"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h5>' ); 
					if (absint(get_theme_mod('new_blog_sidebar_post_post_taxonomy_Date','1')) == 1) : ?>
						<div class="bl-date">
							<?php new_blog_posted_on() ?>
						</div>
					<?php endif ; ?>
				</div>
			</div>
			<?php endwhile;
			wp_reset_query(); 
		endif; ?>
	</div>
	<?php endif; ?>
	<?php dynamic_sidebar( 'sidebar-1' );
	if (absint(get_theme_mod('new_blog_sidebar_quote_enable','0')) ==1) : ?>
	<blockquote class="block">
		<div class="side-title">
		<h4><?php echo esc_html(get_theme_mod('new_blog_sidebar_quote_title',__('Quotes Of The Day','new-blog')) ); ?></h4>
		</div>
		<p>
		<span class="fa fa-quote-left" aria-hidden="true"></span>
		&nbsp; <?php echo esc_html(get_theme_mod('new_blog_sidebar_quote_textarea',__('this is my quote','new-blog')) ) ?> &nbsp;
		<span class="fa fa-quote-right" aria-hidden="true"></span>
		</p>
	</blockquote>
	<?php endif ; ?>
	</div>
</aside><!-- #secondary -->