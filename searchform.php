<?php
/**
 * The template for displaying search forms
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/*
 * Generate a unique ID for each form and a string containing an aria-label if
 * one was passed to get_search_form() in the args array.
 */
$unique_id = kaspweb_unique_id( 'search-form-' );

$aria_label = ! empty( $args['label'] ) ? 'aria-label="' . esc_attr( $args['label'] ) . '"' : '';
?>

<form method="get" <?php echo $aria_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above.?> action="<?php echo esc_url( home_url( '/' ) ); ?>" class="form-inline search-form" role="search">

    <div class="input-group w-100">	
        <label class="sr-only" for="<?php echo esc_attr( $unique_id ); ?>">
            <span class="screen-reader-text"><?php _e( 'Search for:', 'kaspweb' ); // phpcs:ignore:  WordPress.Security.EscapeOutput.UnsafePrintingFunction -- core trusts translations ?></span>	
        </label>
        <input class="form-control search-field ml-3" id="<?php echo esc_attr( $unique_id ); ?>" name="s" type="text" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'kaspweb' ); ?>" value="<?php the_search_query(); ?>">
        <div class="input-group-append">
        <input class="btn btn-success submit search-submit" id="searchsubmit" name="submit" type="submit"
    value="<?php esc_attr_e( 'Search', 'submit button', 'kaspweb' ); ?>">
        </div>
    </div>
    

</form>
