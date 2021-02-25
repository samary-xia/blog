<?php
/**
 * Sanitization Functions
 *
 * @package new_blog
 */

if ( ! function_exists( 'new_blog_sanitize_select' ) ) :

	/**
	 * Sanitize select.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed                $input The value to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return mixed Sanitized value.
	 */
	function new_blog_sanitize_select( $input, $setting ){
         
		//input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
		$input = sanitize_key($input);
	
		//get the list of possible select options 
		$choices = $setting->manager->get_control( $setting->id )->choices;
						 
		//return input if valid or return default option
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
		 
	}

endif;

if ( ! function_exists( 'new_blog_sanitize_positive_integer' ) ) :

	/**
	 * Sanitize positive integer.
	 *
	 * @since 1.0.0
	 *
	 * @param int $input Number to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return int Sanitized number; otherwise, the setting default.
	 */
	function new_blog_sanitize_positive_integer( $input, $setting ) {
		
		$input = abs( $input );
		// If the input is an absolute integer then return it.
		// otherwise, return the default.
		return ( $input ? $input : $setting->default );

	}
endif;

if ( ! function_exists( 'new_blog_sanitize_radio' ) ) :
	/**
	 * Sanitize radio.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $checked Whether the checkbox is checked.
	 * @return bool Whether the checkbox is checked.
	 */
	function new_blog_sanitize_radio( $input, $setting ) {
			
		//input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
		$input = sanitize_key($input);

		//get the list of possible radio box options 
		$choices = $setting->manager->get_control( $setting->id )->choices;
						
		//return input if valid or return default option
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
		
	}
endif;

/**
 * URL sanitization callback example.
 *
 * - Sanitization: url
 * - Control: text, url
 * 
 * Sanitization callback for 'url' type text inputs. This callback sanitizes `$url` as a valid URL.
 * 
 * NOTE: esc_url_raw() can be passed directly as `$wp_customize->add_setting()` 'sanitize_callback'.
 * It is wrapped in a callback here merely for example purposes.
 * 
 * @see esc_url_raw() https://developer.wordpress.org/reference/functions/esc_url_raw/
 *
 * @param string $url URL to sanitize.
 * @return string Sanitized URL.
 */
	function new_blog_sanitize_url( $url ) {
	return esc_url_raw( $url );
}


/**
 * Checkbox sanitization callback example.
 * 
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
	function new_blog_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}