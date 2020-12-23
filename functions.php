<?php
/**
 * Theme functions and definitions.
 *
 * Sets up the theme and provides some helper functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package Kaspweb WordPress theme
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Core Constants
define( 'KASPWEB_THEME_DIR', get_template_directory() );
define( 'KASPWEB_THEME_URI', get_template_directory_uri() );
if ( ! defined( 'KASPWEB_DEBUG' ) ) :
	/**
	 * Check to see if development mode is active.
	 * Проверьте, активен ли режим разработки
	 * If set to false, the theme will load un-minified assets.
	 * Если установлено значение false, то тема будет загружать минифицированные файлы.
	 */
	define( 'KASPWEB_DEBUG', true );
endif;
if ( ! defined( 'KASPWEB_ASSET_SUFFIX' ) ) :
	/**
	 * If not set to true, let's serve minified .css and .js assets.
	 * Если не установлено значение true, то давайте минифицируем .css и .js файлы.
	 * Don't modify this, unless you know what you're doing!
	 * Не изменяйте это, если вы не знаете, что делаете!
	 */
	if ( ! defined( 'KASPWEB_DEBUG' ) || true === KASPWEB_DEBUG ) {
		define( 'KASPWEB_ASSET_SUFFIX', null );
	} else {
		define( 'KASPWEB_ASSET_SUFFIX', '.min' );
	}
endif;

final class Kaspweb_Theme_Class {

	/**
	 * Main Theme Class Constructor
	 *
	 * @since   1.0.0 
	 */
	public function __construct() {

		// Define constants
		add_action( 'after_setup_theme', array( 'Kaspweb_Theme_Class', 'constants' ), 0 );

		// Load all core theme function files
		add_action( 'after_setup_theme', array( 'Kaspweb_Theme_Class', 'include_functions' ), 1 );

		// Load framework classes
		add_action( 'after_setup_theme', array( 'Kaspweb_Theme_Class', 'classes' ), 4 );

		// Setup theme => add_theme_support, register_nav_menus, load_theme_textdomain, etc
		add_action( 'after_setup_theme', array( 'Kaspweb_Theme_Class', 'theme_setup' ), 10 );

		// register sidebar widget areas
		add_action( 'widgets_init', array( 'Kaspweb_Theme_Class', 'register_sidebars' ) );

		/** Admin only actions **/
		if ( is_admin() ) {

			// Outputs custom CSS for the admin
			add_action( 'admin_head', array( 'Kaspweb_Theme_Class', 'admin_inline_css' ) );

		/** Non Admin actions **/
		} else {

			// Load theme CSS
			add_action( 'wp_enqueue_scripts', array( 'Kaspweb_Theme_Class', 'theme_css' ) );

			// Load theme js
			add_action( 'wp_enqueue_scripts', array( 'Kaspweb_Theme_Class', 'theme_js' ) );
            
            // Add a pingback url auto-discovery header for singularly identifiable articles 
			add_action( 'wp_head', array( 'Kaspweb_Theme_Class', 'pingback_header' ), 1 );
            
            // Meta tag viewport to header
			add_action( 'wp_head', array( 'Kaspweb_Theme_Class', 'meta_tag_viewport' ), 1 );

			// Add an X-UA-Compatible header
			add_action( 'wp_headers', array( 'Kaspweb_Theme_Class', 'x_ua_compatible_headers' ), 2 );

			// Add an Skip Link Focus Fix footer
			add_action( 'wp_print_footer_scripts', array( 'Kaspweb_Theme_Class', 'skip_link_focus_fix' ) );

			// Go To Top  
            add_action( 'wp_footer', array( 'Kaspweb_Theme_Class', 'go_to_top' ) );

            // Truncate Read More
            add_action( 'wp_footer', array( 'Kaspweb_Theme_Class', 'truncate_read_more') );

		}
	}

