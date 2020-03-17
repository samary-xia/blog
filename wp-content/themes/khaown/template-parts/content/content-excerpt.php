<?php
/**
 * Template part for displaying post archives and search results
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage khaown
 * @since 1.0.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div  class="row text-left feature bordered bg-color-blog-posts">
		<a id="post-<?php the_ID(); ?>" <?php post_class(); ?> href="<?php the_permalink(); ?>">
			<?php if ( has_post_thumbnail() ) { ?>
				<div class="col-md-4 col-xs-12">
					<div class="blog-posts-image-holder">
						<?php the_post_thumbnail(); ?>
					</div>
				</div>
				<div class="col-md-8 col-xs-12">
					<header>
						<h1 class="mb16 mb-xs-24"><?php the_title(); ?></h1>
					</header>
					<div class="mb40">
						<?php the_excerpt(); ?>
					</div>
				</div>
			<?php } else { ?>
				<div class="col-xs-12">
					<header>
						<h1 class="mb16 mb-xs-24"><?php the_title(); ?></h1>
					</header>
					<div class="mb40">
						<?php the_excerpt(); ?>
					</div>
				</div>
			<?php } ?>
		</a>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
