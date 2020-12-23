<?php
/**
 * This file includes helper functions used throughout the theme.
 *
 * @package Kaspweb WordPress theme
 */

/*-------------------------------------------------------------------------------*/
/* [ General ]
/*-------------------------------------------------------------------------------*/

/**
 * Adds classes to the html tag
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kaspwebwp_html_classes' ) ) {

	function kaspwebwp_html_classes() {

		// Setup classes array
		$classes = array();

		// Main class
		$classes[] = 'html';
        
        if ( is_singular() ) {
		  $classes[] = 'singular';
	    }

		// Set keys equal to vals
		$classes = array_combine( $classes, $classes );
		
		// Apply filters for child theming
		$classes = apply_filters( 'kaspweb_html_classes', $classes );

		// Turn classes into space seperated string
		$classes = implode( ' ', $classes );

		// Return classes
		return $classes;

	}

}
if ( ! function_exists( 'kaspwebwp_body_classes' ) ){
    
    function kaspwebwp_body_classes($classes) {

        
        global $post;
	   $post_type = isset( $post ) ? $post->post_type : false;

        // Check whether we're singular.
        if ( is_singular() ) {
            $classes[] = 'singular';
        }

        // Check for enabled search.
        if ( true === get_theme_mod( 'enable_header_search', true ) ) {
            $classes[] = 'enable-search-modal';
        }


        return $classes;

    }
    
    add_filter( 'body_class', 'kaspweb_body_classes' );
}



if ( ! function_exists( 'kaspweb_setup_theme_default_settings' ) ) {
	/**
	 * Store default theme settings in database.
	 */
	function kaspweb_setup_theme_default_settings() {
		$defaults = kaspweb_get_theme_default_settings();
		$settings = get_theme_mods();
		foreach ( $defaults as $setting_id => $default_value ) {
			// Check if setting is set, if not set it to its default value.
			if ( ! isset( $settings[ $setting_id ] ) ) {
				set_theme_mod( $setting_id, $default_value );
			}
		}
	}
}

if ( ! function_exists( 'kaspweb_get_theme_default_settings' ) ) {
	/**
	 * Retrieve default theme settings.
	 *
	 * @return array
	 */
	function kaspweb_get_theme_default_settings() {
		$defaults = array(
			'kaspweb_posts_index_style' => 'default',   // Latest blog posts style.
			'kaspweb_sidebar_position'  => 'right',     // Sidebar position.
			'kaspweb_container_type'    => 'container', // Container width.
		);

		/**
		 * Filters the default theme settings.
		 *
		 * @param array $defaults Array of default theme settings.
		 */
		return apply_filters( 'kaspweb_theme_default_settings', $defaults );
	}
}


/*-------------------------------------------------------------------------------*/
/* [ Top Bar ]
/*-------------------------------------------------------------------------------*/

/**
 * Display top bar
 *
 * @since 1.1.2
 */
if ( ! function_exists( 'kaspwebwp_display_topbar' ) ) {

	function kaspwebwp_display_topbar() {

		// Return true by default
		$return = true;

		// Return false if disabled via Customizer
		if ( true != get_theme_mod( 'kaspweb_top_bar', true ) ) {
			$return = false;
		}

		// Apply filters and return
		return apply_filters( 'kaspweb_display_top_bar', $return );

	}

}

/**
 * Top bar template
 * I make a function to be able to remove it for the Beaver Themer plugin
 *
 * @since 1.2.5
 */
if ( ! function_exists( 'kaspwebwp_top_bar_template' ) ) {

	function kaspwebwp_top_bar_template() {

		// Return if no top bar
		if ( ! kaspwebwp_display_topbar() ) {
			return;
		}

		get_template_part( 'partials/topbar/layout' );

	}

	add_action( 'kaspweb_top_bar', 'kaspwebwp_top_bar_template' );

}

