<?php
/**
 * Class to handle Header Footer Elementor compatibility
 *
 * @package Izo
 */


if ( !class_exists( 'Izo_HFE' ) ) :

	/**
	 * Izo_HFE 
	 */
	Class Izo_HFE {

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
			add_action( 'after_setup_theme', array( $this, 'theme_support' ) );
			add_action( 'izo_header', array( $this, 'render_header' ), 9 );
			add_action( 'izo_footer', array( $this, 'render_footer' ), 9 );
		}

		/**
		 * Theme support for HFE features
		 */
		public function theme_support() {
			add_theme_support( 'header-footer-elementor' );
		}

		/**
		 * Remove default header and render HFE header
		 */
		public function render_header() {
			if ( !function_exists( 'hfe_header_enabled' ) || !hfe_header_enabled() ) {
				return;
			}

			hfe_render_header();

			remove_action( 'izo_header', array(  Izo_Header::get_instance(), 'header_markup' ) );

		}

		/**
		 * Remove default footer and render HFE footer
		 */
		public function render_footer() {
			if ( !function_exists( 'hfe_footer_enabled' ) || !hfe_footer_enabled() ) {
				return;
			}

			hfe_render_footer();

			remove_action( 'izo_footer', array(  Izo_Footer::get_instance(), 'footer_markup' ) );

		}		

	}

	/**
	 * Initialize class
	 */
	Izo_HFE::get_instance();

endif;