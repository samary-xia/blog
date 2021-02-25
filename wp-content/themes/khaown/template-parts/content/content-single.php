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

<header class="khaown-entry-header">
	<?php get_template_part( 'template-parts/header/entry', 'header' ); ?>
</header>
<?php if ( has_post_thumbnail() ) : ?>
	<div class="khaown-single-page-thumbnail mb8">
		<?php the_post_thumbnail(); ?>
	</div>
<?php endif; ?>
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

	$tags = get_tags(); ?>

	<div class="tags">
		<span>Tags: </span>
		<?php foreach ( $tags as $tag ) { ?>
			<a class="khaown-post-tags" href="<?php echo get_tag_link( $tag->term_id ); ?> " rel="tag"><?php echo $tag->name; ?></a>,
		<?php } ?>
	</div> 

	<?php 
	wp_link_pages(
		array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'khaown' ),
			'after'  => '</div>',
		)
	);
?>				