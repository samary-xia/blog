<?php
/**
 * Sidebar Customizer options
 *
 * @package Izo
 */

$wp_customize->add_section(
	'izo_sidebar_section',
	array(
		'title'         => esc_html__( 'Sidebar', 'izo' ),
		'priority'      => 21,
	)
); 

$wp_customize->add_setting(
	'sidebar_position',
	array(
		'default'           => 'sidebar-right',
		'sanitize_callback' => 'izo_sanitize_select',
	)
);
$wp_customize->add_control(
	'sidebar_position',
	array(
		'type'      		=> 'select',
		'label'     		=> esc_html__( 'Sidebar position', 'izo' ),
		'section'   		=> 'izo_sidebar_section',
		'choices'   		=> array(
			'sidebar-left'	=> esc_html__( 'Left', 'izo' ),
			'sidebar-right'	=> esc_html__( 'Right', 'izo' ),
			'no-sidebar'	=> esc_html__( 'No sidebar', 'izo' ),
		)
	)
);

$wp_customize->add_setting( 'sidebar_width',
	array(
		'default' 			=> 25,
		'transport' 		=> 'postMessage',
		'sanitize_callback' => 'absint'
	)
);
$wp_customize->add_control( new Izo_Slider_Control( $wp_customize, 'sidebar_width',
	array(
		'label' => esc_html__( 'Sidebar width [%]', 'izo' ),
		'section' => 'izo_sidebar_section',
		'input_attrs' => array(
			'min' => 20,
			'max' => 50,
			'step' => 1,
		),
	)
) );