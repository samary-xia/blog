<?php
/**
 * Blog Customizer options
 *
 * @package Izo
 */

$wp_customize->add_panel( 'izo_panel_blog', array(
	'priority'       => 19,
	'capability'     => 'edit_theme_options',
	'title'          => esc_html__( 'Blog', 'izo' ),
) );

/**
 * Archives
 */
$wp_customize->add_section(
	'izo_section_blog_archives',
	array(
		'title'         => esc_html__( 'Blog archives', 'izo'),
		'priority'      => 11,
		'panel'         => 'izo_panel_blog',
	)
);

$wp_customize->add_setting(
	'blog_layout',
	array(
		'default'           => 'layout-default',
		'sanitize_callback' => 'izo_sanitize_select',
	)
);
$wp_customize->add_control(
	'blog_layout',
	array(
		'type'      		=> 'select',
		'label'     		=> esc_html__( 'Blog layout', 'izo' ),
		'section'   		=> 'izo_section_blog_archives',
		'choices'   		=> array(
			'layout-default'	=> esc_html__( 'Default (classic)', 'izo' ),
			'layout-2colssb'	=> esc_html__( '2 columns and sidebar', 'izo' ),
			'layout-3cols'		=> esc_html__( '3 columns (no sidebar)', 'izo' )
		)
	)
);

$wp_customize->add_setting(
	'blog_featured_area',
	array(
		'default'           => false,
		'sanitize_callback' => 'izo_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Izo_Toggle_Control(
		$wp_customize,
		'blog_featured_area',
		array(
			'label'         	=> esc_html__( 'Enable blog featured posts area', 'izo' ),
			'section'       	=> 'izo_section_blog_archives',
			'settings'      	=> 'blog_featured_area',
		)
	)
);

$wp_customize->add_setting( 'post_item_elements', array(
	'default'  => array( 'loop_post_title', 'loop_post_meta', 'loop_image', 'loop_post_excerpt', 'loop_entry_footer' ),
	'sanitize_callback'	=> 'izo_sanitize_blog_post_elements'
) );

$wp_customize->add_control( new \Kirki\Control\Sortable( $wp_customize, 'post_item_elements', array(
	'label'   		=> esc_html__( 'Post elements', 'izo' ),
	'description'   => esc_html__( 'Drag and drop to rearrange the post elements. Click the eye icon to disable', 'izo' ),
	'section' => 'izo_section_blog_archives',
	'choices' => array(
		'loop_post_title' 		=> esc_html__( 'Post title', 'izo' ),
		'loop_post_meta' 		=> esc_html__( 'Post meta', 'izo' ),
		'loop_image' 			=> esc_html__( 'Featured image', 'izo' ),
		'loop_post_excerpt' 	=> esc_html__( 'Post excerpt', 'izo' ),
		'loop_entry_footer' 	=> esc_html__( 'Entry footer', 'izo' ),
	),
) ) );

$wp_customize->add_setting(
	'posts_navigation',
	array(
		'default'           => 'pagination',
		'sanitize_callback' => 'izo_sanitize_posts_navigation',
	)
);
$wp_customize->add_control(
	'posts_navigation',
	array(
		'type'      => 'select',
		'label'     => esc_html__( 'Posts navigation', 'izo' ),
		'section'   => 'izo_section_blog_archives',
		'choices'   => array(
			'pagination' => esc_html__( 'Pagination', 'izo' ),
			'navigation' => esc_html__( 'Older/Newer posts links', 'izo' ),
		),
	)
);  

$wp_customize->add_setting(
	'excerpt_length',
	array(
		'sanitize_callback' => 'absint',
		'default'           => 55,
	)       
);
$wp_customize->add_control( 'excerpt_length', array(
	'type'        => 'number',
	'section'     => 'izo_section_blog_archives',
	'label'       => esc_html__( 'Excerpt length', 'izo' ),
	'input_attrs' => array(
		'min'   => 0,
		'max'   => 200,
		'step'  => 1,
	),
) );

$wp_customize->add_setting(
	'continue_reading_text',
	array(
		'default'           => esc_html__( 'Continue reading', 'izo' ),
		'sanitize_callback' => 'izo_sanitize_text',
	)
);
$wp_customize->add_control(
	'continue_reading_text',
	array(
		'label' 			=> esc_html__( 'Continue reading text', 'izo' ),
		'section' 			=> 'izo_section_blog_archives',
		'type' 				=> 'text',
	)
);

$wp_customize->add_setting(
	'content_excerpt',
	array(
		'default'           => 'excerpt',
		'sanitize_callback' => 'izo_sanitize_select',
	)
);
$wp_customize->add_control(
	'content_excerpt',
	array(
		'type'      		=> 'select',
		'label'     		=> esc_html__( 'Content/excerpt', 'izo' ),
		'section'   		=> 'izo_section_blog_archives',
		'choices'   		=> array(
			'excerpt'	=> esc_html__( 'Excerpt', 'izo' ),
			'full'		=> esc_html__( 'Full content', 'izo' )
		)
	)
);


