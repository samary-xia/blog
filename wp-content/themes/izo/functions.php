<?php
/**
 * Izo functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Izo
 */

if ( ! defined( 'IZO_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'IZO_VERSION', '1.0.0' );
}

if ( ! function_exists( 'izo_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function izo_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Izo, use a find and replace
		 * to change 'izo' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'izo', get_template_directory() . '/languages' );

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
		
		add_image_size( 'izo-750x9999', 750, 9999 );
		add_image_size( 'izo-400x400', 400, 400, true );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'primary-menu' 	=> esc_html__( 'Primary navigation', 'izo' ),
				'top-menu' 		=> esc_html__( 'Top navigation (secondary, hidden on mobiles)', 'izo' ),
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
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'izo_custom_background_args',
				array(
					'default-color' => 'f0f3f5',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		/**
		 * Wide alignments
		 *
		 */		
		add_theme_support( 'align-wide' );

	}
endif;
add_action( 'after_setup_theme', 'izo_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function izo_content_width() {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    // phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'izo_content_width', 1140 );
}
add_action( 'after_setup_theme', 'izo_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function izo_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'izo' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'izo' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'izo_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function izo_scripts() {

	wp_enqueue_style( 'izo-fonts', izo_generate_fonts_url(), array(), IZO_VERSION );

	wp_enqueue_style( 'izo-style', get_stylesheet_uri(), array(), IZO_VERSION );

	wp_enqueue_style( 'izo-style-min', get_template_directory_uri() . '/assets/css/styles.min.css', array(), IZO_VERSION );

	if ( !izo_is_amp() ) {
		wp_enqueue_script( 'izo-functions', get_template_directory_uri() . '/assets/js/functions.min.js', array(), IZO_VERSION, true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'izo_scripts' );

/**
 * Gutenberg assets
 */
function izo_block_editor_styles() {
    // Enqueue the editor styles.
    wp_enqueue_style( 'izo-block-editor-styles', get_template_directory_uri() . '/assets/css/editor-styles.min.css','','20200120','');
}
add_action( 'enqueue_block_editor_assets', 'izo_block_editor_styles' );


/**
 * Disable Elementor default schemes
 */
function izo_set_elementor_defaults() {
	update_option( 'elementor_disable_color_schemes', 'yes' );
	update_option( 'elementor_disable_typography_schemes', 'yes' );
	update_option( 'elementor_container_width', 1170 );
}
add_action( 'after_switch_theme', 'izo_set_elementor_defaults' );

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
require get_template_directory() . '/inc/customizer/callbacks.php';

/**
 * Posts functions.
 */
require get_template_directory() . '/inc/posts/class_izo_loop_post.php';

/**
 * Single posts and pages
 */
require get_template_directory() . '/inc/class_izo_single_post_page.php';

/**
 * Header functions.
 */
require get_template_directory() . '/inc/class_izo_header.php';

/**
 * Footer functions.
 */
require get_template_directory() . '/inc/class_izo_footer.php';

/**
 * Custom CSS output
 */
require get_template_directory() . '/inc/class_izo_custom_css.php';

/**
 * SVG icons.
 */
require get_template_directory() . '/inc/class_izo_svg_icons.php';

/**
 * Single page options
 */
require get_template_directory() . '/inc/class_izo_page_metabox.php';

/**
 * Breadcrumbs
 */
require get_template_directory() . '/inc/class_izo_breadcrumbs.php';

/**
 * Gutenberg custom styles
 */
require get_template_directory() . '/inc/editor-styles.php';

/**
 * Load compatibility files.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
if ( class_exists( 'Elementor\Plugin' ) ) {
	require get_template_directory() . '/inc/compatibility/elementor/class_izo_elementor.php';
}
if ( class_exists( 'LifterLMS' ) ) {
	require get_template_directory() . '/inc/compatibility/lifterlms/class-izo-lifterlms.php';
}
if ( class_exists( 'Header_Footer_Elementor' ) ) {
	require get_template_directory() . '/inc/compatibility/class-izo-hfe.php';
}
require get_template_directory() . '/inc/compatibility/class-izo-amp.php';

/**
 * Onboarding
 */
require get_template_directory() . '/inc/onboarding/class_izo_install_plugins.php';
require get_template_directory() . '/inc/onboarding/class_izo_theme_page.php';

/**
 * Admin notice
 */
require get_template_directory() . '/inc/onboarding/notices/persist-admin-notices-dismissal.php';

function izo_welcome_admin_notice() {

	if ( ! PAnD::is_admin_notice_active( 'izo-welcome-forever' ) ) {
		return;
	}

	$theme = wp_get_theme();
	
	?>
	<div data-dismissible="izo-welcome-forever" class="izo-admin-notice notice notice-info is-dismissible">

		<h3><?php echo esc_html( /* translators: %s: theme name */ sprintf( __( 'Welcome to %s', 'izo' ), $theme->name ) ); ?><span class="theme-version"><?php echo esc_html( $theme->version ); ?></span></h3>
		<p style="margin-bottom:20px;"><?php echo esc_html__( 'Click the button below to install our starter site plugin and import premade demos.', 'izo' ); ?></p>
		<?php Izo_Install_Plugins::instance()->do_plugin_install(); ?>
		<a class="button" href="<?php echo esc_url( admin_url( 'themes.php?page=izo-theme.php' ) ); ?>"><?php esc_html_e( 'Theme Dashboard', 'izo' ); ?></a>

	</div>
	<?php
}
add_action( 'admin_init', array( 'PAnD', 'init' ) );
add_action( 'admin_notices', 'izo_welcome_admin_notice' );

/**
 * Autoloader
 */
require_once get_parent_theme_file_path( 'vendor/autoload.php' );