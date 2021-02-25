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
<article id="post-<?php the_ID(); ?>" <?php post_class('mx16 mb16'); ?>>
	<div  class="row text-left feature bordered bg-color-blog-posts khaown-default-post-view">
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="col-md-5 col-xs-12">
				<div class="blog-posts-image-holder mb16">
					<a id="post-<?php the_ID(); ?>" <?php post_class(); ?> href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail(); ?>
					</a>
				</div>
			</div>
			<div class="col-md-7 col-xs-12">
				<a id="post-<?php the_ID(); ?>" <?php post_class(); ?> href="<?php the_permalink(); ?>">
					<header>
						<h1 class="mb16 mb-xs-24">
							<?php the_title(); ?>
						</h1>
					</header>
					<div class="mb16">
						<?php the_excerpt(); ?>
						<a href="<?php the_permalink(); ?>"> <?php  _e('Read Details', 'khaown') ?></a>
					</div>
				</a>
			</div>
		<?php } else { ?>
			<div class="col-xs-12">
				<a id="post-<?php the_ID(); ?>" <?php post_class(); ?> href="<?php the_permalink(); ?>">
					<header>
						<h1 class="mb16 mb-xs-24">
							<?php the_title(); ?>
						</h1>
					</header>
					<div class="mb16">
						<?php the_excerpt(); ?>
						<a href="<?php the_permalink(); ?>"> <?php  _e('Read Details', 'khaown') ?></a>
					</div>
				</a>
			</div>
		<?php } ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