/**
 * Add classes to the top bar wrap
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kaspwebwp_topbar_classes' ) ) {

	function kaspwebwp_topbar_classes() {

		// Setup classes array
		$classes = array();

		// Clearfix class
		$classes[] = 'clr';

		// Visibility
		$visibility = get_theme_mod( 'kaspweb_top_bar_visibility', 'all-devices' );
		if ( 'all-devices' != $visibility ) {
			$classes[] = $visibility;
		}

		// Set keys equal to vals
		$classes = array_combine( $classes, $classes );
		
		// Apply filters for child theming
		$classes = apply_filters( 'kaspweb_topbar_classes', $classes );

		// Turn classes into space seperated string
		$classes = implode( ' ', $classes );

		// return classes
		return $classes;

	}

}

/**
 * Topbar style
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kaspwebwp_top_bar_style' ) ) {

	function kaspwebwp_top_bar_style() {
		$style = get_theme_mod( 'kaspweb_top_bar_style' );
		$style = $style ? $style : 'one';
		return apply_filters( 'kaspweb_top_bar_style', $style );
	}


}
/**
 * Topbar Content classes
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kaspwebwp_topbar_content_classes' ) ) {

	function kaspwebwp_topbar_content_classes() {

		// Define classes
		$classes = array( 'clr' );

		// Check for content
		if ( get_theme_mod( 'kaspweb_top_bar_content' ) ) {
			$classes[] = 'has-content';
		}

		// Get topbar style
		$style = oceanwp_top_bar_style();

		// Top bar style
		if ( 'one' == $style ) {
			$classes[] = 'top-bar-left';
		} elseif ( 'two' == $style ) {
			$classes[] = 'top-bar-right';
		} elseif ( 'three' == $style ) {
			$classes[] = 'top-bar-centered';
		}

		// Apply filters for child theming
		$classes = apply_filters( 'kaspweb_top_bar_classes', $classes );

		// Turn classes array into space seperated string
		$classes = implode( ' ', $classes );

		// Return classes
		return esc_attr( $classes );

	}

}

/*-------------------------------------------------------------------------------*/
/* [ Header ]
/*-------------------------------------------------------------------------------*/

/**
 * Display header
 *
 * @since 1.1.2
 */
if ( ! function_exists( 'kaspwebwp_display_header' ) ) {

	function kaspwebwp_display_header() {

		// Return true by default
		$return = true;

		// Apply filters and return
		return apply_filters( 'kaspweb_display_header', $return );

	}

}

/**
 * Header template
 * I make a function to be able to remove it for the Beaver Themer plugin
 * Я создаю функцию, чтобы иметь возможность удалить ее для плагина Beaver Themer
 * 
 * @since 1.2.5
 */
if ( ! function_exists( 'kaspwebwp_header_template' ) ) {

	function kaspwebwp_header_template() {

		// Return if no header
		if ( ! kaspwebwp_display_header() ) {
			return;
		}

		get_template_part( 'partials/header/layout' );

	}

	add_action( 'kaspweb_header', 'kaspwebwp_header_template' );

}

/*-------------------------------------------------------------------------------*/
/* [ Page Header ]
/*-------------------------------------------------------------------------------*/

/**
 * Page header template
 * I make a function to be able to remove it for the Beaver Themer plugin
 *
 * @since 1.2.5
 */
if ( ! function_exists( 'kaspweb_page_header_template' ) ) {

	function kaspweb_page_header_template() {

		get_template_part( 'partials/page-header' );

	}

	add_action( 'kaspweb_page_header', 'kaspweb_page_header_template' );

}

/**
 * Checks if the page header is enabled
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kaspweb_has_page_header' ) ) {

	function kaspweb_has_page_header() {
		
		// Define vars
		$return = true;
		$style  = kaspweb_page_header_style();

		// Check if page header style is set to hidden
		if ( 'hidden' == $style || is_page_template( 'templates/landing.php' ) ) {
			$return = false;
		}

		// Apply filters and return
		return apply_filters( 'kaspweb_display_page_header', $return );

	}

}

/**
 * Checks if the page header heading is enabled
 *
 * @since 1.4.0
 */
if ( ! function_exists( 'kaspweb_has_page_header_heading' ) ) {
 
	function kaspweb_has_page_header_heading() {

		// Define vars
		$return = true;

		// Apply filters and return
		return apply_filters( 'kaspweb_display_page_header_heading', $return );

	}

}

