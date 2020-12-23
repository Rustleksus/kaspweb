<?php
/**
 * Kaspweb Customizer Class
 *
 * @package Kaspweb WordPress theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kaspweb_Customizer' ) ) :

	/**
	 * The Kaspweb Customizer class
	 */
	class Kaspweb_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {

            add_action( 'customize_register',					array( $this, 'custom_controls' ) );
			add_action( 'customize_register',					array( $this, 'controls_helpers' ) );
			add_action( 'customize_register',					array( $this, 'customize_register' ), 11 );
            add_action( 'wp_enqueue_scripts',					array( $this, 'kaspweb_customizer_css' ), 11 );
			add_action( 'after_setup_theme',					array( $this, 'register_options' ) );
			add_action( 'customize_preview_init', 				array( $this, 'customize_preview_init' ) );

		}
        
        /**
		 * Adds custom controls
		 *
		 * @since 1.0.0
		 */
		public function custom_controls( $wp_customize ) {

			// Path
			$dir = KASPWEB_INC_DIR . 'customizer/controls/';

			// Load customize control classes
            require_once( $dir . 'dimensions/class-control-dimensions.php' 					    );
            require_once( $dir . 'heading/class-control-customize-heading.php'                  ); 
			require_once( $dir . 'range/class-control-range.php' 							    );
            //require_once( $dir . 'slider/class-control-slider.php' 							);
            require_once( $dir . 'textarea/class-control-textarea.php' 						    );
            require_once( $dir . 'toggle/class-control-toggle.php'                              );
            

			// Register JS control types
            $wp_customize->register_control_type( 'Kaspweb_Customizer_Dimensions_Control'       );
            $wp_customize->register_control_type( 'Kaspweb_Customizer_Heading_Control'          ); 
			$wp_customize->register_control_type( 'Kaspweb_Customizer_Range_Control' 			);
            //$wp_customize->register_control_type( 'Kaspweb_Customizer_Range_Control' 			);
            $wp_customize->register_control_type( 'Kaspweb_Customizer_Textarea_Control' 		);
            // Register JS control types
            $wp_customize->register_control_type( 'Kaspweb_Control_Toggle'                      );

		}

		/**
		 * Adds customizer helpers
		 *
		 * @since 1.0.0
		 */
		public function controls_helpers() {
			require_once( KASPWEB_INC_DIR .'customizer/customizer-helpers.php' );
			require_once( KASPWEB_INC_DIR .'customizer/sanitization-callbacks.php' );
		}

		/**
		 * Core modules
		 *
		 * @since 1.0.0
		 */
		public static function customize_register( $wp_customize ) {
            
            $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
            $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
            $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
            // Update background color with postMessage, so inline CSS output is updated as well.            
            
            /**
			 * Panel
			 */
			$panel = 'kaspweb_general_panel';
			$wp_customize->add_panel( $panel , array(
				'title' 			=> esc_html__( 'General Options', 'kaspweb' ),
				'priority' 			=> 10,
			) );

            // Theme layout settings.
            $wp_customize->add_section(
                'kaspweb_theme_layout_options',
                array(
                    'title'       => __( 'Theme Layout Settings', 'kaspweb' ),
                    'capability'  => 'edit_theme_options',
                    'description' => __( 'Container width and sidebar defaults', 'kaspweb' ),
                    'priority'    => apply_filters( 'kaspweb_theme_layout_options_priority', 10 ),
                    'panel'       => $panel,
                )
            );


            $wp_customize->add_setting(
                'kaspweb_container_type',
                array(
                    'default'           => 'container',
                    'type'              => 'theme_mod',
                    'sanitize_callback' => 'kaspweb_theme_slug_sanitize_select',
                    'capability'        => 'edit_theme_options',
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Control( $wp_customize,
                    'kaspweb_container_type',
                    array(
                        'label'       => __( 'Container Width', 'kaspweb' ),
                        'description' => __( 'Choose between Bootstrap\'s container and container-fluid', 'kaspweb' ),
                        'section'     => 'kaspweb_theme_layout_options',
                        'settings'    => 'kaspweb_container_type',
                        'type'        => 'select',
                        'choices'     => array(
                            'container'       => __( 'Fixed width container', 'kaspweb' ),
                            'container-fluid' => __( 'Full width container', 'kaspweb' ),
                        ),
                        'priority'    => apply_filters( 'kaspweb_container_type_priority', 10 ),
                    )
                )
            );

            $wp_customize->add_setting(
                'kaspweb_sidebar_position',
                array(
                    'default'           => 'right',
                    'type'              => 'theme_mod',
                    'sanitize_callback' => 'sanitize_text_field',
                    'capability'        => 'edit_theme_options',
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Control( $wp_customize,
                    'kaspweb_sidebar_position',
                    array(
                        'label'             => __( 'Sidebar Positioning', 'kaspweb' ),
                        'description'       => __(
                            'Set sidebar\'s default position. Can either be: right, left, both or none. Note: this can be overridden on individual pages.',
                            'kaspweb'
                        ),
                        'section'           => 'kaspweb_theme_layout_options',
                        'settings'          => 'kaspweb_sidebar_position',
                        'type'              => 'select',
                        'sanitize_callback' => 'kaspweb_theme_slug_sanitize_select',
                        'choices'           => array(
                            'right' => __( 'Right sidebar', 'kaspweb' ),
                            'left'  => __( 'Left sidebar', 'kaspweb' ),
                            'both'  => __( 'Left & Right sidebars', 'kaspweb' ),
                            'none'  => __( 'No sidebar', 'kaspweb' ),
                        ),
                        'priority'          => apply_filters( 'kaspweb_sidebar_position_priority', 20 ),
                    )
                )
            );
            
            
            /*-------------------------------------------------------------------------------*/
            /* [ Header ]
            /*-------------------------------------------------------------------------------*/
            
                    
            $wp_customize->add_section(
				'kaspweb_header_section',
				array(
					'title'       => __( 'Header', 'kaspweb' ),
					'priority'    => 209,
                    'capability'  => 'edit_theme_options',
                    'panel'       => $panel,
				)
			);
            
            
            
            /* Enable Header Search --------- */
            
            /**
             * Header Search
             */
            $wp_customize->add_setting(
                'kaspweb_header_search_heading',
                array(
                    'sanitize_callback' => 'wp_kses',
                )
            );

            $wp_customize->add_control(
                new Kaspweb_Customizer_Heading_Control(
                    $wp_customize, 'kaspweb_header_search_heading',
                    array(
                        'label'    => esc_html__( 'Header Search', 'kaspweb' ),
                        'section'  => 'kaspweb_header_section',
                        'priority' => 10,
                    )
                )
            );

			$wp_customize->add_setting(
				'enable_header_search',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => true,
					'sanitize_callback' => 'kaspweb_sanitize_checkbox',
				)
			);

			$wp_customize->add_control(
				'enable_header_search',
				array(
					'type'     => 'checkbox',
					'section'  => 'kaspweb_header_section',
					'priority' => 10,
					'label'    => __( 'Show search in header', 'kaspweb' ),
				)
			);
            
            /**
             * Theme Base Colors settings.
             */
            $wp_customize->add_section(
                'kaspweb_theme_color_options',
                array(
                    'title'       => __( 'Theme Color Settings', 'kaspweb' ),
                    'capability'  => 'edit_theme_options',
                    'description' => __( 'Color theme defaults', 'kaspweb' ),
                    'priority'    => apply_filters( 'kaspweb_theme_color_options_priority', 11 ),
                    'panel'       => $panel,
                )
            );

            // Background Color
            $wp_customize->add_setting(
                'theme_background_color', array(
                    'default'           => '#ffffff',
                    'sanitize_callback' => 'sanitize_hex_color',
                    'transport'         => 'postMessage',
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize, 'theme_background_color', array(
                        'label'   => esc_html__( 'Background Color', 'kaspweb' ),
                        'section' => 'kaspweb_theme_color_options',
                    )
                )
            );
            
            // Text Color
            $wp_customize->add_setting(
                'theme_text_color', array(
                    'default'           => '#000000',
                    'sanitize_callback' => 'sanitize_hex_color',
                    'transport'         => 'postMessage',
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize, 'theme_text_color', array(
                        'label'   => esc_html__( 'Text Color', 'kaspweb' ),
                        'section' => 'kaspweb_theme_color_options',
                    )
                )
            );
            

            /**
             * Heading Site Link Color
             */
            $wp_customize->add_setting(
                'kaspweb_site_linc_color_heading',
                array(
                    'sanitize_callback' => 'wp_kses',
                )
            );

            $wp_customize->add_control(
                new Kaspweb_Customizer_Heading_Control(
                    $wp_customize, 'kaspweb_site_linc_color_heading',
                    array(
                        'label'    => esc_html__( 'Link Color', 'kaspweb' ),
                        'section'  => 'kaspweb_theme_color_options',
                        'priority' => 10,
                    )
                )
            );

            // Link Color
            $wp_customize->add_setting(
                'theme_link_color', array(
                    'default'           => '#000000',
                    'sanitize_callback' => 'sanitize_hex_color',
                    'transport'         => 'postMessage',
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize, 'theme_link_color', array(
                        'label'   => esc_html__( 'Link Color', 'kaspweb' ),
                        'section' => 'kaspweb_theme_color_options',
                    )
                )
            );
            
            // Link Hover Color
            $wp_customize->add_setting(
                'theme_link_hover_color', array(
                    'default'           => '#000000',
                    'sanitize_callback' => 'sanitize_hex_color',
                    'transport'         => 'postMessage',
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize, 'theme_link_hover_color', array(
                        'label'   => esc_html__( 'Color: hover', 'kaspweb' ),
                        'section' => 'kaspweb_theme_color_options',
                    )
                )
            );
            
            /**
             * Theme Typography settings (font-family, typography color)
             */ 
			$wp_customize->add_section(
				'kaspweb_typography_page', array(
					'title' => esc_html__( 'Typography settings', 'kaspweb' ),
                    'priority'    => apply_filters( 'kaspweb_theme_typography_options_priority', 12 ),
                    'panel'       => $panel,
				)
			);

            // Add the $fonts variables for typography choices.
            $fonts = kaspweb_font_library();
            
            // Add the body font family setting and control.
			$wp_customize->add_setting(
				'body_font_family', array(
					'default' => 'Karla',
				)
			);
            $wp_customize->add_control(
				'body_font_family', array(
					'type'    => 'select',
					'label'   => esc_html__( 'Font Family', 'kaspweb' ),
					'section' => 'kaspweb_typography_page',
					'choices' => $fonts,
				)
			);
            
            // Add the body font size setting and control.
            $wp_customize->add_setting(
				'body_font_size', array(
					'default'           => '15',
					'sanitize_callback' => 'absint',
				)
			);
            $wp_customize->add_control(
				new Kaspweb_Customizer_Range_Control(
					$wp_customize, 'body_font_size', array(
						'default'     => '15',
						'type'        => 'kaspweb-range',
						'label'       => esc_html__( 'Font Size, px', 'kaspweb' ),
						'section'     => 'kaspweb_typography_page',
						'input_attrs' => array(
							'min'  => 10,
							'max'  => 100,
							'step' => 1,
						),
					)
				)
			);
            
            // Add the body line height setting and control.
            $wp_customize->add_setting(
				'body_line_height', array(
					'default'           => '26',
					'sanitize_callback' => 'absint',
				)
			);
            $wp_customize->add_control(
				new Kaspweb_Customizer_Range_Control(
					$wp_customize, 'body_line_height', array(
						'default'     => '26',
						'type'        => 'kaspweb-range',
						'label'       => esc_html__( 'Line Height, px', 'kaspweb' ),
						'section'     => 'kaspweb_typography_page',
						'input_attrs' => array(
							'min'  => 10,
							'max'  => 50,
							'step' => 1,
						),
					)
				)
			);
            
            // Add the body letter spacing setting and control.
            $wp_customize->add_setting(
				'body_letter_spacing', array(
					'default'           => '0',
					'sanitize_callback' => 'absint',
				)
			);
            $wp_customize->add_control(
				new Kaspweb_Customizer_Range_Control(
					$wp_customize, 'body_letter_spacing', array(
						'default'     => '0',
						'type'        => 'kaspweb-range',
						'label'       => esc_html__( 'Letter Spacing, px', 'kaspweb' ),
						'section'     => 'kaspweb_typography_page',
						'input_attrs' => array(
							'min'  => 0,
							'max'  => 10,
							'step' => 1,
						),
					)
				)
			);
            
            // Add the body word spacing setting and control.
            $wp_customize->add_setting(
				'body_word_spacing', array(
					'default'           => '0',
					'sanitize_callback' => 'absint',
				)
			);
            $wp_customize->add_control(
				new Kaspweb_Customizer_Range_Control(
					$wp_customize, 'body_word_spacing', array(
						'default'     => '0',
						'type'        => 'kaspweb-range',
						'label'       => esc_html__( 'Word Spacing, px', 'kaspweb' ),
						'section'     => 'kaspweb_typography_page',
						'input_attrs' => array(
							'min'  => 0,
							'max'  => 10,
							'step' => 1,
						),
					)
				)
			);

            /**
             *  Kaspweb Featured Image Post Slider
             */
            // add "Featured Posts" section
            $wp_customize->add_section( 'kaspweb_featured_section' , array(
                'title'      => esc_html__( 'Slider Options', 'kaspweb' ),
                'priority'   => 60,
                'panel' => $panel,
            ) );

            $wp_customize->add_setting( 'kaspweb_featured_cat', array(
                'default' => 0,
                'transport'   => 'refresh',
                'sanitize_callback' => 'kaspweb_sanitize_slidecat',
            ) );

            $wp_customize->add_control( 'kaspweb_featured_cat', array(
                'type' => 'select',
                'label' => esc_html__( 'Choose a category', 'activello' ),
                'choices' => kaspweb_cats(),
                'section' => 'kaspweb_featured_section',
            ) );

            $wp_customize->add_setting( 'kaspweb_featured_limit', array(
                'default' => -1,
                'transport'   => 'refresh',
                'sanitize_callback' => 'kaspweb_sanitize_number',
            ) );

            $wp_customize->add_control( 'kaspweb_featured_limit', array(
                'type' => 'number',
                'label' => esc_html__( 'Limit posts', 'activello' ),
                'section' => 'kaspweb_featured_section',
            ) );

            $wp_customize->add_setting( 'kaspweb_featured_hide', array(
                'default' => 0,
                'transport'   => 'refresh',
                'sanitize_callback' => 'kaspweb_sanitize_checkbox',
            ) );

            $wp_customize->add_control( new Kaspweb_Control_Toggle( $wp_customize, 'kaspweb_featured_hide', array(
                'type'        => 'epsilon-toggle',
                'label'     => esc_html__( 'Show Slider', 'activello' ),
                'section'   => 'kaspweb_featured_section',
            )));

            
            /*-------------------------------------------------------------------------------*/
            /* [ Footer ]
            /*-------------------------------------------------------------------------------*/
            
                    
            $wp_customize->add_section(
				'kaspweb_footer_bottom_section',
				array(
					'title'       => __( 'Footer', 'kaspweb' ),
					'priority'    => 210,
                    'capability'  => 'edit_theme_options',
                    'panel'       => $panel,
				)
			);
            
            // Header & Footer Background Color.
			$wp_customize->add_setting(
				'header_footer_background_color',
				array(
					'default'           => '#ffffff',
					'sanitize_callback' => 'sanitize_hex_color',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize, 'header_footer_background_color',
					array(
						'label'   => __( 'Header &amp; Footer Background Color', 'kaspweb' ),
						'section' => 'kaspweb_footer_bottom_section',
                        'priority'    => 6,
					)
				)
			);
            
            
            /**
             * Heading Site Footer Bottom Color
             */
            $wp_customize->add_setting(
                'kaspweb_site_footer_bottom_heading',
                array(
                    'sanitize_callback' => 'wp_kses',
                )
            );

            $wp_customize->add_control(
                new Kaspweb_Customizer_Heading_Control(
                    $wp_customize, 'kaspweb_site_footer_bottom_heading',
                    array(
                        'label'    => esc_html__( 'Footer Bottom', 'kaspweb' ),
                        'section'  => 'kaspweb_footer_bottom_section',
                        'priority' => 7,
                    )
                )
            );
            
            /**
			 * Enable Footer Bottom
			 */
			$wp_customize->add_setting(
				'kaspweb_footer_bottom',
				array(
					'default'           => true,
					'sanitize_callback' => 'kaspweb_sanitize_checkbox',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize, 'kaspweb_footer_bottom',	array(
						'label'    => esc_html__( 'Enable Footer Bottom', 'kaspweb' ),
						'type'     => 'checkbox',
						'section'  => 'kaspweb_footer_bottom_section',
						'settings' => 'kaspweb_footer_bottom',
						'priority' => 7,
					)
				)
			);
            
           /**
			 * Footer Bottom Visibility
			 */
			$wp_customize->add_setting(
				'kaspweb_bottom_footer_visibility',
				array(
					'transport'         => 'postMessage',
					'default'           => 'all-devices',
					'sanitize_callback' => 'kaspweb_sanitize_select',
				)
			);
            
            /**
			 * Footer Bottom Copyright
			 */
			$wp_customize->add_setting(
				'kaspweb_footer_copyright_text',
				array(
					'transport'         => 'postMessage',
					'default'           => 'Copyright [kaspweb_date] - Kaspweb Theme by Nick',
					'sanitize_callback' => 'wp_kses_post',
				)
			);

			$wp_customize->add_control(
				new Kaspweb_Customizer_Textarea_Control(
					$wp_customize, 'kaspweb_footer_copyright_text',	array(
						'label'           => __( 'Copyright', 'kaspweb' ),
						/* translators: 1: shortocde doc link 2: </a> */
						'description'     => sprintf( esc_html__( 'Shortcodes allowed, %1$ssee the list%2$s.', 'kaspweb' ), '<a href="#" target="_blank">', '</a>' ),
						'section'         => 'kaspweb_footer_bottom_section',
						'settings'        => 'kaspweb_footer_copyright_text',
						'priority'        => 8,
						'active_callback' => 'kaspweb_chelp_footer_bottom',
					)
				)
			);
            
            /**
             * Heading Site Footer Bottom Color
             */
            $wp_customize->add_setting(
                'kaspweb_site_footer_color_heading',
                array(
                    'sanitize_callback' => 'wp_kses',
                )
            );

            $wp_customize->add_control(
                new Kaspweb_Customizer_Heading_Control(
                    $wp_customize, 'kaspweb_site_footer_color_heading',
                    array(
                        'label'    => esc_html__( 'Footer Bottom Color', 'kaspweb' ),
                        'section'  => 'kaspweb_footer_bottom_section',
                        'priority' => 9,
                    )
                )
            );
            
            /**
			 * Footer Bottom Background Color
			 */            
              $wp_customize->add_setting(
                'kaspweb_bottom_footer_background', array(
                    'default'           => '#CCCCCC',
                    'sanitize_callback' => 'sanitize_hex_color',
                    'transport'         => 'postMessage',
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize, 'kaspweb_bottom_footer_background', array(
                        'label'   => esc_html__( 'Background Color', 'kaspweb' ),
                        'section' => 'kaspweb_footer_bottom_section',
                    )
                )
            );
            
            /**
			 * Footer Bottom Text Color
			 */            
              $wp_customize->add_setting(
                'kaspweb_bottom_footer_color', array(
                    'default'           => '#000000',
                    'sanitize_callback' => 'sanitize_hex_color',
                    'transport'         => 'postMessage',
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize, 'kaspweb_bottom_footer_color', array(
                        'label'   => esc_html__( 'Text color', 'kaspweb' ),
                        'section' => 'kaspweb_footer_bottom_section',
                    )
                )
            );
            
            /**
             * Heading Site Footer Bottom Color
             */
            $wp_customize->add_setting(
                'kaspweb_site_footer_padding_heading',
                array(
                    'sanitize_callback' => 'wp_kses',
                )
            );

            $wp_customize->add_control(
                new Kaspweb_Customizer_Heading_Control(
                    $wp_customize, 'kaspweb_site_footer_padding_heading',
                    array(
                        'label'    => esc_html__( 'Footer Bottom Padding', 'kaspweb' ),
                        'section'  => 'kaspweb_footer_bottom_section',
                        'priority' => 10,
                    )
                )
            );
            
            /**
			 * Footer Padding 
			 */
            $wp_customize->add_setting(
				'kaspweb_bottom_footer_top_padding', array(
					'default'           => '5',
					'sanitize_callback' => 'absint',
				)
			);
            $wp_customize->add_control(
				new Kaspweb_Customizer_Range_Control(
					$wp_customize, 'kaspweb_bottom_footer_top_padding', array(
						'default'     => '5',
						'type'        => 'kaspweb-range',
						'label'       => esc_html__( 'Padding top, px', 'kaspweb' ),
						'section'     => 'kaspweb_footer_bottom_section',
						'input_attrs' => array(
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						),
					)
				)
			);
            
            $wp_customize->add_setting(
				'kaspweb_bottom_footer_bottom_padding', array(
					'default'           => '5',
					'sanitize_callback' => 'absint',
				)
			);
            $wp_customize->add_control(
				new Kaspweb_Customizer_Range_Control(
					$wp_customize, 'kaspweb_bottom_footer_bottom_padding', array(
						'default'     => '5',
						'type'        => 'kaspweb-range',
						'label'       => esc_html__( 'Padding bottom, px', 'kaspweb' ),
						'section'     => 'kaspweb_footer_bottom_section',
						'input_attrs' => array(
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						),
					)
				)
			);
            
            $wp_customize->add_setting(
				'kaspweb_bottom_footer_bottom_padding', array(
					'default'           => '5',
					'sanitize_callback' => 'absint',
				)
			);
            $wp_customize->add_control(
				new Kaspweb_Customizer_Range_Control(
					$wp_customize, 'kaspweb_bottom_footer_bottom_padding', array(
						'default'     => '5',
						'type'        => 'kaspweb-range',
						'label'       => esc_html__( 'Padding bottom, px', 'kaspweb' ),
						'section'     => 'kaspweb_footer_bottom_section',
						'input_attrs' => array(
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						),
					)
				)
			);  
            
        } // End of if function_exists( 'understrap_theme_customize_register' ).
        
        public function kaspweb_customizer_css() {
            
            // Colors Base
            $background_color        = get_theme_mod( 'theme_background_color', '#ffffff' );
            $text_color              = get_theme_mod( 'theme_text_color', '#000000' );
            $link_color              = get_theme_mod( 'theme_link_color', '#000000' );
            $link_hover_color        = get_theme_mod( 'theme_link_hover_color', '#000000' );
            
            // Body
            $body_font_family        = get_theme_mod( 'body_font_family', 'Karla' );
            $body_font_size          = get_theme_mod( 'body_font_size', '15' );
            $body_line_height        = get_theme_mod( 'body_line_height', '26' );
            $body_letter_spacing     = get_theme_mod( 'body_letter_spacing', '0' );
            $body_word_spacing       = get_theme_mod( 'body_word_spacing', '0' );
            
            $pagetitle_font_family    = get_theme_mod( 'pagetitle_font_family', 'Karla' );
            $pagetitle_font_size      = get_theme_mod( 'pagetitle_font_size', '26' );
            $pagetitle_line_height    = get_theme_mod( 'pagetitle_line_height', '26' );
            $pagetitle_letter_spacing = get_theme_mod( 'pagetitle_letter_spacing', '0' );
            $pagetitle_word_spacing   = get_theme_mod( 'pagetitle_word_spacing', '0' );
            
            $theme_accent_color      = get_theme_mod( 'theme_accent_color', '#61bfad' );
            
            $social_svg_color        = get_theme_mod( 'social_svg_color', '#222222' );
            $header_typography_color = get_theme_mod( 'header_typography_color', '#222222' );
            $header_a_color          = get_theme_mod( 'header_a_color', '#222222' );
            $footer_color            = get_theme_mod( 'footer_color', '#999999' );
            $widget_title_color      = get_theme_mod( 'wt_color', '#999999' );

            $pagecontent_font_size    = get_theme_mod( 'pagecontent_font_size', '19' );
            $pagecontent_line_height  = get_theme_mod( 'pagecontent_line_height', '32' );
            $pagecontent_word_spacing = get_theme_mod( 'pagecontent_word_spacing', '0' );

            $site_logo_width = get_theme_mod( 'custom_logo_max_width', '50' );
            
            // [Footer]
            $header_footer_background_color = get_theme_mod( 'header_footer_background_color', '#FFFFFF' );
            $kaspweb_bottom_footer_background = get_theme_mod( 'kaspweb_bottom_footer_background', '#CCCCCC' );
            $kaspweb_bottom_footer_color = get_theme_mod( 'kaspweb_bottom_footer_color', '#000000' );
            $kaspweb_bottom_footer_top_padding = get_theme_mod( 'kaspweb_bottom_footer_top_padding', '0' );
            $kaspweb_bottom_footer_bottom_padding = get_theme_mod( 'kaspweb_bottom_footer_bottom_padding', '0' );
            

            // RGB.
            $theme_accent_color_rgb = kaspweb_hex2rgb( $theme_accent_color );
            // If the rgba values are empty return early.
            if ( empty( $theme_accent_color_rgb ) ) {
                return;
            }
            $progress_border = vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.4)', $theme_accent_color_rgb );

            $css =
            '
            body {
                font-family: ' . $body_font_family . ' !important;
                font-size: ' . $body_font_size . 'px !important;
                line-height: ' . $body_line_height . 'px !important;
                letter-spacing: ' . $body_letter_spacing . 'px !important;
                word-spacing: ' . $body_word_spacing . 'px !important;
            }
            body, body .post--wrapper, body .sticky-wrapper, body .project-caption {
                background-color: ' . $background_color . ';
            }
            body p{
                color: ' . $text_color . ';
            }
            body a{ 
                color: ' . $link_color . ' !important; 
            }
            body a:hover, body a:focus, body a:active{ 
                color:' . $link_hover_color . ' !important; 
            }
            #site-footer{
                background-color: ' . $header_footer_background_color . ';
            }
            #footer-bottom{ 
                background-color: ' . $kaspweb_bottom_footer_background . ';
                color: ' . $kaspweb_bottom_footer_color . ';
                padding-top: ' . $kaspweb_bottom_footer_top_padding . 'px;
                padding-bottom: ' . $kaspweb_bottom_footer_bottom_padding . 'px;
            }
            ';

            $css_filter_style = get_theme_mod( 'css_filter' );
            if ( '' !== $css_filter_style ) {
                switch ( $css_filter_style ) {
                    case 'none':
                        break;
                    case 'grayscale':
                        echo ' . brick-fullwidth .brick { filter: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'grayscale\'><feColorMatrix type=\'matrix\' values=\'0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0 0 0 1 0\'/></filter></svg>#grayscale"); filter:gray; -webkit-filter:grayscale(100%);-moz-filter: grayscale(100%);-o-filter: grayscale(100%);}';
                        break;
                    case 'sepia':
                        echo ' . brick-fullwidth .brick { -webkit-filter: sepia(50%); }';
                        break;
                    case 'saturation':
                        echo ' . brick-fullwidth .brick { -webkit-filter: saturate(150%); }';
                        break;
                }
            }

            /**
             * Combine the values from above and minifiy them.
             */
            $css_minified = $css;

            $css_minified = preg_replace( '#/\*.*?\*/#s', '', $css_minified );
            $css_minified = preg_replace( '/\s*([{}|:;,])\s+/', '$1', $css_minified );
            $css_minified = preg_replace( '/\s\s+(.*)/', '$1', $css_minified );

            wp_add_inline_style( 'kaspweb-style', wp_strip_all_tags( $css_minified ) );

        }


		/**
		 * Adds customizer options
		 *
		 * @since 1.0.0
		 */
		public function register_options() {
			
			// Var
			$dir = KASPWEB_INC_DIR .'customizer/settings/';

			// Customizer files array
			$files = array(
				'general',
			);

		}
            
		/**
		 * Loads js file for customizer preview
		 *
		 * @since 1.0.0
		 */
		public function customize_preview_init() {
            
			wp_enqueue_script( 'kaspweb-customize-preview', KASPWEB_INC_DIR_URI . 'customizer/assets/js/customize-preview.js', array( 'customize-preview'), KASPWEB_THEME_VERSION, true );         
		}

		/**
		 * Load scripts for customizer
		 *
		 * @since 1.0.0
		 */
		public function custom_customize_enqueue() {
			wp_enqueue_style( 'simple-line-icons', KASPWEB_INC_DIR_URI .'customizer/assets/css/customizer-simple-line-icons.min.css', false, '2.4.1' );
		}
        
	}

endif;

return new Kaspweb_Customizer();