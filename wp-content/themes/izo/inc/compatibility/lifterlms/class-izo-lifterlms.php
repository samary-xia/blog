<?php
/**
 * Class to handle LifterLMS compatibility
 *
 * @package Izo
 */


if ( !class_exists( 'Izo_LifterLMS' ) ) :

	/**
	 * Izo_LifterLMS 
	 */
	Class Izo_LifterLMS {

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

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

			add_action( 'after_setup_theme', array( $this, 'theme_support' ) );
			add_filter( 'llms_get_theme_default_sidebar', array( $this, 'return_sidebar' ) );
			add_action( 'wp', array( $this, 'remove_sidebar' ) );	
			add_action( 'wp', array( $this, 'checkout_layout' ) );	
			add_filter( 'izo_custom_css_output', array( $this, 'dynamic_css' ) );

			//Wrappers
			remove_action( 'lifterlms_before_main_content', 'lifterlms_output_content_wrapper', 10 );
			remove_action( 'lifterlms_after_main_content', 'lifterlms_output_content_wrapper_end', 10 );
			add_action( 'lifterlms_before_main_content', array( $this, 'catalog_wrapper_start' ), 10 );
			add_action( 'lifterlms_after_main_content', array( $this, 'catalog_wrapper_end' ), 10 );

		}

		/**
		 * Theme support for LifterLMS features
		 */
		public function theme_support() {
			add_theme_support( 'lifterlms' );
			add_theme_support( 'lifterlms-quizzes' );
			add_theme_support( 'lifterlms-sidebars' );
		}

		/**
		 * Return the sidebar
		 */
		public function return_sidebar( $id ) {

			$sidebar = 'sidebar-1';
		
			return $sidebar;
		}

		/**
		 * Remove sidebar on archives and special pages
		 */
		public function remove_sidebar() {

			if ( !is_post_type_archive( 'course' ) && !is_post_type_archive( 'llms_membership' ) && !is_membership() && !is_llms_checkout() && !is_llms_account_page() ) {
				return;
			}

			remove_action( 'lifterlms_sidebar', 'lifterlms_get_sidebar' );
			add_filter( 'izo_enable_sidebar', '__return_false' );
			add_filter( 'izo_has_sidebar', '__return_false' );
		}

		/**
		 * Wrapper start
		 */
		public function catalog_wrapper_start() {
			echo '<main id="primary" class="site-main">';
		}

		/**
		 * Wrapper end
		 */
		public function catalog_wrapper_end() {
			echo '</main>';
		}	
		
		/**
		 * Enqueue custom Lifter styles
		 */
		public function enqueue() {
			wp_enqueue_style( 'izo-lifter-css', get_template_directory_uri() . '/inc/compatibility/lifterlms/styles.css' );
		}		

		/**
		 * Set checkout page to unboxed layout
		 */
		public function checkout_layout() {

			global $post;
			if ( !isset( $post ) ) {
				return;
			}

			$id = $post->ID;

			$already_set = get_post_meta( $id, '_izo_unboxed_meta_settings_flag', true );

			if ( is_llms_checkout() && isset( $post ) && empty( $already_set ) ) {
				update_post_meta( $id, '_izo_page_layout', 'layout-unboxed' );
				update_post_meta( $id, '_izo_unboxed_meta_settings_flag', true );
			}

		}

		/**
		 * Dynamic CSS
		 */
		public function dynamic_css( $css ) {
			$css .= Izo_Custom_CSS::get_background_color_css( 'global_button_background', '#ea285e', '.llms-button-action');
			$css .= Izo_Custom_CSS::get_background_color_css( 'global_button_background_hover', '#b6113f', '.llms-button-action:focus, .llms-button-action:active,.llms-button-action:hover, .llms-button-action.clicked');

			return $css;

		}

	}

	/**
	 * Initialize class
	 */
	Izo_LifterLMS::get_instance();

endif;