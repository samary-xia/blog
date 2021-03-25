<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Izo
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php 
		do_action( 'izo_post_item_before' );

		do_action( 'izo_post_item_content' );
		
		do_action( 'izo_post_item_after' );
	?>

</article><!-- #post-<?php the_ID(); ?> -->
