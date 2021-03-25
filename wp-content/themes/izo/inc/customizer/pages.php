<?php
/**
 * Pages Customizer options
 *
 * @package Izo
 */

$wp_customize->add_section(
	'izo_pages_section',
	array(
		'title'         => esc_html__( 'Pages', 'izo' ),
		'priority'      => 15,
	)
); 

$wp_customize->add_setting(
	'single_page_layout',
	array(
		'default'           => 'layout-boxed',
		'sanitize_callback' => 'izo_sanitize_select',
	)
);
$wp_customize->add_control(
	'single_page_layout',
	array(
		'type'      		=> 'select',
		'label'     		=> esc_html__( 'Page layout', 'izo' ),
		'section'   		=> 'izo_pages_section',
		'choices'   		=> array(
			'layout-boxed'		=> esc_html__( 'Boxed (default)', 'izo' ),
			'layout-unboxed'	=> esc_html__( 'Unboxed', 'izo' ),
			'layout-wide'		=> esc_html__( 'Wide (disables sidebar)', 'izo' ),
			'layout-stretched'	=> esc_html__( 'Stretched', 'izo' ),
		)
	)
);

$wp_customize->add_setting(
	'single_page_header_alignment',
	array(
		'default'           => 'left',
		'sanitize_callback' => 'izo_sanitize_select',
	)
);
$wp_customize->add_control(
	'single_page_header_alignment',
	array(
		'type'      		=> 'select',
		'label'     		=> esc_html__( 'Page header alignment', 'izo' ),
		'section'   		=> 'izo_pages_section',
		'choices'   		=> array(
			'left'		=> esc_html__( 'Left', 'izo' ),
			'center'	=> esc_html__( 'Center', 'izo' ),
			'right'		=> esc_html__( 'Right', 'izo' ),
		)
	)
);

$wp_customize->add_setting(
	'info_pages_section',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Izo_Info( $wp_customize, 'info_pages_section',
	array(
		'label'    => '<span class="panel-info-toggle">i</span>' . wp_kses_post( __( 'For individual page settings, edit your page and find <strong>Izo Page Options</strong> on the lower right-hand side. ', 'izo' ) ),
		'section'  => 'izo_pages_section',
	)
) );

//Styling
$wp_customize->add_setting(
	'title_single_page_styling',
	array(
		'sanitize_callback' => 'esc_html',
	)
);

$wp_customize->add_control( new Izo_Title( $wp_customize, 'title_single_page_styling',
	array(
		'label'    => esc_html__( 'Styling', 'izo' ),
		'section'  => 'izo_pages_section',
	)
) );

//Post title font size
$wp_customize->add_setting( 'single_page_title_size_desktop', array(
	'default'   => 40,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'single_page_title_size_tablet', array(
	'default'	=> 36,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'single_page_title_size_mobile', array(
	'default'	=> 28,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Izo_Responsive_Number( $wp_customize, 'single_page_title_size',
	array(
		'label' => esc_html__( 'Page title size', 'izo' ),
		'section' => 'izo_pages_section',
		'settings'   => array (
			'single_page_title_size_desktop',
			'single_page_title_size_tablet',
			'single_page_title_size_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 250,
			'step'  => 1,
		),		
	)
) );

$wp_customize->add_setting(
	'single_page_title_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'single_page_title_color',
		array(
			'label'         => esc_html__( 'Page title color', 'izo' ),
			'section'       => 'izo_pages_section',
			'settings'      => 'single_page_title_color',
		)
	)
);