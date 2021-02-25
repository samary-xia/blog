<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package new_blog
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="item">
			<header class="entry-header">
			<?php
			if ( ! has_post_thumbnail() ) {
				?>
				<div>
					<img  src = "<?php echo esc_url( get_template_directory_uri() ); ?>/images/woman-3208045_1920-1440x600.jpg " >
				</div>
				<?php 
			} else if ( has_post_thumbnail() ) {
				new_blog_banner_thumbnail();
			}
			?>
			</header><!-- .entry-header -->
			<div class="caption">
				<div class="tag">
				<?php if (absint(get_theme_mod('new_blog_banner_slider_post_taxonomy_Category','1')) == 1) { ?>

					<span> <?php the_category( ' / ' ); ?> </span>
				<?php } ?>
				</div>
				
				<?php the_title( '<h2 class="entry-title banner-post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );  ?>
				<?php if (absint(get_theme_mod('new_blog_banner_slider_post_taxonomy_Excerpt','1')) == 1) {

				the_excerpt(); 
				}
				if (absint(get_theme_mod('new_blog_banner_slider_post_taxonomy_ReadMore','1')) == 1) { ?>
				<a class=" btn" href="<?php the_permalink(); ?>"><?php echo esc_html(get_theme_mod('new_blog_read_more_title',__('Read more', 'new-blog'))); ?></a>
				<?php } ?>
			</div>
			
		</div>
</article><!-- #post-<?php the_ID(); ?> -->