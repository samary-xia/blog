<?php
/**
 * new blog Theme Customizer
 *
 * @package new_blog
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function new_blog_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'new_blog_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'new_blog_customize_partial_blogdescription',
		) );
	}
	//Upgrade to Pro
	// Register custom section types.
	$wp_customize->register_section_type( 'New_Blog_Customize_Section_Upsell' );

	// Register sections.
	$wp_customize->add_section(
		new New_Blog_Customize_Section_Upsell(
			$wp_customize,
			'theme_upsell',
			array(
				'title'    => esc_html__( 'Go Pro','new-blog'),
				'pro_text' => esc_html__( 'Buy Pro New Blog','new-blog' ),
				'pro_url'  => esc_url('https://www.postmagthemes.com/downloads/pro-new-blog-wordpress-theme/'),
				'priority' => 1,
			)
		)
	);
}
add_action( 'customize_register', 'new_blog_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function new_blog_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function new_blog_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function new_blog_customize_preview_js() {
	wp_enqueue_script( 'new-blog-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'new_blog_customize_preview_js' );

function new_blog_customize_other( $wp_customize ) {

// THEME OPTION panel
$wp_customize->add_panel( 'new_blog_theme_option_panel', array(
	'priority'	=> 21,
	'title'		=> __( 'Theme options', 'new-blog' )
) );

/**
 * Enqueue required scripts/styles for customizer panel
 *
 * @since 1.0.0
 */