/**
 * Returns page header style
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kaspweb_page_header_style' ) ) {

	function kaspweb_page_header_style() {

		// Get default page header style defined in Customizer
		$style = get_theme_mod( 'kaspweb_page_header_style' );

		// If featured image in page header
		if ( true == get_theme_mod( 'kaspweb_blog_single_featured_image_title', false )
			&& is_singular( 'post' )
			&& has_post_thumbnail() ) {
			$style = 'background-image';
		}

		// Sanitize data
		$style = ( 'default' == $style ) ? '' : $style;
		
		// Apply filters and return
		return apply_filters( 'kaspweb_page_header_style', $style );

	}

}

/**
 * Return the title
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kaspweb_title' ) ) {

	function kaspweb_title() {

		// Default title is null
		$title = NULL;
		
		// Get post ID
		$post_id = kaspweb_post_id();
		
		// Homepage - display blog description if not a static page
		if ( is_front_page() && ! is_singular( 'page' ) ) {
			
			if ( get_bloginfo( 'description' ) ) {
				$title = get_bloginfo( 'description' );
			} else {
				return esc_html__( 'Recent Posts', 'kaspweb' );
			}

		// Homepage posts page
		} elseif ( is_home() && ! is_singular( 'page' ) ) {

			$title = get_the_title( get_option( 'page_for_posts', true ) );

		}

		// Search needs to go before archives
		elseif ( is_search() ) {
			global $wp_query;
			$title = '<span id="search-results-count">'. $wp_query->found_posts .'</span> '. esc_html__( 'Search Results Found', 'kaspweb' );
		}
			
		// Archives
		elseif ( is_archive() ) {

			// Author
			if ( is_author() ) {
				$title = get_the_archive_title();
			}

			// Post Type archive title
			elseif ( is_post_type_archive() ) {
				$title = post_type_archive_title( '', false );
			}

			// Daily archive title
			elseif ( is_day() ) {
				$title = sprintf( esc_html__( 'Daily Archives: %s', 'kaspweb' ), get_the_date() );
			}

			// Monthly archive title
			elseif ( is_month() ) {
				$title = sprintf( esc_html__( 'Monthly Archives: %s', 'kaspweb' ), get_the_date( esc_html_x( 'F Y', 'Page title monthly archives date format', 'kaspweb' ) ) );
			}

			// Yearly archive title
			elseif ( is_year() ) {
				$title = sprintf( esc_html__( 'Yearly Archives: %s', 'kaspweb' ), get_the_date( esc_html_x( 'Y', 'Page title yearly archives date format', 'kaspweb' ) ) );
			}

			// Categories/Tags/Other
			else {

				// Get term title
				$title = single_term_title( '', false );

				// Fix for plugins that are archives but use pages
				if ( ! $title ) {
					global $post;
					$title = get_the_title( $post_id );
				}

			}

		} // End is archive check

		// 404 Page
		elseif ( is_404() ) {

			$title = esc_html__( '404: Page Not Found', 'kaspweb' );

		}

		// Fix for WooCommerce My Accounts pages
		elseif( function_exists('is_wc_endpoint_url') && is_wc_endpoint_url() ) {
			$endpoint       = WC()->query->get_current_endpoint();
			$endpoint_title = WC()->query->get_endpoint_title( $endpoint );
			$title          = $endpoint_title ? $endpoint_title : $title;
		}
		
		// Anything else with a post_id defined
		elseif ( $post_id ) {

			// Single Pages
			if ( is_singular( 'page' ) || is_singular( 'attachment' ) ) {
				$title = get_the_title( $post_id );
			}

			// Single blog posts
			elseif ( is_singular( 'post' ) ) {

				if ( 'post-title' == get_theme_mod( 'ocean_blog_single_page_header_title', 'blog' ) ) {
					$title = get_the_title();
				} else {
					$title = esc_html__( 'Blog', 'kaspweb' );
				}

			}

			// Other posts
			else {

				$title = get_the_title( $post_id );
				
			}

		}

		// Last check if title is empty
		$title = $title ? $title : get_the_title();

		// Apply filters and return title
		return apply_filters( 'kaspweb_title', $title );
		
	}

}

/**
 * Returns page subheading
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kaspweb_get_page_subheading' ) ) {

	function kaspweb_get_page_subheading() {

		// Subheading is NULL by default
		$subheading = NULL;

		// Search
		if ( is_search() ) {
			$subheading = esc_html__( 'You searched for:', 'kaspweb' ) .' &quot;'. esc_html( get_search_query( false ) ) .'&quot;';
		}

		// Author
		elseif ( is_author() ) {
			$subheading = esc_html__( 'This author has written', 'kaspweb' ) .' '. get_the_author_posts() .' '. esc_html__( 'articles', 'kaspweb' );
		}

		// Archives
		elseif ( is_post_type_archive() ) {
			$subheading = get_the_archive_description();
		}

		// Apply filters and return
		return apply_filters( 'kaspweb_post_subheading', $subheading );

	}

}

/**
 * Get taxonomy description
 *
 * @since 1.5.27
 */
