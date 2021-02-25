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
					<img  src = "<?php echo esc_url( get_theme_file_uri() ); ?>/images/blank-double-post-banner.jpg " >
				</div>
				<?php 
			} else if ( has_post_thumbnail() ) {
				the_post_thumbnail('new-blog-jr-new-banner-thumbnail');
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
				
				<?php if (absint(get_theme_mod('new_blog_banner_slider_post_taxonomy_ReadMore','1')) == 1) { ?>
				<a class=" btn" href="<?php the_permalink(); ?>"><?php echo esc_html(get_theme_mod('new_blog_read_more_title',__('Read more', 'new-blog-jr'))); ?></a>
				<?php } ?>
			</div>
			
		</div>
</article><!-- #post-<?php the_ID(); ?> -->