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
	<h4> <?php _e('找不到与您的查询相关的信息。', 'khaown'); ?> </h4>
	<p><?php _e('没有与此搜索词相关的页面或帖子。请搜索另一个术语。', 'khaown'); ?> </p>
	<h3><a href="<?php echo esc_url( home_url() ); ?>"><?php _e('返回首页', 'khaown'); ?> </a></h3>
</div>
<!--end of container-->