if ( ! function_exists( 'oceanwp_get_tax_description' ) ) {

	function oceanwp_get_tax_description() {

		// Subheading is NULL by default
		$desc = NULL;

		// All other Taxonomies
		if ( is_category() || is_tag() ) {
			$desc = term_description();
		}

		// Apply filters and return
		return apply_filters( 'ocean_tax_description', $desc );

	}

}

/**
 * Add taxonomy description
 *
 * @since 1.5.27
 */
if ( ! function_exists( 'oceanwp_tax_description' ) ) {

	function oceanwp_tax_description() {

		if ( $desc = oceanwp_get_tax_description() ) : ?>

			<div class="clr tax-desc">
				<?php echo do_shortcode( $desc ); ?>
			</div>

		<?php endif;

	}

	add_action( 'ocean_before_content_inner', 'oceanwp_tax_description' );

}

/**
 * Display breadcrumbs
 *
 * @since 1.1.2
 */
if ( ! function_exists( 'oceanwp_has_breadcrumbs' ) ) {

	function kaspwebwp_has_breadcrumbs() {

		// Return true by default
		$return = true;

		// Return false if disabled via Customizer
		if ( true != get_theme_mod( 'kaspweb_breadcrumbs', true ) ) {
			$return = false;
		}

		// Apply filters and return
		return apply_filters( 'kaspweb_display_breadcrumbs', $return );

	}

}

/**
 * Outputs Custom CSS for the page title
 *
 * @since 1.0.4
 */
if ( ! function_exists( 'kaspweb_page_header_overlay' ) ) {

	function kaspweb_page_header_overlay() {

		// Define return
		$return = '';

		// Only needed for the background-image style so return otherwise
		if ( 'background-image' != kaspweb_page_header_style() ) {
			return;
		}

		// Return overlay element
		$return = '<span class="background-image-page-header-overlay"></span>';

		// Apply filters for child theming
		$return = apply_filters( 'kaspweb_page_header_overlay', $return );

		// Return
		echo wp_kses_post( $return );
	}

}



/*-------------------------------------------------------------------------------*/
/* [ Footer ]
/*-------------------------------------------------------------------------------*/


/**
 * Display footer bottom
 *
 * @since 1.1.2
 */
if ( ! function_exists( 'kaspwebwp_display_footer_bottom' ) ) {

	function kaspwebwp_display_footer_bottom() {

		// Return true by default
		$return = true;

		// Return false if disabled via Customizer
		if ( true != get_theme_mod( 'kaspweb_footer_bottom', true ) ) {
			$return = false;
		}

		// Apply filters and return
		return apply_filters( 'kaspweb_display_footer_bottom', $return );

	}

}

/**
 * Footer template
 * I make a function to be able to remove it for the Beaver Themer plugin
 * Я создаю функцию, чтобы иметь возможность удалить ее для плагина Beaver Themer
 * @since 1.2.5
 */
if ( ! function_exists( 'kaspwebwp_footer_template' ) ) {

	function kaspwebwp_footer_template() {

		if ( kaspwebwp_display_footer_bottom() ) {
        	get_template_part( 'partials/footer/layout' );
        }

	}

	add_action( 'kaspweb_footer', 'kaspwebwp_footer_template' );

}

