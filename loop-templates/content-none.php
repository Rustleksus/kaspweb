<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package kaspweb
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<section class="no-results not-found">

	<header class="page-header">

		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'kaspweb' ); ?></h1>

	</header><!-- .page-header -->

	<div class="page-content">

		<?php
		// Если это is_home (домашняя страница) и  если владельцем поста является Автор
		if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

		<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'kaspweb' ), array( 
			'a' => array(
				   'href' => array(),
				   'target' => '_blank',
		    ),
        ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

		<p class="text-center mt-4"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'kaspweb' ); ?></p>
		<?php ?>
				<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
                    <label class="sr-only" for="s"><?php esc_html_e( 'Search', 'kaspweb' ); ?></label>
                    <div class="input-group mb-3">
                        <input class="form-control" id="s" name="s" type="text"
                            placeholder="<?php esc_attr_e( 'Search &hellip;', 'kaspweb' ); ?>" value="<?php the_search_query(); ?>" aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <input class="submit btn btn-outline-success" id="searchsubmit" name="submit" type="submit" value="<?php esc_attr_e( 'Search', 'kaspweb' ); ?>">
                        </div>
                    </div>
                </form>
        <?php else : ?>

		<p class="text-center mt-4"><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'kaspweb' ); ?></p>
		<?php ?>
				<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
                    <label class="sr-only" for="s"><?php esc_html_e( 'Search', 'kaspweb' ); ?></label>
                    <div class="input-group mb-3">
                        <input class="form-control" id="s" name="s" type="text"
                            placeholder="<?php esc_attr_e( 'Search &hellip;', 'kaspweb' ); ?>" value="<?php the_search_query(); ?>" aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <input class="submit btn btn-outline-success" id="searchsubmit" name="submit" type="submit" value="<?php esc_attr_e( 'Search', 'kaspweb' ); ?>">
                        </div>
                    </div>
                </form>
		<?php endif; ?>
	</div><!-- .page-content -->

</section><!-- .no-results -->
