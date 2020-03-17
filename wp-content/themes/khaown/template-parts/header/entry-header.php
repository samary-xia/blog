<?php
/**
 * Displays the post header
 *
 * @package WordPress
 * @subpackage khaown
 * @since 1.0.0
 */

$discussion = ! is_page() && khaown_can_show_post_thumbnail() ? khaown_get_discussion_data() : null; ?>

<?php the_title( '<h1 class="khaown-entry-title">', '</h1>' ); ?>

<?php if ( ! is_page() ) : ?>
<div class="entry-meta">
	<?php khaown_posted_by(); ?>
	<?php khaown_posted_on(); ?>
	<span class="comment-count">
		<?php
		if ( ! empty( $discussion ) ) {
			khaown_discussion_avatars_list( $discussion->authors );
		}
		?>
		<?php khaown_comment_count(); ?>
	</span>
	<?php
	// Edit post link.
		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers. */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'khaown' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">' . khaown_get_icon_svg( 'edit', 16 ),
			'</span>'
		);
	?>
</div><!-- .entry-meta -->
<?php endif; ?>
