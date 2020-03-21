<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage khaown
 * @since 1.0.0
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
 
	<?php wp_head(); ?>
	<script>
		var _hmt = _hmt || [];
		(function () {
			var hm = document.createElement("script");
			hm.src = "https://hm.baidu.com/hm.js?03ad23c5787fb9154e2b990ff2a24bd0";
			var s = document.getElementsByTagName("script")[0];
			s.parentNode.insertBefore(hm, s);
		})();
	</script>

</head>

<body <?php body_class( "scroll-assist custom-background" ); ?>>
	<script>
    (function(){
        var bp = document.createElement('script');
        var curProtocol = window.location.protocol.split(':')[0];
        if (curProtocol === 'https') {
            bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
        }
        else {
            bp.src = 'http://push.zhanzhang.baidu.com/push.js';
        }
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(bp, s);
    })();
</script>
	<?php do_action( 'wp_body_open' ); ?>
	<header class="nav-container">
		<a id="top"></a>
		<nav class="absolute" aria-label="<?php esc_attr_e( 'Top Menu', 'khaown' ); ?>">
			<div class="nav-bar">

				<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
				<!-- .site-branding-container -->

				<?php get_template_part( 'template-parts/header/sitenav', 'main' ); ?>
				<!-- .entry-header -->

			</div>
		</nav>
	</header>

	<a class="skip-link screen-reader-text" href="#content" tabindex="2"> <?php _e('Skip to content', 'khaown'); ?></a>
	<div id="content" class="main-container nav-margin-space">
<?php
if ( function_exists('yoast_breadcrumb') ) {
    //面包屑导航
    yoast_breadcrumb( '<p id="breadcrumbs" class="container">','</p>' );
}
?>