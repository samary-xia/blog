<?php
/**
 * Class to handle the theme footer and footer widgets
 *
 * @package Izo
 */


if ( !class_exists( 'Izo_Footer' ) ) :

	/**
	 * Izo_Footer 
	 */
	Class Izo_Footer {

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
			add_action( 'izo_footer', array( $this, 'footer_markup' ) );
			add_action( 'izo_footer_widgets', array( $this, 'get_footer_widgets' ) );
			add_action( 'widgets_init', array( $this, 'register_footer_areas' ) );
		}

		/**
		 * Markup for the footer
		 */
		public static function footer_markup() {		

			if ( apply_filters( 'izo_disable_footer', false ) ) {
				return;
			}

			global $post;

			if ( isset( $post ) ) {
				$disable_footer	= get_post_meta( $post->ID, '_izo_hide_footer', true );	
				if ( $disable_footer ) {
					return;
				}
			}	
			
			if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'footer' ) ) {
				return;
			}				
			
			$credits = get_theme_mod( 'footer_credits' );
			?>
			<footer id="colophon" class="site-footer">
					
					<?php do_action( 'izo_footer_widgets' ); ?>
					
					<div class="site-info">
						<div class="izo-container">
							<?php do_action( 'izo_credits_before' ); ?>
							<div class="footer-credits">
							<?php if ( $credits ) : ?>
								<?php echo wp_kses_post( $credits ); ?>
							<?php else : ?>
								<?php /* translators: %1$s: theme name */ printf( esc_html__( 'Proudly powered by the %1$s', 'izo' ), '<a class="underline" rel="nofollow" href="https://elfwp.com/themes/izo/">Izo WordPress theme</a>' ); ?>
							<?php endif; ?>
							</div>
							<?php do_action( 'izo_credits_after' ); ?>
						</div>
					</div><!-- .site-info -->
			</footer><!-- #colophon -->
			<?php
		}

		public function get_footer_widgets() {
			get_sidebar( 'footer' );
		}

		/**
		 * Register footer widget areas
		 */
		public function register_footer_areas() {
			
			$footer_widgets_layout = get_theme_mod( 'footer_widgets_layout', 'disabled' );

			switch ( $footer_widgets_layout ) {
				case 'columns1':
					$widget_areas = 1;
					break;

				case 'columns2':
					$widget_areas = 2;
					break;
					 
				case 'columns1l2s':	
				case 'columns3':
					$widget_areas = 3;
					break;

				case 'columns4':
					$widget_areas = 4;
					break;	

				default:
					return;
			}

			for ( $i = 1; $i <= $widget_areas; $i++ ) {
				register_sidebar(
					array(
						'name'          => /* translators: %s: footer area number */ sprintf( esc_html__( 'Footer area %s', 'izo' ), $i ),
						'id'            => 'footer-' . $i,
						'description'   => esc_html__( 'Add widgets here.', 'izo' ),
						'before_widget' => '<section id="%1$s" class="widget %2$s">',
						'after_widget'  => '</section>',
						'before_title'  => '<h2 class="widget-title">',
						'after_title'   => '</h2>',
					)
				);	
			}		
		}

	}

	/**
	 * Initialize class
	 */
	Izo_Footer::get_instance();

endif;