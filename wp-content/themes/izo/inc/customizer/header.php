<?php
/**
 * Header Customizer options
 *
 * @package Izo
 */

$wp_customize->add_panel(
	'izo_header_panel',
	array(
		'title'         => esc_html__( 'Header', 'izo' ),
		'priority'      => 11,
	)
); 

/**
 * Top
 */
$wp_customize->add_section(
	'izo_header_top_bar',
	array(
		'title'         => esc_html__( 'Top bar', 'izo' ),
		'priority'      => 11,
		'panel'			=> 'izo_header_panel'
	)
);
$wp_customize->add_setting(
	'enable_top_bar',
	array(
		'default'           => 0,
		'sanitize_callback' => 'izo_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Izo_Toggle_Control(
		$wp_customize,
		'enable_top_bar',
		array(
			'label'         	=> esc_html__( 'Enable top bar', 'izo' ),
			'section'       	=> 'izo_header_top_bar',
			'settings'      	=> 'enable_top_bar',
		)
	)
);

$wp_customize->add_setting(
	'hide_top_bar_mobile',
	array(
		'default'           => 0,
		'sanitize_callback' => 'izo_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Izo_Toggle_Control(
		$wp_customize,
		'hide_top_bar_mobile',
		array(
			'label'         	=> esc_html__( 'Hide the top bar on mobile', 'izo' ),
			'section'       	=> 'izo_header_top_bar',
			'settings'      	=> 'hide_top_bar_mobile',
			'active_callback' 	=> 'izo_top_bar_active_callback'
		)
	)
);

$wp_customize->add_setting(
	'top_bar_container',
	array(
		'default'           => 'izo-container',
		'sanitize_callback' => 'izo_sanitize_select',
	)
);
$wp_customize->add_control(
	'top_bar_container',
	array(
		'type'      		=> 'select',
		'label'     		=> esc_html__( 'Top bar container', 'izo' ),
		'section'   		=> 'izo_header_top_bar',
		'choices'   		=> array(
			'izo-container'			=> esc_html__( 'Contained', 'izo' ),
			'izo-container-fluid'	=> esc_html__( 'Full width', 'izo' ),
		),
		'active_callback' 	=> 'izo_top_bar_active_callback'
	)
);

$wp_customize->add_setting(
	'izo_header_builder_radio',
	array(
		'default'           => 'top_left',
		'sanitize_callback'	=> 'izo_sanitize_select'
	)
);

$wp_customize->add_control( new Izo_Radio_Header( $wp_customize, 'izo_header_builder_radio',
	array(
		'type'     => 'izo-radio-header',
		'label'    =>  esc_html__( 'Choose the top bar area you want to configure', 'izo' ),
		'choices'  => array(
				'top_left' 		=> array( 'label' => esc_html__( 'Top left', 'izo' ) ),
				'top_right' 	=> array( 'label' => esc_html__( 'Top right', 'izo' ) ),
		),
		'section'  			=> 'izo_header_top_bar',
		'active_callback' 	=> 'izo_top_bar_active_callback'
	)
) );


$izo_header_components = array( 
	'header_component_text' 		=> esc_html__( 'Custom text', 'izo' ),
	'header_component_contact' 		=> esc_html__( 'Contact info', 'izo' ),
	'header_woocommerce' 			=> esc_html__( 'WooCommerce icons', 'izo' ),
	'header_component_social' 		=> esc_html__( 'Social icons', 'izo' ),
	'header_component_top_nav' 		=> esc_html__( 'Top navigation', 'izo' ),
);

$wp_customize->add_setting(
	'left_top_bar_component',
	array(
		'default'           => 'header_component_contact',
		'sanitize_callback' => 'izo_sanitize_select',
	)
);
$wp_customize->add_control(
	'left_top_bar_component',
	array(
		'type'      		=> 'select',
		'label'     		=> esc_html__( 'Left side component', 'izo' ),
		'section'   		=> 'izo_header_top_bar',
		'choices'   		=> $izo_header_components,
		'active_callback' 	=> 'izo_top_bar_left_active_callback'
	)
);  

