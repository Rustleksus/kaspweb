<?php
/**
 * The Header for our theme.
 *
 * @package Kaspweb WordPress theme
 */ ?>

<!DOCTYPE html>
<html class="<?php echo esc_attr( kaspwebwp_html_classes() ); ?>" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
    <title><?php the_title(); ?> - разработка и сопровождение сайтов</title>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                                 m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(56000713, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/56000713" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<?php wp_head(); ?>
</head>

<body <?php kaspwebwp_schema_markup( 'html' ); ?>> 
   
    <?php do_action( 'wp_body_open' ); ?>

        <div id="outer-wrap" class="site clr">

            <div id="wrap" class="clr">
                
                <?php do_action( 'kaspweb_top_bar' ); ?>

                <?php do_action( 'kaspweb_header' ); ?>

                    <main id="main" class="site-main clr">
			             
                         <div class="top-section">
                            <?php kaspweb_featured_post_slider(); ?>
                        </div>