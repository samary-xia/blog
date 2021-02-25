<?php
/**
 * new blog functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package new_blog
 */

if ( ! function_exists( 'new_blog_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function new_blog_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on new blog, use a find and replace
		 * to change 'new-blog' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'new-blog');

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size('new-blog-feature-display-thumbnail', 600, 290, array( 'center','center'));
		add_image_size('new-blog-blog-display-thumbnail', 700, 485, array( 'center','center'));
		add_image_size('new-blog-blog-1colume-thumbnail', 750, 350, array( 'center','center'));
		add_image_size('new-blog-banner-thumbnail', 1440, 600, array( 'center','center'));
		add_image_size('new-blog-footer-thumbnail', 240, 200, array( 'center','center'));
		add_image_size('new-blog-sidebar-thumbnail', 450, 401, array( 'center','center'));
		add_image_size('new-blog-sidebar-latestpost-thumbnail', 90, 80, array( 'center','center'));
		add_image_size('new-blog-155-125', 155, 125,true);

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'new-blog' ),
			'menu-2' => esc_html__( 'Sidemenu', 'new-blog' ),
		) );
		/**
		 * Configure for max number of Tag display
		 */
		add_filter('term_links-post_tag','new_blog_limit_to_five_tags');
		function new_blog_limit_to_five_tags($terms) {
		return array_slice($terms,0,5,true);
		}
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'new_blog_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 25,
			'width'       => 25,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-slider' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'responsive-embeds' );

	}
endif;
add_action( 'after_setup_theme', 'new_blog_setup' );

/**
 * Change the excerpt more string
 */

function new_blog_custom_excerpt_length( $length ) {
	if ( is_admin() ) {
		return $length;
	}
	return 22;
}
add_filter( 'excerpt_length', 'new_blog_custom_excerpt_length', 999 );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function new_blog_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'new_blog_content_width', 640 );
}
add_action( 'after_setup_theme', 'new_blog_content_width', 0 );

