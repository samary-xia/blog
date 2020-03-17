<?php
/**
 * The template for displaying Current Discussion on posts
 *
 * @package WordPress
 * @subpackage khaown
 * @since 1.0.0
 */

/* Get data from current discussion on post. */
$discussion    = khaown_get_discussion_data();
$has_responses = $discussion->responses > 0;

if ( $has_responses ) {
	/* translators: %1(X comments)$s */
	$meta_label = sprintf( _n( '%d Comment', '%d Comments', $discussion->responses, 'khaown' ), $discussion->responses );
} else {
	$meta_label = __( 'No comments', 'khaown' );
}
?>

<h2 class="discussion-meta">
	<?php
	if ( $has_responses ) {
		khaown_discussion_avatars_list( $discussion->authors );
	}
	?>
	<div class="discussion-meta-info">
		<i class="ti ti-comments"></i>
		<?php echo esc_html( $meta_label ); ?>
</h2>

