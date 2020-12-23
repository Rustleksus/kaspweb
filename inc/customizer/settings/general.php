<?php
/**
 * General Customizer Options
 *
 * @package Kaspweb WordPress theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kaspweb_General_Customizer' ) ) :

	class Kaspweb_General_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {

			add_action( 'customize_register', 	array( $this, 'customizer_options' ) );

		}

		/**
		 * Customizer options
		 *
		 * @since 1.0.0
		 */
		public function customizer_options( $wp_customize ) {

        }
        
		/**
		 * Helpers
		 *
		 * @since 1.0.0
		 */
		public static function helpers( $return = NULL ) {

			// Return elementor templates array
			if ( 'elementor' == $return ) {
				$templates 		= array( esc_html__( 'Default', 'oceanwp' ) ); 
				$get_templates 	= get_posts( array( 'post_type' => 'elementor_library', 'numberposts' => -1, 'post_status' => 'publish' ) );

			    if ( ! empty ( $get_templates ) ) {
			    	foreach ( $get_templates as $template ) {
						$templates[ $template->ID ] = $template->post_title;
				    }
				}

				return $templates;
			}

		}

	}

endif;

return new Kaspweb_General_Customizer();