/**
 * Returns array of Social Options
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kaspwebwp_social_options' ) ) {

	function kaspwebwp_social_options() {
		return apply_filters( 'kaspweb_social_options', array(
			'twitter' => array(
				'label' => esc_html__( 'Twitter', 'kaspwebwp' ),
				'icon_class' => 'fab fa-twitter',
			),
			'facebook' => array(
				'label' => esc_html__( 'Facebook', 'kaspwebwp' ),
				'icon_class' => 'fab fa-facebook',
			),
			'googleplus' => array(
				'label' => esc_html__( 'Google Plus', 'kaspwebwp' ),
				'icon_class' => 'fab fa-google-plus',
			),
			'pinterest'  => array(
				'label' => esc_html__( 'Pinterest', 'kaspwebwp' ),
				'icon_class' => 'fab fa-pinterest-p',
			),
			'dribbble' => array(
				'label' => esc_html__( 'Dribbble', 'kaspwebwp' ),
				'icon_class' => 'fab fa-dribbble',
			),
			'vk' => array(
				'label' => esc_html__( 'VK', 'kaspwebwp' ),
				'icon_class' => 'fab fa-vk',
			),
			'instagram'  => array(
				'label' => esc_html__( 'Instagram', 'kaspwebwp' ),
				'icon_class' => 'fab fa-instagram',
			),
			'linkedin' => array(
				'label' => esc_html__( 'LinkedIn', 'kaspwebwp' ),
				'icon_class' => 'fab fa-linkedin',
			),
			'tumblr'  => array(
				'label' => esc_html__( 'Tumblr', 'kaspwebwp' ),
				'icon_class' => 'fab fa-tumblr',
			),
			'github'  => array(
				'label' => esc_html__( 'Github', 'kaspwebwp' ),
				'icon_class' => 'fab fa-github-alt',
			),
			'flickr'  => array(
				'label' => esc_html__( 'Flickr', 'kaspwebwp' ),
				'icon_class' => 'fab fa-flickr',
			),
			'skype' => array(
				'label' => esc_html__( 'Skype', 'kaspwebwp' ),
				'icon_class' => 'fab fa-skype',
			),
			'youtube' => array(
				'label' => esc_html__( 'Youtube', 'kaspwebwp' ),
				'icon_class' => 'fab fa-youtube',
			),
			'vimeo' => array(
				'label' => esc_html__( 'Vimeo', 'kaspwebwp' ),
				'icon_class' => 'fab fa-vimeo-square',
			),
			'vine' => array(
				'label' => esc_html__( 'Vine', 'kaspwebwp' ),
				'icon_class' => 'fab fa-vine',
			),
			'xing' => array(
				'label' => esc_html__( 'Xing', 'kaspwebwp' ),
				'icon_class' => 'fab fa-xing',
			),
			'yelp' => array(
				'label' => esc_html__( 'Yelp', 'kaspwebwp' ),
				'icon_class' => 'fab fa-yelp',
			),
			'tripadvisor' => array(
				'label' => esc_html__( 'Tripadvisor', 'kaspwebwp' ),
				'icon_class' => 'fab fa-tripadvisor',
			),
			'rss'  => array(
				'label' => esc_html__( 'RSS', 'kaspwebwp' ),
				'icon_class' => 'fa fa-rss',
			),
			'email' => array(
				'label' => esc_html__( 'Email', 'kaspwebwp' ),
				'icon_class' => 'fa fa-envelope',
			),
		) );
	}

}

/**
 * Returns topbar social alt content
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kaspwebwp_top_bar_social_alt_content' ) ) {

	function kaspwebwp_top_bar_social_alt_content() {

		// Get page ID from Customizer
		$content = get_theme_mod( 'kaspweb_top_bar_social_alt' );

		// Get the template ID
		$template = get_theme_mod( 'kaspweb_top_bar_social_alt_template' );
		if ( ! empty( $template ) ) {
		    $content = $template;
		}

		// Get Polylang Translation of template
		if ( function_exists( 'pll_get_post' ) ) {
			$content = pll_get_post( $content, pll_current_language() );
		}

		// Get page content
		if ( ! empty( $content ) ) {

			$template = get_post( $content );

			if ( $template && ! is_wp_error( $template ) ) {
				$content = $template->post_content;
			}

		}

		// Return content
		return apply_filters( 'kaspwebwp_top_bar_social_alt_content', $content );

	}

}
/**
 * Return correct schema markup
 *
 * @since 1.2.10
 */
