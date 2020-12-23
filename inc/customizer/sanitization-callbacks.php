<?php
/**
 * Sanitization Callbacks
 * 
 * @package Kaspweb WordPress theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Select sanitization function
 *
 * @param string               $input   Slug to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string               Sanitized slug if it is a valid choice; otherwise, the setting default.
 */
function kaspweb_theme_slug_sanitize_select( $input, $setting ) {

    // Ensure input is a slug (lowercase alphanumeric characters, dashes and underscores are allowed only).
    $input = sanitize_key( $input );

    // Get the list of possible select options.
    $choices = $setting->manager->get_control( $setting->id )->choices;

    // If the input is a valid key, return it; otherwise, return the default.
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

}

/**
 * HEX Color sanitization callback example.
 *
 * - Sanitization: hex_color
 * - Control: text, WP_Customize_Color_Control
 *
 * Note: sanitize_hex_color_no_hash() can also be used here, depending on whether
 * or not the hash prefix should be stored/retrieved with the hex color value.
 *
 * @see sanitize_hex_color() https://developer.wordpress.org/reference/functions/sanitize_hex_color/
 * @link sanitize_hex_color_no_hash() https://developer.wordpress.org/reference/functions/sanitize_hex_color_no_hash/
 *
 * @param string               $hex_color HEX color to sanitize.
 * @param WP_Customize_Setting $setting   Setting instance.
 * @return string The sanitized hex color if not null; otherwise, the setting default.
 */
function kaspweb_sanitize_hex_color( $hex_color, $setting ) {
	// Sanitize $input as a hex value without the hash prefix.
	$hex_color = sanitize_hex_color( $hex_color );

	// If $input is a valid hex value, return it; otherwise, return the default.
	return ( ! null( $hex_color ) ? $hex_color : $setting->default );
}

/**
 * Checkbox sanitization callback
 *
 * @since 1.2.1
 */
function kaspweb_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Select sanitization callback
 *
 * @since 1.2.1
 */
function kaspweb_sanitize_select( $input, $setting ) {
	// Ensure input is a slug.
	$input = sanitize_key( $input );
	
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Number sanitization callback
 *
 * @since 1.2.1
 */
function kaspweb_sanitize_number( $val ) {
	return is_numeric( $val ) ? $val : 0;
}

/**
 * Adds sanitization callback function: Slider Category
 * @package Kaspweb
 */
function kaspweb_sanitize_slidecat( $input ) {

	if ( array_key_exists( $input, kaspweb_cats() ) ) {
		return $input;
	} else {
		return '';
	}
}