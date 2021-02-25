<?php
/**
 *Recommended way to include parent theme styles.
 *(Please see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme)
 */ 
add_action( 'wp_enqueue_scripts', 'new_blog_jr_style' );
function new_blog_jr_style() {

	$parent_style = 'new-blog-style';
	wp_enqueue_style( 'kenwheeler-slicktheme', get_template_directory_uri() . '/css/slick-theme.css' );
	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css');
	wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style(
		'new-blog-jr-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'bootstrap', $parent_style ),
		wp_get_theme()->get('Version') );

	wp_enqueue_script( 'new-blog-jr-js', get_stylesheet_directory_uri() . '/js/new-blog-jr.js', array(), '20200125', true );
	wp_enqueue_style( 'new-blog-jr-google-fonts', '//fonts.googleapis.com/css?family=Courgette', array(), NULL);
}

function new_blog_jr_dequeue_script() {
	wp_dequeue_script( 'new-blog-scroll-js' );
	wp_dequeue_script( 'new-blog-js' );
}
add_action( 'wp_print_scripts', 'new_blog_jr_dequeue_script', 100 );

/**
 *Your code goes below
 */

function new_blog_jr_customize_other( $wp_customize ) {
	// //Removed Section from the Parent theme 
	$wp_customize->remove_control('new_blog_blog_post_layout');
	$wp_customize->remove_control('new_blog_feature_post_noofpost');
	$wp_customize->remove_control('new_blog_feature_post_categorylist');

	$wp_customize->add_setting( 'new_blog_jr_post_layout', array(
		'default'     => 1,
		'sanitize_callback' => 'new_blog_sanitize_select',
	) );

	$wp_customize->add_control( 'new_blog_jr_post_layout', 
		array(
			'label' 	=> __( 'Display layout type', 'new-blog-jr' ),
			'section'	=> 'new_blog_blog_post_section',
			'settings' 	=> 'new_blog_jr_post_layout',
			'type' 		=> 'select',
			'choices'	=> array(
			'1'			=> __('1 column with related posts','new-blog-jr'),
			'2'			=> __('3 columns ','new-blog-jr'),
			)
		) 
	);

	$wp_customize->add_setting( 'new_blog_jr_blog_post_related_post_front', array(
		'default'               => 1,
		'sanitize_callback'     => 'new_blog_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'new_blog_jr_blog_post_related_post_front', array(
		'label'                 =>  __( 'Enable related posts by category', 'new-blog-jr' ),
		'section'               => 'new_blog_blog_post_section',
		'type'                  => 'checkbox',
		'settings'              => 'new_blog_jr_blog_post_related_post_front',
	) );

	require_once( trailingslashit( get_template_directory() ) . 'inc/dropdown-category.php' );
	$wp_customize->add_setting( 'new_blog_jr_categorylist1', 
	array(
		'default'     => 0,
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( new new_blog_My_Dropdown_Category_Control( $wp_customize, 'new_blog_jr_categorylist1', array(
		
			'label' 	=> __( 'Select the 1st category among', 'new-blog-jr' ),
			'section'	=> 'new_blog_feature_post_section',
			
	) 	)	
	);
	require_once( trailingslashit( get_template_directory() ) . 'inc/dropdown-category.php' );
	$wp_customize->add_setting( 'new_blog_jr_categorylist2', 
	array(
		'default'     => 0,
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( new new_blog_My_Dropdown_Category_Control( $wp_customize, 'new_blog_jr_categorylist2', array(
		
			'label' 	=> __( 'Select the 2nd category among', 'new-blog-jr' ),
			'section'	=> 'new_blog_feature_post_section',
			
	) 	)	
	);
	require_once( trailingslashit( get_template_directory() ) . 'inc/dropdown-category.php' );
	$wp_customize->add_setting( 'new_blog_jr_categorylist3', 
	array(
		'default'     => 0,
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( new new_blog_My_Dropdown_Category_Control( $wp_customize, 'new_blog_jr_categorylist3', array(
		
			'label' 	=> __( 'Select the 3rd category among', 'new-blog-jr' ),
			'section'	=> 'new_blog_feature_post_section',
			
	) 	)	
	);
}
add_action( 'customize_register', 'new_blog_jr_customize_other', 9999 );


function new_blog_jr_remove_parent_function() {
	remove_action( 'after_setup_theme', 'new_blog_custom_header_setup' );
	remove_action( 'excerpt_length','new_blog_custom_excerpt_length',999 );

}
add_action( 'after_setup_theme', 'new_blog_jr_remove_parent_function',2 );

function new_blog_jr_custom_header_setup() {
	
	add_theme_support( 'custom-header', apply_filters( 'new_blog_jr_custom_header_args', array(
		'default-image'			=> get_theme_file_uri( '/images/header-image-jr.jpg'),
		'width'              => 1440,
		'height'             => 695,
		'flex-height'        => true,
		'wp-head-callback'   => 'new_blog_header_style',
	) ) );
	register_default_headers( array(
		'default-image' => array(
			'url'           => get_theme_file_uri( '/images/header-image-jr.jpg'),
			'thumbnail_url' => get_theme_file_uri( '/images/header-image-jr.jpg'),
			'description'   => __( 'Default image ', 'new-blog-jr' ),
		)
		
	) );
}
add_action( 'after_setup_theme', 'new_blog_jr_custom_header_setup', 1 );

function new_blog_jr_custom_excerpt_length( $length ) {
	if ( is_admin() ) {
		return $length;
	}
	return 35;
}
add_filter( 'excerpt_length', 'new_blog_jr_custom_excerpt_length', 1 );

function new_blog_jr_customizer_styles() { ?>
	<style>
		#customize-control-new_blog_banner_slider_post_taxonomy_Excerpt .customize-inside-control-row {
		display: none !important;
	}
	</style>
	<?php
}
add_action( 'customize_controls_print_styles', 'new_blog_jr_customizer_styles', 999 );

function new_blog_jr_setup() {
	add_image_size('new-blog-jr-new-banner-thumbnail', 720, 525, array( 'center','center'));

}
add_action( 'after_setup_theme', 'new_blog_jr_setup' );

if ( ! function_exists( 'new_blog_jr_new_banner_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function new_blog_jr_new_banner_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		} ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'new-blog-jr-new-banner-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
					
				) ),
				'class' => 'card-img-top img-holder',
			) );
			?>
		</a>
		<?php
	}
endif;