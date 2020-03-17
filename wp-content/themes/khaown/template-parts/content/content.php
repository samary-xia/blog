<?php
/**
 * Template part for displaying posts
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
						<h1 class=" mb40 mb-xs-24"><?php the_title(); ?></h1>
					</header>
					<div class="mb40">
						<?php
							the_content(
								sprintf(
									wp_kses(
										/* translators: %s: Name of current post. Only visible to screen readers */
										__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'khaown' ),
										array(
											'span' => array(
												'class' => array(),
											),
										)
									),
									get_the_title()
								)
							);

							wp_link_pages(
								array(
									'before' => '<div class="page-links">' . __( 'Pages:', 'khaown' ),
									'after'  => '</div>',
								)
							);
						?>
					</div>
				</div>
			<?php } else { ?>
				<div class="col-xs-12">
					<header>
						<h1 class=" mb40 mb-xs-24"><?php the_title(); ?></h1>
					</header>
					<div class="mb40">
					<?php
						the_content(
							sprintf(
								wp_kses(
									/* translators: %s: Name of current post. Only visible to screen readers */
									__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'khaown' ),
									array(
										'span' => array(
											'class' => array(),
										),
									)
								),
								get_the_title()
							)
						);

						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . __( 'Pages:', 'khaown' ),
								'after'  => '</div>',
							)
						);
						?>
					</div>
				</div>
			<?php } ?>
		</a>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