$wp_customize->add_setting(
	'right_top_bar_component',
	array(
		'default'           => 'header_component_text',
		'sanitize_callback' => 'izo_sanitize_select',
	)
);
$wp_customize->add_control(
	'right_top_bar_component',
	array(
		'type'      		=> 'select',
		'label'     		=> esc_html__( 'Right side component', 'izo' ),
		'section'   		=> 'izo_header_top_bar',
		'choices'   		=> $izo_header_components,
		'active_callback' 	=> 'izo_top_bar_right_active_callback'
	)
); 

/**
 * Components
 */

//Header custom text
$wp_customize->add_setting(
	'header_custom_text',
	array(
		'default'           => esc_html__( 'Lorem ipsum dolor sit amet', 'izo' ),
		'sanitize_callback' => 'izo_sanitize_text',
	)
);
$wp_customize->add_control(
	'header_custom_text',
	array(
		'label' 			=> esc_html__( 'Your custom text', 'izo' ),
		'section' 			=> 'izo_header_top_bar',
		'type' 				=> 'text',
		'priority' 			=> 12,
		'active_callback' 	=> 'izo_header_text_active_callback'
	)
);

$wp_customize->add_setting(
	'top_header_text_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'top_header_text_color',
		array(
			'label'         	=> esc_html__( 'Color', 'izo' ),
			'section'       	=> 'izo_header_top_bar',
			'active_callback' 	=> 'izo_header_text_active_callback'
		)
	)
);

//Woocommerce icons
$wp_customize->add_setting(
	'top_header_wc_icons_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'top_header_wc_icons_color',
		array(
			'label'         	=> esc_html__( 'Color', 'izo' ),
			'section'       	=> 'izo_header_top_bar',
			'active_callback' 	=> 'izo_header_wc_icons_active_callback'
		)
	)
);

//Header social
$wp_customize->add_setting( 'header_social_profiles',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'izo_sanitize_urls'
	)
);
$wp_customize->add_control( new Izo_Repeater_Control( $wp_customize, 'header_social_profiles',
	array(
		'label' 		=> esc_html__( 'Social profile', 'izo' ),
		'description' 	=> esc_html__( 'Add links to your social profiles here. You can also rearrange the links.', 'izo' ),
		'section' 		=> 'izo_header_top_bar',
		'button_labels' => array(
			'add' => esc_html__( 'Add new social link', 'izo' ),
		),
		'active_callback'=> 'izo_social_active_callback'
	)
) );

$wp_customize->add_setting(
	'top_header_social_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'top_header_social_color',
		array(
			'label'         	=> esc_html__( 'Color', 'izo' ),
			'section'       	=> 'izo_header_top_bar',
			'active_callback' 	=> 'izo_social_active_callback'
		)
	)
);

//Header top nav
$wp_customize->add_setting(
	'top_header_nav_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'top_header_nav_color',
		array(
			'label'         	=> esc_html__( 'Color', 'izo' ),
			'section'       	=> 'izo_header_top_bar',
			'active_callback' 	=> 'izo_top_nav_active_callback'
		)
	)
);
$wp_customize->add_setting(
	'top_header_nav_color_hover',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'top_header_nav_color_hover',
		array(
			'label'         	=> esc_html__( 'Color (hover)', 'izo' ),
			'section'       	=> 'izo_header_top_bar',
			'active_callback' 	=> 'izo_top_nav_active_callback'
		)
	)
);
$wp_customize->add_setting(
	'info_header_top_nav',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Izo_Info( $wp_customize, 'info_header_top_nav',
	array(
		'label'    			=> '<span class="panel-info-toggle">i</span>' . wp_kses_post( __( 'Go to <strong>Appearance > Menus</strong> to create and assign a menu for the <strong>Top Navigation</strong> location.', 'izo' ) ),
		'section'  			=> 'izo_header_top_bar',
		'active_callback'	=> 'izo_top_nav_active_callback'
	)
) );

//Header contact
$wp_customize->add_setting(
	'header_phone',
	array(
		'default'           => '+99.11.33.22',
		'sanitize_callback' => 'izo_sanitize_text',
	)
);
$wp_customize->add_control(
	'header_phone',
	array(
		'label' 			=> esc_html__( 'Phone number', 'izo' ),
		'section' 			=> 'izo_header_top_bar',
		'type' 				=> 'text',
		'priority' 			=> 12,
		'active_callback' 	=> 'izo_header_contact_active_callback'
	)
);
$wp_customize->add_setting(
	'header_mail',
	array(
		'default'           => 'office@example.org',
		'sanitize_callback' => 'sanitize_email',
	)
);
$wp_customize->add_control(
	'header_mail',
	array(
		'label' 			=> esc_html__( 'Email address', 'izo' ),
		'section' 			=> 'izo_header_top_bar',
		'type' 				=> 'text',
		'priority' 			=> 12,
		'active_callback' 	=> 'izo_header_contact_active_callback'
	)
);

