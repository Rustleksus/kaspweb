<?php
/**
 * The default template for displaying the footer copyright
 *
 * @package Kaspweb WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get copyright text.
$copy = get_theme_mod( 'kaspweb_footer_copyright_text', 'Copyright - Kaspweb Theme by Rustleksus' );

// Visibility.
$visibility = get_theme_mod( 'kaspweb_bottom_footer_visibility', 'all-devices' );

// Inner classes.
$wrap_classes = array( 'clr' );

if ( 'all-devices' !== $visibility ) {
	$wrap_classes[] = $visibility;
}
$wrap_classes = implode( ' ', $wrap_classes ); ?>

<div id="footer-bottom" class="<?php echo esc_attr( $wrap_classes ); ?>">

	<?php do_action( 'kaspweb_before_footer_bottom_inner' ); ?>

	<div id="footer-bottom-inner" class="container clr">
            
            <?php
            // Display copyright info.
            if ( $copy ) :
                ?>

                <div id="copyright" class="text-center clr" role="contentinfo">
                    <?php echo wp_kses_post( do_shortcode( $copy ) ); ?>
                </div><!-- #copyright -->

                <?php
            endif;
            ?> 
            

	</div><!-- #footer-bottom-inner -->

	<?php do_action( 'kaspweb_after_footer_bottom_inner' ); ?>

</div><!-- #footer-bottom -->