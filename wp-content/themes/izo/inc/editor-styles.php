<?php

/**
 * Gutenberg support
 */

function izo_editor_styles() {

	wp_enqueue_style( 'izo-fonts', izo_generate_fonts_url(), array(), IZO_VERSION );


	$css = '';

	/**
	 * Fonts
	 */		
	$defaults 	= json_encode(
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
		$css .= 'div.editor-styles-wrapper { font-family:' . esc_attr( $body_font['font'] ) . ',' . esc_attr( $body_font['category'] ) . ';}' . "\n";	
		$css .= 'div.editor-styles-wrapper { font-weight:' . esc_attr( $body_font['regularweight'] ) . ';}' . "\n";	
	}

	$css .= Izo_Custom_CSS::get_resp_font_sizes_css( 'body_font_size', $defaults = array( 'desktop' => 16, 'tablet' => 16, 'mobile' => 16 ), 'div.editor-styles-wrapper' );

	if ( 'System default' !== $headings_font['font'] ) {
		$css .= 'div.editor-styles-wrapper .editor-post-title .editor-post-title__input, div.editor-styles-wrapper h1,div.editor-styles-wrapper h2,div.editor-styles-wrapper h3,div.editor-styles-wrapper h4,div.editor-styles-wrapper h5,div.editor-styles-wrapper h6{ font-family:' . esc_attr( $headings_font['font'] ) . ',' . esc_attr( $headings_font['category'] ) . ';}' . "\n";	
		$css .= 'div.editor-styles-wrapper .editor-post-title .editor-post-title__input, div.editor-styles-wrapper h1,div.editor-styles-wrapper h2,div.editor-styles-wrapper h3,div.editor-styles-wrapper h4,div.editor-styles-wrapper h5,div.editor-styles-wrapper h6 { font-weight:' . esc_attr( $headings_font['boldweight'] ) . ';}' . "\n";	
	}	

	$css .= Izo_Custom_CSS::get_resp_font_sizes_css( 'h1_heading_font_size', $defaults = array( 'desktop' => 40, 'tablet' => 36, 'mobile' => 28 ), 'div.editor-styles-wrapper .editor-post-title .editor-post-title__input, div.editor-styles-wrapper h1' );
	$css .= Izo_Custom_CSS::get_resp_font_sizes_css( 'h2_heading_font_size', $defaults = array( 'desktop' => 32, 'tablet' => 28, 'mobile' => 22 ), 'div.editor-styles-wrapper h2' );
	$css .= Izo_Custom_CSS::get_resp_font_sizes_css( 'h3_heading_font_size', $defaults = array( 'desktop' => 28, 'tablet' => 24, 'mobile' => 18 ), 'div.editor-styles-wrapper h3' );
	$css .= Izo_Custom_CSS::get_resp_font_sizes_css( 'h4_heading_font_size', $defaults = array( 'desktop' => 24, 'tablet' => 20, 'mobile' => 16 ), 'div.editor-styles-wrapper h4' );
	$css .= Izo_Custom_CSS::get_resp_font_sizes_css( 'h5_heading_font_size', $defaults = array( 'desktop' => 20, 'tablet' => 16, 'mobile' => 16 ), 'div.editor-styles-wrapper h5' );
	$css .= Izo_Custom_CSS::get_resp_font_sizes_css( 'h6_heading_font_size', $defaults = array( 'desktop' => 16, 'tablet' => 16, 'mobile' => 16 ), 'div.editor-styles-wrapper h6' );

	/**
	 * Buttons
	 */
	$css .= Izo_Custom_CSS::get_background_color_css( 'global_button_background', '#ea285e', '.wp-block button:not(.components-button),.wp-block .button:not(.components-button),.wp-block-button__link,.wp-block input[type="button"],.wp-block input[type="reset"],.wp-block input[type="submit"]');
	$css .= Izo_Custom_CSS::get_background_color_css( 'global_button_background_hover', '#b6113f', '.wp-block button:not(.components-button):hover,.wp-block .button:not(.components-button):hover,.wp-block-button__link:hover,.wp-block input[type="button"]:hover,.wp-block input[type="reset"]:hover,.wp-block input[type="submit"]:hover');
	$css .= Izo_Custom_CSS::get_color_css( 'global_button_color', '#ffffff', '.wp-block button:not(.components-button),.wp-block .button:not(.components-button),.wp-block-button__link,.wp-block input[type="button"],.wp-block input[type="reset"],.wp-block input[type="submit"]');
	$css .= Izo_Custom_CSS::get_color_css( 'global_button_color_hover', '#ffffff', '.wp-block button:not(.components-button):hover,.wp-block .button:not(.components-button):hover,.wp-block-button__link:hover,.wp-block input[type="button"]:hover,.wp-block input[type="reset"]:hover,.wp-block input[type="submit"]:hover');
	$css .= Izo_Custom_CSS::get_border_color_css( 'accent_color', '#ea285e', '.is-style-outline .wp-block-button__link,.wp-block-button__link.is-style-outline,button,.button,.wp-block-button__link,input[type="button"],input[type="reset"],input[type="submit"],.wpforms-form button[type=submit],div.wpforms-container-full .wpforms-form button[type=submit],div.nf-form-content input[type=button]');

	wp_add_inline_style( 'izo-block-editor-styles', $css );	

}
add_action( 'enqueue_block_editor_assets', 'izo_editor_styles' );