$wp_customize->add_setting(
	'header_contact_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'header_contact_color',
		array(
			'label'         => esc_html__( 'Color', 'izo' ),
			'section'       => 'izo_header_top_bar',
			'settings'      => 'header_contact_color',
			'priority'      => 13,
			'active_callback' 	=> 'izo_header_contact_active_callback'
		)
	)
);


//Header button
$wp_customize->add_setting(
	'header_button_url',
	array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	'header_button_url',
	array(
		'label' 			=> esc_html__( 'Button URL', 'izo' ),
		'section' 			=> 'izo_header_top_bar',
		'type' 				=> 'url',
		'priority' 			=> 12,
		'active_callback' 	=> 'izo_header_button_active_callback'
	)
);
$wp_customize->add_setting(
	'header_button_text',
	array(
		'default'           => esc_html__( 'Click me', 'izo' ),
		'sanitize_callback' => 'izo_sanitize_text',
	)
);
$wp_customize->add_control(
	'header_button_text',
	array(
		'label' 			=> esc_html__( 'Button text', 'izo' ),
		'section' 			=> 'izo_header_top_bar',
		'type' 				=> 'text',
		'priority' 			=> 12,
		'active_callback' 	=> 'izo_header_button_active_callback'
	)
);
$wp_customize->add_setting(
	'header_button_newtab',
	array(
		'default'           => '',
		'sanitize_callback' => 'izo_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Izo_Toggle_Control(
		$wp_customize,
		'header_button_newtab',
		array(
			'label'         	=> esc_html__( 'Open link in a new tab', 'izo' ),
			'section'       	=> 'izo_header_top_bar',
			'settings'      	=> 'header_button_newtab',
			'priority'      	=> 12,
			'active_callback' 	=> 'izo_header_button_active_callback'
		)
	)
);



/**
 * Main header bar
 */
$wp_customize->add_section(
	'izo_main_header',
	array(
		'title'         => esc_html__( 'Menu bar', 'izo' ),
		'priority'      => 11,
		'panel'			=> 'izo_header_panel'
	)
);

//Layout
$wp_customize->add_setting(
	'title_main_header_layout',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Izo_Title( $wp_customize, 'title_main_header_layout',
	array(
		'label'    => esc_html__( 'Layout', 'izo' ),
		'section'  => 'izo_main_header',
	)
) );
$wp_customize->add_setting(
	'menu_layout',
	array(
		'default'           => 'menu-layout-default',
		'sanitize_callback' => 'sanitize_key',
	)
);
$wp_customize->add_control(
	new Izo_Radio_Images(
		$wp_customize,
		'menu_layout',
		array(
			'label'    => esc_html__( 'Menu bar layout', 'izo' ),
			'section'  => 'izo_main_header',
			'choices'  => array(
				'menu-layout-default' => array(
					'label' => esc_html__( 'Default', 'izo' ),
					'url'   => '%s/assets/images/ml1.jpg'
				),
				'menu-layout-centered' => array(
					'label' => esc_html__( 'Centered', 'izo' ),
					'url'   => '%s/assets/images/ml2.jpg'
				),
			),
		)
	)
);

$wp_customize->add_setting(
	'menu_container',
	array(
		'default'           => 'izo-container',
		'sanitize_callback' => 'izo_sanitize_select',
	)
);
$wp_customize->add_control(
	'menu_container',
	array(
		'type'      		=> 'select',
		'label'     		=> esc_html__( 'Menu bar container', 'izo' ),
		'section'   		=> 'izo_main_header',
		'choices'   		=> array(
			'izo-container'			=> esc_html__( 'Contained', 'izo' ),
			'izo-container-fluid'	=> esc_html__( 'Full width', 'izo' ),
		),
	)
);

$wp_customize->add_setting(
	'title_mobile_menu',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Izo_Title( $wp_customize, 'title_mobile_menu',
	array(
		'label'    => esc_html__( 'Mobile menu', 'izo' ),
		'section'  => 'izo_main_header',
	)
) );

