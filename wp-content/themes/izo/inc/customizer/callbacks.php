<?php
/**
 * Customizer callbacks
 *
 * @package Izo
 */
 
/**
 * Header custom text callback
 */
function izo_header_text_active_callback() {

    $active_top_bar = get_theme_mod( 'enable_top_bar' );

	if ( !$active_top_bar ) {
		return false;
	}   

	//Get the active menu area
    $area 		        = get_theme_mod( 'izo_header_builder_radio' );

	//Get the current component for that specific left top bar area
    $component_left 	= get_theme_mod( 'left_top_bar_component' );
    
    //Get the current component for that specific right top bar area
	$component_right 	= get_theme_mod( 'right_top_bar_component' );

    if ( ( 'top_left' == $area && 'header_component_text' == $component_left ) || ( 'top_right' == $area && 'header_component_text' == $component_right ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Header Woocommerce icons callback
 */
function izo_header_wc_icons_active_callback() {

    $active_top_bar = get_theme_mod( 'enable_top_bar' );

	if ( !$active_top_bar ) {
		return false;
	}   

	//Get the active menu area
    $area 		        = get_theme_mod( 'izo_header_builder_radio' );

	//Get the current component for that specific left top bar area
    $component_left 	= get_theme_mod( 'left_top_bar_component' );
    
    //Get the current component for that specific right top bar area
	$component_right 	= get_theme_mod( 'right_top_bar_component' );

    if ( ( 'top_left' == $area && 'header_woocommerce' == $component_left ) || ( 'top_right' == $area && 'header_woocommerce' == $component_right ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Header social callback
 */
function izo_social_active_callback() {

    $active_top_bar = get_theme_mod( 'enable_top_bar' );

	if ( !$active_top_bar ) {
		return false;
	}   

	//Get the active menu area
    $area 		        = get_theme_mod( 'izo_header_builder_radio' );

	//Get the current component for that specific left top bar area
    $component_left 	= get_theme_mod( 'left_top_bar_component' );
    
    //Get the current component for that specific right top bar area
	$component_right 	= get_theme_mod( 'right_top_bar_component' );

    if ( ( 'top_left' == $area && 'header_component_social' == $component_left ) || ( 'top_right' == $area && 'header_component_social' == $component_right ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Header top navigation callback
 */
function izo_top_nav_active_callback() {
    $active_top_bar = get_theme_mod( 'enable_top_bar' );

	if ( !$active_top_bar ) {
		return false;
	}   

	//Get the active menu area
    $area 		        = get_theme_mod( 'izo_header_builder_radio' );

	//Get the current component for that specific left top bar area
    $component_left 	= get_theme_mod( 'left_top_bar_component' );
    
    //Get the current component for that specific right top bar area
	$component_right 	= get_theme_mod( 'right_top_bar_component' );

    if ( ( 'top_left' == $area && 'header_component_top_nav' == $component_left ) || ( 'top_right' == $area && 'header_component_top_nav' == $component_right ) ) {
		return true;
	} else {
		return false;
	}	
}

/**
 * Header contact info callback
 */
function izo_header_contact_active_callback() {

    $active_top_bar = get_theme_mod( 'enable_top_bar' );

	if ( !$active_top_bar ) {
		return false;
	}    

	//Get the active menu area
    $area 		        = get_theme_mod( 'izo_header_builder_radio' );

	//Get the current component for that specific left top bar area
    $component_left 	= get_theme_mod( 'left_top_bar_component' );
    
    //Get the current component for that specific right top bar area
	$component_right 	= get_theme_mod( 'right_top_bar_component' );

    if ( ( 'top_left' == $area && 'header_component_contact' == $component_left ) || ( 'top_right' == $area && 'header_component_contact' == $component_right ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Header button callback
 */
function izo_header_button_active_callback() {

    $active_top_bar = get_theme_mod( 'enable_top_bar' );

	if ( !$active_top_bar ) {
		return false;
	}    

	//Get the active menu area
    $area 		        = get_theme_mod( 'izo_header_builder_radio' );

	//Get the current component for that specific left top bar area
    $component_left 	= get_theme_mod( 'left_top_bar_component' );
    
    //Get the current component for that specific right top bar area
	$component_right 	= get_theme_mod( 'right_top_bar_component' );

    if ( ( 'top_left' == $area && 'header_component_button' == $component_left ) || ( 'top_right' == $area && 'header_component_button' == $component_right ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Main header button callback
 */
function izo_main_header_button_active_callback() {

    $lastitem = get_theme_mod( 'main_header_last_item', 'main_header_component_nothing' );

    if ( 'main_header_component_button' == $lastitem ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Main header text callback
 */
function izo_main_header_text_active_callback() {

    $lastitem = get_theme_mod( 'main_header_last_item', 'main_header_component_nothing' );

    if ( 'main_header_component_text' == $lastitem ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Main header search callback
 */
function izo_main_header_search_active_callback() {

    $lastitem = get_theme_mod( 'main_header_last_item', 'main_header_component_nothing' );

    if ( 'main_header_component_search' == $lastitem ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Top bar active
 */
function izo_top_bar_active_callback() {
    $active_top_bar = get_theme_mod( 'enable_top_bar' );

	if ( $active_top_bar ) {
		return true;
	} else {
		return false;
	}    
}
function izo_top_bar_left_active_callback() {

    $active_top_bar = get_theme_mod( 'enable_top_bar' );

	if ( !$active_top_bar ) {
		return false;
	}

    $izo_header_builder_radio = get_theme_mod( 'izo_header_builder_radio' );

	if ( 'top_left' == $izo_header_builder_radio ) {
		return true;
	} else {
		return false;
	} 
}
function izo_top_bar_right_active_callback() {

    $active_top_bar = get_theme_mod( 'enable_top_bar' );

	if ( !$active_top_bar ) {
		return false;
    }
    
    $izo_header_builder_radio = get_theme_mod( 'izo_header_builder_radio' );

	if ( 'top_right' == $izo_header_builder_radio ) {
		return true;
	} else {
		return false;
	} 
}

/**
 * Post banner callback
 */
function izo_post_banner_callback() {

    $banner = get_theme_mod( 'single_post_banner', 'default' );

    if ( 'banner' == $banner ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Page banner callback
 */
function izo_page_banner_callback() {

    $banner = get_theme_mod( 'single_page_banner', 'default' );

    if ( 'banner' == $banner ) {
		return true;
	} else {
		return false;
	}
}