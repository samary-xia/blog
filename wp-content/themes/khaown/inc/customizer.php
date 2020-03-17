<?php
/**
 * khaown: Customizer
 *
 * @package WordPress
 * @subpackage khaown
 * @since 1.0.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function khaown_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.khaown-site-title',
				'render_callback' => 'khaown_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.khaown-site-description',
				'render_callback' => 'khaown_customize_partial_blogdescription',
			)
		);
	}


	/**
	 * Background color.
	 */
	// add the settings and controls for each color
	// main color ( site title, h1, h2, h4. h6, widget headings, nav links, footer headings )
	$bgcolors[] = array(
		'slug'			=>'bg_color_scheme_1', 
		'default' 		=> '#ffffff',
		'label' 		=> __('Body Background Color', 'khaown')
	);
	// link color
	$bgcolors[] = array(
		'slug'		=>'text_color', 
		'default' 	=> '#545454',
		'label' 	=> __('Text Color', 'khaown')
	);

	// link color
	$bgcolors[] = array(
		'slug'		=>'link_color', 
		'default' 	=> '#545454',
		'label' 	=> __('Link Color', 'khaown')
	);
	
	// link color ( hover, active )
	$bgcolors[] = array(
		'slug'		=>'hover_link_color', 
		'default' 	=> '#a0a0a0',
		'label' 	=> __('Link Color (on hover)', 'khaown')
	);

	foreach( $bgcolors as $txtcolor ) {
	
		// SETTINGS
		$wp_customize->add_setting(
			$txtcolor['slug'], array(
				'default' 				=> $txtcolor['default'],
				'type' 					=> 'theme_mod',
				'sanitize_callback'  	=> 'sanitize_hex_color'
			)
		);
		// CONTROLS
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$txtcolor['slug'], 
				array(
					'label' 		=> $txtcolor['label'], 
					'section' 		=> 'colors',
					'settings' 		=> $txtcolor['slug'])
			)
		);
	}

	/**************************************
	 * // Layout Design Section setup
	**************************************/
	
	$wp_customize->add_section('layout_design', array(
		'title'			=> __('Layout', 'khaown'),
		'description'	=> sprintf(__('Customize your layout desing', 'khaown') ),
		'priority' 		=> 41
	) );

	// flat_or_deep_design setting setup
	$wp_customize->add_setting('flat_or_deep_design', array(
		'default'			=> 'deep_design',
		'sanitize_callback' => 'khaown_sanitize_radio',
		'type' 				=> 'theme_mod'
	) );
	
	// flat_or_deep_design Control setup
	$wp_customize->add_control('flat_or_deep_design', array(
		'label'			=> __('Choose Design Type', 'khaown'),
		'type'			=> 'radio',
		'choices'   => array(
			'flat_design' => __( 'Flat Design', 'khaown' ),
			'deep_design' => __( 'Deep Design', 'khaown' )
		),
		'section' 		=> 'layout_design',
		'priority' 		=>  20
	) );
	// Border setting setup
	$wp_customize->add_setting('border_design', array(
		'default'			=> 'border_none',
		'sanitize_callback' => 'khaown_sanitize_radio',
		'type' 				=> 'theme_mod'
	) );
	
	// Border Control setup
	$wp_customize->add_control('border_design', array(
		'label'			=> __('Box Border', 'khaown'),
		'type'			=> 'radio',
		'choices'   => array(
			'has_border'  => __( 'Has Border', 'khaown' ),
			'border_none' => __( 'Border None', 'khaown' )
		),
		'section' 		=> 'layout_design',
		'priority' 		=>  20
	) );

	// Border Radius setting setup
	$wp_customize->add_setting('border_radius', array(
		'default'			=> '5',
		'sanitize_callback' => 'absint',
		'type' 				=> 'theme_mod'
	) );
	
	// Border Radius Control setup
	$wp_customize->add_control('border_radius', array(
		'label'			=> __('Border Radius', 'khaown'),
		'type'			=> 'number',
		'section' 		=> 'layout_design',
		'priority' 		=>  20
	) );

	// secondary color ( site description, sidebar headings, h3, h5, nav links on hover )
	$index_bgcolors[] = array(
		'slug'			=>'sidebar_background_color', 
		'default' 		=> '#fff',
		'label' 		=> __( 'Posts Background Color', 'khaown' )
	);

	// secondary color ( site description, sidebar headings, h3, h5, nav links on hover )
	$index_bgcolors[] = array(
		'slug'			=> 'veriant_posts_background_color', 
		'default' 		=> '#8224e3',
		'label' 		=> __( 'Veriant Posts Background Color', 'khaown' )
	);
	
	// secondary color ( site description, sidebar headings, h3, h5, nav links on hover )
	$index_bgcolors[] = array(
		'slug'			=> 'veriant_posts_text_color', 
		'default' 		=> '#ffffff',
		'label' 		=> __( 'Veriant Posts Text Color', 'khaown')
	);

	foreach( $index_bgcolors as $index_bg_color ) {
	
		// SETTINGS
		$wp_customize->add_setting(
			$index_bg_color['slug'], array(
				'default' 			=> $index_bg_color['default'],
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_hex_color'
			)
		);
		// CONTROLS
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$index_bg_color['slug'], 
				array('label' 		=> $index_bg_color['label'], 
				'section' 			=> 'layout_design',
				'priority' 			=>  20,
				'settings' 			=> $index_bg_color['slug'])
				
			)
		);
	}

	/**************************************
	 * Sidebar Layout setup
	**************************************/
	$wp_customize->add_panel('sidebar_layout_panel', array(
        'theme_supports' => '',
		'title'			=> __('Sidebar', 'khaown'),
		'description'	=> sprintf(__('Setup your theme Top header', 'khaown') ),
		'priority' 		=> 42
    ) );
	
	$wp_customize->add_section('blogpage_sidebar_layout', array(
		'title'			=> __('Blog Page Sidebar', 'khaown'),
		'panel'         => 'sidebar_layout_panel',
		'priority' 		=> 41
	) );

	// Blog page sidebar setting setup
	$wp_customize->add_setting('blog_page_sidebar_position', array(
		'default'			=> 'left-sidebar',
		'sanitize_callback' => 'khaown_sanitize_select',
		'type' 				=> 'theme_mod'
	) );
	
	// Blog page sidebar Control setup
	$wp_customize->add_control('blog_page_sidebar_position', array(
		'label'			=> __('Sidebar', 'khaown'),
		'section' 		=> 'blogpage_sidebar_layout',
		'type'			=> 'select',
		'choices'  => array(
			'no-sidebar' 		=> _x( 'No Sidebar', 'no-sidebar', 'khaown' ),
			'left-sidebar' 		=> _x( 'Left Sidebar', 'left-sidebar', 'khaown' ),
			'right-sidebar' 	=> _x( 'Right Sidebar', 'right-sidebar', 'khaown' ),
		),
		'priority' 		=>  20
	) );

	// Section search page sidebar
	$wp_customize->add_section('search_page_sidebar_layout', array(
		'title'			=> __('Search Page Sidebar', 'khaown'),
		'panel'         => 'sidebar_layout_panel',
		'priority' 		=> 41
	) );

	// Search page sidebar setting setup
	$wp_customize->add_setting('search_page_sidebar_position', array(
		'default'			=> 'no-sidebar',
		'sanitize_callback' => 'khaown_sanitize_select',
		'type' 				=> 'theme_mod'
	) );
	
	// Search page sidebar Control setup
	$wp_customize->add_control('search_page_sidebar_position', array(
		'label'			=> __('Sidebar', 'khaown'),
		'section' 		=> 'search_page_sidebar_layout',
		'type'			=> 'select',
		'choices'  => array(
			'no-sidebar' 		=> _x( 'No Sidebar', 'no-sidebar', 'khaown' ),
			'left-sidebar' 		=> _x( 'Left Sidebar', 'left-sidebar', 'khaown' ),
			'right-sidebar' 	=> _x( 'Right Sidebar', 'right-sidebar', 'khaown' ),
		),
		'priority' 		=>  20
	) );

	// Section archive page sidebar
	$wp_customize->add_section('archive_page_sidebar_layout', array(
		'title'			=> __('Archive Page Sidebar', 'khaown'),
		'panel'         => 'sidebar_layout_panel',
		'priority' 		=> 41
	) );

	// archive page sidebar setting setup
	$wp_customize->add_setting('archive_page_sidebar_position', array(
		'default'			=> 'no-sidebar',
		'sanitize_callback' => 'khaown_sanitize_select',
		'type' 				=> 'theme_mod'
	) );
	
	// archive page sidebar Control setup
	$wp_customize->add_control('archive_page_sidebar_position', array(
		'label'			=> __('Sidebar', 'khaown'),
		'section' 		=> 'archive_page_sidebar_layout',
		'type'			=> 'select',
		'choices'  => array(
			'no-sidebar' => _x( 'No Sidebar', 'no-sidebar', 'khaown' ),
			'left-sidebar' => _x( 'Left Sidebar', 'left-sidebar', 'khaown' ),
			'right-sidebar' => _x( 'Right Sidebar', 'right-sidebar', 'khaown' ),
		),
		'priority' 		=>  20
	) );

	/**************************************
	 * // Typography Section setup
	**************************************/
	
	$wp_customize->add_section('typography', array(
		'title'			=> __('Font CSS', 'khaown'),
		'description'	=> sprintf(__('Setup your theme font styles', 'khaown') ),
		'priority' 		=> 43
	) );

	// paragraph_font_style setting setup
	$wp_customize->add_setting('paragraph_font_style', array(
		'default'			=> 'normal',
		'sanitize_callback' => 'khaown_sanitize_select',
		'type' 				=> 'theme_mod'
	) );
	
	// paragraph_font_style Control setup
	$wp_customize->add_control('paragraph_font_style', array(
		'label'			=> __('Font Style', 'khaown'),
		'section' 		=> 'typography',
		'type'			=> 'select',
		'choices'  => array(
			'normal' 	=> _x( 'Normal', 'normal', 'khaown' ),
			'italic'  	=> _x( 'Italic', 'italic', 'khaown' )
		),
		'priority' 		=>  20
	) );

	// paragraph_text_transform setting setup
	$wp_customize->add_setting('paragraph_text_transform', array(
		'default'			=> 'none',
		'sanitize_callback' => 'khaown_sanitize_select',
		'type' 				=> 'theme_mod'
	) );
	
	// paragraph_text_transform Control setup
	$wp_customize->add_control('paragraph_text_transform', array(
		'label'			=> __('Text Transform', 'khaown'),
		'section' 		=> 'typography',
		'type'			=> 'select',
		'choices'  => array(
			'none' 			=> _x( 'Default', 'default', 'khaown' ),
			'uppercase' 	=> _x( 'Uppercase', 'uppercase', 'khaown' ),
			'lowercase'  	=> _x( 'Lowercase', 'lowercase', 'khaown' ),
			'capitalize'  	=> _x( 'Capitalize', 'capitalize', 'khaown' ),
		),
		'priority' 		=>  20
	) );

	// paragraph_font_size setting setup
	$wp_customize->add_setting('paragraph_font_size', array(
		'default'			=> '16',
		'sanitize_callback' => 'absint',
		'type' 				=> 'theme_mod'
	) );
	
	// paragraph_font_size Control setup
	$wp_customize->add_control('paragraph_font_size', array(
		'label'			=> __('Font Size', 'khaown'),
		'section' 		=> 'typography',
		'type'			=> 'number',
		'priority' 		=>  20
	) );

	// paragraph_font_weight setting setup
	$wp_customize->add_setting('paragraph_font_weight', array(
		'default'			=> '400',
		'sanitize_callback' => 'khaown_sanitize_select',
		'type' 				=> 'theme_mod'
	) );
	
	// paragraph_font_weight Control setup
	$wp_customize->add_control('paragraph_font_weight', array(
		'label'			=> __('Font Weight', 'khaown'),
		'section' 		=> 'typography',
		'type'			=> 'select',
		'choices'  => array(
			'100' => _x( '100', '100', 'khaown' ),
			'200'  => _x( '200', '200', 'khaown' ),
			'300'  => _x( '300', '300', 'khaown' ),
			'400' => _x( '400', '400', 'khaown' ),
			'500'  => _x( '500', '500', 'khaown' ),
			'600'  => _x( '600', '600', 'khaown' ),
			'700'  => _x( '700', '700', 'khaown' ),
		),
		'priority' 		=>  20
	) );

	// paragraph_line_height setting setup
	$wp_customize->add_setting('paragraph_line_height', array(
		'default'			=> '32',
		'sanitize_callback' => 'absint',
		'type' 				=> 'theme_mod'
	) );
	
	// paragraph_line_height Control setup
	$wp_customize->add_control('paragraph_line_height', array(
		'label'			=> __('Line Height', 'khaown'),
		'section' 		=> 'typography',
		'type'			=> 'number',
		'priority' 		=>  20
	) );

	// paragraph_letter_spacing setting setup
	$wp_customize->add_setting('paragraph_letter_spacing', array(
		'default'			=> '0',
		'sanitize_callback'  => 'absint',
		'type' 				=> 'theme_mod'
	) );
	
	// paragraph_letter_spacing Control setup
	$wp_customize->add_control('paragraph_letter_spacing', array(
		'label'			=> __('Letter Spacing', 'khaown'),
		'section' 		=> 'typography',
		'type'			=> 'number',
		'priority' 		=>  20
	) );

	// paragraph_word_spacing setting setup
	$wp_customize->add_setting('paragraph_word_spacing', array(
		'default'			=> '0',
		'sanitize_callback' => 'absint',
		'type' 				=> 'theme_mod'
	) );
	
	// paragraph_word_spacing Control setup
	$wp_customize->add_control('paragraph_word_spacing', array(
		'label'			=> __('Word Spacing', 'khaown'),
		'section' 		=> 'typography',
		'type'			=> 'number',
		'priority' 		=>  20
	) );


	/**********************************
		Heading Section setup
	*********************************/

	$wp_customize->add_panel('heading_customization_panel', array(
        'theme_supports' => '',
		'title'			 => __('Headings', 'khaown'),
		'description'	 => sprintf(__('Customize your theme headings', 'khaown') ),
		'priority' 		 => 44
    ) );

	$wp_customize->add_section('heading_general', array(
		'title'			=> __('General', 'khaown'),
		'panel'          => 'heading_customization_panel'
	) );

	// Heading setting setup
	$wp_customize->add_setting('heading_1_text_case', array(
		'default'			=> 'uppercase',
		'sanitize_callback' => 'khaown_sanitize_select',
		'type' 				=> 'theme_mod'
	) );
	
	// heading Control setup
	$wp_customize->add_control('heading_1_text_case', array(
		'type'     => 'select',
		'label'    => __( 'Heading Text Case', 'khaown' ),
		'choices'  => array(
			'none' => _x( 'Default', 'default', 'khaown' ),
			'uppercase' => _x( 'Uppercase', 'uppercase', 'khaown' ),
			'lowercase'  => _x( 'Lowercase', 'lowercase', 'khaown' ),
			'capitalize'  => _x( 'Capitalize', 'capitalize', 'khaown' ),
		),
		'section'  => 'heading_general',
		'priority' 		=>  20
	) );

	// SETTINGS
	$wp_customize->add_setting('heading_text_color', array(
		'default'			=> '#7a7a7a',
		'sanitize_callback' => 'sanitize_hex_color',
		'type' 				=> 'theme_mod'
	) );
	// CONTROLS
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 
			'heading_text_color', 
			array(
				'label'			=> __('Heading Text Color', 'khaown'),
				'section' 		=> 'heading_general',
				'priority' 		=>  20
			)
		)
	);
	// Heading setting setup
	$wp_customize->add_setting('heading_1_letter_spacing', array(
		'default'			=> '1',
		'sanitize_callback'  => 'absint',
		'type' 				=> 'theme_mod'
	) );
	
	// heading Control setup
	$wp_customize->add_control('heading_1_letter_spacing', array(
		'label'			=> __('Heading Letter Spacing', 'khaown'),
		'section' 		=> 'heading_general',
		'type'			=> 'number',
		'priority' 		=>  20
	) );

	// Heading setting setup
	$wp_customize->add_setting('heading_wordspecing_spacing', array(
		'default'			=> '0',
		'sanitize_callback' => 'absint',
		'type' 				=> 'theme_mod'
	) );
	
	// heading Control setup
	$wp_customize->add_control('heading_wordspecing_spacing', array(
		'label'			=> __('Heading Word Spacing', 'khaown'),
		'section' 		=> 'heading_general',
		'type'			=> 'number',
		'priority' 		=>  20
	) );
	
	
	// Heading setting setup
	$wp_customize->add_setting('heading_1_font_weight', array(
		'default'			=> '400',
		'sanitize_callback' => 'khaown_sanitize_select',
		'type' 				=> 'theme_mod'
	) );
	
	// heading Control setup
	$wp_customize->add_control('heading_1_font_weight', array(
		'type'     => 'select',
		'label'    => __( 'Heading Font Weight', 'khaown' ),
		'choices'  => array(
			'100' => _x( '100', '100', 'khaown' ),
			'200'  => _x( '200', '200', 'khaown' ),
			'300'  => _x( '300', '300', 'khaown' ),
			'400' => _x( '400', '400', 'khaown' ),
			'500'  => _x( '500', '500', 'khaown' ),
			'600'  => _x( '600', '600', 'khaown' ),
			'700'  => _x( '700', '700', 'khaown' ),
		),
		'section'  => 'heading_general',
		'priority' 		=>  20
	) );

	$wp_customize->add_section('heading_h1_customization', array(
		'title'			=> __('H1 Heading', 'khaown'),
		'panel'          => 'heading_customization_panel',
	) );

	// Heading setting setup
	$wp_customize->add_setting('heading_1_font_size', array(
		'default'			=> '28',
		'sanitize_callback' => 'absint',
		'type' 				=> 'theme_mod'
	) );
	
	// heading Control setup
	$wp_customize->add_control('heading_1_font_size', array(
		'label'			=> __('H1 Font Size', 'khaown'),
		'section' 		=> 'heading_h1_customization',
		'type'			=> 'number',
		'priority' 		=>  20
	) );
	// Heading setting setup
	$wp_customize->add_setting('heading_1_line_height', array(
		'default'			=> '36',
		'sanitize_callback' => 'absint',
		'type' 				=> 'theme_mod'
	) );
	
	// heading Control setup 
	$wp_customize->add_control('heading_1_line_height', array(
		'type'     => 'number',
		'label'    => __( 'H1 Line Height', 'khaown' ),
		'section'  => 'heading_h1_customization',
		'priority' 		=>  20
	) );
	$wp_customize->add_section('heading_h2_customization', array(
		'title'			=> __('H2 Heading', 'khaown'),
		'panel'          => 'heading_customization_panel',
	) );
	// Heading setting setup
	$wp_customize->add_setting('heading_h2_font_size', array(
		'default'			=> '24',
		'sanitize_callback' => 'absint',
		'type' 				=> 'theme_mod'
	) );
	
	// heading Control setup
	$wp_customize->add_control('heading_h2_font_size', array(
		'label'			=> __('H2 Font Size', 'khaown'),
		'section' 		=> 'heading_h2_customization',
		'type'			=> 'number',
		'priority' 		=>  20
	) );
	
	// Heading setting setup
	$wp_customize->add_setting('heading_h2_line_height', array(
		'default'			=> '32',
		'sanitize_callback' => 'absint',
		'type' 				=> 'theme_mod'
	) );
	
	// heading Control setup
	$wp_customize->add_control('heading_h2_line_height', array(
		'type'     => 'number',
		'label'    => __( 'H2 Line Height', 'khaown' ),
		'section'  => 'heading_h2_customization',
		'priority' 		=>  20
	) );


	/**********************************
		Navigation Bar Section setup
	*********************************/
	$wp_customize->add_section('nav_bar', array(
		'title'			=> __('Navigation Bar', 'khaown'),
		'description'	=> sprintf(__('Setup your theme Navigation', 'khaown') ),
		'priority' 		=> 45
	) );

	// Top header Site Desc color
	$nav_colors[] = array(
		'slug'		=>'nav_bar_bg_color', 
		'default' 	=> '#ffffff',
		'label' 	=> 'Background Color'
	);
	$nav_colors[] = array(
		'slug'		=>'nav_bar_text_color', 
		'default' 	=> '#000000',
		'label' 	=> 'Text Color'
	);
	foreach( $nav_colors as $colors ) {	
		// SETTINGS
		$wp_customize->add_setting(
			$colors['slug'], array(
				'default' 				=> $colors['default'],
				'sanitize_callback'  	=> 'sanitize_hex_color',
				'type' 					=> 'theme_mod'
			)
		);
		// CONTROLS
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$colors['slug'], 
				array('label' 			=> $colors['label'], 
				'section' 				=> 'nav_bar',
				'priority' 				=>  20,
				'settings' 				=> $colors['slug'])
			)
		);
	}
	// Heading setting setup
	$wp_customize->add_setting('nav_bar_font_size', array(
		'default'			=> '15',
		'sanitize_callback' => 'absint',
		'type' 				=> 'theme_mod'
	) );
	
	// heading Control setup
	$wp_customize->add_control('nav_bar_font_size', array(
		'type'     => 'number',
		'label'    => __( 'Nav Bar Font Size', 'khaown' ),
		'section'  => 'nav_bar',
		'priority' 		=>  20
	) );
	// Heading setting setup
	$wp_customize->add_setting('nav_bar_font_weight', array(
		'default'			=> '500',
		'sanitize_callback' => 'khaown_sanitize_select',
		'type' 				=> 'theme_mod'
	) );
	
	// heading Control setup
	$wp_customize->add_control('nav_bar_font_weight', array(
		'type'     => 'select',
		'choices'  => array(
			'100' => _x( '100', '100', 'khaown' ),
			'200'  => _x( '200', '200', 'khaown' ),
			'300'  => _x( '300', '300', 'khaown' ),
			'400' => _x( '400', '400', 'khaown' ),
			'500'  => _x( '500', '500', 'khaown' ),
			'600'  => _x( '600', '600', 'khaown' ),
			'700'  => _x( '700', '700', 'khaown' ),
		),
		'label'    => __( 'Nav Bar Font Weight', 'khaown' ),
		'section'  => 'nav_bar',
		'priority' 		=>  20
	) );

	// Heading setting setup
	$wp_customize->add_setting('nav_bar_margin_right', array(
		'default'			=> '15',
		'sanitize_callback' => 'absint',
		'type' 				=> 'theme_mod'
	) );
	
	// heading Control setup
	$wp_customize->add_control('nav_bar_margin_right', array(
		'type'		=>	'number',
		'default' 	=> 	'25',
		'label' 	=> 	'Margin Right',
		'section'  	=> 	'nav_bar',
		'priority' 	=>  20
	) );

	/**********************************
		Button Section setup
    *********************************/
    $wp_customize->add_section( 'khaown_theme_button', array(
		'title'          => __( 'Button', 'khaown' ),
        'description'    => __( 'Your Button color, hover color, etc.', 'khaown' ),
        'priority' 		 => 46
    ) );

    $khaown_btn_colors[] = array(
		'slug'		=>'khaown_btn_bg_color', 
		'default' 	=> '#000000',
		'label' 	=> 'Button Background Color'
	);
	$khaown_btn_colors[] = array(
		'slug'		=> 'khaown_btn_text_color', 
		'default' 	=> '#ffffff',
		'label' 	=> 'Button Text Color'
	);
	$khaown_btn_colors[] = array(
		'slug'		=>'khaown_btn_hover_bg_color', 
		'default' 	=> '#010101',
		'label' 	=> 'Button Hover Background Color'
	);
	$khaown_btn_colors[] = array(
		'slug'		=>'khaown_btn_hover_text_color', 
		'default' 	=> '#f9f9f9',
		'label' 	=> 'Button Hover Text Color'
	);
	foreach( $khaown_btn_colors as $btn_colors ) {
	
		// SETTINGS
		$wp_customize->add_setting(
			$btn_colors['slug'], array(
				'default' 				=> $btn_colors['default'],
				'sanitize_callback'  	=> 'sanitize_hex_color',
				'type' 					=> 'theme_mod'
			)
		);
		// CONTROLS
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$btn_colors['slug'], 
				array('label' 	=> $btn_colors['label'], 
				'priority' 		=>  20,
				'section'  		=> 'khaown_theme_button',
				'settings' 		=> $btn_colors['slug'])
			)
		);
	}

	/**********************************
		Header Top Section setup
	*********************************/
	$wp_customize->add_section('top_header', array(
		'title'			=> __('Top Header', 'khaown'),
		'description'	=> sprintf(__('Setup your theme Top header', 'khaown') ),
		'priority' 		=> 46
	) );


	// Top header Background color
	$header_topcolors[] = array(
		'slug'			=> 'homepage_header_bg_color', 
		'default' 		=> '#8224e3',
		'label' 		=> 'Top Header Background Color'
	);
	// Top header Site Title color
	$header_topcolors[] = array(
		'slug'			=>'top_header_site_tile_color', 
		'default' 		=> '#ffffff',
		'label' 		=> 'Top Header Site Title Color'
	);
	// Top header Site Desc color
	$header_topcolors[] = array(
		'slug'			=> 'top_header_site_desc_color', 
		'default' 		=> '#ffffff',
		'label' 		=> 'Top Header Site Desc Color'
	);
	foreach( $header_topcolors as $colors ) {
	
		// SETTINGS
		$wp_customize->add_setting(
			$colors['slug'], array(
				'default' => $colors['default'],
				'sanitize_callback'  => 'sanitize_hex_color',
				'type' => 'theme_mod'
			)
		);
		// CONTROLS
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$colors['slug'], 
				array(
					'label' 	=> $colors['label'], 
					'section' 	=> 'top_header',
					'priority' 	=>  20,
					'settings' 	=> $colors['slug'])
			)
		);
	}

	// Heading setting setup
	$wp_customize->add_setting('site_title_font_size', array(
		'default'			=> '32',
		'sanitize_callback' => 'absint',
		'type' 				=> 'theme_mod'
	) );
	
	// heading Control setup
	$wp_customize->add_control('site_title_font_size', array(
		'type'     => 'number',
		'label'    => __( 'Site Title Font Size', 'khaown' ),
		'section'  => 'top_header',
		'priority' 		=>  20
	) );
	// Heading setting setup
	$wp_customize->add_setting('site_title_font_weight', array(
		'default'			=> '500',
		'sanitize_callback' => 'khaown_sanitize_select',
		'type' 				=> 'theme_mod'
	) );
	
	// heading Control setup
	$wp_customize->add_control('site_title_font_weight', array(
		'type'     => 'select',
		'choices'  => array(
			'100'  => _x( '100', '100', 'khaown' ),
			'200'  => _x( '200', '200', 'khaown' ),
			'300'  => _x( '300', '300', 'khaown' ),
			'400'  => _x( '400', '400', 'khaown' ),
			'500'  => _x( '500', '500', 'khaown' ),
			'600'  => _x( '600', '600', 'khaown' ),
			'700'  => _x( '700', '700', 'khaown' ),
		),
		'label'    => __( 'Site Title Font Weight', 'khaown' ),
		'section'  => 'top_header',
		'priority' 		=>  20
	) );
	// Heading setting setup
	$wp_customize->add_setting('site_title_margin_bottom', array(
		'default'			=> '5',
		'sanitize_callback' => 'absint',
		'type' 				=> 'theme_mod'
	) );
	
	// heading Control setup
	$wp_customize->add_control('site_title_margin_bottom', array(
		'type'     => 'number',
		'label'    => __( 'Site Title Bottom Space', 'khaown' ),
		'section'  => 'top_header',
		'priority' 		=>  20
	) );
	// Heading setting setup
	$wp_customize->add_setting('site_desc_font_size', array(
		'default'			=> '15',
		'sanitize_callback' => 'absint',
		'type' 				=> 'theme_mod'
	) );
	
	// heading Control setup
	$wp_customize->add_control('site_desc_font_size', array(
		'type'     => 'number',
		'label'    => __( 'Site Desc Font Size', 'khaown' ),
		'section'  => 'top_header',
		'priority' 		=>  20
	) );

	

	/**********************************
	Social Media Add customizer setup
    *********************************/
    $wp_customize->add_section( 'social_media_section', array(
		'title'          => __( 'Social Accounts', 'khaown' ),
        'priority' 		 => 47
	) );
	
	// Social media colors
	$social_media_colors[] = array(
		'slug'		=>'social_media_icon_color', 
		'default' 	=> '#a0a0a0',
		'label' 	=> 'Social Media Icon Color'
	);
	$social_media_colors[] = array(
		'slug'			=> 'social_media_icon_hover_color', 
		'default' 		=> '#0073aa',
		'label' 		=> 'Social Media Icon Hover Color'
	);
	foreach( $social_media_colors as $sm_color ) {
	
		// SETTINGS
		$wp_customize->add_setting(
			$sm_color['slug'], array(
				'default' 				=> $sm_color['default'],
				'sanitize_callback'  	=> 'sanitize_hex_color',
				'type' 					=> 'theme_mod'
			)
		);
		// CONTROLS
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$sm_color['slug'], 
				array('label' 		=> $sm_color['label'], 
				'section' 			=> 'social_media_section',
				'priority' 			=>  20,
				'settings' 			=> $sm_color['slug'])
			)
		);
	}


	// Border Radius setting setup
	$wp_customize->add_setting('social_icon_font_size', array(
		'default'			=> 14,
		'sanitize_callback' => 'absint',
		'type' 				=> 'theme_mod'
	) );
	
	// Border Radius Control setup
	$wp_customize->add_control('social_icon_font_size', array(
		'label'			=> __('Social Icon Font Size', 'khaown'),
		'type'			=> 'number',
		'section' 		=> 'social_media_section',
		'priority' 		=>  20
	) );
	// Social Accounts color
	$social_accounts[] = array(
		'slug'		=> 'social_account_twitter', 
		'default' 	=> '',
		'label' 	=> 'Twitter',
		'type' 		=> 'text'
	);
	$social_accounts[] = array(
		'slug'		=> 'social_account_facebook', 
		'default' 	=> '',
		'label' 	=> 'Facebook',
		'type' 		=> 'text'
	);
	$social_accounts[] = array(
		'slug'		=> 'social_account_Instagram', 
		'default' 	=> '',
		'label' 	=> 'Instagram',
		'type' 		=> 'text'
	);
	$social_accounts[] = array(
		'slug'		=> 'social_account_Pinterest', 
		'default' 	=> '',
		'label' 	=> 'Pinterest',
		'type' 		=> 'text'
	);
	$social_accounts[] = array(
		'slug'		=> 'social_account_Dribbble', 
		'default' 	=> '',
		'label' 	=> 'Dribbble',
		'type' 		=> 'text'
	);
	$social_accounts[] = array(
		'slug'		=> 'social_account_LinkedIn', 
		'default' 	=> '',
		'label' 	=> 'LinkedIn',
		'type' 		=> 'text'
	);
	$social_accounts[] = array(
		'slug'		=> 'social_account_Tumblr', 
		'default' 	=> '',
		'label' 	=> 'Tumblr',
		'type' 		=> 'text'
	);
	$social_accounts[] = array(
		'slug'		=> 'social_account_Youtube', 
		'default' 	=> '',
		'label' 	=> 'Youtube',
		'type' 		=> 'text'
	);
	$social_accounts[] = array(
		'slug'		=> 'social_account_Vimeo', 
		'default' 	=> '',
		'label' 	=> 'Vimeo',
		'type' 		=> 'text'
	);
	$social_accounts[] = array(
		'slug'		=> 'social_account_RSS', 
		'default' 	=> '',
		'label' 	=> 'RSS',
		'type' 		=> 'text'
	);
	$social_accounts[] = array(
		'slug'		=> 'social_account_Email', 
		'default' 	=> '',
		'label' 	=> 'Email',
		'type' 		=> 'text'
	);
	foreach( $social_accounts as $account ) {
	
		// SETTINGS
		$wp_customize->add_setting(
			$account['slug'], array(
				'default' 				=> $account['default'],
				'sanitize_callback'  	=> 'esc_url_raw',
				'type' 					=> 'theme_mod'
			)
		);
		// CONTROLS
		$wp_customize->add_control(
				$account['slug'], 
				array('label' 	=> $account['label'], 
				'section' 		=> 'social_media_section',
				'type' 			=> $account['type'], 
				'priority' 		=>  20,
				'settings' 		=> $account['slug'])
		);
	}



	
}
add_action( 'customize_register', 'khaown_customize_register' );


