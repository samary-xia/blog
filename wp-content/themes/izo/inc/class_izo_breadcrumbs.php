<?php
/**
 * Class to handle breadcrumbs support
 *
 * @package Izo
 */


if ( !class_exists( 'Izo_Breadcrumb' ) ) :

	/**
	 * Izo_Breadcrumb 
	 */
	Class Izo_Breadcrumb {

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
			add_action( 'izo_header_after', array( $this, 'get_breadcrumb' ), 19 );
		}

		/**
		 * Get the breadcrumbs from the supported plugin
		 */
		public function get_breadcrumb() {

			//Don't show breadcrumbs on stretched pages
			if ( 'layout-stretched' == $this->page_layout() ) {
				return;
			}

			if ( function_exists( 'yoast_breadcrumb' ) ) { //Yoast breadcrumbs
				?>
				<div class="izo-container">				
				<?php yoast_breadcrumb( '<p id="breadcrumbs">','</p>' ); ?>
				</div>
				<?php
			} elseif ( function_exists( 'bcn_display' ) ) { //Breadcrumb NavXT
				?>
				<div class="izo-container">
					<p class="izo-breadcrumbs breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
						<?php bcn_display(); ?>
					</p>
				</div>
				<?php
			} elseif ( function_exists('rank_math_the_breadcrumbs') ) { //Rank Math breadcrumbs
				?>
				<div class="izo-container">
					<?php rank_math_the_breadcrumbs(); ?>
				</div>
				<?php
			} else {
				return;
			}

			//If we reached this point, remove the Woocommerce breadcrumbs
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
		}

		/**
		 * Check page layout
		 */
		public function page_layout() {

			if ( is_404() ) {
				return;
			}

			global $post;

			$id = $post->ID;

			$layout = get_post_meta( $id, '_izo_page_layout', 'layout-stretched' );

			return $layout;
		}

	}

	/**
	 * Initialize class
	 */
	Izo_Breadcrumb::get_instance();

endif;