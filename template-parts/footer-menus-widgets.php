<?php
/**
 * Displays the menus and widgets at the end of the main element.
 * Visually, this output is presented as part of the footer element.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since 1.0.0
 */

$has_footer_menu = has_nav_menu( 'footer' );
$has_social_menu = has_nav_menu( 'social' );

$has_sidebar_1 = is_active_sidebar( 'sidebar-1' );
$has_sidebar_2 = is_active_sidebar( 'sidebar-2' );
$has_sidebar_3 = is_active_sidebar( 'sidebar-3' );// LS
$has_sidebar_4 = is_active_sidebar( 'sidebar-4' );// LS

// Only output the container if there are elements to display.
if ( $has_footer_menu || $has_social_menu || $has_sidebar_1 || $has_sidebar_2 || $has_sidebar_3 || $has_sidebar_4 ) {
	?>

	<footer class="footer-nav-widgets-wrapper header-footer-group">

		<div class="footer-inner section-inner">

			<?php

			$footer_top_classes = '';

			$footer_top_classes .= $has_footer_menu ? ' has-footer-menu' : '';
			$footer_top_classes .= $has_social_menu ? ' has-social-menu' : '';

			if ( $has_footer_menu || $has_social_menu ) {
				?>
				<div class="footer-top<?php echo $footer_top_classes; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?>">
					<?php if ( $has_footer_menu ) { ?>

						<nav aria-label="<?php esc_attr_e( 'Footer', 'twentytwenty' ); ?>" role="navigation" class="footer-menu-wrapper">

							<ul class="footer-menu reset-list-style">
								<?php
								wp_nav_menu(
									array(
										'container'      => '', 
										'depth'          => 1,
										'items_wrap'     => '%3$s',
										'theme_location' => 'footer',
									)
								);
								?>
							</ul>

						</nav><!-- .site-nav -->

					<?php } ?>
					<?php if ( $has_social_menu ) { ?>

						<nav aria-label="<?php esc_attr_e( 'Social links', 'twentytwenty' ); ?>" class="footer-social-wrapper">

							<ul class="social-menu footer-social reset-list-style social-icons fill-children-current-color">

								<?php
								wp_nav_menu(
									array(
										'theme_location'  => 'social',
										'container'       => '',
										'container_class' => '',
										'items_wrap'      => '%3$s',
										'menu_id'         => '',
										'menu_class'      => '',
										'depth'           => 1,
										'link_before'     => '<span class="screen-reader-text">',
										'link_after'      => '</span>',
										'fallback_cb'     => '',
									)
								);
								?>

							</ul><!-- .footer-social -->

						</nav><!-- .footer-social-wrapper -->

					<?php } ?>
				</div><!-- .footer-top -->

			<?php } ?>

			<?php if ( $has_sidebar_1 || $has_sidebar_2 || $has_sidebar_3 || $has_sidebar_4 ) { ?>

				<aside class="footer-widgets-outer-wrapper" role="complementary">

					<div class="container"> 
                        
                        <div class="row">
                            
                            <?php if ( $has_sidebar_1 ) { ?>

                                <div class="col-12 col-sm-6 col-md-3 mb-3">
                                    <?php dynamic_sidebar( 'sidebar-1' ); ?>
                                </div>

                            <?php } ?>

                            <?php if ( $has_sidebar_2 ) { ?>

                                <div class="col-12 col-sm-6 col-md-3 mb-3">
                                    <?php dynamic_sidebar( 'sidebar-2' ); ?>
                                </div>

                            <?php } ?>

                            <?php if ( $has_sidebar_3 ) { ?>

                                <div class="col-12 col-sm-6 col-md-3 mb-3">
                                    <?php dynamic_sidebar( 'sidebar-3' ); ?>
                                </div>

                            <?php } ?>

                            <?php if ( $has_sidebar_4 ) { ?>

                                <div class="col-12 col-sm-6 col-md-3 mb-3">
                                    <?php dynamic_sidebar( 'sidebar-4' ); ?>
                                </div>

                            <?php } ?>
                            
                        </div>


					</div><!-- .footer-widgets-wrapper -->
					
					<div class="container mr-0 pl-0"> <!-- .footer-widgets-wrapper-social-login -->
                        <div class="row">
                            <div class="col-12 p-0">
                                <ul class="social-buttons" id="demo3">
                                    <li>
                                        <a href="#" class="brandico-twitter-bird"><i class="icon-social-twitter icons"></i></a>
                                    </li>
                                    <li>
                                        <a href="#" class="brandico-facebook"><i class="icon-social-facebook icons"></i></a>
                                    </li>
                                    <li>
                                        <a href="#" class="brandico-instagram"><i class="icon-social-instagram icons"></i></a>
                                    </li>
                                    <li>
                                        <a href="#" class="brandico-linkedin"><i class="icon-social-linkedin icons"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

				</aside><!-- .footer-widgets-outer-wrapper -->

			<?php } ?>

		</div><!-- .footer-inner -->

	</footer><!-- .footer-nav-widgets-wrapper -->

<?php } ?>