$wp_customize->add_setting(
	'always_display_mobile_menu',
	array(
		'default'           => 0,
		'sanitize_callback' => 'izo_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Izo_Toggle_Control(
		$wp_customize,
		'always_display_mobile_menu',
		array(
			'label'         	=> esc_html__( 'Display mobile menu for desktop', 'izo' ),
			'section'       	=> 'izo_main_header',
			'settings'      	=> 'always_display_mobile_menu',
		)
	)
);

$wp_customize->add_setting(
	'mobile_menu_layout',
	array(
		'default'           => 'mobile-layout-default',
		'sanitize_callback' => 'sanitize_key',
	)
);
$wp_customize->add_control(
	new Izo_Radio_Images(
		$wp_customize,
		'mobile_menu_layout',
		array(
			'label'    => esc_html__( 'Mobile menu toggle position', 'izo' ),
			'section'  => 'izo_main_header',
			'choices'  => array(
				'mobile-layout-default' => array(
					'label' => esc_html__( 'Default', 'izo' ),
					'url'   => '%s/assets/images/mmd.jpg'
				),
				'mobile-layout-centered' => array(
					'label' => esc_html__( 'Centered', 'izo' ),
					'url'   => '%s/assets/images/mmc.jpg'
				),
			),
		)
	)
);

$wp_customize->add_setting(
	'mobile_menu_label',
	array(
		'sanitize_callback' => 'izo_sanitize_text',
	)
);
$wp_customize->add_control(
	'mobile_menu_label',
	array(
		'label' 			=> esc_html__( 'Button label', 'izo' ),
		'section' 			=> 'izo_main_header',
		'type' 				=> 'text',
	)
);

$wp_customize->add_setting(
	'mobile_menu_background_color',
	array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'mobile_menu_background_color',
		array(
			'label'         	=> esc_html__( 'Mobile menu background color', 'izo' ),
			'section'       	=> 'izo_main_header',
			'settings'      	=> 'mobile_menu_background_color',
		)
	)
);

$wp_customize->add_setting(
	'mobile_menu_items_color',
	array(
		'default'           => '#1d1d1d',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'mobile_menu_items_color',
		array(
			'label'         	=> esc_html__( 'Mobile menu items color', 'izo' ),
			'section'       	=> 'izo_main_header',
			'settings'      	=> 'mobile_menu_items_color',
		)
	)
);


//Last item
$izo_main_header_components = array( 
	'main_header_component_nothing'		=> esc_html__( 'Nothing', 'izo' ),
	'main_header_component_text' 		=> esc_html__( 'Custom text', 'izo' ),
	'main_header_woocommerce' 			=> esc_html__( 'WooCommerce icons', 'izo' ),
	'main_header_component_button' 		=> esc_html__( 'Button', 'izo' ),
	'main_header_component_search' 		=> esc_html__( 'Search', 'izo' ),
);

$wp_customize->add_setting(
	'title_header_last_item',
	array(
		'sanitize_callback' => 'esc_html',
	)
);

$wp_customize->add_control( new Izo_Title( $wp_customize, 'title_header_last_item',
	array(
		'label'    => esc_html__( 'Last menu item', 'izo' ),
		'section'  => 'izo_main_header',
		'priority'	=> 19
	)
) );

$wp_customize->add_setting(
	'main_header_last_item',
	array(
		'default'           => 'main_header_component_nothing',
		'sanitize_callback' => 'izo_sanitize_select',
	)
);
$wp_customize->add_control(
	'main_header_last_item',
	array(
		'type'      		=> 'select',
		'label'     		=> esc_html__( 'Add an item to your menu', 'izo' ),
		'section'   		=> 'izo_main_header',
		'choices'   		=> $izo_main_header_components,
		'priority'			=> 19
	)
);