//Large archive titles font size
$wp_customize->add_setting( 'archive_title_large_size_desktop', array(
	'default'   => 32,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'archive_title_large_size_tablet', array(
	'default'	=> 28,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'archive_title_large_size_mobile', array(
	'default'	=> 22,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Izo_Responsive_Number( $wp_customize, 'archive_title_large_size',
	array(
		'label' => esc_html__( 'Post titles size (classic layout)', 'izo' ),
		'section' => 'izo_section_blog_archives',
		'settings'   => array (
			'archive_title_large_size_desktop',
			'archive_title_large_size_tablet',
			'archive_title_large_size_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 250,
			'step'  => 1,
		),		
	)
) );

//small archive titles font size
$wp_customize->add_setting( 'archive_title_small_size_desktop', array(
	'default'   => 24,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'archive_title_small_size_tablet', array(
	'default'	=> '',
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'archive_title_small_size_mobile', array(
	'default'	=> '',
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Izo_Responsive_Number( $wp_customize, 'archive_title_small_size',
	array(
		'label' => esc_html__( 'Post titles size (2 and 3 columns layouts)', 'izo' ),
		'section' => 'izo_section_blog_archives',
		'settings'   => array (
			'archive_title_small_size_desktop',
			'archive_title_small_size_tablet',
			'archive_title_small_size_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 250,
			'step'  => 1,
		),		
	)
) );

/**
 * Singles
 */
$wp_customize->add_section(
	'izo_section_blog_singles',
	array(
		'title'         => esc_html__( 'Single posts', 'izo'),
		'priority'      => 11,
		'panel'         => 'izo_panel_blog',
	)
);
$wp_customize->add_setting(
	'single_post_layout',
	array(
		'default'           => 'layout-boxed',
		'sanitize_callback' => 'izo_sanitize_select',
	)
);
$wp_customize->add_control(
	'single_post_layout',
	array(
		'type'      		=> 'select',
		'label'     		=> esc_html__( 'Single post layout', 'izo' ),
		'section'   		=> 'izo_section_blog_singles',
		'choices'   		=> array(
			'layout-boxed'		=> esc_html__( 'Boxed (default)', 'izo' ),
			'layout-unboxed'	=> esc_html__( 'Unboxed', 'izo' ),
			'layout-wide'		=> esc_html__( 'Wide (disables sidebar)', 'izo' ),
			'layout-stretched'	=> esc_html__( 'Stretched', 'izo' ),
		)
	)
);

$wp_customize->add_setting(
	'single_post_header_alignment',
	array(
		'default'           => 'left',
		'sanitize_callback' => 'izo_sanitize_select',
	)
);
$wp_customize->add_control(
	'single_post_header_alignment',
	array(
		'type'      		=> 'select',
		'label'     		=> esc_html__( 'Post header alignment', 'izo' ),
		'section'   		=> 'izo_section_blog_singles',
		'choices'   		=> array(
			'left'		=> esc_html__( 'Left', 'izo' ),
			'center'	=> esc_html__( 'Center', 'izo' ),
			'right'		=> esc_html__( 'Right', 'izo' ),
		)
	)
);

$wp_customize->add_setting(
	'single_post_enable_featured',
	array(
		'default'           => true,
		'sanitize_callback' => 'izo_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Izo_Toggle_Control(
		$wp_customize,
		'single_post_enable_featured',
		array(
			'label'         	=> esc_html__( 'Display the featured image', 'izo' ),
			'section'       	=> 'izo_section_blog_singles',
			'settings'      	=> 'single_post_enable_featured',
		)
	)
);

$wp_customize->add_setting(
	'single_post_enable_meta',
	array(
		'default'           => true,
		'sanitize_callback' => 'izo_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Izo_Toggle_Control(
		$wp_customize,
		'single_post_enable_meta',
		array(
			'label'         	=> esc_html__( 'Display author and post date', 'izo' ),
			'section'       	=> 'izo_section_blog_singles',
			'settings'      	=> 'single_post_enable_meta',
		)
	)
);

$wp_customize->add_setting(
	'single_post_enable_cats_tags',
	array(
		'default'           => true,
		'sanitize_callback' => 'izo_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Izo_Toggle_Control(
		$wp_customize,
		'single_post_enable_cats_tags',
		array(
			'label'         	=> esc_html__( 'Display the categories and tags', 'izo' ),
			'section'       	=> 'izo_section_blog_singles',
			'settings'      	=> 'single_post_enable_cats_tags',
		)
	)
);

$wp_customize->add_setting(
	'info_single_posts_section',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Izo_Info( $wp_customize, 'info_single_posts_section',
	array(
		'label'    => '<span class="panel-info-toggle">i</span>' . wp_kses_post( __( 'For individual post settings, edit your post and find <strong>Izo Page Options</strong> on the lower right-hand side. ', 'izo' ) ),
		'section'  => 'izo_section_blog_singles',
	)
) );

//Styling
$wp_customize->add_setting(
	'title_single_post_styling',
	array(
		'sanitize_callback' => 'esc_html',
	)
);

$wp_customize->add_control( new Izo_Title( $wp_customize, 'title_single_post_styling',
	array(
		'label'    => esc_html__( 'Styling', 'izo' ),
		'section'  => 'izo_section_blog_singles',
	)
) );

//Post title font size
$wp_customize->add_setting( 'single_post_title_size_desktop', array(
	'default'   => 40,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'single_post_title_size_tablet', array(
	'default'	=> 36,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'single_post_title_size_mobile', array(
	'default'	=> 28,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Izo_Responsive_Number( $wp_customize, 'single_post_title_size',
	array(
		'label' => esc_html__( 'Post title size', 'izo' ),
		'section' => 'izo_section_blog_singles',
		'settings'   => array (
			'single_post_title_size_desktop',
			'single_post_title_size_tablet',
			'single_post_title_size_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 250,
			'step'  => 1,
		),		
	)
) );

$wp_customize->add_setting(
	'single_post_title_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'single_post_title_color',
		array(
			'label'         => esc_html__( 'Post title color', 'izo' ),
			'section'       => 'izo_section_blog_singles',
			'settings'      => 'single_post_title_color',
		)
	)
);