/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function khaown_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function khaown_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

//radio box sanitization function
function khaown_sanitize_radio( $input, $setting ){
          
	//input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
	$input = sanitize_key($input);

	//get the list of possible radio box options 
	$choices = $setting->manager->get_control( $setting->id )->choices;
					  
	//return input if valid or return default option
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
	  
}

//select sanitization function
function khaown_sanitize_select( $input, $setting ){
          
	//input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
	$input = sanitize_key($input);

	//get the list of possible select options 
	$choices = $setting->manager->get_control( $setting->id )->choices;
					  
	//return input if valid or return default option
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
	  
}


/**
 * Bind JS handlers to instantly live-preview changes.
 */
function khaown_customize_preview_js() {
	wp_enqueue_script( 'khaown-customize-preview', get_theme_file_uri( '/js/customize-preview.js' ), array( 'customize-preview' ), '20181231', true );
}
add_action( 'customize_preview_init', 'khaown_customize_preview_js' );

/**
 * Load dynamic logic for the customizer controls area.
 */
function khaown_panels_js() {
	wp_enqueue_script( 'khaown-customize-controls', get_theme_file_uri( '/js/customize-controls.js' ), array(), '20181231', true );
}
add_action( 'customize_controls_enqueue_scripts', 'khaown_panels_js' );
