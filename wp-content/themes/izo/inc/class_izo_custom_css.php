<?php
/**
 * Class for dynamic CSS output
 *
 * @package Izo
 */


if ( !class_exists( 'Izo_Custom_CSS' ) ) :

	/**
	 * Izo_Custom_CSS 
	 */
	Class Izo_Custom_CSS {

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
			add_action( 'wp_enqueue_scripts', array( $this, 'output_css' ) );
		}

		/**
		 * Output all custom CSS
		 */
		public function output_css() {
			global $post;

			$css = '';

			/**
			 * Fonts
			 */		
			$defaults = json_encode(
				array(
					'font' 			=> 'System default',
					'regularweight' => 'regular',
					'italicweight' 	=> 'italic',
					'boldweight' 	=> 'bold',
					'category' 		=> 'sans-serif'
				)
			);
		
			$body_font		= get_theme_mod( 'izo_body_font', $defaults );
			$headings_font 	= get_theme_mod( 'izo_headings_font', $defaults );
		
			$body_font 		= json_decode( $body_font, true );
			$headings_font 	= json_decode( $headings_font, true );
			
			if ( 'System default' !== $body_font['font'] ) {
				$css .= 'body, button, input, optgroup, select, textarea { font-family:' . esc_attr( $body_font['font'] ) . ',' . esc_attr( $body_font['category'] ) . ';}' . "\n";	
				$css .= 'body, button, input, optgroup, select, textarea { font-weight:' . esc_attr( $body_font['regularweight'] ) . ';}' . "\n";	
			}
			 
			$css .= $this->get_resp_font_sizes_css( 'body_font_size', $defaults = array( 'desktop' => 16, 'tablet' => 16, 'mobile' => 16 ), 'body' );

			$body_line_height = get_theme_mod( 'body_line_height', 1.7 );
			$css .= 'body { line-height:' . esc_attr( $body_line_height ) . ';}' . "\n";

			$body_letter_spacing = get_theme_mod( 'body_letter_spacing', 0 );
			$css .= 'body { letter-spacing:' . esc_attr( $body_letter_spacing ) . 'px;}' . "\n";

			if ( 'System default' !== $headings_font['font'] ) {
				$css .= 'h1,h2,h3,h4,h5,h6,.site-title { font-family:' . esc_attr( $headings_font['font'] ) . ',' . esc_attr( $headings_font['category'] ) . ';}' . "\n";	
				$css .= 'h1,h2,h3,h4,h5,h6,.site-title { font-weight:' . esc_attr( $headings_font['boldweight'] ) . ';}' . "\n";	
			}
			
			$headings_line_height = get_theme_mod( 'headings_line_height', 1.2 );
			$css .= 'h1,h2,h3,h4,h5,h6,.site-title { line-height:' . esc_attr( $headings_line_height ) . ';}' . "\n";			

			$headings_letter_spacing = get_theme_mod( 'headings_letter_spacing', 0 );
			$css .= 'h1,h2,h3,h4,h5,h6,.site-title { letter-spacing:' . esc_attr( $headings_letter_spacing ) . 'px;}' . "\n";

			//Headings
			$css .= $this->get_resp_font_sizes_css( 'h1_heading_font_size', $defaults = array( 'desktop' => 40, 'tablet' => 36, 'mobile' => 28 ), 'h1' );
			$css .= $this->get_resp_font_sizes_css( 'h2_heading_font_size', $defaults = array( 'desktop' => 32, 'tablet' => 28, 'mobile' => 22 ), 'h2' );
			$css .= $this->get_resp_font_sizes_css( 'h3_heading_font_size', $defaults = array( 'desktop' => 28, 'tablet' => 24, 'mobile' => 18 ), 'h3' );
			$css .= $this->get_resp_font_sizes_css( 'h4_heading_font_size', $defaults = array( 'desktop' => 24, 'tablet' => 20, 'mobile' => 16 ), 'h4' );
			$css .= $this->get_resp_font_sizes_css( 'h5_heading_font_size', $defaults = array( 'desktop' => 20, 'tablet' => 16, 'mobile' => 16 ), 'h5' );
			$css .= $this->get_resp_font_sizes_css( 'h6_heading_font_size', $defaults = array( 'desktop' => 16, 'tablet' => 16, 'mobile' => 16 ), 'h6' );

			$headings_line_height = get_theme_mod( 'headings_line_height', 1.2 );
			$css .= 'h1,h2,h3,h4,h5,h6,.site-title { line-height:' . esc_attr( $headings_line_height ) . ';}' . "\n";			

			$h1_letter_spacing = get_theme_mod( 'h1_letter_spacing' );
			$css .= 'h1 { letter-spacing:' . esc_attr( $h1_letter_spacing ) . 'px;}' . "\n";
	
			$h1_heading_line_height = get_theme_mod( 'h1_heading_line_height' );
			$css .= 'h1 { line-height:' . esc_attr( $h1_heading_line_height ) . ';}' . "\n";			
			
			$h2_letter_spacing = get_theme_mod( 'h2_letter_spacing' );
			$css .= 'h2 { letter-spacing:' . esc_attr( $h2_letter_spacing ) . 'px;}' . "\n";
	
			$h2_heading_line_height = get_theme_mod( 'h2_heading_line_height' );
			$css .= 'h2 { line-height:' . esc_attr( $h2_heading_line_height ) . ';}' . "\n";
			
			$h3_letter_spacing = get_theme_mod( 'h3_letter_spacing' );
			$css .= 'h3 { letter-spacing:' . esc_attr( $h3_letter_spacing ) . 'px;}' . "\n";
	
			$h3_heading_line_height = get_theme_mod( 'h3_heading_line_height' );
			$css .= 'h3 { line-height:' . esc_attr( $h3_heading_line_height ) . ';}' . "\n";
			
			$h4_letter_spacing = get_theme_mod( 'h4_letter_spacing' );
			$css .= 'h4 { letter-spacing:' . esc_attr( $h4_letter_spacing ) . 'px;}' . "\n";
	
			$h4_heading_line_height = get_theme_mod( 'h4_heading_line_height' );
			$css .= 'h4 { line-height:' . esc_attr( $h4_heading_line_height ) . ';}' . "\n";	
			
			$h5_letter_spacing = get_theme_mod( 'h5_letter_spacing' );
			$css .= 'h5 { letter-spacing:' . esc_attr( $h5_letter_spacing ) . 'px;}' . "\n";
	
			$h5_heading_line_height = get_theme_mod( 'h5_heading_line_height' );
			$css .= 'h5 { line-height:' . esc_attr( $h5_heading_line_height ) . ';}' . "\n";	
			
			$h6_letter_spacing = get_theme_mod( 'h6_letter_spacing' );
			$css .= 'h6 { letter-spacing:' . esc_attr( $h6_letter_spacing ) . 'px;}' . "\n";
	
			$h6_heading_line_height = get_theme_mod( 'h6_heading_line_height' );
			$css .= 'h6 { line-height:' . esc_attr( $h6_heading_line_height ) . ';}' . "\n";

			/**
			 * General colors
			 */
			$css .= $this->get_background_color_css( 'accent_color', '#ea285e', '.elementor-button-wrapper .elementor-button, .backtotop,.widget_search .search-form::after,.woocommerce-pagination li .page-numbers:hover, .woocommerce-pagination li .page-numbers.current,.navigation.pagination .page-numbers:hover, .navigation.pagination .page-numbers.current,.menu-last-item .header-search-toggle.stacked,button,.button,.wp-block-button__link,input[type="button"],input[type="reset"],input[type="submit"],.wpforms-form button[type=submit],div.wpforms-container-full .wpforms-form button[type=submit],div.nf-form-content input[type=button]');
			$css .= $this->get_color_css( 'accent_color', '#ea285e', '.blog-featured-area .featured-post .post-content a:hover,.page.woocommerce-account .woocommerce-MyAccount-navigation ul li a:hover,.widget a:hover,.read-more:hover,.entry-meta a:hover,.entry-footer a:hover,article .entry-title a:hover,.comment-navigation a:hover,.posts-navigation a:hover,.post-navigation a:hover,.top-navigation ul a:hover,.main-navigation a:hover,.is-style-outline .wp-block-button__link,.wp-block-button__link.is-style-outline');
			$css .= $this->get_border_color_css( 'accent_color', '#ea285e', '.is-style-outline .wp-block-button__link,.wp-block-button__link.is-style-outline,button,.button,.wp-block-button__link,input[type="button"],input[type="reset"],input[type="submit"],.wpforms-form button[type=submit],div.wpforms-container-full .wpforms-form button[type=submit],div.nf-form-content input[type=button]');
			$css .= $this->get_fill_color_css( 'accent_color', '#ea285e', '.header-social .izo-icon:hover,.header-contact .izo-icon');

			$css .= $this->get_color_css( 'body_color', '#1d1d1f', 'body');
			$css .= $this->get_color_css( 'content_link_color', '#4169e1', 'a');
			$css .= $this->get_color_css( 'content_link_color_hover', '#191970', 'a:hover');
			$css .= $this->get_color_css( 'headings_color', '#1d1d1f', 'h1,h2,h3,h4,h5,h6');

			/**
			 * Buttons
			 */
			$css .= $this->get_background_color_css( 'global_button_background', '#ea285e', '.widget_shopping_cart_content .button,.elementor-button-wrapper .elementor-button,button,.button,.wp-block-button__link,input[type="button"],input[type="reset"],input[type="submit"],.wpforms-form button[type=submit],div.wpforms-container-full .wpforms-form button[type=submit],div.nf-form-content input[type=button]');
			$css .= $this->get_background_color_css( 'global_button_background_hover', '#b6113f', '.widget_shopping_cart_content .button:hover,.elementor-button-wrapper .elementor-button:hover,button:hover,.button:hover,.wp-block-button__link:hover,input[type="button"]:hover,input[type="reset"]:hover,input[type="submit"]:hover,.wpforms-form button[type=submit]:hover,div.wpforms-container-full .wpforms-form button[type=submit]:hover,div.nf-form-content input[type=button]:hover');
			$css .= $this->get_color_css( 'global_button_color', '#ffffff', '.widget_shopping_cart_content .button,.elementor-button-wrapper .elementor-button,button,.button,.wp-block-button__link,input[type="button"],input[type="reset"],input[type="submit"],.wpforms-form button[type=submit],div.wpforms-container-full .wpforms-form button[type=submit],div.nf-form-content input[type=button]');
			$css .= $this->get_color_css( 'global_button_color_hover', '#ffffff', '.widget_shopping_cart_content .button:hover,.elementor-button-wrapper .elementor-button:hover,button:hover,.button:hover,.wp-block-button__link:hover,input[type="button"]:hover,input[type="reset"]:hover,input[type="submit"]:hover,.wpforms-form button[type=submit]:hover,div.wpforms-container-full .wpforms-form button[type=submit]:hover,div.nf-form-content input[type=button]:hover');
			
			$global_button_padding_tb 		= get_theme_mod( 'global_button_padding_tb', 14 );	
			$global_button_padding_lr 		= get_theme_mod( 'global_button_padding_lr', 26 );	
			$global_button_border_radius 	= get_theme_mod( 'global_button_border_radius', 0 );	
			$global_button_font_size 		= get_theme_mod( 'global_button_font_size', 16 );	
			
			$css .= '.elementor-button-wrapper .elementor-button,button,.button,.wp-block-button__link,input[type="button"],input[type="reset"],input[type="submit"],.wpforms-form button[type=submit],div.wpforms-container-full .wpforms-form button[type=submit],div.nf-form-content input[type=button] { font-size:' . intval( $global_button_font_size ) . 'px;border-radius:' . intval( $global_button_border_radius ) . 'px;padding-left:' . intval( $global_button_padding_lr ) . 'px;padding-right:' . intval( $global_button_padding_lr ) . 'px;padding-top:' . intval( $global_button_padding_tb ) . 'px;padding-bottom:' . intval( $global_button_padding_tb ) . 'px;}' . "\n";
		
			/**
			 * Header
			 */

			//Top bar
			$hide_top_bar_mobile = get_theme_mod( 'hide_top_bar_mobile', 0 );
			if ( $hide_top_bar_mobile ) {
				$css .= '@media ( max-width: '. $this->get_mobile_breakpoint() . 'px) { .top-header-bar { display:none;} }' . "\n";	
			}

			//logo size
			$site_logo_size_desktop = get_theme_mod( 'site_logo_size_desktop', 130 );
			$site_logo_size_tablet 	= get_theme_mod( 'site_logo_size_tablet', 130 );
			$site_logo_size_mobile	= get_theme_mod( 'site_logo_size_mobile', 130 );	

			$css .= '.site-branding .custom-logo { max-width:' . intval( $site_logo_size_desktop ) . 'px;}' . "\n";	
			$css .= '@media ( max-width: '. $this->get_tablet_breakpoint() . 'px) { .site-branding .custom-logo { max-width:' . intval( $site_logo_size_tablet ) . 'px;} }' . "\n";	
			$css .= '@media ( max-width: '. $this->get_mobile_breakpoint() . 'px) { .site-branding .custom-logo { max-width:' . intval( $site_logo_size_mobile ) . 'px;} }' . "\n";	

			//Colors
			$top_bar_background_color 		= get_theme_mod( 'top_bar_background_color' );
			$bottom_bar_background_color 	= get_theme_mod( 'bottom_bar_background_color' );

			$css .= '.top-header-bar:not(.is-merged) { background-color:' . esc_attr( $top_bar_background_color ) . ';}' . "\n";	
			$css .= '.bottom-header-bar:not(.is-merged) { background-color:' . esc_attr( $bottom_bar_background_color ) . ';}' . "\n";	

			//Transparent mode
			$css .= $this->get_background_color_css( 'top_bar_background_color_transp', '', '.top-header-bar.is-merged');
			$css .= $this->get_color_css( 'top_bar_color_transp', '', '.top-header-bar.is-merged, .top-header-bar.is-merged a');

			$css .= $this->get_background_color_css( 'bottom_bar_background_color_transp', '', '.bottom-header-bar.is-merged');

			//Paddings
			$top_hb_padding_desktop 	= get_theme_mod( 'top_hb_padding_desktop', 10 );
			$top_hb_padding_tablet 		= get_theme_mod( 'top_hb_padding_tablet', 10 );
			$top_hb_padding_mobile	 	= get_theme_mod( 'top_hb_padding_mobile', 10 );	
			
			$css .= '.top-header-bar { padding:' . intval( $top_hb_padding_desktop ) . 'px 0;}' . "\n";	
			$css .= '@media ( max-width: '. $this->get_tablet_breakpoint() . 'px) { .top-header-bar { padding:' . intval( $top_hb_padding_tablet ) . 'px 0;} }' . "\n";	
			$css .= '@media ( max-width: '. $this->get_mobile_breakpoint() . 'px) { .top-header-bar { padding:' . intval( $top_hb_padding_mobile ) . 'px 0;} }' . "\n";	

			$bottom_hb_padding_desktop 		= get_theme_mod( 'bottom_hb_padding_desktop', '20' );
			$bottom_hb_padding_tablet 		= get_theme_mod( 'bottom_hb_padding_tablet', '20' );
			$bottom_hb_padding_mobile	 	= get_theme_mod( 'bottom_hb_padding_mobile', '20' );	
			
			$css .= '.bottom-header-bar { padding:' . intval( $bottom_hb_padding_desktop ) . 'px 0;}' . "\n";	
			$css .= '@media ( max-width: '. $this->get_tablet_breakpoint() . 'px) { .bottom-header-bar { padding:' . intval( $bottom_hb_padding_tablet ) . 'px 0;} }' . "\n";	
			$css .= '@media ( max-width: '. $this->get_mobile_breakpoint() . 'px) { .bottom-header-bar { padding:' . intval( $bottom_hb_padding_mobile ) . 'px 0;} }' . "\n";	

			//Colors
			$css .= $this->get_color_css( 'header_contact_color', '', '.header-contact a');
			$css .= $this->get_color_css( 'bottom_bar_color_transp', '', '.bottom-header-bar.is-merged, .bottom-header-bar.is-merged .site-title a, .bottom-header-bar.is-merged .menu > li > a:not(.button), .bottom-header-bar.is-merged .site-description');
			$css .= $this->get_background_color_css( 'bottom_bar_background_color_transp', '', '.bottom-header-bar.is-merged');
			
			$css .= $this->get_color_css( 'header_search_color', '', '.menu-last-item .header-search-toggle.default');
			$css .= $this->get_background_color_css( 'header_search_color', '', '.menu-last-item .header-search-toggle.stacked');

			$css .= $this->get_color_css( 'main_header_text_color', '', '.main-header-text, .main-header-text a');

			$css .= $this->get_background_color_css( 'main_header_button_background', '', '.menu-last-item .button');
			$css .= $this->get_background_color_css( 'main_header_button_background_hover', '', '.menu-last-item .button:hover');
			$css .= $this->get_border_color_css( 'main_header_button_background_hover', '', '.menu-last-item .button:hover');

			$css .= $this->get_color_css( 'main_header_button_color', '#fff', '.menu-last-item .button,.bottom-header-bar.is-sticky .menu-last-item .button');
			$css .= $this->get_color_css( 'main_header_button_color_hover', '#fff', '.menu-last-item .button:hover, .bottom-header-bar.is-sticky .menu-last-item .button:hover');

			$css .= $this->get_background_color_css( 'sticky_header_bg_color', 'rgba(255, 255, 255, 0.8)', '.has-sticky-menu .bottom-header-bar.is-sticky');
			$css .= $this->get_color_css( 'sticky_header_color', '', '.has-sticky-menu .bottom-header-bar.is-sticky, .has-sticky-menu .bottom-header-bar.is-sticky .site-title a, .has-sticky-menu .bottom-header-bar.is-sticky .site-description, .has-sticky-menu .bottom-header-bar.is-sticky .menu > li > a:not(.button)');
			$css .= $this->get_fill_color_css( 'sticky_header_color', '', '.has-sticky-menu .bottom-header-bar.is-sticky .woocommerce-links .izo-icon');


			$css .= $this->get_background_color_css( 'mobile_menu_background_color', '#fff', '.main-navigation.toggled');
			$css .= $this->get_color_css( 'mobile_menu_items_color', '#1d1d1d', '.main-navigation.toggled, .main-navigation.toggled a');

			$css .= $this->get_color_css( 'top_header_text_color', '', '.top-header-bar .header-custom-text');
			$css .= $this->get_fill_color_css( 'top_header_wc_icons_color', '', '.top-header-bar .woocommerce-links .izo-icon');
			$css .= $this->get_color_css( 'top_header_nav_color', '', '.top-navigation ul a');
			$css .= $this->get_color_css( 'top_header_nav_color_hover', '', '.top-navigation ul a:hover');
			$css .= $this->get_fill_color_css( 'top_header_social_color', '', '.top-header-bar .header-social .izo-icon');

			$css .= $this->get_color_css( 'site_title_color', '', '.site-title a');
			$css .= $this->get_color_css( 'site_desc_color', '', '.site-description');
			$css .= $this->get_color_css( 'menu_items_color', '', '.main-navigation > div > ul > li > a');
			$css .= $this->get_fill_color_css( 'menu_items_color', '', '.menu-last-item .izo-icon');
			$css .= $this->get_fill_color_css( 'bottom_bar_color_transp', '', '.is-merged.bottom-header-bar .menu-last-item .izo-icon');
			$css .= $this->get_color_css( 'menu_items_color_hover', '', '.main-navigation > div > ul > li > a:hover');
			$css .= $this->get_color_css( 'submenu_items_color', '', '.main-navigation ul ul a');
			$css .= $this->get_color_css( 'submenu_items_color_hover', '', '.main-navigation ul ul a:hover');
			$css .= $this->get_background_color_css( 'submenu_items_background', '', '.main-navigation ul ul li');

			//Header button
			$main_header_button_padding_tb 		= get_theme_mod( 'main_header_button_padding_tb', 14 );	
			$main_header_button_padding_lr 		= get_theme_mod( 'main_header_button_padding_lr', 26 );	
			$main_header_button_border_radius 	= get_theme_mod( 'main_header_button_border_radius', 0 );	
			$main_header_button_font_size 		= get_theme_mod( 'main_header_button_font_size', 16 );	

			$css .= '.menu-last-item .button { padding-top:' . intval( $main_header_button_padding_tb ) . 'px;padding-bottom:' . intval( $main_header_button_padding_tb ) . 'px;}' . "\n";	
			$css .= '.menu-last-item .button { padding-left:' . intval( $main_header_button_padding_lr ) . 'px;padding-right:' . intval( $main_header_button_padding_lr ) . 'px;}' . "\n";	
			$css .= '.menu-last-item .button { border-radius:' . intval( $main_header_button_border_radius ) . 'px;}' . "\n";	
			$css .= '.menu-last-item .button { font-size:' . intval( $main_header_button_font_size ) . 'px;}' . "\n";	

			/**
			 * Footer
			 */
			$css .= $this->get_background_color_css( 'footer_bottom_background', '', '.site-info' );
			$css .= $this->get_color_css( 'footer_bottom_color', '', '.site-info, .site-info a' );

			$css .= $this->get_background_color_css( 'footer_widgets_background', '', '.footer-widgets' );
			$css .= $this->get_color_css( 'footer_widgets_color', '', '.footer-widgets');
			$css .= $this->get_color_css( 'footer_widgets_links_color', '', '.footer-widgets a');
			$css .= $this->get_color_css( 'footer_widgets_title_color', '', '.footer-widgets .widget-title');
			$css .= $this->get_border_color_css( 'footer_widgets_border_color', '', '.footer-widgets');

			/**
			 * Sidebar
			 */
			$sidebar_width = get_theme_mod( 'sidebar_width', 25 );
			$css .= '.izo-container.has-sidebar { grid-template-columns:' . 'auto ' . intval( $sidebar_width ) . '%;}' . "\n";	

			$css .= '.sidebar-left .izo-container.has-sidebar { grid-template-columns:' . intval( $sidebar_width ) . '%'  . ' auto;}' . "\n";	
			$css .= '.sidebar-left .izo-container.has-sidebar { grid-template-areas: "sidebar main";}' . "\n";	
		
			$css .= '.no-sidebar .izo-container.has-sidebar { grid-template-areas: "main"; grid-template-columns: auto; max-width: 900px;}' . "\n";	

			/**
			 * Page layout
			 */
			$css .= '.layout-unboxed .site-main article { background: transparent;padding:0;} .layout-unboxed .site-main .widget-area .widget { background: transparent;padding:0;}' . "\n";	

			$css .= '.layout-stretched {background:#fff!important;} .layout-stretched .site-header {margin:0;} .layout-stretched .site-footer {margin:0;} .layout-stretched .izo-container.has-sidebar {max-width:100%;padding:0;} .layout-stretched article { background: transparent;padding:0;} .layout-stretched .widget-area .widget { background: transparent;padding:0;}' . "\n";	

			$css .= $this->get_resp_font_sizes_css( 'single_page_title_size', $defaults = array( 'desktop' => 40, 'tablet' => 36, 'mobile' => 28 ), '.page .entry-header .entry-title' );
			$css .= $this->get_color_css( 'single_page_title_color', '', '.page .entry-header .entry-title' );

			/**
			 * Blog
			 */
			$css .= $this->get_resp_font_sizes_css( 'archive_title_large_size', $defaults = array( 'desktop' => 32, 'tablet' => 28, 'mobile' => 22 ), '.posts-loop.layout-default .entry-title' );
			$css .= $this->get_resp_font_sizes_css( 'archive_title_small_size', $defaults = array( 'desktop' => 32, 'tablet' => 28, 'mobile' => 22 ), '.posts-loop.layout-2colssb .entry-title,.posts-loop.layout-3cols .entry-title' );


			$single_post_header_alignment = get_theme_mod( 'single_post_header_alignment', 'left' );
			$css .= '.single-post .entry-header { text-align:' . esc_attr( $single_post_header_alignment ) . ';}' . "\n";	

			$single_page_header_alignment = get_theme_mod( 'single_page_header_alignment', 'left' );
			$css .= '.page .entry-header { text-align:' . esc_attr( $single_page_header_alignment ) . ';}' . "\n";	

			$css .= $this->get_resp_font_sizes_css( 'single_post_title_size', $defaults = array( 'desktop' => 40, 'tablet' => 36, 'mobile' => 28 ), '.single-post .entry-title' );
			$css .= $this->get_color_css( 'single_post_title_color', '', '.single-post .entry-title' );

			$css = apply_filters( 'izo_custom_css_output', $css );

			wp_add_inline_style( 'izo-style-min', $css );	
		}

		/**
		 * Tablet breakpoint
		 */
		public static function get_tablet_breakpoint() {
			$breakpoint = '991';
			return apply_filters( 'izo_tablet_breakpoint', $breakpoint );
		}

		/**
		 * Mobile breakpoint
		 */
		public static function get_mobile_breakpoint() {
			$breakpoint = '575';
			return apply_filters( 'izo_mobile_breakpoint', $breakpoint );
		}	
		
		/**
		 * Get color CSS
		 */
		public static function get_color_css( $setting, $default, $selector ) {
			$mod = get_theme_mod( $setting, $default );

			return $selector . '{ color:' . esc_attr( $mod ) . ';}' . "\n";
		}

		/**
		 * Get responsive font sizes
		 */
		public static function get_resp_font_sizes_css( $setting, $defaults = array(), $selector ) {
			$devices 	= array( 
				'desktop' 	=> '@media (min-width:  ' . ( self::get_tablet_breakpoint() + 1 ) . 'px)',
				'tablet'	=> '@media (min-width:  ' . ( self::get_mobile_breakpoint() + 1 ) . 'px) and (max-width:  '. self::get_tablet_breakpoint() . 'px)',
				'mobile'	=> '@media (max-width:  ' . self::get_mobile_breakpoint() . 'px)'
			);

			$css = '';

			foreach ( $devices as $device => $media ) {
				$mod = get_theme_mod( $setting . '_' . $device, $defaults[$device] );
				$css .= $media . ' { ' . $selector . ' { font-size:' . intval( $mod ) . 'px;} }' . "\n";	
			}

			return $css;
		}		

		/**
		 * Get background color CSS
		 */
		public static function get_background_color_css( $setting, $default, $selector ) {
			$mod = get_theme_mod( $setting, $default );

			return $selector . '{ background-color:' . esc_attr( $mod ) . ';}' . "\n";
		}

		/**
		 * Get border color CSS
		 */
		public static function get_border_color_css( $setting, $default, $selector ) {
			$mod = get_theme_mod( $setting, $default );

			return $selector . '{ border-color:' . esc_attr( $mod ) . ';}' . "\n";
		}	
		
		/**
		 * Get fill color CSS
		 */
		public static function get_fill_color_css( $setting, $default, $selector ) {
			$mod = get_theme_mod( $setting, $default );

			return $selector . '{ fill:' . esc_attr( $mod ) . ';}' . "\n";
		}		
	}

	/**
	 * Initialize class
	 */
	Izo_Custom_CSS::get_instance();

endif;