if ( ! function_exists( 'kaspwebwp_get_schema_markup' ) ) {

	function kaspwebwp_get_schema_markup( $location ) {

		// Return if disable
		if ( ! get_theme_mod( 'kaspweb_schema_markup', true ) ) {
			return null;
		}

		// Default
		$schema = $itemprop = $itemtype = '';

		// HTML
		if ( 'html' == $location ) {
			if ( is_home() || is_front_page() ) {
				$schema = 'itemscope="itemscope" itemtype="https://schema.org/WebPage"';
			}
			elseif ( is_category() || is_tag() ) {
				$schema = 'itemscope="itemscope" itemtype="https://schema.org/Blog"';
			}
			elseif ( is_singular( 'post') ) {
				$schema = 'itemscope="itemscope" itemtype="https://schema.org/Article"';
			}
			elseif ( is_page() ) {
				$schema = 'itemscope="itemscope" itemtype="https://schema.org/WebPage"';
			}
			else {
				$schema = 'itemscope="itemscope" itemtype="https://schema.org/WebPage"';
			}
		}

		// Header
		elseif ( 'header' == $location ) {
			$schema = 'itemscope="itemscope" itemtype="https://schema.org/WPHeader"';
		}

		// Logo
		elseif ( 'logo' == $location ) {
			$schema = 'itemscope itemtype="https://schema.org/Brand"';
		}

		// Navigation
		elseif ( 'site_navigation' == $location ) {
			$schema = 'itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement"';
		}

		// Main
		elseif ( 'main' == $location ) {
			$itemtype = 'https://schema.org/WebPageElement';
			$itemprop = 'mainContentOfPage';
		}

		// Sidebar
		elseif ( 'sidebar' == $location ) {
			$schema = 'itemscope="itemscope" itemtype="https://schema.org/WPSideBar"';
		}

		// Footer widgets
		elseif ( 'footer' == $location ) {
			$schema = 'itemscope="itemscope" itemtype="https://schema.org/WPFooter"';
		}

		// Headings
		elseif ( 'headline' == $location ) {
			$schema = 'itemprop="headline"';
		}

		// Posts
		elseif ( 'entry_content' == $location ) {
			$schema = 'itemprop="text"';
		}

		// Publish date
		elseif ( 'publish_date' == $location ) {
			$schema = 'itemprop="datePublished"';
		}

		// Modified date
		elseif ( 'modified_date' == $location ) {
			$schema = 'itemprop="dateModified"';
		}

		// Author name
		elseif ( 'author_name' == $location ) {
			$schema = 'itemprop="name"';
		}

		// Author link
		elseif ( 'author_link' == $location ) {
			$schema = 'itemprop="author" itemscope="itemscope" itemtype="https://schema.org/Person"';
		}

		// Item
		elseif ( 'item' == $location ) {
			$schema = 'itemprop="item"';
		}

		// Url
		elseif ( 'url' == $location ) {
			$schema = 'itemprop="url"';
		}

		// Position
		elseif ( 'position' == $location ) {
			$schema = 'itemprop="position"';
		}

		// Image
		elseif ( 'image' == $location ) {
			$schema = 'itemprop="image"';
		}

		return ' ' . apply_filters( 'kaspweb_schema_markup', $schema );

	}

}

/**
 * Outputs correct schema markup
 * Выводит правильную разметку схемы
 *
 * @since 1.2.10
 */
if ( ! function_exists( 'kaspwebwp_schema_markup' ) ) {

	function kaspwebwp_schema_markup( $location ) {

		echo kaspwebwp_get_schema_markup( $location );

	}

}

/**
 * Default color picker palettes
 * Палитры выбора цветов по умолчанию
 * 
 * @since 1.4.9
 */
if ( ! function_exists( 'kaspwebwp_default_color_palettes' ) ) {

	function kaspwebwp_default_color_palettes() {

		$palettes = array(
			'#000000',
			'#ffffff',
			'#dd3333',
			'#dd9933',
			'#eeee22',
			'#81d742',
			'#1e73be',
			'#8224e3',
		);

		// Apply filters and return
		return apply_filters( 'kaspweb_default_color_palettes', $palettes );

	}

}

/**
 * Get unique ID.
 *
 * This is a PHP implementation of Underscore's uniqueId method. A static variable
 * contains an integer that is incremented with each call. This number is returned
 * with the optional prefix. As such the returned value is not universally unique,
 * but it is unique across the life of the PHP process.
 *
 * @see wp_unique_id() Themes requiring WordPress 5.0.3 and greater should use this instead.
 *
 * @staticvar int $id_counter
 *
 * @param string $prefix Prefix for the returned ID.
 * @return string Unique ID.
 */
function kaspweb_unique_id( $prefix = '' ) {
	static $id_counter = 0;
	if ( function_exists( 'wp_unique_id' ) ) {
		return wp_unique_id( $prefix );
	}
	return $prefix . (string) ++$id_counter;
}


