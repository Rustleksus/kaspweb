<?php
/**
 * Main Header Layout
 *
 * @package Kaspweb WordPress theme
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$container = get_theme_mod( 'kaspweb_container_type' );

?>

<!-- ******************* The Navbar Area ******************* -->
<div id="wrapper-navbar">

		<a class="skip-link sr-only sr-only-focusable" href="#content"><?php esc_html_e( 'Skip to content', 'kaspweb' ); ?></a>

		<nav id="main-nav" class="navbar navbar-light navbar-expand-lg vesco-top-nav" aria-labelledby="main-nav-label">

			<h2 id="main-nav-label" class="sr-only">
				<?php esc_html_e( 'Main Navigation', 'kaspweb' ); ?>
			</h2>

            <?php if ( 'container' === $container ) : ?>
                <div class="container">
            <?php endif; ?>
            	<button class="navbar-toggler navbar-toggler-right text-dark pl-0 pl-sm-3" data-toggle="offcanvas" data-target="#navbarResponsive" type="button" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <div class="menu-btn">
                        <div class="line line--1"></div>
                        <div class="line line--2"></div>
                        <div class="line line--3"></div>
                    </div>
                </button> 

					<!-- Your site title as branding in the menu -->
					<?php if ( ! has_custom_logo() ) { ?>

						<?php if ( is_front_page() && is_home() ) : ?>

							<h1 class="navbar-brand mb-0"><a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>

						<?php else : ?>

							<a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a>

						<?php endif; ?>

						<?php
					} else {
						the_custom_logo();
					}
					?>
					<!-- end custom logo -->
				<div class="navbar-collapse offcanvas-collapse" id="navbarResponsive">
					<div class="d-flex pt-2 pb-1">
						<a class="navbar-brand js-scroll-trigger w-100 text-left pl-0 d-block d-lg-none text-white" href="">Kaspweb</a>
						<button class="navbar-toggler text-white btn-close menu-btn flex-shrink-1" data-toggle="offcanvas" data-target="#navbarResponsive" type="button" aria-controls="navbarResponsive" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'kaspweb' ); ?>">
                           <div class="gg-close">
                            </div>
                        </button> 
                    </div>
                    <ul class="nav navbar-nav mr-auto">
                        <!-- The WordPress Menu goes here -->
                        <?php wp_nav_menu(
                            array(
                                'theme_location'  => 'main_menu',
                                'container_class' => 'collapse navbar-collapse d-block',
                                'container_id'    => 'navbarNavDropdown',
                                'menu_class'      => 'navbar-nav ml-auto',
                                'fallback_cb'     => '',
                                'menu_id'         => 'main-menu',
                                'depth'           => 2,
                                'walker'          => new Kaspweb_WP_Bootstrap_Navwalker(),
                            )
                        ); ?>
                    </ul>

					<ul class="nav navbar-nav ml-auto navbar-text d-flex pt-0 pt-md-2">
                        <li class="nav-item" role="presentation"><a class="nav-link js-scroll-trigger pr-2" href="mailto:contact@kaspweb.ru">contact@kaspweb.ru</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link js-scroll-trigger" href="">8-800-800-08-80</a></li>
	                        
	                        <?php

								// Check whether the header search is activated in the customizer.
								$enable_header_search = get_theme_mod( 'enable_header_search', true );

								if ( true === $enable_header_search ) {

									?>

									<button class="toggle search-toggle mobile-search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
										<span class="toggle-inner">
											<span class="toggle-icon">
												<?php kaspweb_the_theme_svg( 'search' ); ?>
											</span> 
										</span>
									</button><!-- .search-toggle -->

							<?php } ?>

						<div class="dd d-none d-lg-block"> 
                            <a class="drop" title="">
	                            <i class="icon-options-vertical float-right ml-2" style="cursor:pointer; font-size: 22px">
	                             	<?php kaspweb_the_theme_svg( 'vertical-menu' ); ?>
	                         	</i>
                            </a>
                                <div class="dd-menu p-2 pt-4">
	                                <span class="ml-3 mb-1 dd-menu-heading">Клиентам</span>
		                                <?php wp_nav_menu(
		                                    array(
		                                        'theme_location'  => 'main_menu',
		                                        'container_class' => 'collapse navbar-collapse',
		                                        'container_id'    => 'navbarNavDropdown',
		                                        'menu_class'      => 'navbar-nav ml-auto d-block',
		                                        'fallback_cb'     => '',
		                                        'menu_id'         => 'main-menu',
		                                        'depth'           => 2,
		                                        'walker'          => new Kaspweb_WP_Bootstrap_Navwalker(),
		                                    )
		                                ); ?>
                                </div>
                                 <script type="text/javascript">
                                    $('html').click(function() {
                                      $('.dd-menu').removeClass("active");
                                    });
                                    $('.dd-menu ul li').each(function() {
                                        var delay = $(this).index() * 50 + 'ms';
                                        $(this).css({
                                            '-webkit-transition-delay': delay,
                                            '-moz-transition-delay': delay,
                                            '-o-transition-delay': delay,
                                            'transition-delay': delay
                                        });                  
                                    });
                                    $(".drop").click (function(e){
                                      e.stopPropagation();
                                      $('.dd-menu').toggleClass("active");
                                    });
                                     $('.dd-menu').click (function(e){
                                      e.stopPropagation();
                                    });
                                </script>
                        </div>

					</ul>
		       
            <?php if ( 'container' === $container ) : ?>
                </div><!-- .container -->
            <?php endif; ?>

		</nav><!-- .site-navigation -->
		
		<?php
		// Output the search modal (if it is activated in the customizer).
			if ( true === $enable_header_search ) {
				get_template_part( 'template-parts/modal-search' );
			}
        ?>

</div><!-- #wrapper-navbar end -->
	
<?php