//Main header button
$wp_customize->add_setting(
	'main_header_button_url',
	array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	'main_header_button_url',
	array(
		'label' 			=> esc_html__( 'Button URL', 'izo' ),
		'section' 			=> 'izo_main_header',
		'type' 				=> 'url',
		'active_callback' 	=> 'izo_main_header_button_active_callback',
		'priority'	=> 19
	)
);
$wp_customize->add_setting(
	'main_header_button_text',
	array(
		'default'           => esc_html__( 'Click me', 'izo' ),
		'sanitize_callback' => 'izo_sanitize_text',
	)
);
$wp_customize->add_control(
	'main_header_button_text',
	array(
		'label' 			=> esc_html__( 'Button text', 'izo' ),
		'section' 			=> 'izo_main_header',
		'type' 				=> 'text',
		'active_callback' 	=> 'izo_main_header_button_active_callback',
		'priority'	=> 19
	)
);
$wp_customize->add_setting(
	'main_header_button_newtab',
	array(
		'default'           => '',
		'sanitize_callback' => 'izo_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Izo_Toggle_Control(
		$wp_customize,
		'main_header_button_newtab',
		array(
			'label'         	=> esc_html__( 'Open link in a new tab', 'izo' ),
			'section'       	=> 'izo_main_header',
			'settings'      	=> 'main_header_button_newtab',
			'active_callback' 	=> 'izo_main_header_button_active_callback',
			'priority'	=> 19
		)
	)
);

$wp_customize->add_setting(
	'main_header_button_background',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'main_header_button_background',
		array(
			'label'         	=> esc_html__( 'Button background color', 'izo' ),
			'section'       	=> 'izo_main_header',
			'settings'      	=> 'main_header_button_background',
			'active_callback' 	=> 'izo_main_header_button_active_callback',
			'priority'	=> 19
		)
	)
);

$wp_customize->add_setting(
	'main_header_button_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'main_header_button_color',
		array(
			'label'         	=> esc_html__( 'Button color', 'izo' ),
			'section'       	=> 'izo_main_header',
			'settings'      	=> 'main_header_button_color',
			'active_callback' 	=> 'izo_main_header_button_active_callback',
			'priority'	=> 19
		)
	)
);

$wp_customize->add_setting(
	'main_header_button_background_hover',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'main_header_button_background_hover',
		array(
			'label'         	=> esc_html__( 'Button background color (hover)', 'izo' ),
			'section'       	=> 'izo_main_header',
			'settings'      	=> 'main_header_button_background_hover',
			'active_callback' 	=> 'izo_main_header_button_active_callback',
			'priority'	=> 19
		)
	)
);

$wp_customize->add_setting(
	'main_header_button_color_hover',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'main_header_button_color_hover',
		array(
			'label'         	=> esc_html__( 'Button color (hover)', 'izo' ),
			'section'       	=> 'izo_main_header',
			'settings'      	=> 'main_header_button_color_hover',
			'active_callback' 	=> 'izo_main_header_button_active_callback',
			'priority'	=> 19
		)
	)
);

