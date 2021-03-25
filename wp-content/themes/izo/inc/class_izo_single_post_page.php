<?php
/**
 * Class to handle single post/page content
 *
 * @package Izo
 */


if ( !class_exists( 'Izo_Single_Post_Page' ) ) :

	/**
	 * Izo_Single_Post_Page 
	 */
	Class Izo_Single_Post_Page {

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
			add_action( 'izo_single_item_content', array( $this, 'entry_header' ) );
			add_action( 'izo_single_item_content', array( $this, 'post_thumbnail' ) );
			add_action( 'izo_single_item_content', array( $this, 'entry_content' ) );
			add_action( 'izo_single_item_content', array( $this, 'entry_footer' ) );
			add_action( 'izo_header_after', array( $this, 'post_banner' ), 20 );
		}

		/**
		 * Entry header
		 */
		public function entry_header( $align = 'left' ) {

			if ( apply_filters( 'izo_disable_single_header', false ) ) {
				return;
			}

			$hide = get_post_meta( get_the_ID(), '_izo_hide_title', true );
			if ( $hide || !is_singular() ) {
				return;
			}
			?>
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' );

				if ( 'post' === get_post_type() ) :

					$display_meta = get_theme_mod( 'single_post_enable_meta', true );
					?>
					<div class="entry-meta">
						<?php
						if ( $display_meta ) {
							izo_posted_on();
							izo_posted_by();
						}
						?>
					</div><!-- .entry-meta -->
				<?php endif; ?>
			</header><!-- .entry-header -->			
			<?php
		}

		/**
		 * Page thumbnail
		 */
		public function post_thumbnail() {

			if ( apply_filters( 'izo_disable_single_thumb', false ) ) {
				return;
			}			

			$hide = get_post_meta( get_the_ID(), '_izo_hide_featured_image', true );

			if ( $hide ) {
				return;
			}

			$post_featured = get_theme_mod( 'single_post_enable_featured', true );

			if ( ( is_single() && $post_featured ) || is_page() ) {
				izo_post_thumbnail();
			}

		}

		/**
		 * Entry content
		 */
		public function entry_content( $is_page ) {
			if ( $is_page ) : ?>
			<div class="entry-content">
				<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'izo' ),
						'after'  => '</div>',
					)
				);
				?>
			</div><!-- .entry-content -->
			<?php else : ?>
			<div class="entry-content">
				<?php
				the_content(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'izo' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						wp_kses_post( get_the_title() )
					)
				);

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'izo' ),
						'after'  => '</div>',
					)
				);
				?>
			</div><!-- .entry-content -->
			<?php endif;			
		}

		/**
		 * Entry footer
		 */
		public function entry_footer( $is_page ) {

			if ( $is_page ) {
				return;
			}

			$post_cats_tags = get_theme_mod( 'single_post_enable_cats_tags', true );

			if ( $post_cats_tags ) :
			?>
			<footer class="entry-footer">
				<?php izo_entry_footer(); ?>
			</footer><!-- .entry-footer -->
			<?php
			endif;
		}

		/**
		 * Post/page banner
		 */
		public function post_banner() {
			
			$hide = get_post_meta( get_the_ID(), '_izo_hide_title', true );

			if ( $hide ) {
				return;
			}

			$post_banner = get_theme_mod( 'single_post_banner', 'default' );
			$page_banner = get_theme_mod( 'single_page_banner', 'default' );

			if ( ( is_single() && 'banner' == $post_banner ) || ( is_page() && 'banner' == $page_banner ) ) :

			//Remove the default header
			remove_action( 'izo_single_item_content', array( $this, 'entry_header' ) );

			//Add the page banner instead ?>
			<div class="page-banner">
				<div class="izo-container">
					<?php $this->entry_header(); ?>
				</div>
			</div>
			
			<?php
			endif;
		}

	}

	/**
	 * Initialize class
	 */
	Izo_Single_Post_Page::get_instance();

endif;