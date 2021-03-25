<?php
/**
 * Izo Theme Customizer
 *
 * @package Izo
 */

if ( !class_exists( 'Izo_Customizer' ) ) {
	class Izo_Customizer {

		/**
		 * Instance
		 */		
		private static $instance;

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {		
			add_action( 'customize_preview_init', array( $this, 'customize_preview_js' ) );
			add_action( 'customize_register', array( $this, 'customize_register' ) );
			add_action( 'customize_controls_print_footer_scripts', array( $this, 'scripts' ) );
		}

		/**
		 * Options
		 */		
		function customize_register( $wp_customize ) {

			$wp_customize->register_control_type( '\Kirki\Control\sortable' );

			// @codingStandardsIgnoreStart WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
			require get_template_directory() . '/inc/customizer/custom-controls/class_izo_radio_header.php';
			require get_template_directory() . '/inc/customizer/custom-controls/class_izo_radio_images.php';
			require get_template_directory() . '/inc/customizer/custom-controls/slider/class_izo_slider.php';
			require get_template_directory() . '/inc/customizer/custom-controls/class_izo_title.php';
			require get_template_directory() . '/inc/customizer/custom-controls/class_izo_info.php';
			require get_template_directory() . '/inc/customizer/custom-controls/alpha-color/class_izo_alpha_color.php';
			require get_template_directory() . '/inc/customizer/custom-controls/responsive-number/class_izo_responsive_number.php';
			require get_template_directory() . '/inc/customizer/custom-controls/class_izo_toggle.php';
			require get_template_directory() . '/inc/customizer/custom-controls/typography/class_izo_typography.php';
			require get_template_directory() . '/inc/customizer/custom-controls/repeater/class_izo_repeater.php';
			// @codingStandardsIgnoreEnd WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

			$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
			$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
			$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
			$wp_customize->get_section( 'title_tagline' )->panel 		= 'izo_header_panel';
			$wp_customize->get_section( 'title_tagline' )->priority 	= 1;
			$wp_customize->get_section( 'background_image' )->panel 	= 'izo_general_panel';
			$wp_customize->get_section( 'header_image' )->panel 		= 'izo_header_panel';
			$wp_customize->get_section( 'colors' )->panel 				= 'izo_general_panel';
			if ( class_exists( 'WooCommerce') ) {
				$wp_customize->get_panel( 'woocommerce' )->priority 	= 31;
			}

			if ( isset( $wp_customize->selective_refresh ) ) {
				$wp_customize->selective_refresh->add_partial(
					'blogname',
					array(
						'selector'        => '.site-title a',
						'render_callback' => 'izo_customize_partial_blogname',
					)
				);
				$wp_customize->selective_refresh->add_partial(
					'blogdescription',
					array(
						'selector'        => '.site-description',
						'render_callback' => 'izo_customize_partial_blogdescription',
					)
				);
			}

			// @codingStandardsIgnoreStart WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
			//Sanitize functions
			require get_template_directory() . '/inc/customizer/sanitize.php';

			//General options
			require get_template_directory() . '/inc/customizer/general.php';			

			//Blog options
			require get_template_directory() . '/inc/customizer/blog.php';

			//Header options
			require get_template_directory() . '/inc/customizer/header.php';

			//Sidebar options
			require get_template_directory() . '/inc/customizer/sidebar.php';	

			//Footer options
			require get_template_directory() . '/inc/customizer/footer.php';
			
			//Shop options
			if ( class_exists( 'WooCommerce' ) ) {
				require get_template_directory() . '/inc/customizer/shop.php';
			}

			//Page options
			require get_template_directory() . '/inc/customizer/pages.php';				

			//Typography options
			require get_template_directory() . '/inc/customizer/typography.php';
			// @codingStandardsIgnoreEnd WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound			
		}

		public function customize_preview_js() {
			wp_enqueue_script( 'izo-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'jquery', 'customize-preview' ), IZO_VERSION, true );
		}		

		function scripts() {
			wp_enqueue_script( 'izo-customizer-scripts', get_template_directory_uri() . '/assets/js/customizer-scripts.min.js', array( 'jquery', 'jquery-ui-core' ), '20201211', true );

			$strings = array(
				'generalDesc' => esc_html__( 'Colors, fonts etc.', 'izo' ),
			);

			wp_localize_script( 'izo-customizer-scripts', 'izoCustomizer', $strings );

			wp_enqueue_style( 'izo-customizer-styles', get_template_directory_uri() . '/assets/css/customizer.min.css' );
		}
		
	}
}

//Initiate
Izo_Customizer::get_instance();

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function izo_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function izo_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Sanitize text
 */
function izo_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}