$wp_customize->add_setting(
	'main_header_button_padding_tb',
	array(
		'default'           => 14,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'main_header_button_padding_tb',
	array(
		'label' 			=> esc_html__( 'Top/bottom padding [px]', 'izo' ),
		'section' 			=> 'izo_main_header',
		'type' 				=> 'number',
		'active_callback' 	=> 'izo_main_header_button_active_callback',
		'priority'	=> 19
	)
);

$wp_customize->add_setting(
	'main_header_button_padding_lr',
	array(
		'default'           => 26,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'main_header_button_padding_lr',
	array(
		'label' 			=> esc_html__( 'Left/right padding [px]', 'izo' ),
		'section' 			=> 'izo_main_header',
		'type' 				=> 'number',
		'active_callback' 	=> 'izo_main_header_button_active_callback',
		'priority'	=> 19
	)
);

$wp_customize->add_setting(
	'main_header_button_border_radius',
	array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'main_header_button_border_radius',
	array(
		'label' 			=> esc_html__( 'Border radius [px]', 'izo' ),
		'section' 			=> 'izo_main_header',
		'type' 				=> 'number',
		'active_callback' 	=> 'izo_main_header_button_active_callback',
		'priority'	=> 19
	)
);

$wp_customize->add_setting(
	'main_header_button_font_size',
	array(
		'default'           => 16,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'main_header_button_font_size',
	array(
		'label' 			=> esc_html__( 'Font size [px]', 'izo' ),
		'section' 			=> 'izo_main_header',
		'type' 				=> 'number',
		'active_callback' 	=> 'izo_main_header_button_active_callback',
		'priority'	=> 19
	)
);

//Main header custom text
$wp_customize->add_setting(
	'main_header_custom_text',
	array(
		'default'           => esc_html__( 'Lorem ipsum dolor sit amet', 'izo' ),
		'sanitize_callback' => 'izo_sanitize_text',
	)
);
$wp_customize->add_control(
	'main_header_custom_text',
	array(
		'label' 			=> esc_html__( 'Your custom text', 'izo' ),
		'section' 			=> 'izo_main_header',
		'type' 				=> 'text',
		'active_callback' 	=> 'izo_main_header_text_active_callback',
		'priority'	=> 19
	)
);

$wp_customize->add_setting(
	'main_header_text_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'main_header_text_color',
		array(
			'label'         	=> esc_html__( 'Color', 'izo' ),
			'section'       	=> 'izo_main_header',
			'settings'      	=> 'main_header_text_color',
			'active_callback' 	=> 'izo_main_header_text_active_callback',
			'priority'	=> 19
		)
	)
);

//Search
$wp_customize->add_setting(
	'header_search_style',
	array(
		'default'           => 'default',
		'sanitize_callback' => 'izo_sanitize_select',
	)
);
$wp_customize->add_control(
	'header_search_style',
	array(
		'type'      		=> 'select',
		'label'     		=> esc_html__( 'Search toggle style', 'izo' ),
		'section'   		=> 'izo_main_header',
		'choices'   		=> array(
			'default'	=> esc_html__( 'Default', 'izo' ),
			'stacked'	=> esc_html__( 'Stacked', 'izo' )
		),
		'active_callback' 	=> 'izo_main_header_search_active_callback',
		'priority'	=> 19
	)
);

$wp_customize->add_setting(
	'header_search_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'header_search_color',
		array(
			'label'         	=> esc_html__( 'Color', 'izo' ),
			'section'       	=> 'izo_main_header',
			'settings'      	=> 'header_search_color',
			'active_callback' 	=> 'izo_main_header_search_active_callback',
			'priority'	=> 19
		)
	)
);

/**
 * Styles
 */
$wp_customize->add_section(
	'izo_header_styles',
	array(
		'title'         => esc_html__( 'Header styling', 'izo' ),
		'priority'      => 11,
		'panel'			=> 'izo_header_panel'
	)
);

//Top header bar
$wp_customize->add_setting(
	'title_header_styles_top',
	array(
		'sanitize_callback' => 'esc_html',
	)
);

$wp_customize->add_control( new Izo_Title( $wp_customize, 'title_header_styles_top',
	array(
		'label'    => esc_html__( 'Top header bar', 'izo' ),
		'section'  => 'izo_header_styles',
		'priority'      => 1,
	)
) );


$wp_customize->add_setting( 'top_bar_background_color',
	array(
		'default' 			=> '',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'izo_hex_rgba_sanitize'
	)
);
$wp_customize->add_control( new Izo_Alpha_Color( $wp_customize, 'top_bar_background_color',
	array(
		'label' => esc_html__( 'Background color', 'izo' ),
		'section' => 'izo_header_styles',
		'priority'      => 1,
	)
) );

//Paddings
$wp_customize->add_setting( 'top_hb_padding_desktop', array(
	'default'   		=> 10,
	'sanitize_callback' => 'absint'
) );
$wp_customize->add_setting( 'top_hb_padding_tablet', array(
	'default'			=> 10,
	'sanitize_callback' => 'absint'
) );
$wp_customize->add_setting( 'top_hb_padding_mobile', array(
	'default'			=> 10,
	'sanitize_callback' => 'absint'
) );

$wp_customize->add_control( new Izo_Responsive_Number( $wp_customize, 'top_header_bar_padding',
	array(
		'label' => esc_html__( 'Top/bottom padding', 'izo' ),
		'section' => 'izo_header_styles',
		'settings'   => array (
			'top_hb_padding_desktop',
			'top_hb_padding_tablet',
			'top_hb_padding_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 250,
			'step'  => 1,
		),		
		'priority'      => 1,
	)
) );

//Bottom header bar
$wp_customize->add_setting(
	'title_header_styles_bottom',
	array(
		'sanitize_callback' => 'esc_html',
	)
);

$wp_customize->add_control( new Izo_Title( $wp_customize, 'title_header_styles_bottom',
	array(
		'label'    => esc_html__( 'Main menu bar', 'izo' ),
		'section'  => 'izo_header_styles',
	)
) );


$wp_customize->add_setting( 'bottom_bar_background_color',
	array(
		'default' 			=> '',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'izo_hex_rgba_sanitize'
	)
);
$wp_customize->add_control( new Izo_Alpha_Color( $wp_customize, 'bottom_bar_background_color',
	array(
		'label' => esc_html__( 'Background color', 'izo' ),
		'section' => 'izo_header_styles',
	)
) );

//Paddings
$wp_customize->add_setting( 'bottom_hb_padding_desktop', array(
	'default'   => 20,
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'bottom_hb_padding_tablet', array(
	'default'	=> 20,
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'bottom_hb_padding_mobile', array(
	'default'	=> 20,
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Izo_Responsive_Number( $wp_customize, 'bottom_header_bar_padding',
	array(
		'label' => esc_html__( 'Top/bottom padding', 'izo' ),
		'section' => 'izo_header_styles',
		'settings'   => array (
			'bottom_hb_padding_desktop',
			'bottom_hb_padding_tablet',
			'bottom_hb_padding_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 250,
			'step'  => 1,
		),		
	)
) );

$wp_customize->add_setting(
	'site_title_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'site_title_color',
		array(
			'label'         	=> esc_html__( 'Site title color', 'izo' ),
			'section'       	=> 'izo_header_styles',
		)
	)
);

$wp_customize->add_setting(
	'site_desc_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'site_desc_color',
		array(
			'label'         	=> esc_html__( 'Site description color', 'izo' ),
			'section'       	=> 'izo_header_styles',
		)
	)
);

$wp_customize->add_setting(
	'menu_items_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'menu_items_color',
		array(
			'label'         	=> esc_html__( 'Menu items color', 'izo' ),
			'section'       	=> 'izo_header_styles',
		)
	)
);

$wp_customize->add_setting(
	'menu_items_color_hover',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'menu_items_color_hover',
		array(
			'label'         	=> esc_html__( 'Menu items color (hover)', 'izo' ),
			'section'       	=> 'izo_header_styles',
		)
	)
);