	/**
	 * Define Constants
	 *
	 * @since   1.0.0
	 */
	public static function constants() {

		$version = self::theme_version();

		// Theme version
		define( 'KASPWEB_THEME_VERSION', $version );

		// Javascript and CSS Paths
		define( 'KASPWEB_JS_DIR_URI', KASPWEB_THEME_URI .'/assets/js/' );
		define( 'KASPWEB_CSS_DIR_URI', KASPWEB_THEME_URI .'/assets/css/' );

		// Include Paths
		define( 'KASPWEB_INC_DIR', KASPWEB_THEME_DIR .'/inc/' );
		define( 'KASPWEB_INC_DIR_URI', KASPWEB_THEME_URI .'/inc/' );
	}
    
    	/**
	 * Load all core theme function files
	 *
	 * @since 1.0.0
	 */
	public static function include_functions() {
        
		$dir = KASPWEB_INC_DIR;
        
		require_once( $dir . 'helpers.php' );
		require_once( $dir . 'template-tags.php' );
		require_once( $dir . 'class-kaspweb-walker-comment.php' );
		require_once( $dir . 'class-kaspweb-walker-page.php' );
		require_once( $dir . 'class-kaspweb-non-latin-languages.php' );
		require_once( $dir . 'custom-css.php' );
        // Declaring fonts
        require_once( $dir . 'fonts.php' );
        require_once( $dir . 'fonts-library.php' );
        // Handle SVG icons.
        require_once( $dir . 'class-kaspweb-svg-icons.php' );
        require_once( $dir . 'svg-icons.php' );
        // Declaring widgets
        require_once( $dir . 'widgets.php' ); 
        require_once( $dir . 'pagination.php' );
        // classes
        require_once( $dir . 'class-kaspweb-wp-bootstrap-navwalker.php' );
        require_once( $dir . 'class-kaspweb-script-loader.php' ); 
	}

	/**
	 * Returns current theme version
	 *
	 * @since   1.0.0
	 */
	public static function theme_version() {

		// Get theme data
		$theme = wp_get_theme();

		// Return theme version
		return $theme->get( 'Version' );
	}

	/**
	 * Load theme classes
	 *
	 * @since   1.0.0
	 */
	public static function classes() {

		// Breadcrumbs class
		require_once( KASPWEB_INC_DIR .'breadcrumbs.php' );

		// Customizer class
		require_once( KASPWEB_INC_DIR .'customizer.php' );
	}

	/**
	 * Theme Setup
	 *
	 * @since   1.0.0
	 */
	public static function theme_setup() {

		// Load text domain
		load_theme_textdomain( 'kaspweb', KASPWEB_THEME_DIR .'/languages' );

		// Get globals
		global $content_width;

		// Set content width based on theme's default design
		if ( ! isset( $content_width ) ) {
			$content_width = 1200;
		}

		// Register navigation menus
		register_nav_menus( array(
            'topbar_menu'               => esc_html__( 'Top Bar', 'kaspweb' ),
            'main_menu'                 => esc_html__( 'Main', 'kaspweb' ),
			'footer_menu_copyright'     => esc_html__( 'Footer', 'kaspweb' ),
			'mobile_menu'               => esc_html__( 'Mobile (optional)', 'kaspweb' )
		) );

		// Enable support for Post Formats
		add_theme_support( 'post-formats', array( 'video', 'gallery', 'audio', 'quote', 'link' ) );

		// Enable support for <title> tag
		add_theme_support( 'title-tag' );

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		// Enable support for Post Thumbnails on posts and pages
		add_theme_support( 'post-thumbnails' );

		add_image_size( 'kaspweb-slider', 1920, 550, true );
        
		/**
		 * Enable support for header image
		 */
		add_theme_support( 'custom-header', apply_filters( 'kaspweb_custom_header', array(
			'width'              => 2000,
			'height'             => 1200,
			'flex-height'        => true,
			'video'              => true,
		) ) );

		/**
		 * Enable support for site logo
		 */
		add_theme_support( 'custom-logo', apply_filters( 'kaspweb_custom_logo', array(
			'height'      => 45,
			'width'       => 164,
			'flex-height' => true,
			'flex-width'  => true,
		) ) );

		/*
		 * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'widgets',
		) );
        
        // Declare support for selective refreshing of widgets.
        // Объявите о поддержке выборочного обновления виджетов.
		add_theme_support( 'customize-selective-refresh-widgets' );
        
             
        /*
         * Adds `async` and `defer` support for scripts registered or enqueued
         * Добавлена поддержка 'async` и' defer` для зарегистрированных или поставленных в очередь скриптов
         * by the theme.
         */
        $loader = new Kaspweb_Script_Loader();
        add_filter( 'script_loader_tag', array( $loader, 'filter_script_loader_tag' ), 10, 2 );
        
        /*
         * This theme styles the visual editor to resemble the theme style.
         */
        add_editor_style( array( 'assets/css/editor' . KASPWEB_ASSET_SUFFIX . '.css', kaspweb_fonts_url() ) );
	}

