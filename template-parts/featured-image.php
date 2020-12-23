<?php
/**
 * Displays the featured image
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since 1.0.0
 */

if ( has_post_thumbnail() && ! post_password_required() ) {

	$featured_media_inner_classes = '';
    
    // Image args
    $img_args = array(
        'alt' => get_the_title(),
    );
    
    if ( kaspwebwp_get_schema_markup( 'image' ) ) {
        $img_args['itemprop'] = 'image';
    }

	// Make the featured media thinner on archive pages.
	if ( ! is_singular() ) {
		$featured_media_inner_classes .= ' medium';
	}
	?>

	<figure class="featured-media">

		<div class="featured-media-inner section-inner<?php echo $featured_media_inner_classes; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?>">

    
            <a href="<?php the_permalink(); ?>" class="thumbnail-link">
			
                <?php the_post_thumbnail(); ?>
                
            </a>
            
            <?php

			$caption = get_the_post_thumbnail_caption();

			if ( $caption ) {
				?>

				<figcaption class="wp-caption-text"><?php echo esc_html( $caption ); ?></figcaption>

				<?php
			}
			?>

		</div><!-- .featured-media-inner -->

	</figure><!-- .featured-media -->

	<?php
}
