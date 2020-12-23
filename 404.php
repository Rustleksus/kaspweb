<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Kaspweb
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

 get_header(); 

$container = get_theme_mod( 'kaspweb_container_type' );

?>

 <?php if ( 'container' === $container ) : ?>
	<div class="container">
 <?php endif; ?> 
 
     <div class="row">
         
	    <h1 class="mx-auto p-4"><?php esc_html_e('404','kaspweb'); ?> <span><?php esc_html_e('Page not found!','kaspweb'); ?></span></h1>


        <div class="pad group">

            <div class="notebox">
                <?php get_search_form(); ?>
            </div>

            <div class="entry">
                <p class="text-center"><?php esc_html_e( 'The page you are trying to reach does not exist, or has been moved. Please use the menus or the search box to find what you are looking for.', 'kaspweb' ); ?></p>
            </div>

        </div><!--/.pad-->
         
    </div>
	

<?php if ( 'container' === $container ) : ?>
    </div><!-- .container -->
<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>