<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage khaown
 * @since 1.0.0
 */

?>

<div class="text-left">
	<h4> <?php _e('Nothing found related to your query.', 'khaown'); ?> </h4>
	<p><?php _e('There is no page or post related to this search term. Please search with another term. ', 'khaown'); ?> </p>
	<h3><a href="<?php echo esc_url( home_url() ); ?>"><?php _e('Go to Homepage', 'khaown'); ?> </a></h3>
</div>
<!--end of container-->