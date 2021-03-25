<?php
/**
 * Shop Customizer options
 *
 * @package Izo
 */

//Layout
$wp_customize->add_setting(
	'shop_archive_layout',
	array(
		'default'           => 'no-sidebar',
		'sanitize_callback' => 'sanitize_key',
	)
);
$wp_customize->add_control(
	new Izo_Radio_Images(
		$wp_customize,
		'shop_archive_layout',
		array(
			'label'    => esc_html__( 'Product catalog and archives layout', 'izo' ),
			'section'  => 'woocommerce_product_catalog',
			'choices'  => array(
				'no-sidebar' => array(
					'label' => esc_html__( 'Default', 'izo' ),
					'url'   => '%s/assets/images/catalogl1.jpg'
				),
				'sidebar-left' => array(
					'label' => esc_html__( 'Sidebar left', 'izo' ),
					'url'   => '%s/assets/images/catalogl2.jpg'
				),
				'sidebar-right' => array(
					'label' => esc_html__( 'Sidebar right', 'izo' ),
					'url'   => '%s/assets/images/catalogl3.jpg'
				),				
			)
		)
	)
); 

$wp_customize->add_setting( 'loop_product_title_size_desktop', array(
	'default'   		=> 16,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'loop_product_title_size_tablet', array(
	'default'	=> 16,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'loop_product_title_size_mobile', array(
	'default'	=> 16,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Izo_Responsive_Number( $wp_customize, 'loop_product_title_size',
	array(
		'label' => esc_html__( 'Product title font size', 'izo' ),
		'section' => 'woocommerce_product_catalog',
		'settings'   => array (
			'loop_product_title_size_desktop',
			'loop_product_title_size_tablet',
			'loop_product_title_size_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 250,
			'step'  => 1,
		),		
	)
) );

$wp_customize->add_setting(
	'loop_product_title_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'loop_product_title_color',
		array(
			'label'         	=> esc_html__( 'Product title color', 'izo' ),
			'section'       	=> 'woocommerce_product_catalog',
		)
	)
);

$wp_customize->add_setting( 'loop_product_price_size_desktop', array(
	'default'   => 16,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'loop_product_price_size_tablet', array(
	'default'	=> 16,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'loop_product_price_size_mobile', array(
	'default'	=> 16,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Izo_Responsive_Number( $wp_customize, 'loop_product_price_size',
	array(
		'label' => esc_html__( 'Product price font size', 'izo' ),
		'section' => 'woocommerce_product_catalog',
		'settings'   => array (
			'loop_product_price_size_desktop',
			'loop_product_price_size_tablet',
			'loop_product_price_size_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 250,
			'step'  => 1,
		),		
	)
) );

$wp_customize->add_setting(
	'loop_product_price_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'loop_product_price_color',
		array(
			'label'         	=> esc_html__( 'Product price color', 'izo' ),
			'section'       	=> 'woocommerce_product_catalog',
		)
	)
);

/**
 * Single products
 */
$wp_customize->add_section(
	'izo_single_products',
	array(
		'title'         => esc_html__( 'Single products', 'izo' ),
		'priority'      => 11,
		'panel'			=> 'woocommerce'
	)
);

//Layout
$wp_customize->add_setting(
	'single_product_layout',
	array(
		'default'           => 'no-sidebar',
		'sanitize_callback' => 'sanitize_key',
	)
);
$wp_customize->add_control(
	new Izo_Radio_Images(
		$wp_customize,
		'single_product_layout',
		array(
			'label'    => esc_html__( 'Layout', 'izo' ),
			'section'  => 'izo_single_products',
			'choices'  => array(
				'no-sidebar' => array(
					'label' => esc_html__( 'Default', 'izo' ),
					'url'   => '%s/assets/images/productl1.jpg'
				),
				'sidebar-left' => array(
					'label' => esc_html__( 'Sidebar left', 'izo' ),
					'url'   => '%s/assets/images/productl2.jpg'
				),
				'sidebar-right' => array(
					'label' => esc_html__( 'Sidebar right', 'izo' ),
					'url'   => '%s/assets/images/productl3.jpg'
				),				
			)
		)
	)
); 

$wp_customize->add_setting(
	'disable_single_product_breadcrumbs',
	array(
		'default'           => 0,
		'sanitize_callback' => 'izo_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Izo_Toggle_Control(
		$wp_customize,
		'disable_single_product_breadcrumbs',
		array(
			'label'         	=> esc_html__( 'Disable breadcrumbs', 'izo' ),
			'section'       	=> 'izo_single_products',
		)
	)
);

$wp_customize->add_setting(
	'disable_single_product_related',
	array(
		'default'           => 0,
		'sanitize_callback' => 'izo_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Izo_Toggle_Control(
		$wp_customize,
		'disable_single_product_related',
		array(
			'label'         	=> esc_html__( 'Disable related products', 'izo' ),
			'section'       	=> 'izo_single_products',
		)
	)
);

$wp_customize->add_setting(
	'disable_single_product_upsells',
	array(
		'default'           => 0,
		'sanitize_callback' => 'izo_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Izo_Toggle_Control(
		$wp_customize,
		'disable_single_product_upsells',
		array(
			'label'         	=> esc_html__( 'Disable upsell products', 'izo' ),
			'section'       	=> 'izo_single_products',
		)
	)
);

$wp_customize->add_setting(
	'disable_single_product_meta',
	array(
		'default'           => 0,
		'sanitize_callback' => 'izo_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Izo_Toggle_Control(
		$wp_customize,
		'disable_single_product_meta',
		array(
			'label'         	=> esc_html__( 'Disable product meta', 'izo' ),
			'section'       	=> 'izo_single_products',
		)
	)
);

$wp_customize->add_setting(
	'disable_single_product_rating',
	array(
		'default'           => 0,
		'sanitize_callback' => 'izo_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Izo_Toggle_Control(
		$wp_customize,
		'disable_single_product_rating',
		array(
			'label'         	=> esc_html__( 'Disable product rating', 'izo' ),
			'section'       	=> 'izo_single_products',
		)
	)
);

//Styling
$wp_customize->add_setting(
	'title_single_product_styling',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Izo_Title( $wp_customize, 'title_single_product_styling',
	array(
		'label'    => esc_html__( 'Styling', 'izo' ),
		'section'  => 'izo_single_products',
	)
) );

$wp_customize->add_setting( 'single_product_title_size_desktop', array(
	'default'   => 40,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'single_product_title_size_tablet', array(
	'default'	=> 36,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'single_product_title_size_mobile', array(
	'default'	=> 28,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Izo_Responsive_Number( $wp_customize, 'single_product_title_size',
	array(
		'label' => esc_html__( 'Product title font size', 'izo' ),
		'section' => 'izo_single_products',
		'settings'   => array (
			'single_product_title_size_desktop',
			'single_product_title_size_tablet',
			'single_product_title_size_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 250,
			'step'  => 1,
		),		
	)
) );

$wp_customize->add_setting(
	'single_product_title_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'single_product_title_color',
		array(
			'label'         	=> esc_html__( 'Product title color', 'izo' ),
			'section'       	=> 'izo_single_products',
		)
	)
);

$wp_customize->add_setting( 'single_product_price_size_desktop', array(
	'default'   => 22,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'single_product_price_size_tablet', array(
	'default'	=> 22,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'single_product_price_size_mobile', array(
	'default'	=> 22,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Izo_Responsive_Number( $wp_customize, 'single_product_price_size',
	array(
		'label' => esc_html__( 'Product price font size', 'izo' ),
		'section' => 'izo_single_products',
		'settings'   => array (
			'single_product_price_size_desktop',
			'single_product_price_size_tablet',
			'single_product_price_size_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 250,
			'step'  => 1,
		),		
	)
) );

$wp_customize->add_setting(
	'single_product_price_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'single_product_price_color',
		array(
			'label'         	=> esc_html__( 'Product price color', 'izo' ),
			'section'       	=> 'izo_single_products',
		)
	)
);