function new_blog_comment($comment, $args, $depth) {
        $tag       = 'div';
        $add_below = 'comment';
   ?>
	<div class="media">
			<?php 
			if ( $args['avatar_size'] != 0 ) {
			?><div class="img-holder mr-4">
				<?php echo get_avatar( $comment, 100 ); ?>
			</div>
			<?php } ?>

			<div class="media-body">
				<div class="title-reply">
					<?php /* translators: %s: author */
					printf( __( '<cite class="fn mr-auto">%s</cite>','new-blog' ), get_comment_author_link() ); ?>
					<span class="reply fa fa-reply" aria-hidden="true"><?php 
					comment_reply_link( 
						array_merge( 
							$args, 
							array( 
								'add_below' => $add_below, 
								'depth'     => $depth, 
								'max_depth' => $args['max_depth'],

							) 
						) 
					); ?>
					</span> 
				</div>

				<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"><?php
				/* translators: 1: date, 2: time */
				printf( __('%1$s at %2$s','new-blog'), get_comment_date(),  get_comment_time() ); ?>
				</a><?php 
				edit_comment_link( __( '(Edit)','new-blog' ), '  ', '' ); ?>
				<br/>
				
				<?php comment_text(); ?>
			</div>
			<?php 
			if ( $comment->comment_approved == '0' ) { ?>
				<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.','new-blog' ); ?></em><br/><?php 
			} ?>
			
	</div> 
	<br/>
	<br/>
	<?php
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function new_blog_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar one', 'new-blog' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'new-blog' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s categories block">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class ="side-title" > <h4 class="widget-title ">',
		'after_title'   => '</h4></div>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar one', 'new-blog' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here.', 'new-blog' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s categories block">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class ="side-title" > <h4 class="widget-title ">',
		'after_title'   => '</h4></div>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar two', 'new-blog' ),
		'id'            => 'sidebar-3',
		'description'   => esc_html__( 'Add widgets here.', 'new-blog' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s categories block">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class ="side-title" > <h4 class="widget-title ">',
		'after_title'   => '</h4></div>',
	) );
}
add_action( 'widgets_init', 'new_blog_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function new_blog_scripts() {
	wp_enqueue_style( 'kenwheeler-slicktheme', get_template_directory_uri() . '/css/slick-theme.css', array(), '1.9.0', 'all' );

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '4.1.1', 'all' );
	wp_enqueue_style( 'new-blog-style', get_stylesheet_uri() );
	wp_enqueue_style( 'kenwheeler-slick', get_template_directory_uri() . '/css/slick.css', array(), '1.9.0', 'all' );
	wp_enqueue_style( 'new-blog-sidenav', get_template_directory_uri() . '/css/sidenav.css', array(), '1.0.0', 'all' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '1.9.0', 'all' );
	wp_enqueue_style( 'google-webfonts', '//fonts.googleapis.com/css?family=Kaushan+Script|Poppins|Muli', array(), NULL);
	
	wp_enqueue_script( 'navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.js', array(), '20151215', true );

	wp_enqueue_script( 'smartmenu-js', get_template_directory_uri() . '/js/jquery.smartmenus.js', array(), '20151215', true );

	wp_enqueue_script( 'smartmenu-bootstrap-js', get_template_directory_uri() . '/js/jquery.smartmenus.bootstrap-4.js', array(), '20151215', true );

	wp_enqueue_script( 'kenwheeler-slick-js', get_template_directory_uri() . '/js/slick.js', array(), '1.9.0', true );

	wp_enqueue_script( 'new-blog-sidenav-js', get_template_directory_uri() . '/js/sidenav.js', array(), '20181201', true );

	wp_enqueue_script( 'new-blog-js', get_template_directory_uri() . '/js/new-blog.js', array(), '20181201', true );

	wp_enqueue_script( 'scroll-js', get_template_directory_uri() . '/js/jquery.scrollUp.js', array(), '20181201', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	if ( is_single() || is_archive() || ! is_front_page())  {
		wp_enqueue_script( 'new-blog-scroll-js', get_template_directory_uri() . '/js/new-blog-scroll.js', array(), '20181201', true );
		
	}
	wp_enqueue_script( 'jquery');
}
add_action( 'wp_enqueue_scripts', 'new_blog_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Customizer-color-css additions.
 */
require get_template_directory() . '/inc/css/css-customize.php';

/**
 * menu-color-highlight additions.
 */
require get_template_directory() . '/inc/css/color-luminance.php';

/**
 * Load walker.
 */

require get_template_directory() . '/inc/class-wp-bootsrtrap-navwalker.php';

/**
 *  load sanitize.
 */
require_once( trailingslashit( get_template_directory() ) . 'inc/sanitize.php' );

/**
 *  load Go to Pro.
 */
require_once trailingslashit( get_template_directory() ) . '/inc/upgrade-to-pro/control.php';


/**
 * This function adds some styles to the WordPress Customizer
 */
function new_blog_customizer_styles() { ?>
	<style>
		#customize-control-new_blog_sidebar_enable,
		#customize-control-new_blog_sidebar_about_enable,
		#customize-control-new_blog_sidebar_slider_enable,
		#customize-control-new_blog_sidebar_post_enable,
		#customize-control-new_blog_sidebar_quote_enable,
		#customize-control-new_blog_single_page_author_title label,
		#customize-control-new_blog_related_post_title label {
			border-bottom: 2px solid #000000;
			font-weight: 900;
		}
		
	</style>
	<?php

}
add_action( 'customize_controls_print_styles', 'new_blog_customizer_styles', 999 );


function new_blog_add_class_to_excerpt( $excerpt ) {
    return str_replace('<p', '<p class="text-justify"', $excerpt);
}
add_filter( "the_excerpt", "new_blog_add_class_to_excerpt" );

/* Word read count Pagination */
if (!function_exists('new_blog_count_content_words')) :
    /**
     * @param $content
     *
     * @return string
     */
    function new_blog_count_content_words($post_id)
    {
            $content = apply_filters('the_content', get_post_field('post_content', $post_id));
            $read_words = get_theme_mod('global_show_min_read_number','150');
            $decode_content = html_entity_decode($content);
            $filter_shortcode = do_shortcode($decode_content);
            $strip_tags = wp_strip_all_tags($filter_shortcode, true);
            $count = str_word_count($strip_tags);
            $word_per_min = (absint($count) / $read_words);
            $word_per_min = ceil($word_per_min);

           if ( absint($word_per_min) > 0) {
                $word_count_strings = sprintf(_n('%s min', '%s min', number_format_i18n($word_per_min),'new-blog'), number_format_i18n($word_per_min));
                if ('post' == get_post_type($post_id)):
                    echo '<span class="date"><a><i class="fa fa-book"></i><span class="pl-1"> ';
                    echo esc_html($word_count_strings);
                    echo '</span></a></span>';
                endif;
            }
    }
endif;

/* Function which displays your post date in time ago format */
function new_blog_time_ago() {
	echo human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) );
}