	/**
	 * Load front-end scripts
	 *
	 * @since   1.0.0
	 */
	public static function theme_css() {

		// Define dir
		$dir = KASPWEB_CSS_DIR_URI;
		$theme_version = KASPWEB_THEME_VERSION;

        // Add custom fonts, used in the main stylesheet.
	    wp_enqueue_style( 'kaspweb-fonts', kaspweb_fonts_url(), array(), null );
        
		// Remove font awesome style from plugins 
		wp_deregister_style( 'font-awesome' );
		wp_deregister_style( 'fontawesome' );

		// Main Style.css File
		wp_enqueue_style( 'kaspweb-style', $dir .'/style.min.css', false, $theme_version );

		// Add slider CSS only if is front page ans slider is enabled
        if ( ( is_home() || is_front_page() ) && get_theme_mod( 'kaspweb_featured_hide' ) == 1 ) {
            wp_enqueue_style( 'flexslider-css', $dir . 'third/flexslider.css' );
        }

	}

	/**
	 * Returns all js needed for the front-end
	 *
	 * @since 1.0.0
	 */
	public static function theme_js() {

		// Get js directory uri
		$dir = KASPWEB_JS_DIR_URI;

		// Get current theme version
		$theme_version = KASPWEB_THEME_VERSION;
        

		// Comment reply
		if ( ( ! is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
        wp_enqueue_script( 'kaspweb-js', $dir . 'index.js', array(), $theme_version, false );
	    wp_script_add_data( 'kaspweb-js', 'async', true );

	    // Add slider JS only if is front page ans slider is enabled
		if ( ( is_home() || is_front_page() ) && get_theme_mod( 'activello_featured_hide' ) == 1 ) {
         wp_enqueue_script( 'flexslider-js', $dir . 'third/flexslider.min.js', array( 'jquery' ), '20140222', true );
        }
        
		// Load minified js
		//wp_enqueue_script( 'kaspweb-main', $dir .'main.min.js', array( 'jquery' ), $theme_version, true );
        //wp_script_add_data( 'kaspweb-main', 'async', true );
	}

	/**
	 * Registers sidebars 
	 *
	 * @since   1.0.0
	 */ 
	public static function register_sidebars() {

		$heading = 'h4';
		$heading = apply_filters( 'kaspweb_sidebar_heading', $heading );

        // Right Sidebar
        register_sidebar(
			array(
				'name'          => __( 'Right Sidebar', 'kaspweb' ),
				'id'            => 'right-sidebar',
				'description'   => __( 'Right sidebar widget area', 'kaspweb' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s clr">',
				'after_widget'  => '</aside>',
				'before_title'  => '<'. $heading .' class="widget-title">',
				'after_title'   => '</'. $heading .'>',
			)
		);
        
        // Left Sidebar
        register_sidebar(
			array(
				'name'          => __( 'Left Sidebar', 'kaspweb' ),
				'id'            => 'left-sidebar',
				'description'   => __( 'Left sidebar widget area', 'kaspweb' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s clr">',
				'after_widget'  => '</aside>',
				'before_title'  => '<'. $heading .' class="widget-title">',
				'after_title'   => '</'. $heading .'>',
			)
		);
        
		// Default Sidebar
		register_sidebar( array(
			'name'			=> esc_html__( 'Default Sidebar', 'kaspweb' ),
			'id'			=> 'sidebar',
			'description'	=> esc_html__( 'Widgets in this area will be displayed in the left or right sidebar area if you choose the Left or Right Sidebar layout.', 'kaspweb' ),
			'before_widget'	=> '<aside id="%1$s" class="widget %2$s clr">',
			'after_widget'	=> '</aside>',
			'before_title'	=> '<'. $heading .' class="widget-title">',
			'after_title'	=> '</'. $heading .'>',
		) );

		// Search Results Sidebar
		if ( get_theme_mod( 'kaspweb_search_custom_sidebar', true ) ) {
			register_sidebar( array(
				'name'			=> esc_html__( 'Search Results Sidebar', 'kaspweb' ),
				'id'			=> 'search_sidebar',
				'description'	=> esc_html__( 'Widgets in this area are used in the search result page.', 'kaspweb' ),
				'before_widget'	=> '<aside id="%1$s" class="widget %2$s clr">',
				'after_widget'	=> '</aside>',
				'before_title'	=> '<'. $heading .' class="widget-title">',
				'after_title'	=> '</'. $heading .'>',
			) );
		}
        
        register_sidebar(
			array(
				'name'          => __( 'Hero Slider', 'kaspweb' ),
				'id'            => 'hero',
				'description'   => __( 'Hero slider area. Place two or more widgets here and they will slide!', 'kaspweb' ),
				'before_widget' => '<div class="carousel-item">',
				'after_widget'  => '</div>',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Hero Canvas', 'kaspweb' ),
				'id'            => 'herocanvas',
				'description'   => __( 'Full size canvas hero area for Bootstrap and other custom HTML markup', 'kaspweb' ),
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '',
				'after_title'   => '',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Top Full', 'kaspweb' ),
				'id'            => 'statichero',
				'description'   => __( 'Full top widget with dynamic grid', 'kaspweb' ),
				'before_widget' => '<div id="%1$s" class="static-hero-widget %2$s dynamic-classes">',
				'after_widget'  => '</div><!-- .static-hero-widget -->',
				'before_title'  => '<'. $heading .' class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Footer Full', 'kaspweb' ),
				'id'            => 'footerfull',
				'description'   => __( 'Full sized footer widget with dynamic grid', 'kaspweb' ),
				'before_widget' => '<div id="%1$s" class="footer-widget %2$s dynamic-classes">',
				'after_widget'  => '</div><!-- .footer-widget -->',
				'before_title'  => '<'. $heading .' class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		// Footer 1
		register_sidebar( array(
			'name'			=> esc_html__( 'Footer 1', 'kaspweb' ),
			'id'			=> 'footer-one',
			'description'	=> esc_html__( 'Widgets in this area are used in the first footer region.', 'kaspweb' ),
			'before_widget'	=> '<div id="%1$s" class="footer-widget %2$s clr">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<'. $heading .' class="widget-title">',
			'after_title'	=> '</'. $heading .'>',
		) );

		// Footer 2
		register_sidebar( array(
			'name'			=> esc_html__( 'Footer 2', 'kaspweb' ),
			'id'			=> 'footer-two',
			'description'	=> esc_html__( 'Widgets in this area are used in the second footer region.', 'kaspweb' ),
			'before_widget'	=> '<div id="%1$s" class="footer-widget %2$s clr">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<'. $heading .' class="widget-title">',
			'after_title'	=> '</'. $heading .'>',
		) );

		// Footer 3
		register_sidebar( array(
			'name'			=> esc_html__( 'Footer 3', 'kaspweb' ),
			'id'			=> 'footer-three',
			'description'	=> esc_html__( 'Widgets in this area are used in the third footer region.', 'kaspweb' ),
			'before_widget'	=> '<div id="%1$s" class="footer-widget %2$s clr">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<'. $heading .' class="widget-title">',
			'after_title'	=> '</'. $heading .'>',
		) );

		// Footer 4
		register_sidebar( array(
			'name'			=> esc_html__( 'Footer 4', 'kaspweb' ),
			'id'			=> 'footer-four',
			'description'	=> esc_html__( 'Widgets in this area are used in the fourth footer region.', 'kaspweb' ),
			'before_widget'	=> '<div id="%1$s" class="footer-widget %2$s clr">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<'. $heading .' class="widget-title">',
			'after_title'	=> '</'. $heading .'>',
		) );
	}
    
    /**
	 * Adds the meta tag to the site header
	 *
	 * @since 1.1.0
	 */
	public static function pingback_header() {

		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}
    
    /**
	 * Adds the meta tag to the site header
	 *
	 * @since 1.0.0
	 */
	public static function meta_tag_viewport() {

		// Meta viewport
		$viewport = '<meta name="viewport" content="width=device-width, initial-scale=1">';

		// Apply filters for child theme tweaking
		echo apply_filters( 'kaspweb_meta_viewport', $viewport );
	}
    
    /**
	 * Add headers for IE to override IE's Compatibility View Settings
	 *
	 * @since 1.0.0
	 */
	public static function x_ua_compatible_headers( $headers ) {
		$headers['X-UA-Compatible'] = 'IE=edge';
		return $headers;
	}

	/**
	 * Fix skip link focus in IE11.
	 *
	 * This does not enqueue the script because it is tiny and because it is only for IE11,
	 * thus it does not warrant having an entire dedicated blocking script being loaded.
	 *
	 * @link https://git.io/vWdr2
	 */
	public function skip_link_focus_fix() {
		// The following is minified via `terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
		?>
		<script type="text/javascript">
		/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
		</script>
		<?php
	}

	/**
     *
     * "Go to Top" floated button will be showed on the footer when user scrolling down.
     *
     */
    public static function go_to_top() {
        // The following is minified via `terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
        ?>
        <script type="text/javascript">
            jQuery( document ).ready(function( $ ) { 
                $( 'a.go-top' ).on( 'click' ,function(e) { e.preventDefault(); $( 'html, body' ).animate( { scrollTop: 0 }, 1000 ); });
                $( window ).scroll( function() { var windowTop =  $( window ).scrollTop(); if ( windowTop > 100 ) { $( 'a.go-top' ).fadeIn( 300 ); } else { $( 'a.go-top' ).fadeOut( 300 ); } });
            });
        </script>
    <?php
    }

     /**
	  * @snippet       Truncate Short Description
	  * @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
	  * @author        Rodolfo Melogli
	  */
    public static function truncate_read_more() { 
	?>
		<script type="text/javascript">

		    jQuery(document).ready(function($){

		        var show_char = 90; 
		        var ellipses = ""; // "..."
		        var content = $(".entry-content-truncated").html();

		        if (content.length > show_char) {
		            var a = content.substr(0, show_char);
		            var b = content.substr(show_char - content.length);
		            var html = a + '<span class="truncated">' + ellipses + b + '</span>';
		            $(".entry-content-truncated").html(html);
		        }

		        $(".read-more").click(function(e) {
		            e.preventDefault();
		            $(".entry-content-truncated .truncated").toggle();
		        });

		    }); 

		</script>
	<?php
	}

    
    /**
	 * Adds inline CSS for the admin
	 *
	 * @since 1.0.0
	 */
	public static function admin_inline_css() {
		echo '<style>div#setting-error-tgmpa{display:block;}</style>';
	}
    
}
new Kaspweb_Theme_Class;