$wp_customize->add_setting(
	'submenu_items_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'submenu_items_color',
		array(
			'label'         	=> esc_html__( 'Submenu items color', 'izo' ),
			'section'       	=> 'izo_header_styles',
		)
	)
);

$wp_customize->add_setting(
	'submenu_items_color_hover',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'submenu_items_color_hover',
		array(
			'label'         	=> esc_html__( 'Submenu items color (hover)', 'izo' ),
			'section'       	=> 'izo_header_styles',
		)
	)
);

$wp_customize->add_setting(
	'submenu_items_background',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'submenu_items_background',
		array(
			'label'         	=> esc_html__( 'Submenu background', 'izo' ),
			'section'       	=> 'izo_header_styles',
		)
	)
);

/**
 * Transparent header styles
 */
$wp_customize->add_section(
	'izo_transparent_header_styles',
	array(
		'title'         => esc_html__( 'Header styling (transparent mode)', 'izo' ),
		'priority'      => 11,
		'description'	=> esc_html__( 'These options are available for pages for which you have activated the Transparent menu bar option', 'izo' ), 
		'panel'			=> 'izo_header_panel'
	)
);

$wp_customize->add_setting(
	'logo_transparent',
	array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'logo_transparent',
		array(
		   'label'          => esc_html__( 'Logo for transparent mode', 'izo' ),
		   'description'    => esc_html__( 'This logo will replace your default logo on pages with transparent menu enabled.', 'izo' ),
		   'type'           => 'image',
		   'section'        => 'izo_transparent_header_styles',
		)
	)
);

$wp_customize->add_setting( 'bottom_bar_background_color_transp',
	array(
		'default' 			=> '',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'izo_hex_rgba_sanitize'
	)
);
$wp_customize->add_control( new Izo_Alpha_Color( $wp_customize, 'bottom_bar_background_color_transp',
	array(
		'label' => esc_html__( 'Background color', 'izo' ),
		'section' => 'izo_transparent_header_styles',
	)
) );

