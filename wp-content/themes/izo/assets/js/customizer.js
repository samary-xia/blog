/* global wp, jQuery */
/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute',
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					clip: 'auto',
					position: 'relative',
				} );
				$( '.site-title a, .site-description' ).css( {
					color: to,
				} );
			}
		} );
	} );


	//Header
	wp.customize( 'top_bar_background_color', function( value ) {
		value.bind( function( to ) {
			$( '.top-header-bar:not(.is-merged)' ).css( 'background-color', to );
		} );
	} );

	wp.customize( 'bottom_bar_background_color', function( value ) {
		value.bind( function( to ) {
			$( '.bottom-header-bar:not(.is-merged)' ).css( 'background-color', to );
		} );
	} );	


	//Responsive font sizes
	//Control: control_name
	//Settings: control_name_{{device}}
	$fontSizes 	= { "loop_product_price_size": "ul.products li.product .price","loop_product_title_size": "ul.products li.product .woocommerce-loop-product__title","single_product_price_size": ".single-product-top .price","single_product_title_size": ".single-product-top .entry-title","single_page_title_size": ".page .entry-header .entry-title", "single_post_title_size": ".single-post .entry-title", "h1_heading_font_size": "h1,.site-title","h2_heading_font_size": "h2","h3_heading_font_size": "h3","h4_heading_font_size": "h4","h5_heading_font_size": "h5","h6_heading_font_size": "h6", "body_font_size": "body", "archive_title_large_size": ".posts-loop.layout-default .entry-title", "archive_title_small_size": ".posts-loop.layout-2colssb .entry-title, .posts-loop.layout-3cols .entry-title" };
	$devices 	= { "desktop": "(min-width: 992px)", "tablet": "(min-width: 576px) and (max-width: 991px)", "mobile": "(max-width: 575px)" };
	$.each( $fontSizes, function( option, selector ) {
		$.each( $devices, function( device, mediaSize ) {
			wp.customize( option + '_' + device, function( value ) {
				value.bind( function( to ) {
				
					$( 'head' ).find( '#izo-preview-styles-' + option + '_' + device ).remove();
		
					var output = '@media ' + mediaSize + ' {' + selector + ' { font-size:' + to + 'px; } }';
		
					$( 'head' ).append( '<style id="izo-preview-styles-' + option + '_' + device + '">' + output + '</style>' );
				} );
			} );
		});
	});

	//accent color
	wp.customize( 'accent_color', function( value ) {
		value.bind( function( to ) {
		
			$( 'head' ).find( '#izo-preview-styles-accent-color' ).remove();

			var output = 	'.backtotop,.widget_search .search-form::after,.woocommerce-pagination li .page-numbers:hover, .woocommerce-pagination li .page-numbers.current,.navigation.pagination .page-numbers:hover, .navigation.pagination .page-numbers.current,.menu-last-item .header-search-toggle.stacked,button,.button,.wp-block-button__link,input[type="button"],input[type="reset"],input[type="submit"],.wpforms-form button[type=submit],div.wpforms-container-full .wpforms-form button[type=submit],div.nf-form-content input[type=button] { background-color:' + to + '; } '
							+ '.widget a:hover,.read-more:hover,.entry-meta a:hover,.entry-footer a:hover,article .entry-title a:hover,.comment-navigation a:hover,.posts-navigation a:hover,.post-navigation a:hover,.top-navigation ul a:hover,.main-navigation a:hover,.is-style-outline .wp-block-button__link,.wp-block-button__link.is-style-outline, .page.woocommerce-account .woocommerce-MyAccount-navigation ul li a:hover { color:' + to + '; } '
							+ '.header-social .izo-icon:hover,.header-contact .izo-icon { fill:' + to + '; } '
							+ '.is-style-outline .wp-block-button__link,.wp-block-button__link.is-style-outline,button,.button,.wp-block-button__link,input[type="button"],input[type="reset"],input[type="submit"],.wpforms-form button[type=submit],div.wpforms-container-full .wpforms-form button[type=submit],div.nf-form-content input[type=button] { border-color:' + to + '; }';

			$( 'head' ).append( '<style id="izo-preview-styles-accent-color">' + output + '</style>' );

		} );
	} );	


	//Color options
	$color_options = { "headings_color":"h1,h2,h3,h4,h5,h6", "content_link_color":".entry-content a:not(.button)", "body_color":"body", "submenu_items_color":".main-navigation ul ul a", "menu_items_color":".main-navigation > div > ul > li > a","site_title_color":".site-title a","site_desc_color":".site-description","top_header_nav_color":".top-navigation ul a","top_header_text_color":".top-header-bar .header-custom-text","global_button_color": ".elementor-button-wrapper .elementor-button,button,.button,.wp-block-button__link,input[type=\"button\"],input[type=\"reset\"],input[type=\"submit\"],.wpforms-form button[type=submit],div.wpforms-container-full .wpforms-form button[type=submit],div.nf-form-content input[type=button]","loop_product_price_color": "ul.products li.product .price","loop_product_title_color": "ul.products li.product .woocommerce-loop-product__title","single_product_price_color": ".single-product-top .price","single_product_title_color": ".single-product-top .entry-title", "single_page_title_color": ".page .entry-header .entry-title", "single_post_title_color": ".single-post .entry-title", "page_banner_color": ".page .page-banner .entry-title", "post_banner_color": ".single-post .page-banner .entry-title, .single-post .page-banner .entry-meta, .single-post .page-banner .entry-meta a", "mobile_menu_items_color": "#mobile-menu, #mobile-menu a", "footer_widgets_title_color": ".footer-widgets .widget-title", "footer_widgets_links_color": ".footer-widgets a", "footer_widgets_color": ".footer-widgets", "footer_bottom_color": ".site-info, .site-info a", "main_header_button_color": ".menu-last-item .button", "main_header_text_color": ".main-header-text, .main-header-text a", "header_search_color": ".header-search-toggle.default", "header_contact_color": ".header-contact a", "top_bar_color_transp": ".top-header-bar.is-merged, .top-header-bar.is-merged a", "bottom_bar_color_transp": ".bottom-header-bar.is-merged, .bottom-header-bar.is-merged .site-description, .bottom-header-bar.is-merged a:not(.button)" }; //"option": "selector"
	
	$.each( $color_options, function( option, selector ) {
		wp.customize( option, function( value ) {
			value.bind( function( to ) {
				$( selector ).css( 'color', to );
			} );
		} );
	});

	$bg_color_options = { "submenu_items_background":".main-navigation ul ul li","global_button_background": ".elementor-button-wrapper .elementor-button,button,.button,.wp-block-button__link,input[type=\"button\"],input[type=\"reset\"],input[type=\"submit\"],.wpforms-form button[type=submit],div.wpforms-container-full .wpforms-form button[type=submit],div.nf-form-content input[type=button]", "page_banner_background_color": ".page .page-banner", "post_banner_background_color": ".single-post .page-banner", "mobile_menu_background_color": "#mobile-menu","footer_widgets_background": ".footer-widgets", "footer_bottom_background": ".site-info", "main_header_button_background_hover": ".menu-last-item .button:hover", "main_header_button_background": ".menu-last-item .button", "header_search_color": ".header-search-toggle.stacked", "top_bar_background_color_transp": ".top-header-bar.is-merged", "bottom_bar_background_color_transp": ".bottom-header-bar.is-merged" }; //"option": "selector"

	$.each( $bg_color_options, function( option, selector ) {
		wp.customize( option, function( value ) {
			value.bind( function( to ) {
				$( selector ).css( 'background-color', to );
			} );
		} );
	});

	//background hover
	$bg_hover_options = { "global_button_background_hover": ".elementor-button-wrapper .elementor-button:hover,button:hover,.button:hover,.wp-block-button__link:hover,input[type=\"button\"]:hover,input[type=\"reset\"]:hover,input[type=\"submit\"]:hover,.wpforms-form button[type=submit]:hover,div.wpforms-container-full .wpforms-form button[type=submit]:hover,div.nf-form-content input[type=button]:hover","main_header_button_background_hover": ".menu-last-item .button:hover" };

	$.each( $bg_hover_options, function( option, selector ) {
		wp.customize( option, function( value ) {
			value.bind( function( to ) {
		
				$( 'head' ).find( '#izo-preview-styles-' + option ).remove();
	
				var output = selector + ' { background-color:' + to + '!important; }';
	
				$( 'head' ).append( '<style id="izo-preview-styles-' + option + '">' + output + '</style>' );
	
			} );
		} );
	});	

	//color hover
	$color_hover_options = { "content_link_color_hover":".entry-content a:not(.button):hover","submenu_items_color_hover":".main-navigation ul ul a:hover","menu_items_color_hover":".main-navigation > div > ul > li > a:hover","top_header_nav_color_hover":".top-navigation ul a:hover","global_button_color_hover": ".elementor-button-wrapper .elementor-button:hover,button:hover,.button:hover,.wp-block-button__link:hover,input[type=\"button\"]:hover,input[type=\"reset\"]:hover,input[type=\"submit\"]:hover,.wpforms-form button[type=submit]:hover,div.wpforms-container-full .wpforms-form button[type=submit]:hover,div.nf-form-content input[type=button]:hover","main_header_button_color_hover": ".menu-last-item .button:hover" };

	$.each( $color_hover_options, function( option, selector ) {
		wp.customize( option, function( value ) {
			value.bind( function( to ) {
		
				$( 'head' ).find( '#izo-preview-styles-' + option ).remove();
	
				var output = selector + ' { color:' + to + '!important; }';
	
				$( 'head' ).append( '<style id="izo-preview-styles-' + option + '">' + output + '</style>' );
	
			} );
		} );
	});	

	//fill
	$fill_options = { "bottom_bar_color_transp":".is-merged.bottom-header-bar .menu-last-item .izo-icon","menu_items_color":".menu-last-item .izo-icon","top_header_social_color":".top-header-bar .header-social .izo-icon","top_header_wc_icons_color":".top-header-bar .woocommerce-links .izo-icon","post_banner_color": ".single-post .page-banner .entry-meta .izo-icon" };

	$.each( $fill_options, function( option, selector ) {
		wp.customize( option, function( value ) {
			value.bind( function( to ) {
				$( selector ).css( 'fill', to );
			} );
		} );
	});	
	
	//border colors
	$border_color_options = { "footer_widgets_border_color": ".footer-widgets" };

	$.each( $border_color_options, function( option, selector ) {
		wp.customize( option, function( value ) {
			value.bind( function( to ) {
				$( selector ).css( 'border-color', to );
			} );
		} );
	});		

	//border color hover
	$border_color_hover_options = { "main_header_button_background_hover": ".menu-last-item .button:hover" };

	$.each( $border_color_hover_options, function( option, selector ) {
		wp.customize( option, function( value ) {
			value.bind( function( to ) {
		
				$( 'head' ).find( '#izo-preview-styles-' + option ).remove();
	
				var output = selector + ' { border-color:' + to + '!important; }';
	
				$( 'head' ).append( '<style id="izo-preview-styles-' + option + '">' + output + '</style>' );
	
			} );
		} );
	});	

	

	//Sidebar
	wp.customize( 'sidebar_width', function( value ) {
		value.bind( function( to ) {
			$( '.izo-container.has-sidebar' ).css( 'grid-template-columns', 'auto ' + to + '%' );
		} );
	} );

	//line heights
	$line_height_options = { "body_line_height": "body", "h1_heading_line_height": "h1","h2_heading_line_height": "h2","h3_heading_line_height": "h3","h4_heading_line_height": "h4","h5_heading_line_height": "h5","h6_heading_line_height": "h6", "headings_line_height": "h1,h2,h3,h4,h5,h6,.site-title" };

	$.each( $line_height_options, function( option, selector ) {
		wp.customize( option, function( value ) {
			value.bind( function( to ) {
				$( selector ).css( 'line-height', to );
			} );
		} );
	});	
	
	//letter spacing
	$letter_spacing_options = { "body_letter_spacing": "body", "headings_letter_spacing": "h1,h2,h3,h4,h5,h6,.site-title", "h1_letter_spacing": "h1","h2_letter_spacing": "h2","h3_letter_spacing": "h3","h4_letter_spacing": "h4","h5_letter_spacing": "h5","h6_letter_spacing": "h6" };

	$.each( $letter_spacing_options, function( option, selector ) {
		wp.customize( option, function( value ) {
			value.bind( function( to ) {
				$( selector ).css( 'letter-spacing', to + 'px');
			} );
		} );
	});	

}( jQuery ) );
