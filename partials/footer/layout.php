<?php
/**
 * Footer layout
 *
 * @package Kaspweb WordPress theme
 */

    // Exit if accessed directly.
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    } 

?>


<footer id="site-footer" class="header-footer-group" <?php kaspwebwp_schema_markup( 'footer' ); ?> role="contentinfo">

	<?php do_action( 'kaspweb_before_footer_inner' ); ?>

	<div id="footer-inner" class="clr">
	
				        
                <?php
                    // Display the footer  if enabled.
                    if ( kaspwebwp_display_footer_bottom() ) {
                        get_template_part( 'partials/footer/widgets' );
                    }
                ?>
               
                <?php
                    // Display the footer bottom if enabled.
                    if ( kaspwebwp_display_footer_bottom() ) {
                        get_template_part( 'partials/footer/copyright' );
                    }
                ?>
            

	</div><!-- #footer-inner -->

	<?php do_action( 'kaspweb_after_footer_inner' ); ?>

</footer><!-- #footer -->