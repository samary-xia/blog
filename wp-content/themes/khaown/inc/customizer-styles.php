<?php
/**
 * khaown: Color Patterns
 *
 * @package WordPress
 * @subpackage khaown
 * @since 1.0
 */

/**
 * Generate the CSS for the current primary color.
 */
function khaown_customizer_css() {

	$primary_color = 0;
	if ( "default" !== get_theme_mod( "primary_color", "default" ) ) {
		$primary_color = absint( get_theme_mod( "primary_color_hue", 0 ) );
	}

	/**
	 * Filter khaown default saturation level.
	 *
	 * @since khaown 1.0
	 *
	 * @param int $saturation Color saturation level.
	 */
	$saturation = apply_filters( "khaown_custom_colors_saturation", 100 );
	$saturation = absint( $saturation ) . "%";

	/**
	 * Filter khaown default selection saturation level.
	 *
	 * @since khaown 1.0
	 *
	 * @param int $saturation_selection Selection color saturation level.
	 */
	$saturation_selection = absint( apply_filters( "khaown_custom_colors_saturation_selection", 50 ) );
	$saturation_selection = $saturation_selection . "%";

	/**
	 * Filter khaown default lightness level.
	 *
	 * @since khaown 1.0
	 *
	 * @param int $lightness Color lightness level.
	 */
	$lightness = apply_filters( "khaown_custom_colors_lightness", 33 );
	$lightness = absint( $lightness ) . "%";

	/**
	 * Filter khaown default hover lightness level.
	 *
	 * @since khaown 1.0
	 *
	 * @param int $lightness_hover Hover color lightness level.
	 */
	$lightness_hover = apply_filters( "khaown_custom_colors_lightness_hover", 60 );
	$lightness_hover = absint( $lightness_hover ) . "%";

	/**
	 * Filter khaown default selection lightness level.
	 *
	 * @since khaown 1.0
	 *
	 * @param int $lightness_selection Selection color lightness level.
	 */
	$lightness_selection = apply_filters( "khaown_custom_colors_lightness_selection", 90 );
	$lightness_selection = absint( $lightness_selection ) . "%";

	$font_Choice = get_theme_mod("default_or_customfont", "default_font");

	$flat_or_deep_design = get_theme_mod("flat_or_deep_design", "deep_design");

	$border_design = get_theme_mod("border_design", "border_none");

	$theme_css = '';

	if( $flat_or_deep_design === "flat_design") : 
		
		$theme_css .= " 
	
		.blog-posts .row .bg-color-blog-posts {
			background: " . esc_attr(get_theme_mod("sidebar_background_color", "#f8f8f8")) . ";
			border-radius: 0px;
			box-shadow: 0;
		}
	";
	endif;

	if( $flat_or_deep_design === "deep_design") : 
		
		$theme_css .= " 
	
		.blog-posts .row .bg-color-blog-posts {
			background: #ffffff;
			border-radius: 5px;
			transition: all .4s;
			box-shadow: 0 1px 3px 0 rgba(0,0,0,.2), 0 1px 1px 0 rgba(0,0,0,.14), 0 2px 1px -1px rgba(0,0,0,.12);
		}
		.blog-posts .row .bg-color-blog-posts:hover {
			box-shadow: 0 3px 3px 1px rgba(0,0,0,.2), 0 3px 4px 0 rgba(0,0,0,.14), 0 1px 8px 0 rgba(0,0,0,.12);
			transition: all .4s;
		}
		header nav, header .menu > li ul {
			box-shadow: 0 1px 3px 0 rgba(0,0,0,.2), 0 1px 1px 0 rgba(0,0,0,.14), 0 2px 1px -1px rgba(0,0,0,.12);
		}
	";
	endif;

	if( $border_design === "has_border") : 
		
		$theme_css .= " 
		.feature.bordered {
			border: 1px solid #ccc;
		}
	";
	endif;

	if( $border_design === "border_none") : 
		
		$theme_css .= " 
		.feature.bordered {
			border: 0;
		}
		  
	";
	endif;

	$theme_css .= "

		body {
			background-color: " .  esc_attr(get_theme_mod("bg_color_scheme_1", "#ffffff")) . ";
		}
		p, .row p, span, button, .btn, .blog-posts .row p {
			font-size: " .  esc_attr(get_theme_mod("paragraph_font_size", "16")) . "px;
			font-weight: " .  esc_attr(get_theme_mod("paragraph_font_weight", "400")) . ";
			font-style: " .  esc_attr(get_theme_mod("paragraph_font_style", "normal")) . ";
			text-transform: " .  esc_attr(get_theme_mod("paragraph_text_transform", "none")) . ";
			line-height: " .  esc_attr(get_theme_mod("paragraph_line_height", "32")) . "px;
			letter-spacing: " .  esc_attr(get_theme_mod("paragraph_letter_spacing", "0")) . "px;
			word-spacing: " .  esc_attr(get_theme_mod("paragraph_word_spacing", "0")) . "px;
			color: " .  esc_attr(get_theme_mod("text_color", "#545454")) . ";
		}
		a, .widget a {
			font-size: " .  esc_attr(get_theme_mod("paragraph_font_size", "16")) . "px;
			font-weight: " .  esc_attr(get_theme_mod("paragraph_font_weight", "400")) . ";
			color: " .  esc_attr(get_theme_mod("link_color", "#545454")) . ";
			font-style: " .  esc_attr(get_theme_mod("paragraph_font_style", "normal")) . ";
			line-height: " .  esc_attr(get_theme_mod("paragraph_line_height", "32")) . "px;
			letter-spacing: " .  esc_attr(get_theme_mod("paragraph_letter_spacing", "0")) . "px;
			word-spacing: " .  esc_attr(get_theme_mod("paragraph_word_spacing", "0")) . "px;
		}
		svg.svg-icon {
			fill: " .  esc_attr(get_theme_mod("hover_link_color", "#a0a0a0")) . ";
		}

		a:hover, a:visited, a:active, .widget a:hover, .post-navigation .nav-links a:hover, .entry .entry-meta a:hover, .entry .entry-footer a:hover {
			color: " .  esc_attr(get_theme_mod("hover_link_color", "#a0a0a0")) . ";
		}

		h1, h2, h3, h4, h5, h6, p, ul, ol, pre, table, blockquote, input, button, select, textarea, .blog-posts .row p, span, button, .btn {
			font-style: " .  esc_attr(get_theme_mod("paragraph_font_style", "normal")) . ";
		}

		h1, h2, h3, h4, h5, h6 {		
			font-weight: " .  esc_attr(get_theme_mod("heading_1_font_weight", "400")) . ";
			letter-spacing: " .  esc_attr(get_theme_mod("heading_1_letter_spacing", "1")) . "px;
			text-transform: " .  esc_attr(get_theme_mod("heading_1_text_case", "uppercase")) . ";
			color: " .  esc_attr(get_theme_mod("heading_text_color", "#7a7a7a")) . ";
			word-spacing: " .  esc_attr(get_theme_mod("heading_wordspecing_spacing", "0")) . "px;
		}
		h1 {
			font-size: " .  esc_attr(get_theme_mod("heading_1_font_size", "28")) . "px;
			line-height: " .  esc_attr(get_theme_mod("heading_1_line_height", "36")) . "px;
		}
		h2, .widget h2.widget-title {
			font-size: " .  esc_attr(get_theme_mod("heading_h2_font_size", "24")) . "px;
			line-height: " .  esc_attr(get_theme_mod("heading_h2_line_height", "32")) . "px;
		}

		.blog-posts .row .bg-color-blog-posts {
			border-radius: " .  esc_attr(get_theme_mod("border_radius", "5")) . "px;
			background: " .  esc_attr(get_theme_mod("sidebar_background_color", "#fff")) . ";
		}



		.bg-menu-4 {
			background-color: " .  esc_attr(get_theme_mod("homepage_header_bg_color", "#8224e3")) . ";
		}
		.page-title h1.khaown-site-title a {
			color: " .  esc_attr(get_theme_mod("top_header_site_tile_color", "#ffffff")) . ";
			font-size: " .  esc_attr(get_theme_mod("site_title_font_size", "32")) . "px;
			font-weight: " .  esc_attr(get_theme_mod("site_title_font_weight", "500")) . ";
		  }
		.page-title h1.khaown-site-title {
			font-size: " .  esc_attr(get_theme_mod("site_title_font_size", "32")) . "px;
			font-weight: " .  esc_attr(get_theme_mod("site_title_font_weight", "500")) . ";
			margin-bottom: " .  esc_attr(get_theme_mod("site_title_margin_bottom", "5")) . "px;
			color: " .  esc_attr(get_theme_mod("top_header_site_tile_color", "#ffffff")) . ";
		}
		p.khaown-site-description {
			color: " .  esc_attr(get_theme_mod("top_header_site_desc_color", "#ffffff")) . ";
			font-size: " .  esc_attr(get_theme_mod("site_desc_font_size", "15")) . "px;
		}

		nav, .menu > li ul {
			background: " .  esc_attr(get_theme_mod("nav_bar_bg_color", "#ffffff")) . ";
		}
		nav .menu ul li span {
			color: " .  esc_attr(get_theme_mod("nav_bar_text_color", "#000000")) . ";
			font-size: " .  esc_attr(get_theme_mod("nav_bar_font_size", "15")) . "px;
			font-weight: " .  esc_attr(get_theme_mod("nav_bar_font_weight", "500")) . ";
		}
		.menu > li {
			margin-right: " .  esc_attr(get_theme_mod("nav_bar_margin_right", "15")) . "px;
		}



		
		.blog-posts article:nth-child(3n-1) .bg-color-blog-posts {
			background: " .  esc_attr(get_theme_mod("veriant_posts_background_color", "#8224e3")) . " !important;
		}
		input[type='submit'], button[type='submit'], .em_comment input#submit {
			border: 0px solid " .  esc_attr(get_theme_mod("button_bg_color", "#292929")) . ";
			background: " .  esc_attr(get_theme_mod("button_bg_color", "")) . ";
		}

		.blog-posts article:nth-child(3n-1) .row p, .blog-posts article:nth-child(3n-1) .row h1 {
			color: " .  esc_attr(get_theme_mod("veriant_posts_text_color", "#ffffff")) . ";
		}

		.site-branding {
			margin: 0;
			line-height: inherit;
		}
		.social-accounts a {
			color: " .  esc_attr(get_theme_mod("social_media_icon_color", "#a0a0a0")) . ";
			font-size: " .  esc_attr(get_theme_mod("social_icon_font_size", "14")) . "px;
			padding: 5px;
		}
		.social-accounts a:hover {
			color: " .  esc_attr(get_theme_mod("social_media_icon_hover_color", "#0073aa")) . ";
		}

		section.restaurant-schedule {
			background-color: " .  esc_attr(get_theme_mod("schedule_bg_color", "#7774B3")) . ";
		}
		section.restaurant-schedule strong, section.restaurant-schedule span, section.restaurant-schedule h3 {
			color: " .  esc_attr(get_theme_mod("schedule_text_color", "#292929")) . ";
		}

		.btn, .em_comment input#submit, input[type='submit'], button {
			background-color: " .  esc_attr(get_theme_mod("khaown_btn_bg_color", "#000000")) . ";
			color: " .  esc_attr(get_theme_mod("khaown_btn_text_color", "#ffffff")) . ";
		}
		.btn:hover, .em_comment input#submit:hover,
		input[type='submit']:hover, button:hover {
			background-color: " .  esc_attr(get_theme_mod("khaown_btn_hover_bg_color", "#010101")) . ";
			color: " .  esc_attr(get_theme_mod("khaown_btn_hover_text_color", "#f9f9f9")) . ";
		}

		
		@media all and (max-width: 990px) {
			.khaown-btn-style {
				background-color: " .  esc_attr(get_theme_mod("khaown_btn_bg_color", "#000000")) . ";
				color: " .  esc_attr(get_theme_mod("khaown_btn_text_color", "#ffffff")) . ";
			}
			.khaown-btn-style:hover {
				background-color: " .  esc_attr(get_theme_mod("khaown_btn_hover_bg_color", "#010101")) . ";
				color: " .  esc_attr(get_theme_mod("khaown_btn_hover_text_color", "#f9f9f9")) . ";
			}

		}

		
		";

	$editor_css = "
		/*
		 * Set colors for:
		 * - links
		 * - blockquote
		 * - pullquote (solid color)
		 * - buttons
		 */
		.editor-block-list__layout .editor-block-list__block a,
		.editor-block-list__layout .editor-block-list__block .wp-block-button.is-style-outline .wp-block-button__link:not(.has-text-color),
		.editor-block-list__layout .editor-block-list__block .wp-block-button.is-style-outline:hover .wp-block-button__link:not(.has-text-color),
		.editor-block-list__layout .editor-block-list__block .wp-block-button.is-style-outline:focus .wp-block-button__link:not(.has-text-color),
		.editor-block-list__layout .editor-block-list__block .wp-block-button.is-style-outline:active .wp-block-button__link:not(.has-text-color),
		.editor-block-list__layout .editor-block-list__block .wp-block-file .wp-block-file__textlink {
			color: hsl( " . $primary_color . ", " . $saturation . ", " . $lightness . " ); /* base: #0073a8; */
		}

		.editor-block-list__layout .editor-block-list__block .wp-block-quote:not(.is-large):not(.is-style-large),
		.editor-styles-wrapper .editor-block-list__layout .wp-block-freeform blockquote {
			border-color: hsl( " . $primary_color . ", " . $saturation . ", " . $lightness . " ); /* base: #0073a8; */
		}

		.editor-block-list__layout .editor-block-list__block .wp-block-pullquote.is-style-solid-color:not(.has-background-color) {
			background-color: hsl( " . $primary_color . ", " . $saturation . ", " . $lightness . " ); /* base: #0073a8; */
		}

		.editor-block-list__layout .editor-block-list__block .wp-block-file .wp-block-file__button,
		.editor-block-list__layout .editor-block-list__block .wp-block-button:not(.is-style-outline) .wp-block-button__link,
		.editor-block-list__layout .editor-block-list__block .wp-block-button:not(.is-style-outline) .wp-block-button__link:active,
		.editor-block-list__layout .editor-block-list__block .wp-block-button:not(.is-style-outline) .wp-block-button__link:focus,
		.editor-block-list__layout .editor-block-list__block .wp-block-button:not(.is-style-outline) .wp-block-button__link:hover {
			background-color: hsl( " . $primary_color . ", " . $saturation . ", " . $lightness . " ); /* base: #0073a8; */
		}

		/* Hover colors */
		.editor-block-list__layout .editor-block-list__block a:hover,
		.editor-block-list__layout .editor-block-list__block a:active,
		.editor-block-list__layout .editor-block-list__block .wp-block-file .wp-block-file__textlink:hover {
			color: hsl( " . $primary_color . ", " . $saturation . ", " . $lightness_hover . " ); /* base: #005177; */
		}

		/* Do not overwrite solid color pullquote or cover links */
		.editor-block-list__layout .editor-block-list__block .wp-block-pullquote.is-style-solid-color a,
		.editor-block-list__layout .editor-block-list__block .wp-block-cover a {
			color: inherit;
		}
		";

	if ( function_exists( "register_block_type" ) && is_admin() ) {
		$theme_css = $editor_css;
	}

	/**
	 * Filters khaown custom colors CSS.
	 *
	 * @since khaown 1.0
	 *
	 * @param string $css           Base theme colors CSS.
	 * @param int    $primary_color The user"s selected color hue.
	 * @param string $saturation    Filtered theme color saturation level.
	 */
	return apply_filters( "khaown_customizer_css", $theme_css, $primary_color, $saturation );
}