$wp_customize->add_setting( 'bottom_bar_color_transp',
	array(
		'default' 			=> '',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'izo_hex_rgba_sanitize'
	)
);
$wp_customize->add_control( new Izo_Alpha_Color( $wp_customize, 'bottom_bar_color_transp',
	array(
		'label' => esc_html__( 'Color', 'izo' ),
		'section' => 'izo_transparent_header_styles',
	)
) );



/**
 * Sticky menu
 */
$wp_customize->add_section(
	'izo_header_sticky',
	array(
		'title'         => esc_html__( 'Sticky menu', 'izo' ),
		'priority'      => 11,
		'panel'			=> 'izo_header_panel'
	)
);
$wp_customize->add_setting(
	'enable_sticky_menu',
	array(
		'default'           => 0,
		'sanitize_callback' => 'izo_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Izo_Toggle_Control(
		$wp_customize,
		'enable_sticky_menu',
		array(
			'label'         	=> esc_html__( 'Enable sticky menu?', 'izo' ),
			'section'       	=> 'izo_header_sticky',
			'settings'      	=> 'enable_sticky_menu',
		)
	)
);
$wp_customize->add_setting(
	'disable_sticky_mobiles',
	array(
		'default'           => 1,
		'sanitize_callback' => 'izo_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Izo_Toggle_Control(
		$wp_customize,
		'disable_sticky_mobiles',
		array(
			'label'         	=> esc_html__( 'Disable sticky menu on mobiles?', 'izo' ),
			'section'       	=> 'izo_header_sticky',
			'settings'      	=> 'disable_sticky_mobiles',
		)
	)
);
//Styling
$wp_customize->add_setting(
	'title_sticky_header_styles',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Izo_Title( $wp_customize, 'title_sticky_header_styles',
	array(
		'label'    => esc_html__( 'Sticky menu styling', 'izo' ),
		'section'  => 'izo_header_sticky',
	)
) );
$wp_customize->add_setting( 'sticky_header_bg_color',
	array(
		'default' 			=> 'rgba(255,255,255,0.8)',
		'sanitize_callback' => 'izo_hex_rgba_sanitize'
	)
);
$wp_customize->add_control( new Izo_Alpha_Color( $wp_customize, 'sticky_header_bg_color',
	array(
		'label' 	=> esc_html__( 'Background color', 'izo' ),
		'section' 	=> 'izo_header_sticky',
	)
) );
$wp_customize->add_setting(
	'sticky_header_color',
	array(
		'default'           => '#1d1d1f',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'sticky_header_color',
		array(
			'label'         => esc_html__( 'Color', 'izo' ),
			'section'       => 'izo_header_sticky',
			'settings'      => 'sticky_header_color',
		)
	)
);


/**
 * Header image section
 */
$wp_customize->add_setting(
	'header_image_front_page',
	array(
		'default'           => 0,
		'sanitize_callback' => 'izo_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Izo_Toggle_Control(
		$wp_customize,
		'header_image_front_page',
		array(
			'label'         	=> esc_html__( 'Show the header image on your static front page', 'izo' ),
			'description'      	=> esc_html__( 'By default, the header image is shown only on your blog page.', 'izo' ),
			'section'       	=> 'header_image',
		)
	)
);

/**
 * Display site title and description when logo is supplied
 */
$wp_customize->add_setting(
	'display_site_title',
	array(
		'default'           => 0,
		'sanitize_callback' => 'izo_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Izo_Toggle_Control(
		$wp_customize,
		'display_site_title',
		array(
			'label'         	=> esc_html__( 'Display site title and description when logo is active', 'izo' ),
			'section'       	=> 'title_tagline',
			'settings'      	=> 'display_site_title',
		)
	)
);

//Logo max size
$wp_customize->add_setting( 'site_logo_size_desktop', array(
	'default'   		=> 130,
	'sanitize_callback' => 'absint',	
) );
$wp_customize->add_setting( 'site_logo_size_tablet', array(
	'default'			=> 130,
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'site_logo_size_mobile', array(
	'default'			=> 130,
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Izo_Responsive_Number( $wp_customize, 'site_logo_size',
	array(
		'label' => esc_html__( 'Logo max. width [px]', 'izo' ),
		'section' => 'title_tagline',
		'settings'   => array (
			'site_logo_size_desktop',
			'site_logo_size_tablet',
			'site_logo_size_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 300,
			'step'  => 1,
		),		
		'priority' => 9
	)
) );