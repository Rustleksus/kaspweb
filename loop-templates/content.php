<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package understrap
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

	<div class="entry-content entry-content-truncated">

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
