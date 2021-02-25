<?php

/**
 * new blog CSS Customizer
 *
 * @package new_blog
 *
 */

function new_blog_customize_css() {
    $hex = esc_attr( get_theme_mod( 'new_blog_theme_color', __('#b29700', 'new-blog') ) );
	$percent  = -0.1;
	$final_color = new_blog_color_luminance( $hex, $percent );
    ?>
	<style type="text/css">
    
    /* highlight active menu */
    li.current-menu-item {   
        color: <?php echo esc_attr( $final_color ); ?>  ; 
    }
    
    /* main width */
    .banner-holder .container-fluid {
	width: <?php echo esc_attr( get_theme_mod( 'new_blog_box_width_banner','80' )).'%';?> ;

    }
 
    /* UPPERCASE */
    .category1, .category2, .category3, .category4  {
		text-transform: <?php echo esc_attr( get_theme_mod( 'new_blog_case_'.'Category','uppercase' ));?> ;

    }
    .post-auther-edit-1, .post-auther-edit-2, .post-auther-edit-3, .post-auther-edit-4  {
		text-transform: <?php echo esc_attr( get_theme_mod( 'new_blog_case_'.__('Postdate, Author & Tag','new-blog'),'uppercase' ));?> ;
    }
    .leave-comment  {
		text-transform: <?php echo esc_attr( get_theme_mod( 'new_blog_case_'.__('Leave comment','new-blog'),'uppercase' ));?> ;

    }
    .read-more  {
		text-transform: <?php echo esc_attr( get_theme_mod( 'new_blog_case_'.__('Readmore','new-blog'),'uppercase' ));?> ;

    }
    .widget-title, .most1, .most2, .most3, .most4 {
        text-transform: <?php echo esc_attr( get_theme_mod( 'new_blog_case_'.__('Widget Title','new-blog'),'uppercase' ));?> ;
    }
    #primary-menu {
        text-transform: <?php echo esc_attr( get_theme_mod( 'new_blog_case_'.__('Menu','new-blog'),'uppercase' ));?> ;
    }   
    </style>
<?php }
add_action( 'wp_head', 'new_blog_customize_css' );