function new_blog_customize_backend_scripts() {
	wp_enqueue_script( 'new-blog-customize-controls', get_template_directory_uri() . '/inc/upgrade-to-pro/pro.js', array( 'customize-controls' ) );
	wp_enqueue_style( 'new-blog-customize-controls', get_template_directory_uri() . '/inc/upgrade-to-pro/pro.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'new_blog_customize_backend_scripts', 10 );


					///////// 'Banner Slider section'  ////////////

$wp_customize->add_section( 'new_blog_banner_slider_section',
array(
	'title'      => __( 'Banner slider section', 'new-blog' ),
	'priority'   => 20,
	'panel'		=> 'new_blog_theme_option_panel'
) );

$wp_customize->add_setting( 'new_blog_banner_slider_enable', 
array(
	
	'default'     => 1,
	'sanitize_callback' => 'new_blog_sanitize_checkbox'
) );

$wp_customize->add_control( 'new_blog_banner_slider_enable', 
	array(
		'label' 	=> __( 'Display Banner slider', 'new-blog' ),
		'section'	=> 'new_blog_banner_slider_section',
		'settings' 	=> 'new_blog_banner_slider_enable',
		'type'      => 'checkbox',

	) 
);

$wp_customize->add_setting( 'new_blog_banner_slider_order', 
array(
	
	'default'     => 'date',
	'sanitize_callback' => 'new_blog_sanitize_select'
) );

$wp_customize->add_control( 'new_blog_banner_slider_order', 
	array(
		'label' 	=> __( 'Order by', 'new-blog' ),
		'section'	=> 'new_blog_banner_slider_section',
		'settings' 	=> 'new_blog_banner_slider_order',
		'type'      => 'select',
		'choices'	=> array (
			'date'	=> __( 'Recent publish date', 'new-blog' ),
			'comment_count' => __( 'Most commented ', 'new-blog' ),
		)

	) 
);

require_once( trailingslashit( get_template_directory() ) . 'inc/dropdown-category.php' );
$wp_customize->add_setting( 'new_blog_banner_slider_categorylist', 
array(
	'default'     =>  0,
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new New_Blog_My_Dropdown_Category_Control( $wp_customize, 'new_blog_banner_slider_categorylist', array(
	
		'label' 	=> __( 'Select the post among', 'new-blog' ),
		'section'	=> 'new_blog_banner_slider_section',
		
) 	)	
);

$wp_customize->add_setting( 'new_blog_banner_slider_noofpost', 
array(
	'default'     => 7,
	'sanitize_callback' => 'new_blog_sanitize_positive_integer'
) );

$wp_customize->add_control( 'new_blog_banner_slider_noofpost', 
	array(
		'label' 	=> __( 'Number of post to show', 'new-blog' ),
		'section'	=> 'new_blog_banner_slider_section',
		'settings' 	=> 'new_blog_banner_slider_noofpost',
		'type' 		=> 'number',
	) 
);

$post_taxonomy_arrays = array(__('Excerpt','new-blog'),__('ReadMore','new-blog'),__('Category','new-blog'));
foreach ($post_taxonomy_arrays as  $post_taxonomy) {
	$wp_customize->add_setting( 'new_blog_banner_slider_post_taxonomy_'.$post_taxonomy, array(
	'capability'            => 'edit_theme_options',
	'default'               => 1,
	'sanitize_callback' => 'new_blog_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'new_blog_banner_slider_post_taxonomy_'.$post_taxonomy, array(
		/* translators: %s: Label */ 
		'label'                 =>  sprintf( __( '%s display', 'new-blog' ), $post_taxonomy ),
		'section'               => 'new_blog_banner_slider_section',
		'type'                  => 'checkbox',
		'settings' => 'new_blog_banner_slider_post_taxonomy_'.$post_taxonomy,

	) );
}

				//////// 'Feature post section' //////////
$wp_customize->add_section( 'new_blog_feature_post_section',
array(
	'title'      => __( 'Feature post section', 'new-blog' ),
	'priority'   => 20,
	'panel'		=> 'new_blog_theme_option_panel'
) );

$wp_customize->add_setting( 'new_blog_feature_post_enable', 
array(
	
	'default'     => 1,
	'sanitize_callback' => 'new_blog_sanitize_checkbox'
) );

$wp_customize->add_control( 'new_blog_feature_post_enable', 
	array(
		'label' 	=> __( 'Display Feature post', 'new-blog' ),
		'section'	=> 'new_blog_feature_post_section',
		'settings' 	=> 'new_blog_feature_post_enable',
		'type'      => 'checkbox',

	) 
);

$wp_customize->add_setting( 'new_blog_feature_post_order', 
array(
	
	'default'     => 'date',
	'sanitize_callback' => 'new_blog_sanitize_select'
) );

$wp_customize->add_control( 'new_blog_feature_post_order', 
	array(
		'label' 	=> __( 'Order by', 'new-blog' ),
		'section'	=> 'new_blog_feature_post_section',
		'settings' 	=> 'new_blog_feature_post_order',
		'type'      => 'select',
		'choices'	=> array (
			'date'	=> __( 'Recent publish date', 'new-blog' ),
			'comment_count' => __( 'Most commented ', 'new-blog' ),
		)

	) 
);

require_once( trailingslashit( get_template_directory() ) . 'inc/dropdown-category.php' );
$wp_customize->add_setting( 'new_blog_feature_post_categorylist', 
array(
	'default'     => 0,
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new New_Blog_My_Dropdown_Category_Control( $wp_customize, 'new_blog_feature_post_categorylist', array(
	
		'label' 	=> __( 'Select the post among', 'new-blog' ),
		'section'	=> 'new_blog_feature_post_section',
		
) 	)	
);

$wp_customize->add_setting( 'new_blog_feature_post_noofpost', 
array(
	'default'     => 4,
	'sanitize_callback' => 'new_blog_sanitize_positive_integer'
) );

$wp_customize->add_control( 'new_blog_feature_post_noofpost', 
	array(
		'label' 	=> __( 'Number of post to show', 'new-blog' ),
		'section'	=> 'new_blog_feature_post_section',
		'settings' 	=> 'new_blog_feature_post_noofpost',
		'type' 		=> 'number',
	) 
);

$post_taxonomy_arrays = array(__('Category','new-blog'),__('UseBlankImage','new-blog'));
foreach ($post_taxonomy_arrays as  $post_taxonomy) {
	$wp_customize->add_setting( 'new_blog_feature_post_post_taxonomy_'.$post_taxonomy, array(
	'capability'            => 'edit_theme_options',
	'default'               => 1,
	'sanitize_callback' => 'new_blog_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'new_blog_feature_post_post_taxonomy_'.$post_taxonomy, array(
		/* translators: %s: Label */ 
		'label'                 =>  sprintf( __( '%s display', 'new-blog' ), $post_taxonomy ),
		'section'               => 'new_blog_feature_post_section',
		'type'                  => 'checkbox',
		'settings' => 'new_blog_feature_post_post_taxonomy_'.$post_taxonomy,

	) );
}
	
///////   'Blog post section'  ////////////

$wp_customize->add_section( 'new_blog_blog_post_section',
array(
	'title'      => __( 'Blog post section', 'new-blog' ),
	'priority'   => 20,
	'panel'		=> 'new_blog_theme_option_panel'
) );

$wp_customize->add_setting( 'new_blog_blog_post_enable', 
array(
	
	'default'     => 1,
	'sanitize_callback' => 'new_blog_sanitize_checkbox'
) );

$wp_customize->add_control( 'new_blog_blog_post_enable', 
	array(
		'label' 	=> __( 'Display Blog post', 'new-blog' ),
		'section'	=> 'new_blog_blog_post_section',
		'settings' 	=> 'new_blog_blog_post_enable',
		'type'      => 'checkbox',
		'description' => __('Below settings are applicable to archive and search page as well', 'new-blog'),


	) 
);

$post_taxonomy_arrays = array(__('Category','new-blog'),__('Date','new-blog'),__('Comment','new-blog'),__('Tag','new-blog'),__('ReadMore','new-blog'),__('UseBlankImage','new-blog'),__('TimeAgo','new-blog'));
foreach ($post_taxonomy_arrays as  $post_taxonomy) {
	$wp_customize->add_setting( 'new_blog_blog_post_post_taxonomy_'.$post_taxonomy, array(
	'capability'            => 'edit_theme_options',
	'default'               => 1,
	'sanitize_callback' => 'new_blog_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'new_blog_blog_post_post_taxonomy_'.$post_taxonomy, array(
		/* translators: %s: Label */ 
		'label'                 =>  sprintf( __( '%s display', 'new-blog' ), $post_taxonomy ),
		'section'               => 'new_blog_blog_post_section',
		'type'                  => 'checkbox',
		'settings' => 'new_blog_blog_post_post_taxonomy_'.$post_taxonomy,

	) );
}


$wp_customize->add_setting( 'new_blog_blog_post_layout', 
array(
	'default'     => 1,
	'sanitize_callback' => 'new_blog_sanitize_select'
) );

$wp_customize->add_control( 'new_blog_blog_post_layout', 
	array(
		'label' 	=> __( 'Display type', 'new-blog' ),
		'section'	=> 'new_blog_blog_post_section',
		'settings' 	=> 'new_blog_blog_post_layout',
		'type' 		=> 'select',
		'choices'	=> array(
		'1'			=> __('1 colume type','new-blog'),
		'2'			=> __('2 colume type','new-blog'),

		)
	) 
);
// Global read min

    /*----------------------------------------------------------------------------------------------------------------------------------------*/
    /**
     *Enable/Disable min read
     * @since 1.0.0
     */
    $wp_customize->add_setting(
		'global_show_min_read',
		array(
		  'default'           => 1,
		  'sanitize_callback' => 'new_blog_sanitize_checkbox',
		)
	  );
	  
	  $wp_customize->add_control(
		'global_show_min_read',
		array(
		  'section'     => 'new_blog_blog_post_section',
		  'label'       => __( 'Enable/Disable Minutes Read Count', 'new-blog' ),
		  'type'        => 'checkbox'
		)       
	  );
  
	  $wp_customize->add_setting('global_show_min_read_number',
		  array(
			  'default' => 150,
			  'capability' => 'edit_theme_options',
			  'sanitize_callback' => 'absint',
		  )
	  );
	  $wp_customize->add_control('global_show_min_read_number',
		  array(
			  'label' => esc_html__('Number of Words per Minute Read', 'new-blog'),
			  'section' => 'new_blog_blog_post_section',
			  'type' => 'number',
			  'priority' => 20
		  )
	  ); 
								///////   'Footer slider section'  ////////////

$wp_customize->add_section( 'new_blog_footer_slider_section',
array(
	'title'      => __( 'Footer section', 'new-blog' ),
	'priority'   => 20,
	'panel'		=> 'new_blog_theme_option_panel'
) );

$wp_customize->add_setting( 'new_blog_footer_slider_enable', 
array(
	
	'default'     => 1,
	'sanitize_callback' => 'new_blog_sanitize_checkbox'
) );

$wp_customize->add_control( 'new_blog_footer_slider_enable', 
	array(
		'label' 	=> __( 'Display Footer slider', 'new-blog' ),
		'section'	=> 'new_blog_footer_slider_section',
		'settings' 	=> 'new_blog_footer_slider_enable',
		'type'      => 'checkbox',

	) 
);

$wp_customize->add_setting( 'new_blog_footer_slider_order', 
array(
	
	'default'     => 'date',
	'sanitize_callback' => 'new_blog_sanitize_select'
) );

$wp_customize->add_control( 'new_blog_footer_slider_order', 
	array(
		'label' 	=> __( 'Order by', 'new-blog' ),
		'section'	=> 'new_blog_footer_slider_section',
		'settings' 	=> 'new_blog_footer_slider_order',
		'type'      => 'select',
		'choices'	=> array (
			'date'	=> __( 'Recent publish date', 'new-blog' ),
			'comment_count' => __( 'Most commented ', 'new-blog' ),
		)

	) 
);

require_once( trailingslashit( get_template_directory() ) . 'inc/dropdown-category.php' );
$wp_customize->add_setting( 'new_blog_footer_slider_categorylist', 
array(
	'default'     =>  0,
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new New_Blog_My_Dropdown_Category_Control( $wp_customize, 'new_blog_footer_slider_categorylist', array(
	
		'label' 	=> __( 'Select the post among', 'new-blog' ),
		'section'	=> 'new_blog_footer_slider_section',
		
) 	)	
);

$wp_customize->add_setting( 'new_blog_footer_slider_noofpost', 
array(
	'default'     => 7,
	'sanitize_callback' => 'new_blog_sanitize_positive_integer'
) );

$wp_customize->add_control( 'new_blog_footer_slider_noofpost', 
	array(
		'label' 	=> __( 'Number of post to show', 'new-blog' ),
		'section'	=> 'new_blog_footer_slider_section',
		'settings' 	=> 'new_blog_footer_slider_noofpost',
		'type' 		=> 'number',
	) 
);

$post_taxonomy_arrays = array(__('UseBlankImage','new-blog'));
foreach ($post_taxonomy_arrays as  $post_taxonomy) {
	$wp_customize->add_setting( 'new_blog_footer_slider_post_taxonomy_'.$post_taxonomy, array(
	'capability'            => 'edit_theme_options',
	'default'               => 1,
	'sanitize_callback' => 'new_blog_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'new_blog_footer_slider_post_taxonomy_'.$post_taxonomy, array(
		/* translators: %s: Label */ 
		'label'                 =>  sprintf( __( '%s display', 'new-blog' ), $post_taxonomy ),
		'section'               => 'new_blog_footer_slider_section',
		'type'                  => 'checkbox',
		'settings' => 'new_blog_footer_slider_post_taxonomy_'.$post_taxonomy,

	) );
}

$wp_customize->add_setting( 'new_blog_footer_title', 
array(
	
	'default'     => 1,
	'sanitize_callback' => 'new_blog_sanitize_checkbox'
) );

$wp_customize->add_control( 'new_blog_footer_title', 
	array(
		'label' 	=> __( 'Display site title at footer', 'new-blog' ),
		'section'	=> 'new_blog_footer_slider_section',
		'settings' 	=> 'new_blog_footer_title',
		'type'      => 'checkbox',

	) 
);

	// 'Social link' section
$wp_customize->add_section( 'new_blog_section_social_section',
array(
	'title'      => __( 'Social link section', 'new-blog' ),
	'priority'   => 20,
	'panel'		=> 'new_blog_theme_option_panel'
) );
	////	enable social link at variuos places  /////

	$wp_customize->add_setting( 'new_blog_social_top_enable', array(
		'capability'            => 'edit_theme_options',
		'default'               => 0,
		'sanitize_callback'     => 'new_blog_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'new_blog_social_top_enable', array(
		'label'                 =>  __( 'Enable Social link at top', 'new-blog' ),
		'section'               => 'new_blog_section_social_section',
		'type'                  => 'checkbox',
		'settings'              => 'new_blog_social_top_enable',
	) );

$wp_customize->add_setting( 'new_blog_social_sidebar_enable', array(
	'capability'            => 'edit_theme_options',
	'default'               => 0,
	'sanitize_callback'     => 'new_blog_sanitize_checkbox'
) );
$wp_customize->add_control( 'new_blog_social_sidebar_enable', array(
	'label'                 =>  __( 'Enable Social link at sidebar', 'new-blog' ),
	'section'               => 'new_blog_section_social_section',
	'type'                  => 'checkbox',
	'settings'              => 'new_blog_social_sidebar_enable',
) );
$wp_customize->add_setting( 'new_blog_social_sidebar_title', array(
	'capability'            => 'edit_theme_options',
	'default'               => __('Stay connected','new-blog'),
	'sanitize_callback'     => 'sanitize_text_field'
) );
$wp_customize->add_control( 'new_blog_social_sidebar_title', array(
	'label'                 =>  __( 'Title Social link at sidebar', 'new-blog' ),
	'section'               => 'new_blog_section_social_section',
	'settings'              => 'new_blog_social_sidebar_title',
	'type'					=> 'text',
) );
$wp_customize->add_setting( 'new_blog_social_bottom_enable', array(
	'capability'            => 'edit_theme_options',
	'default'               => 0,
	'sanitize_callback'     => 'new_blog_sanitize_checkbox'
) );
$wp_customize->add_control( 'new_blog_social_bottom_enable', array(
	'label'                 =>  __( 'Enable Social link at bottom', 'new-blog' ),
	'section'               => 'new_blog_section_social_section',
	'type'                  => 'checkbox',
	'settings'              => 'new_blog_social_bottom_enable',
) );


// Socail url
$social_name_arrays = array(__('Facebook','new-blog'),__('Twitter','new-blog'),__('Youtube','new-blog'),__('Pinterest','new-blog'));
foreach ($social_name_arrays as  $social_name) {
	$wp_customize->add_setting( 'new_blog_social_url_'.$social_name, array(
	'capability'            => 'edit_theme_options',
	'default'               => '',
	'sanitize_callback' => 'new_blog_sanitize_url'
	) );

	$wp_customize->add_control( 'new_blog_social_url_'.$social_name, array(
		/* translators: %s: Label */ 
		'label'                 =>  sprintf( __( '%s Url', 'new-blog' ), $social_name ),
		'section'               => 'new_blog_section_social_section',
		'type'                  => 'url',
		'settings' => 'new_blog_social_url_'.$social_name,
	) );
}
//Socail Url Enable or disable by checkboxs

$wp_customize->add_setting( 'new_blog_facebook_url_enable', array(
	'capability'            => 'edit_theme_options',
	'default'               => 1,
	'sanitize_callback'     => 'new_blog_sanitize_checkbox'
) );

$wp_customize->add_control( 'new_blog_facebook_url_enable', array(
	'label'                 =>  __( 'Enable facebook Icon', 'new-blog' ),
	'section'               => 'new_blog_section_social_section',
	'type'                  => 'checkbox',
	'settings'              => 'new_blog_facebook_url_enable',
) );
$wp_customize->add_setting( 'new_blog_twitter_url_enable', array(
	'capability'            => 'edit_theme_options',
	'default'               => 1,
	'sanitize_callback'     => 'new_blog_sanitize_checkbox'
) );

$wp_customize->add_control( 'new_blog_twitter_url_enable', array(
	'label'                 =>  __( 'Enable twitter Icon', 'new-blog' ),
	'section'               => 'new_blog_section_social_section',
	'type'                  => 'checkbox',
	'settings'              => 'new_blog_twitter_url_enable',
) );

$wp_customize->add_setting( 'new_blog_youtube_url_enable', array(
	'capability'            => 'edit_theme_options',
	'default'               => 1,
	'sanitize_callback'     => 'new_blog_sanitize_checkbox'
) );

$wp_customize->add_control( 'new_blog_youtube_url_enable', array(
	'label'                 =>  __( 'Enable youtube Icon', 'new-blog' ),
	'section'               => 'new_blog_section_social_section',
	'type'                  => 'checkbox',
	'settings'              => 'new_blog_youtube_url_enable',
) );

$wp_customize->add_setting( 'new_blog_pinterest_url_enable', array(
	'capability'            => 'edit_theme_options',
	'default'               => 1,
	'sanitize_callback'     => 'new_blog_sanitize_checkbox'
) );

$wp_customize->add_control( 'new_blog_pinterest_url_enable', array(
	'label'                 =>  __( 'Enable pinterest Icon', 'new-blog' ),
	'section'               => 'new_blog_section_social_section',
	'type'                  => 'checkbox',
	'settings'              => 'new_blog_pinterest_url_enable',
) );

	
//////   'Sidebar  section enable'  ////////////

$wp_customize->add_setting( 'new_blog_sidebar_enable', 
array(
	
	'default'     => 1,
	'sanitize_callback' => 'new_blog_sanitize_checkbox'
) );

$wp_customize->add_control( 'new_blog_sidebar_enable', 
	array(
		'label' 	=> __( 'Display Sidebar', 'new-blog' ),
		'section'	=> 'new_blog_sidebar_section',
		'settings' 	=> 'new_blog_sidebar_enable',
		'type'      => 'checkbox',

	) 
);
$wp_customize->add_setting( 'new_blog_sidebar_enable_page', 
array(
	
	'default'     => 1,
	'sanitize_callback' => 'new_blog_sanitize_checkbox'
) );

$wp_customize->add_control( 'new_blog_sidebar_enable_page', 
	array(
		'label' 	=> __( 'Display Sidebar on page', 'new-blog' ),
		'section'	=> 'new_blog_sidebar_section',
		'settings' 	=> 'new_blog_sidebar_enable_page',
		'type'      => 'checkbox',

	) 
);

//////   'Sidebar about section'  ////////////

$wp_customize->add_setting( 'new_blog_sidebar_about_enable', 
array(
	
	'default'     => 0,
	'sanitize_callback' => 'new_blog_sanitize_checkbox'
) );

$wp_customize->add_control( 'new_blog_sidebar_about_enable', 
	array(
		'label' 	=> __( 'Display about', 'new-blog' ),
		'section'	=> 'new_blog_sidebar_section',
		'settings' 	=> 'new_blog_sidebar_about_enable',
		'type'      => 'checkbox',

	) 
);
$wp_customize->add_setting( 'new_blog_sidebar_about_title', 
array(
	
	'default'     => __('About Me','new-blog'),
	'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( 'new_blog_sidebar_about_title', 
	array(
		'label' 	=> __( 'Display about', 'new-blog' ),
		'section'	=> 'new_blog_sidebar_section',
		'settings' 	=> 'new_blog_sidebar_about_title',
		'type'      => 'text',

	) 
);
$wp_customize->add_setting( 'new_blog_sidebar_about_textarea', 
array(
	
	'default'     => __('Mauris eget pharetra lectus', 'new-blog'),
	'sanitize_callback' => 'sanitize_textarea_field'
) );

$wp_customize->add_control( 'new_blog_sidebar_about_textarea', 
	array(
		'label' 	=> __( 'Write about', 'new-blog' ),
		'section'	=> 'new_blog_sidebar_section',
		'settings' 	=> 'new_blog_sidebar_about_textarea',
		'type'      => 'textarea',

	) 
);
$wp_customize->add_setting( 'new_blog_sidebar_about_image', 
array(
	
	'default'     => '',
	'sanitize_callback' => 'sanitize_textarea_field'
) );
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'logo',
		array(
			'label'      => __( 'Upload a image', 'new-blog' ),
			'section'    => 'new_blog_sidebar_section',
			'settings'   => 'new_blog_sidebar_about_image',
			'context'    => 'your_setting_context' 
		)
	)
);

			///////   'Sidebar slider section'  ////////////

$wp_customize->add_section( 'new_blog_sidebar_section',
array(
	'title'      => __( 'Sidebar section', 'new-blog' ),
	'priority'   => 20,
	'panel'		=> 'new_blog_theme_option_panel'
) );


$wp_customize->add_setting( 'new_blog_sidebar_slider_enable', 
array(
	
	'default'     => 1,
	'sanitize_callback' => 'new_blog_sanitize_checkbox'
) );

$wp_customize->add_control( 'new_blog_sidebar_slider_enable', 
	array(
		'label' 	=> __( 'Display slider at sidebar', 'new-blog' ),
		'section'	=> 'new_blog_sidebar_section',
		'settings' 	=> 'new_blog_sidebar_slider_enable',
		'type'      => 'checkbox',

	) 
);

$wp_customize->add_setting( 'new_blog_sidebar_slider_order', 
array(
	
	'default'     => 'date',
	'sanitize_callback' => 'new_blog_sanitize_select'
) );

$wp_customize->add_control( 'new_blog_sidebar_slider_order', 
	array(
		'label' 	=> __( 'Order by', 'new-blog' ),
		'section'	=> 'new_blog_sidebar_section',
		'settings' 	=> 'new_blog_sidebar_slider_order',
		'type'      => 'select',
		'choices'	=> array (
			'date'	=> __( 'Recent publish date', 'new-blog' ),
			'comment_count' => __( 'Most commented ', 'new-blog' ),
		)

	) 
);

require_once( trailingslashit( get_template_directory() ) . 'inc/dropdown-category.php' );
$wp_customize->add_setting( 'new_blog_sidebar_slider_categorylist', 
array(
	'default'     =>  0,
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new New_Blog_My_Dropdown_Category_Control( $wp_customize, 'new_blog_sidebar_slider_categorylist', array(
	
		'label' 	=> __( 'Select the post among', 'new-blog' ),
		'section'	=> 'new_blog_sidebar_section',
		
) 	)	
);

$wp_customize->add_setting( 'new_blog_sidebar_slider_noofpost', 
array(
	'default'     => 7,
	'sanitize_callback' => 'new_blog_sanitize_positive_integer'
) );

$wp_customize->add_control( 'new_blog_sidebar_slider_noofpost', 
	array(
		'label' 	=> __( 'Number of post to show', 'new-blog' ),
		'section'	=> 'new_blog_sidebar_section',
		'settings' 	=> 'new_blog_sidebar_slider_noofpost',
		'type' 		=> 'number',
	) 
);

$post_taxonomy_arrays = array(__('Category','new-blog'),__('UseBlankImage','new-blog'));
foreach ($post_taxonomy_arrays as  $post_taxonomy) {
	$wp_customize->add_setting( 'new_blog_sidebar_slider_post_taxonomy_'.$post_taxonomy, array(
	'capability'            => 'edit_theme_options',
	'default'               => 1,
	'sanitize_callback' => 'new_blog_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'new_blog_sidebar_slider_post_taxonomy_'.$post_taxonomy, array(
		/* translators: %s: Label */ 
		'label'                 =>  sprintf( __( '%s display', 'new-blog' ), $post_taxonomy ),
		'section'               => 'new_blog_sidebar_section',
		'type'                  => 'checkbox',
		'settings' => 'new_blog_sidebar_slider_post_taxonomy_'.$post_taxonomy,

	) );
}

///////   'Sidebar post section'  ////////////

$wp_customize->add_setting( 'new_blog_sidebar_post_enable', 
array(
	
	'default'     => 1,
	'sanitize_callback' => 'new_blog_sanitize_checkbox'
) );

$wp_customize->add_control( 'new_blog_sidebar_post_enable', 
	array(
		'label' 	=> __( 'Display Sidebar post', 'new-blog' ),
		'section'	=> 'new_blog_sidebar_section',
		'settings' 	=> 'new_blog_sidebar_post_enable',
		'type'      => 'checkbox',

	) 
);
$wp_customize->add_setting( 'new_blog_sidebar_post_title', 
array(
	
	'default'     => __('Latest Posts','new-blog'),
	'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( 'new_blog_sidebar_post_title', 
	array(
		'label' 	=> __( 'Display Sidebar post', 'new-blog' ),
		'section'	=> 'new_blog_sidebar_section',
		'settings' 	=> 'new_blog_sidebar_post_title',
		'type'      => 'text',

	) 
);

$wp_customize->add_setting( 'new_blog_sidebar_post_order', 
array(
	
	'default'     => 'date',
	'sanitize_callback' => 'new_blog_sanitize_select'
) );

$wp_customize->add_control( 'new_blog_sidebar_post_order', 
	array(
		'label' 	=> __( 'Order by', 'new-blog' ),
		'section'	=> 'new_blog_sidebar_section',
		'settings' 	=> 'new_blog_sidebar_post_order',
		'type'      => 'select',
		'choices'	=> array (
			'date'	=> __( 'Recent publish date', 'new-blog' ),
			'comment_count' => __( 'Most commented ', 'new-blog' ),
		)

	) 
);

require_once( trailingslashit( get_template_directory() ) . 'inc/dropdown-category.php' );
$wp_customize->add_setting( 'new_blog_sidebar_post_categorylist', 
array(
	'default'     =>  0,
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new New_Blog_My_Dropdown_Category_Control( $wp_customize, 'new_blog_sidebar_post_categorylist', array(
	
		'label' 	=> __( 'Select the post among', 'new-blog' ),
		'section'	=> 'new_blog_sidebar_section',
		
) 	)	
);

$wp_customize->add_setting( 'new_blog_sidebar_post_noofpost', 
array(
	'default'     => 4,
	'sanitize_callback' => 'new_blog_sanitize_positive_integer'
) );

$wp_customize->add_control( 'new_blog_sidebar_post_noofpost', 
	array(
		'label' 	=> __( 'Number of post to show', 'new-blog' ),
		'section'	=> 'new_blog_sidebar_section',
		'settings' 	=> 'new_blog_sidebar_post_noofpost',
		'type' 		=> 'number',
	) 
);

$post_taxonomy_arrays = array(__('Date','new-blog'));
foreach ($post_taxonomy_arrays as  $post_taxonomy) {
	$wp_customize->add_setting( 'new_blog_sidebar_post_post_taxonomy_'.$post_taxonomy, array(
	'capability'            => 'edit_theme_options',
	'default'               => 1,
	'sanitize_callback' => 'new_blog_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'new_blog_sidebar_post_post_taxonomy_'.$post_taxonomy, array(
		/* translators: %s: Label */ 
		'label'                 =>  sprintf( __( '%s display', 'new-blog' ), $post_taxonomy ),
		'section'               => 'new_blog_sidebar_section',
		'type'                  => 'checkbox',
		'settings' => 'new_blog_sidebar_post_post_taxonomy_'.$post_taxonomy,

	) );
}

				//////   'Sidebar Quote section'  ////////////
$wp_customize->add_setting( 'new_blog_sidebar_quote_enable', 
array(
	
	'default'     => 0,
	'sanitize_callback' => 'new_blog_sanitize_checkbox'
) );

$wp_customize->add_control( 'new_blog_sidebar_quote_enable', 
	array(
		'label' 	=> __( 'Display Quote', 'new-blog' ),
		'section'	=> 'new_blog_sidebar_section',
		'settings' 	=> 'new_blog_sidebar_quote_enable',
		'type'      => 'checkbox',

	) 
);
$wp_customize->add_setting( 'new_blog_sidebar_quote_title', 
array(
	
	'default'     => __('Quotes Of The Day','new-blog'),
	'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( 'new_blog_sidebar_quote_title', 
	array(
		'label' 	=> __( 'Display Quote', 'new-blog' ),
		'section'	=> 'new_blog_sidebar_section',
		'settings' 	=> 'new_blog_sidebar_quote_title',
		'type'      => 'text',

	) 
);
$wp_customize->add_setting( 'new_blog_sidebar_quote_textarea', 
array(
	
	'default'     => __('this is my quote','new-blog'),
	'sanitize_callback' => 'sanitize_textarea_field'
) );

$wp_customize->add_control( 'new_blog_sidebar_quote_textarea', 
	array(
		'label' 	=> __( 'Write About', 'new-blog' ),
		'section'	=> 'new_blog_sidebar_section',
		'settings' 	=> 'new_blog_sidebar_quote_textarea',
		'type'      => 'textarea',

	) 
);
//////   'Single page section'  ////////////

$wp_customize->add_section( 'new_blog_single_page_section',
array(
	'title'      => __( 'Single page section', 'new-blog' ),
	'priority'   => 20,
	'panel'		=> 'new_blog_theme_option_panel'
) );
$wp_customize->add_setting( 'new_blog_single_page_author_title', 
array(
	
	'default'     => __('Author','new-blog'),
	'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( 'new_blog_single_page_author_title', 
	array(
		'label' 	=> __( 'Author title', 'new-blog' ),
		'section'	=> 'new_blog_single_page_section',
		'settings' 	=> 'new_blog_single_page_author_title',
		'type'      => 'text',

	) 
);
$post_taxonomy_arrays = array(__('AuthorSection','new-blog'),__('Avatar','new-blog'), __('Email','new-blog'),__('Description','new-blog'),__('TimeAgo','new-blog'));
foreach ($post_taxonomy_arrays as  $post_taxonomy) {
	$wp_customize->add_setting( 'new_blog_single_page_post_taxonomy_'.$post_taxonomy, array(
	'capability'            => 'edit_theme_options',
	'default'               => 1,
	'sanitize_callback' => 'new_blog_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'new_blog_single_page_post_taxonomy_'.$post_taxonomy, array(
		/* translators: %s: Label */ 
		'label'                 =>  sprintf( __( '%s display', 'new-blog' ), $post_taxonomy ),
		'section'               => 'new_blog_single_page_section',
		'type'                  => 'checkbox',
		'settings' => 'new_blog_single_page_post_taxonomy_'.$post_taxonomy,

	) );
}

$wp_customize->add_setting( 'new_blog_single_page_post_taxonomy_PreviousPostFloat', array(
'capability'            => 'edit_theme_options',
'default'               => 1,
'sanitize_callback' => 'new_blog_sanitize_checkbox'
) );

$wp_customize->add_control( 'new_blog_single_page_post_taxonomy_PreviousPostFloat', array(
	
	'label'                 =>  __( 'Next Post Float Display', 'new-blog' ),
	'section'               => 'new_blog_single_page_section',
	'type'                  => 'checkbox',
	'settings' => 'new_blog_single_page_post_taxonomy_PreviousPostFloat',

) );


$wp_customize->add_setting( 'new_blog_single_page_post_taxonomy_NextPostFloat', array(
	'capability'            => 'edit_theme_options',
	'default'               => 1,
	'sanitize_callback' => 'new_blog_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'new_blog_single_page_post_taxonomy_NextPostFloat', array(
		
		'label'                 =>  __( 'Previous Post Float Display', 'new-blog' ),
		'section'               => 'new_blog_single_page_section',
		'type'                  => 'checkbox',
		'settings' => 'new_blog_single_page_post_taxonomy_NextPostFloat',

	) );

$wp_customize->add_setting( 'new_blog_related_post_enable', 
array(
	
	'default'     => '1',
	'sanitize_callback' => 'new_blog_sanitize_checkbox'
) );

$wp_customize->add_control( 'new_blog_related_post_enable', 
	array(
		'label' 	=> __( 'Display Related post', 'new-blog' ),
		'section'	=> 'new_blog_single_page_section',
		'settings' 	=> 'new_blog_related_post_enable',
		'type'      => 'checkbox',

	) 
);
$wp_customize->add_setting( 'new_blog_related_post_title', 
array(
	
	'default'     => __('Related Posts','new-blog'),
	'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( 'new_blog_related_post_title', 
	array(
		'label' 	=> __( 'Related post title', 'new-blog' ),
		'section'	=> 'new_blog_single_page_section',
		'settings' 	=> 'new_blog_related_post_title',
		'type'      => 'text',

	) 
);
$wp_customize->add_setting( 'new_blog_related_post_order', 
array(
	
	'default'     => 'date',
	'sanitize_callback' => 'new_blog_sanitize_select'
) );

$wp_customize->add_control( 'new_blog_related_post_order', 
	array(
		'label' 	=> __( 'Order by', 'new-blog' ),
		'section'	=> 'new_blog_single_page_section',
		'settings' 	=> 'new_blog_related_post_order',
		'type'      => 'select',
		'choices'	=> array (
			'date'	=> __( 'Recent publish date', 'new-blog' ),
			'comment_count' => __( 'Most commented ', 'new-blog' ),
		)

	) 
);
$wp_customize->add_setting( 'new_blog_related_post_noofpost', 
array(
	'default'     => 6,
	'sanitize_callback' => 'new_blog_sanitize_positive_integer'
) );

$wp_customize->add_control( 'new_blog_related_post_noofpost', 
	array(
		'label' 	=> __( 'Number of post to show', 'new-blog' ),
		'section'	=> 'new_blog_single_page_section',
		'settings' 	=> 'new_blog_related_post_noofpost',
		'type' 		=> 'number',
	) 
);

$post_taxonomy_arrays = array(__('Category','new-blog'),__('Date','new-blog'),__('Excerpt','new-blog'),__('Tag','new-blog'),__('ReadMore','new-blog'),__('UseBlankImage','new-blog'),__('TimeAgo','new-blog'));
foreach ($post_taxonomy_arrays as  $post_taxonomy) {
	$wp_customize->add_setting( 'new_blog_related_post_post_taxonomy_'.$post_taxonomy, array(
	'capability'            => 'edit_theme_options',
	'default'               => 1,
	'sanitize_callback' => 'new_blog_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'new_blog_related_post_post_taxonomy_'.$post_taxonomy, array(
		/* translators: %s: Label */ 
		'label'                 =>  sprintf( __( '%s display', 'new-blog' ), $post_taxonomy ),
		'section'               => 'new_blog_single_page_section',
		'type'                  => 'checkbox',
		'settings' => 'new_blog_related_post_post_taxonomy_'.$post_taxonomy,

	) );
}

///////// 'General layout section'  ////////////

$wp_customize->add_section( 'new_blog_general_layout_section',
array(
	'title'      => __( 'General layout section', 'new-blog' ),
	'priority'   => 20,
	'panel'		=> 'new_blog_theme_option_panel'
) );

$wp_customize->add_setting( 'new_blog_box_width_banner', 
array(
	
	'default'     => 80,
	'sanitize_callback' => 'new_blog_sanitize_positive_integer'
) );

$wp_customize->add_control( 'new_blog_box_width_banner', 
	array(
		'label' 	=> __( 'Box width banner slider', 'new-blog' ),
		'section'	=> 'new_blog_general_layout_section',
		'settings' 	=> 'new_blog_box_width_banner',
		'type'      => 'number',
		'input_attrs' => array(
			'min'		=> 1,
			'max' 	  	=> 100,
			'step'    	=> 1,
		),
	) 
);


///////// 'General setting section'  ////////////

$wp_customize->add_section( 'new_blog_general_setting_section',
array(
	'title'      => __( 'General setting section', 'new-blog' ),
	'priority'   => 20,
	'panel'		=> 'new_blog_theme_option_panel'
) );

$wp_customize->add_setting( 'new_blog_read_more_title', 
array(
	
	'default'     => __('Read more','new-blog'),
	'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( 'new_blog_read_more_title', 
	array(
		'label' 	=> __( 'Read more text', 'new-blog' ),
		'section'	=> 'new_blog_general_setting_section',
		'settings' 	=> 'new_blog_read_more_title',
		'type'      => 'text',
	));

}
add_action( 'customize_register', 'new_blog_customize_other' );