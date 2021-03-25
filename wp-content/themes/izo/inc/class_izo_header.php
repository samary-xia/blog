<?php
/**
 * Class to handle post items on all types of archives
 *
 * @package Izo
 */


if ( !class_exists( 'Izo_Header' ) ) :

	/**
	 * Izo_Header 
	 */
	Class Izo_Header {

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
			add_action( 'izo_header', array( $this, 'header_markup' ) );
			add_filter( 'wp_nav_menu_items', array( $this, 'last_menu_item' ), 11, 2 );
			add_action( 'izo_header_after', array( $this, 'header_image' ) );
			add_filter( 'izo_custom_css_output', array( $this, 'display_site_title' ) );
		}

		/**
		 * Markup for the header bars
		 */
		public function header_markup() {

			if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'header' ) ) {
				return;
			}
			
			$enable_top_bar 	= get_theme_mod( 'enable_top_bar', 0 );
			$menu_layout		= get_theme_mod( 'menu_layout', 'mobile-layout-default' );
			$mobile_menu_layout	= get_theme_mod( 'mobile_menu_layout', 'menu-layout-default' );

			$menu_container = get_theme_mod( 'menu_container', 'izo-container' );
			$top_container 	= get_theme_mod( 'top_bar_container', 'izo-container' );

			global $post;

			if ( isset( $post ) ) {
				$disable_header	= get_post_meta( $post->ID, '_izo_hide_header', true );	
				if ( $disable_header ) {
					return;
				}
			}
			?>

			<header id="masthead" class="site-header">
				<?php if ( $enable_top_bar ) : ?>
				<div class="top-header-bar">
					<div class="<?php echo esc_attr( $top_container ); ?>">
						<div class="top-header-bar-inner">
							<div class="header-area-top-left"><?php $this->get_component( 'left' ); ?></div>
							<div class="header-area-top-right"><?php $this->get_component( 'right' ); ?></div>
						</div>
					</div>
				</div>
				<?php endif; ?>

				<div class="bottom-header-bar <?php echo esc_attr( $mobile_menu_layout ); ?> <?php echo esc_attr( $menu_layout ); ?> <?php $this->merge_menu_bar(); ?>">
					<div class="<?php echo esc_attr( $menu_container ); ?>">
						<div class="bottom-header-bar-inner">	
							<div class="header-area-bottom-left"><?php $this->site_branding(); ?></div>
							<div class="header-area-bottom-right"><?php $this->main_navigation(); ?></div>
						</div>	
					</div>
				</div>
			</header><!-- #masthead -->
			<?php
		}

		/**
		 * Site branding
		 */	
		function site_branding() {
			?>
			<div class="site-branding">
			<?php
			echo $this->site_logo(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$izo_description = get_bloginfo( 'description', 'display' );
			if ( $izo_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $izo_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
			</div><!-- .site-branding -->
			<?php
		}

		/**
		 * Main navigation
		 */	
		function main_navigation() {
			$mobile_label 	= get_theme_mod( 'mobile_menu_label' );
			$opening		= get_theme_mod( 'mobile_menu_opening', 'op-default' );
			?>

			<?php if ( function_exists('max_mega_menu_is_enabled') && max_mega_menu_is_enabled( 'primary-menu' ) ) : ?>
				<?php wp_nav_menu( array( 'theme_location' => 'primary-menu') ); ?>
			<?php else: ?>		
			<button class="menu-toggle" aria-controls="primary-menu" aria-label="<?php echo esc_attr__( 'Toggle mobile menu', 'izo' ); ?>" aria-expanded="false" <?php echo wp_kses_post( apply_filters( 'izo_nav_toggle_data_attrs', '' ) ); ?>><?php izo_get_svg_icon( 'icon-bars', true ); ?><span class="menu-label"><?php echo esc_html( $mobile_label ); ?></span></button>	
			<nav id="site-navigation" class="main-navigation" data-open="<?php echo esc_attr( $opening ); ?>" <?php echo wp_kses_post( apply_filters( 'izo_nav_data_attrs', '' ) ); ?>>
			<?php
			wp_nav_menu( array(
				'theme_location' 	=> 'primary-menu',
				'menu_id'        	=> 'primary-menu',
				'fallback_cb' 		=> 'izo_main_nav_fallback',
			) );
			?>
			</nav><!-- #site-navigation -->

			<?php endif; ?>
			<?php 
		}

		/**
		 * Header contact
		 */	
		function header_component_contact() {

			$data = '<div class="header-contact">';
	
				$phone 	= get_theme_mod( 'header_phone', '+99.11.33.22' );
				$mail 	= get_theme_mod( 'header_mail', 'office@example.org' );
				
				$data .= '<a href="tel:' . esc_attr( $phone ) . '">' . izo_get_svg_icon( 'icon-phone', false ) . esc_html( $phone ) . '</a>';
				$data .= '<a href="mailto:' . esc_attr( antispambot( $mail ) ) . '">' . izo_get_svg_icon( 'icon-mail', false ) . esc_html( antispambot( $mail ) ) . '</a>';
	
			$data .= '</div>';
	
			echo $data; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		/**
		 * Header text
		 */	
		function header_component_text() {

			$text = get_theme_mod( 'header_custom_text', 'Lorem ipsum dolor sit amet' );
	
			$data = '<div class="header-custom-text">';
				$data .= wp_kses_post( $text );
			$data .= '</div>';
	
			echo $data; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		/**
		 * Top navigation
		 */	
		function header_component_top_nav() {
			?>
			<?php if ( function_exists('max_mega_menu_is_enabled') && max_mega_menu_is_enabled( 'top-menu' ) ) : ?>
				<?php wp_nav_menu( array( 'theme_location' => 'top-menu') ); ?>
			<?php else: ?>				
			<nav id="top-navigation" class="top-navigation">
				<?php
				wp_nav_menu( array(
					'theme_location'=> 'top-menu',
					'menu_id'       => 'top-menu',
					'fallback_cb'	=> false,
					'depth'			=> 1
				) );
				?>
			</nav><!-- #top-navigation -->
			<?php endif; ?>
			<?php 
		}

		/**
		 * WooCommerce icons
		 */		
		function header_woocommerce() {

			if ( !class_exists( 'WooCommerce' ) ) {
				return;
			}
	
			?>
			<div class="woocommerce-links">
				<?php echo izo_woocommerce_header_cart(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>	
			<?php
		}

		/**
		 * Header social
		 */
		function header_component_social() {
		
			$socials = get_theme_mod( 'header_social_profiles' );

			if ( !$socials ) {
				return;
			}

			$socials = explode( ',', $socials );
	
			echo '<div class="header-social">';
			foreach ( $socials as $social ) {
				$network = izo_get_social_network( $social );
				if ( $network ) {
					echo '<a href="' . esc_url( $social ) . '">' . izo_get_svg_icon( 'icon-' . esc_html( $network ), false ) . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
			}
			echo '</div>';
		}

		/**
		 * Header search form
		 */
		function header_search_form() {
			get_search_form();
		}	

		/**
		 * Get the component for a specific top header area
		 */
		public function get_component( $location ) {
			
			switch ( $location ) {
				case 'left':
					$default = 'header_component_contact';
					break;
		
				case 'right':
					$default = 'header_component_text';
					break;		
			}

			$component = get_theme_mod( $location . '_top_bar_component' , $default );

			if ( 'nothing' === $component ) {
				return;
			}

			$this->$component();		
		}

		/**
		 * Handles header bars merging
		 */
		public function merge_menu_bar() {
			
			global $post;

			if ( !isset( $post ) ) {
				return;
			}			

			$merge_bottom_bar	= get_post_meta( $post->ID, '_izo_merge_bottom_bar', true );	

			if ( $merge_bottom_bar ) {
				echo 'is-merged';
			}
		}

		/**
		 * Site logo
		 */
		public function site_logo() {
			global $post;

			if ( !isset( $post ) ) {
				return get_custom_logo();
			}

			$merge_bottom_bar	= get_post_meta( $post->ID, '_izo_merge_bottom_bar', true );
			$logo_transparent	= get_theme_mod( 'logo_transparent' );

			if ( $merge_bottom_bar && $logo_transparent ) { //logo for pages that have the transparent mode active
				$aria_current = is_front_page() && ! is_paged() ? ' aria-current="page"' : '';

				$logo = sprintf(
					'<a href="%1$s" class="custom-logo-link" rel="home"%2$s>%3$s</a>',
					esc_url( home_url( '/' ) ),
					$aria_current,
					'<img class="custom-logo" alt="' . get_bloginfo( 'name', 'display' ) . '" src="' . $logo_transparent . '"/>'
				);
			} else { //core logo
				$logo = get_custom_logo();
			}
			
			return $logo;
		}

		/**
		 * Last menu item
		 */
		public function last_menu_item( $items, $args ) {

			$lastitem = get_theme_mod( 'main_header_last_item', 'main_header_component_nothing' );

			if ( 'main_header_component_nothing' == $lastitem ) {
				return $items; //return if we don't have to show anything here
			}

			if ( 'primary-menu' != $args -> theme_location ) {
				return $items; //return if this is not the main menu 
			}

			switch( $lastitem ) {
				//Button
				case 'main_header_component_button':
					$url 	= get_theme_mod( 'main_header_button_url', '#' );
					$text 	= get_theme_mod( 'main_header_button_text', esc_attr__( 'Click me', 'izo' ) );
					$newtab = get_theme_mod( 'main_header_button_newtab', 0 );
		
					$target = '';
					if ( $newtab ) {
						$target = 'target="_blank"';
					}
		
					$items .= '<li class="menu-last-item"><a ' . $target . ' class="button" tabindex="0" href="' . esc_url( $url ) . '">' . esc_html( $text ) . '</a></li>';
					break;

				//Text
				case 'main_header_component_text':
					$text = get_theme_mod( 'main_header_custom_text', 'Lorem ipsum dolor sit amet' );
	
					$items .= '<li class="menu-last-item"><div class="main-header-text">' . wp_kses_post( $text ) . '</div></li>';

					break;	

				//Search	
				case 'main_header_component_search':
					
					$style = get_theme_mod( 'header_search_style', 'default' );

					$items .= '<li class="menu-last-item"><span class="header-search-toggle ' . esc_attr( $style ) . '"><i class="icon-search"></i></span></li>';
					$items .= '<li class="header-search-form">' . get_search_form( false ) . '</li>';
				
					break;	

				//Search	
				case 'main_header_woocommerce':
					if ( class_exists( 'WooCommerce' ) ) {
						$items .= '<li class="menu-last-item"><div class="woocommerce-links">' . izo_woocommerce_header_cart() . '</div></li>';
					} else {
						$items .= '';
					}
	
				break;						
			}

			return $items;

		}

		/**
		 * Header image
		 */
		public function header_image() {

			if ( !get_header_image() ) {
				return;
			}

			$show_on_front = get_theme_mod( 'header_image_front_page', 0 );

			if ( is_home() || is_front_page() && $show_on_front ) {
				echo '<div class="header-image">';
					the_header_image_tag();
				echo '</div>';
			}

		}

		/**
		 * Handle site title and description display when logo is active
		 */
		public function display_site_title( $css ) {

			$display_site_title = get_theme_mod( 'display_site_title', 0 );
			$has_logo			= has_custom_logo();

			if ( $has_logo && !$display_site_title ) {
				$css .= '.site-title,.site-description {position: absolute;clip: rect(1px, 1px, 1px, 1px);}';
			}

			return $css;
		}

	}

	/**
	 * Initialize class
	 */
	Izo_Header::get_instance();

endif;