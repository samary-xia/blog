<?php
/**
 * Class to handle Elementor compatibility
 * 
 * Some things based on Astra
 *
 * @package Izo
 */


if ( !class_exists( 'Izo_Elementor' ) ) :

	/**
	 * Izo_Elementor 
	 */
	Class Izo_Elementor {

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
			add_action( 'elementor/preview/init', array( $this, 'set_page_defaults' ) );
			add_action( 'elementor/widgets/widgets_registered', array( $this, 'elementor_widgets' ) );
			add_action( 'elementor/elements/categories_registered', array( $this, 'widgets_category' ) );
			add_action( 'wp', array( $this, 'convert_pages' ) );

			if ( class_exists( 'ElementorPro\Modules\ThemeBuilder\Module' ) ) {
				add_action( 'elementor/theme/register_locations', array( $this, 'register_locations' ) );
			}

		}

		/**
		 * Set page defaults to obtain a full editing area
		 */
		public function set_page_defaults() {

			if ( 'page' !== get_post_type() || !$this->is_elementor_editor() ) {
				return;
			}

			global $post;
			$id = $post->ID;

			$already_set = get_post_meta( $id, '_izo_updated_meta_settings_flag', true );

			if ( isset( $post ) && empty( $already_set ) && ( is_admin() || is_singular() ) ) {
				if ( empty( $post->post_content ) && $this->with_elementor( $id ) ) {
					
					update_post_meta( $id, '_izo_updated_meta_settings_flag', true );
					update_post_meta( $id, '_izo_hide_title', '1' );
					update_post_meta( $id, '_izo_hide_featured_image', '1' );

					$content_layout = get_post_meta( $id, '_izo_page_layout', true );
					if ( empty( $content_layout ) || 'customizer' == $content_layout ) {
						update_post_meta( $id, '_izo_page_layout', 'layout-stretched' );
					}

					$sidebar_layout = get_post_meta( $id, '_izo_sidebar_layout', true );
					if ( empty( $sidebar_layout ) || 'customizer' == $sidebar_layout ) {
						update_post_meta( $id, '_izo_sidebar_layout', 'no-sidebar' );
					}

					add_filter( 'izo_enable_sidebar', '__return_false' );
				}
			}
		}

		/**
		 * Setup Elementor pages built with other themes
		 */
		public function convert_pages() {
			if ( 'page' !== get_post_type() ) {
				return;
			}		
			
			global $post;
			$id = $post->ID;

			$already_set = get_post_meta( $id, '_izo_converted_meta_settings_flag', true );

			if ( isset( $post ) && empty( $already_set ) && ( is_admin() || is_page() ) ) {
				if ( $this->with_elementor( $id ) ) {
					
					update_post_meta( $id, '_izo_converted_meta_settings_flag', true );
					update_post_meta( $id, '_izo_hide_title', '1' );
					update_post_meta( $id, '_izo_hide_featured_image', '1' );

					$content_layout = get_post_meta( $id, '_izo_page_layout', true );
					if ( empty( $content_layout ) || 'customizer' == $content_layout ) {
						update_post_meta( $id, '_izo_page_layout', 'layout-stretched' );
					}

					$sidebar_layout = get_post_meta( $id, '_izo_sidebar_layout', true );
					if ( empty( $sidebar_layout ) || 'customizer' == $sidebar_layout ) {
						update_post_meta( $id, '_izo_sidebar_layout', 'no-sidebar' );
					}
				}
			}			
		}

		/**
		 * Check is the page is built with Elementor
		 */
		public function with_elementor( $id ) {
			return Elementor\Plugin::$instance->db->is_built_with_elementor( $id );
		}

		/**
		 * Check if Elementor Editor is open.
		 */
		private function is_elementor_editor() {
			if ( ( isset( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] ) || isset( $_REQUEST['elementor-preview'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				return true;
			}

			return false;
		}	
		
		/**
		 * Load extra Elementor widgets
		 */
		public function elementor_widgets() {
			require get_template_directory() . '/inc/compatibility/elementor/blocks/block-blog.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
		}

		/**
		 * Custom widgets category
		 */
		public function widgets_category() {
	
			Elementor\Plugin::$instance->elements_manager->add_category( 
				'izo-elements',
				[
					'title' => __( 'Izo Elements', 'izo' ),
					'icon' => 'fa fa-plug',
				],
				1
			);		
		}	
		
		/**
		 * Register Elementor Pro supported locations
		 */
		public function register_locations( $elementor_theme_manager ) {
			$elementor_theme_manager->register_location( 'header' );
			$elementor_theme_manager->register_location( 'footer' );
		}
	}

	/**
	 * Initialize class
	 */
	Izo_Elementor::get_instance();

endif;