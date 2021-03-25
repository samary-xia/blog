<?php
/**
 * Footer Customizer options
 *
 * @package Izo
 */

$wp_customize->add_panel(
	'izo_footer_panel',
	array(
		'title'         => esc_html__( 'Footer', 'izo' ),
		'priority'      => 29,
	)
); 

/**
 * Footer widgets
 */
$wp_customize->add_section(
	'izo_footer_widgets',
	array(
		'title'         => esc_html__( 'Footer widgets', 'izo' ),
		'panel'			=> 'izo_footer_panel'
	)
);

$wp_customize->add_setting(
	'footer_widgets_layout',
	array(
		'default'           => 'disabled',
		'sanitize_callback' => 'izo_sanitize_select',
	)
);
$wp_customize->add_control(
	'footer_widgets_layout',
	array(
		'type'      		=> 'select',
		'label'     		=> esc_html__( 'Footer widgets layout', 'izo' ),
		'section'   		=> 'izo_footer_widgets',
		'choices'   		=> array(
			'disabled'		=> esc_html__( 'Disabled', 'izo' ),
			'columns1'		=> esc_html__( '1 column', 'izo' ),
			'columns2'		=> esc_html__( '2 columns', 'izo' ),
			'columns3'		=> esc_html__( '3 columns', 'izo' ),
			'columns4'		=> esc_html__( '4 columns', 'izo' ),
			'columns1l2s'	=> esc_html__( '1 large, 2 small', 'izo' ),
		),
	)
); 

$wp_customize->add_setting(
	'footer_widgets_background',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'footer_widgets_background',
		array(
			'label'         => esc_html__( 'Background color', 'izo' ),
			'section'       => 'izo_footer_widgets',
			'settings'      => 'footer_widgets_background',
		)
	)
);

$wp_customize->add_setting(
	'footer_widgets_title_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'footer_widgets_title_color',
		array(
			'label'         => esc_html__( 'Widget titles color', 'izo' ),
			'section'       => 'izo_footer_widgets',
			'settings'      => 'footer_widgets_title_color',
		)
	)
);

$wp_customize->add_setting(
	'footer_widgets_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'footer_widgets_color',
		array(
			'label'         => esc_html__( 'Content color', 'izo' ),
			'section'       => 'izo_footer_widgets',
			'settings'      => 'footer_widgets_color',
		)
	)
);

$wp_customize->add_setting(
	'footer_widgets_links_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'footer_widgets_links_color',
		array(
			'label'         => esc_html__( 'Links color', 'izo' ),
			'section'       => 'izo_footer_widgets',
			'settings'      => 'footer_widgets_links_color',
		)
	)
);

$wp_customize->add_setting(
	'footer_widgets_border_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'footer_widgets_border_color',
		array(
			'label'         => esc_html__( 'Border color', 'izo' ),
			'section'       => 'izo_footer_widgets',
			'settings'      => 'footer_widgets_border_color',
		)
	)
);

/**
 * Bottom footer bar
 */
$wp_customize->add_section(
	'izo_footer_bar',
	array(
		'title'         => esc_html__( 'Footer credits bar', 'izo' ),
		'panel'			=> 'izo_footer_panel'
	)
);

$wp_customize->add_setting(
	'footer_credits',
	array(
		'default'           => /* translators: %1$s: theme name */ sprintf( esc_html__( 'Proudly powered by the %1$s', 'izo' ), '<a class="underline" rel="nofollow" href="https://elfwp.com/themes/izo/">Izo WordPress theme</a>' ),
		'sanitize_callback' => 'izo_sanitize_text',
	)
);
$wp_customize->add_control(
	'footer_credits',
	array(
		'label' 			=> esc_html__( 'Footer credits', 'izo' ),
		'section' 			=> 'izo_footer_bar',
		'type' 				=> 'textarea',
	)
);

$wp_customize->add_setting(
	'footer_bottom_background',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'footer_bottom_background',
		array(
			'label'         => esc_html__( 'Background color', 'izo' ),
			'section'       => 'izo_footer_bar',
			'settings'      => 'footer_bottom_background',
		)
	)
);

$wp_customize->add_setting(
	'footer_bottom_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'footer_bottom_color',
		array(
			'label'         => esc_html__( 'Content color', 'izo' ),
			'section'       => 'izo_footer_bar',
			'settings'      => 'footer_bottom_color',
		)
	)
);