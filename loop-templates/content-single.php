<?php
/**
 * Single post partial template
 *
 * @package kaspweb
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    
    <?php

        if ( ! is_search() ) {
            get_template_part( 'template-parts/featured-image' );
        }

        get_template_part( 'template-parts/entry-header' );

    ?>
    
	<div class="entry-content">

        <?php the_excerpt(); ?>

        <?php
        wp_link_pages(
            array(
                'before' => '<div class="page-links">' . __( 'Pages:', 'kaspweb' ),
                'after'  => '</div>',
            )
        );
        ?>

    </div><!-- .entry-content -->

</article><!-- #post-## -->