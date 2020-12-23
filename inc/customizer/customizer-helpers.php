<?php
/**
 * Active callback functions for the customizer
 *
 * @package Kaspweb WordPress theme
 */

/*-------------------------------------------------------------------------------*/
/* / Footer /
/*-------------------------------------------------------------------------------*/
function kaspweb_chelp_footer_bottom() {
	return get_theme_mod( 'kaspweb_footer_bottom', true );
}

function kaspweb_chelp_footer_widgets() {
	return get_theme_mod( 'kaspweb_footer_widgets', true );
}

function kaspweb_customizer_helpers( $return = NULL ) {

	// Return library templates array
	if ( 'library' == $return ) {
		$templates 		= array( '&mdash; '. esc_html__( 'Select', 'kaspweb' ) .' &mdash;' );
		$get_templates 	= get_posts( array( 'post_type' => 'kaspwebwp_library', 'numberposts' => -1, 'post_status' => 'publish' ) );

	    if ( ! empty ( $get_templates ) ) {
	    	foreach ( $get_templates as $template ) {
				$templates[ $template->ID ] = $template->post_title;
		    }
		}

		return $templates;
	}

}