<?php
/**
 * khaown functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage khaown
 * @since 1.0.0
 */

/**
 * khaown only works in WordPress 4.7 or later.
 */
define( 'KHAOWN_THEME_DIR', trailingslashit( get_template_directory() ) );


if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

if ( ! function_exists( 'khaown_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function khaown_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on khaown, use a find and replace
		 * to change 'khaown' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'khaown', get_template_directory() . '/languages' );

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
		set_post_thumbnail_size( 1568, 9999 );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-1' => __( 'Primary', 'khaown' ),
				'footer' => __( 'Footer Menu', 'khaown' ),
				'social' => __( 'Social Links Menu', 'khaown' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 130,
				'width'       => 390,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

		// Add custom editor font sizes.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => __( 'Small', 'khaown' ),
					'shortName' => __( 'S', 'khaown' ),
					'size'      => 19.5,
					'slug'      => 'small',
				),
				array(
					'name'      => __( 'Normal', 'khaown' ),
					'shortName' => __( 'M', 'khaown' ),
					'size'      => 22,
					'slug'      => 'normal',
				),
				array(
					'name'      => __( 'Large', 'khaown' ),
					'shortName' => __( 'L', 'khaown' ),
					'size'      => 36.5,
					'slug'      => 'large',
				),
				array(
					'name'      => __( 'Huge', 'khaown' ),
					'shortName' => __( 'XL', 'khaown' ),
					'size'      => 49.5,
					'slug'      => 'huge',
				),
			)
		);

		// Editor color palette.
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Primary', 'khaown' ),
					'slug'  => 'primary',
					'color' => khaown_hsl_hex( 'default' === get_theme_mod( 'primary_color' ) ? 199 : get_theme_mod( 'primary_color_hue', 199 ), 100, 33 ),
				),
				array(
					'name'  => __( 'Secondary', 'khaown' ),
					'slug'  => 'secondary',
					'color' => khaown_hsl_hex( 'default' === get_theme_mod( 'primary_color' ) ? 199 : get_theme_mod( 'primary_color_hue', 199 ), 100, 23 ),
				),
				array(
					'name'  => __( 'Dark Gray', 'khaown' ),
					'slug'  => 'dark-gray',
					'color' => '#111',
				),
				array(
					'name'  => __( 'Light Gray', 'khaown' ),
					'slug'  => 'light-gray',
					'color' => '#767676',
				),
				array(
					'name'  => __( 'White', 'khaown' ),
					'slug'  => 'white',
					'color' => '#FFF',
				),
			)
		);

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );
	}
endif;
add_action( 'after_setup_theme', 'khaown_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function khaown_widgets_init() {

	register_sidebar(
		array(
			'name'          => __( 'Left Sidebar', 'khaown' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your sidebar.', 'khaown' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Right Sidebar', 'khaown' ),
			'id'            => 'sidebar-2',
			'description'   => __( 'Add widgets here to appear in your sidebar.', 'khaown' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);


}
add_action( 'widgets_init', 'khaown_widgets_init' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width Content width.
 */
function khaown_content_width() {
	// This variable is intended to be overruled from themes.
	$GLOBALS['content_width'] = apply_filters( 'khaown_content_width', 640 );
}
add_action( 'after_setup_theme', 'khaown_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function khaown_scripts() {
	wp_enqueue_style( 'khaown-bootstrap-style', get_template_directory_uri() . '/bootstrap-v3.3.5.css', array(), wp_get_theme()->get( 'Version' ), 'all' );
	wp_enqueue_style( 'khaown-themify-icons', get_template_directory_uri() . '/themify-icons.css', array(), wp_get_theme()->get( 'Version' ), 'all' );
	wp_enqueue_style( 'khaown-font', "https://fonts.googleapis.com/css?family=Rajdhani:300,400,500,600,700&display=swap", array(), wp_get_theme()->get( 'Version' ) );
	wp_enqueue_style( 'khaown-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
	wp_enqueue_style( 'khaown-zhidinyi', get_template_directory_uri() . '/css/style.css', array(), wp_get_theme()->get( 'Version' ), 'all' ); //自己加的
	wp_style_add_data( 'khaown-style', 'rtl', 'replace' );

	wp_enqueue_script("jquery");
	wp_enqueue_script( 'khaown-bootstrap-js', get_theme_file_uri( '/js/bootstrap.min.js' ), array(), '1.1', true );
	wp_enqueue_script( 'khaown-scripts', get_theme_file_uri( '/js/scripts.js' ), array(), '1.1', true );
	wp_enqueue_script( 'khaown-yinyon', get_theme_file_uri( '/js/buann.js' ), array(), '1.1', true );//自己加的
	wp_enqueue_style( 'khaown-print-style', get_template_directory_uri() . '/print.css', array(), wp_get_theme()->get( 'Version' ), 'print' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'khaown_scripts' );

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function khaown_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'khaown_skip_link_focus_fix' );

/**
 * Display custom color CSS in customizer and on frontend.
 */
function khaown_customizer_css_wrap() {

	require_once get_parent_theme_file_path( '/inc/customizer-styles.php' ); ?>

<style type="text/css" id="custom-theme-colors" >
	<?php echo khaown_customizer_css(); ?> 
</style> 
 	<?php
}
add_action( 'wp_head', 'khaown_customizer_css_wrap' );



// Dropdown Menu - Navigation Menu
class khaown_Menu_Maker_Walker extends Walker {
	var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

	function start_lvl( &$output, $depth = 0, $args = array() ) {  
		$indent = str_repeat("\t", $depth);  
		$output .= "\n$indent<ul>\n";  
	}  

	function end_lvl( &$output, $depth = 0, $args = array() ) {  
		$indent = str_repeat("\t", $depth);  
		$output .= "$indent</ul>\n";  
	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		global $wp_query;  
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';  
		$class_names = $value = '';          
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;  

		/* Add active class */  
		if(in_array('current-menu-item', $classes)) { 
			$classes[] = 'active';  
			unset($classes['current-menu-item']);  
		}

		/* Check for children */

		$children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));  
		if (!empty($children)) {  
			$classes[] = 'has-sub';  
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );  
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );  
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : ''; 
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';  
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output = $args->before; 
		$item_output .= '<a'. $attributes .'><span>';  
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;  
		$item_output .= '</span></a>';  
		$item_output .= $args->after;  
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );  
	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {  
		$output .= "</li>\n";  
	}
}


/**
 * SVG Icons class.
 */
require get_template_directory() . '/classes/class-khaown-svg-icons.php';

/**
 * Custom Comment Walker template.
 */
require get_template_directory() . '/classes/class-khaown-walker-comment.php';

/**
 * Enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * SVG Icons related functions.
 */
require get_template_directory() . '/inc/icon-functions.php';

/**
 * Custom template tags for the theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