/**
 * Returns correct post layout
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'oceanwp_post_layout' ) ) {

	function oceanwp_post_layout() {

		// Define variables
		$class  = 'right-sidebar';
		$meta   = get_post_meta( kaspweb_post_id(), 'ocean_post_layout', true );

		// Check meta first to override and return (prevents filters from overriding meta)
		if ( $meta ) {
			return $meta;
		}

		// Singular Page
		if ( is_page() ) {

			// Landing template
			if ( is_page_template( 'templates/landing.php' ) ) {
				$class = 'full-width';
			}

			// Attachment
			elseif ( is_attachment() ) {
				$class = 'full-width';
			}

			// All other pages
			else {
				$class = get_theme_mod( 'ocean_page_single_layout', 'right-sidebar' );
			}

		}

		// Home
		elseif ( is_home()
			|| is_category()
			|| is_tag()
			|| is_date()
			|| is_author() ) {
			$class = get_theme_mod( 'ocean_blog_archives_layout', 'right-sidebar' );
		}

		// Singular Post
		elseif ( is_singular( 'post' ) ) {
			$class = get_theme_mod( 'ocean_blog_single_layout', 'right-sidebar' );
		}

		// Library and Elementor template
		elseif ( is_singular( 'oceanwp_library' )
    			|| is_singular( 'elementor_library' ) ) {
			$class = 'full-width';
		}

		// Search
		elseif ( is_search() ) {
			$class = get_theme_mod( 'ocean_search_layout', 'right-sidebar' );
		}
		
		// 404 page
		elseif ( is_404() ) {
			$class = get_theme_mod( 'ocean_error_page_layout', 'full-width' );
		}

		// All else
		else {
			$class = 'right-sidebar';
		}

		// Class should never be empty
		if ( empty( $class ) ) {
			$class = 'right-sidebar';
		}

		// Apply filters and return
		return apply_filters( 'ocean_post_layout_class', $class );

	}

}

/**
 * Store current post ID
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kaspweb_post_id' ) ) {

	function kaspweb_post_id() {

		// Default value
		$id = '';

		// If singular get_the_ID
		if ( is_singular() ) {
			$id = get_the_ID();
		}

		// Get ID of WooCommerce product archive
		//elseif ( OCEANWP_WOOCOMMERCE_ACTIVE && is_shop() ) {
		//	$shop_id = wc_get_page_id( 'shop' );
		//	if ( isset( $shop_id ) ) {
		//		$id = $shop_id;
		//	}
		//}

		// Posts page
		elseif ( is_home() && $page_for_posts = get_option( 'page_for_posts' ) ) {
			$id = $page_for_posts;
		}

		// Apply filters
		$id = apply_filters( 'kaspweb_post_id', $id );

		// Sanitize
		$id = $id ? $id : '';

		// Return ID
		return $id;

	}

}

/**
 * Returns the correct classname for any specific column grid
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kaspweb_grid_class' ) ) {

	function kaspweb_grid_class( $col = '4' ) {
		return esc_attr( apply_filters( 'kaspweb_grid_class', 'span_1_of_'. $col ) );
	}

}

/*-------------------------------------------------------------------------------*/
/* [ Blog ]
/*-------------------------------------------------------------------------------*/

/**
 * Returns blog single elements positioning
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'kaspweb_blog_single_elements_positioning' ) ) {

	function kaspweb_blog_single_elements_positioning() {

		// Default sections
		$sections = array( 'featured_image', 'title', 'meta', 'content', 'tags', 'social_share', 'next_prev', 'author_box', 'related_posts', 'single_comments' );

		// Get sections from Customizer
		$sections = get_theme_mod( 'ocean_blog_single_elements_positioning', $sections );

		// Turn into array if string
		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}

		// Apply filters for easy modification
		$sections = apply_filters( 'ocean_blog_single_elements_positioning', $sections );

		// Return sections
		return $sections;

	}

}


/**
 * Register Google fonts.
 *
 * @return string Google fonts URL for the theme.
 */
if ( ! function_exists( 'kaspweb_fonts_url' ) ) {
    
    function kaspweb_fonts_url() {

    $fonts_url = '';

    /*
     * Translators: If there are characters in your language that are not
     * Переводчики: если в вашем языке есть символы, которых нет
     * supported by Karla, translate this to 'off'. Do not translate
     * в поддержке шрифтов Карлы переведите это в положение "Выкл". Не переводить
     * into your own language.
     * на свой собственный язык.
     */
    $karla = esc_html_x( 'on', 'Karla font: on or off', 'kaspweb' );

    if ( 'off' !== $karla ) {
        $font_families = array();

        if ( 'off' !== $karla ) {
            $font_families[] = 'Karla';
        }

        $query_args = array(
            'family' => rawurlencode( implode( '|', $font_families ) ),
            'subset' => rawurlencode( 'latin,latin-ext' ),
        );

        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }

    return esc_url_raw( $fonts_url );
    }
}
/**
 * Add preconnect for Google Fonts.
 * Добавьте preconnect для шрифтов Google.
 *
 * @param  array  $urls          URLs to print for resource hints.
 * @param  string $relation_type The relation type the URLs are printed.
 * @return array  $urls           URLs to print for resource hints.
 */
