<?php
/**
 * Class to handle post items on all types of archives
 *
 * @package Izo
 */


if ( !class_exists( 'Izo_Post_Item' ) ) :

	/**
	 * Izo_Post_Item 
	 */
	Class Izo_Post_Item {

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
			add_action( 'izo_post_item_content', array( $this, 'render_post_elements' ) );
			add_filter( 'excerpt_more', array( $this, 'read_more_link' ) );
			add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
			add_filter( 'izo_blog_layout', array( $this, 'blog_layout' ) );
			add_filter( 'izo_has_sidebar', array( $this, 'check_sidebar' ) );
		}

		/**
		 * Build post item
		 */
		public function render_post_elements() {

			$elements = get_theme_mod( 'post_item_elements', $this->get_default_elements() );

			foreach( $elements as $element ) {
				call_user_func( array( $this, $element ) );
			}
		}

		/**
		 * Default elements for the post item
		 */
		public function get_default_elements() {
			return array( 'loop_post_title', 'loop_post_meta', 'loop_image', 'loop_post_excerpt', 'loop_entry_footer' );
		}

		/**
		 * Post element: image
		 */
		public function loop_image() {

			if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
				return;
			}

			izo_post_thumbnail();
		}

		/**
		 * Post element: title
		 */
		public function loop_post_title() {
			?>
			<header class="entry-header post-header">
				<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			</header><!-- .entry-header -->
			<?php
		}	
		
		/**
		 * Post element: first category
		 */
		public function loop_entry_footer() {
			?>
			<footer class="entry-footer">
				<?php izo_entry_footer(); ?>
			</footer><!-- .entry-footer -->
			<?php
		}	
		
		/**
		 * Post element: meta
		 */
		public function loop_post_meta() {
			if ( 'post' === get_post_type() ) :
				?>
				<div class="entry-meta">
					<?php
					izo_posted_on();
					izo_posted_by();
					?>
				</div><!-- .entry-meta -->
			<?php endif;
		}	
		
		/**
		 * Post element: excerpt
		 */
		public function loop_post_excerpt() {

			$content = get_theme_mod( 'content_excerpt', 'excerpt' );
			?>
			<div class="entry-content">
				<?php

				if ( 'excerpt' == $content ) {
					the_excerpt(); 
				} else {
					the_content(); 
				}

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'izo' ),
					'after'  => '</div>',
				) );
				?>
			</div><!-- .entry-content -->
			<?php
		}

		/**
		 * Build read more link with user defined text
		 */
		public function read_more_link( $more ) {

			if ( is_admin() ) {
				return $more;
			}

			$text = get_theme_mod( 'continue_reading_text', esc_html__( 'Continue reading', 'izo' ) );
			
			$link =  '&nbsp;&lsqb;&hellip;&rsqb;<a class="read-more" href="'. esc_url( get_permalink() ) . '"/>' . esc_html( $text ) . '</a>';

			return $link;
		}	
		
		/**
		 * Excerpt length
		 */
		function excerpt_length( $length ) {
			if ( is_admin() ) {
				return $length;
			}

			$length = get_theme_mod( 'excerpt_length', 55 );
			
			return $length;
		}
		
		/**
		 * Blog layout
		 */
		function blog_layout() {

			$layout = get_theme_mod( 'blog_layout', 'layout-default' );
			
			return $layout;
		}	
		
		/**
		 * Remove sidebar for specific blog layouts
		 */
		function check_sidebar( $sidebar ) {

			$layout = $this->blog_layout();

			if ( ( 'layout-3cols' == $layout || 'layout-3colsmas' == $layout ) && ( is_home() || is_archive() || is_tag() ) ) {
				$sidebar = 'no-sidebar';
				return $sidebar;
			}

			return $sidebar;
		}
	}

	/**
	 * Initialize class
	 */
	Izo_Post_Item::get_instance();

endif;