if ( ! function_exists( 'kaspweb_resource_hints' ) ) {
    
    function kaspweb_resource_hints( $urls, $relation_type ) {
        if ( wp_style_is( 'kaspweb-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
            $urls[] = array(
                'href' => 'https://fonts.gstatic.com',
                'crossorigin',
            );
        }

        return $urls;
    }
    add_filter( 'wp_resource_hints', 'kaspweb_resource_hints', 10, 2 );
}

/**
 * Convert HEX to RGB.
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 * HEX code, empty array otherwise.
 */
if ( ! function_exists( 'kaspweb_hex2rgb' ) ){ 
    function kaspweb_hex2rgb( $color ) {
        $color = trim( $color, '#' );

        if ( strlen( $color ) === 3 ) {
            $r = hexdec( substr( $color, 0, 1 ) . substr( $color, 0, 1 ) );
            $g = hexdec( substr( $color, 1, 1 ) . substr( $color, 1, 1 ) );
            $b = hexdec( substr( $color, 2, 1 ) . substr( $color, 2, 1 ) );
        } elseif ( strlen( $color ) === 6 ) {
            $r = hexdec( substr( $color, 0, 2 ) );
            $g = hexdec( substr( $color, 2, 2 ) );
            $b = hexdec( substr( $color, 4, 2 ) );
        } else {
            return array();
        }

        return array(
            'red'   => $r,
            'green' => $g,
            'blue'  => $b,
        );
    }
}

/*
 * This display blog description from wp customizer setting.
 */
if ( ! function_exists( 'kaspweb_cats' ) ) {
	function kaspweb_cats() {
		$cats = array();
		$cats[0] = 'All';

		foreach ( get_categories() as $categories => $category ) {
			$cats[ $category->term_id ] = $category->name;
		}
		return $cats;
	}
}


/**
 * Featured image Post slider, displayed on front page for static page and blog
 */
if ( ! function_exists( 'kaspweb_featured_post_slider' ) ) {
	/**
 * Featured image slider, displayed on front page for static page and blog
 */
	function kaspweb_featured_post_slider() {
		if ( ( is_home() || is_front_page() ) && get_theme_mod( 'kaspweb_featured_hide' ) == 1 ) {

			wp_enqueue_style( 'flexslider-css' );
			wp_enqueue_script( 'flexslider-js' );

			echo '<div class="flexslider">';
			echo '<ul class="slides">';

			$slidecat = get_theme_mod( 'kaspweb_featured_cat' );
			$slidelimit = get_theme_mod( 'kaspweb_featured_limit', -1 );
			$slider_args = array(
				'cat' => $slidecat,
				'posts_per_page' => $slidelimit,
				'meta_query' => array(
					array(
						'key' => '_thumbnail_id',
						'compare' => 'EXISTS',
					),
				),
			);
			$query = new WP_Query( $slider_args );
			if ( $query->have_posts() ) :

				while ( $query->have_posts() ) : $query->the_post();
					if ( ( function_exists( 'has_post_thumbnail' ) ) && ( has_post_thumbnail() ) ) :
						echo '<li>';
						if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'photon' ) ) {
							$feat_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
							$args = array(
								'resize' => '1920,550',
							);
							$photon_url = jetpack_photon_url( $feat_image_url[0], $args );
							echo '<img src="' . $photon_url . '">';
						} else {
							  echo get_the_post_thumbnail( get_the_ID(), 'kaspweb-slider' );
						}
								echo '<div class="flex-caption">';
							  echo get_the_category_list();
						if ( get_the_title() != '' ) { echo '<a href="' . get_permalink() . '"><h2 class="entry-title">' . get_the_title() . '</h2></a>';
						}
								echo '<div class="read-more"><a href="' . get_permalink() . '">' . __( 'Read More', 'kaspweb' ) . '</a></div>';
								echo '</div>';
								echo '</li>';
						endif;
					endwhile;
				wp_reset_query();
			endif;
			echo '</ul>';
			echo ' </div>';
		}// End if().
	}
}