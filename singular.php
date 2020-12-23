<?php
/**
 * The template for displaying all single posts
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

get_template_part( 'partials/page-header-blog' ); 
   
$container = get_theme_mod( 'kaspweb_container_type' );
?>

<div class="wrapper" id="single-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

            
				<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'loop-templates/content', 'single' ); 
                    
                    
					if ( is_single() ) {

                        get_template_part( 'template-parts/navigation' );

                    }
                    
                    // Get elements
                    $elements = kaspweb_blog_single_elements_positioning();

                    // Loop through elements
                    foreach ( $elements as $element ) {

                        // Related Posts
                        if ( 'related_posts' == $element ) {

                            get_template_part( 'partials/single/related-posts' );

                        }

                    }
                    
                    if ( ( get_theme_mod( 'author-bio', 'on' ) == 'on' ) && get_the_author_meta( 'description' ) ): ?>
                        <div class="author-bio">
                            <div class="bio-avatar"><?php echo get_avatar(get_the_author_meta('user_email'),'128'); ?></div>
                            <p class="bio-name"><?php the_author_meta('display_name'); ?></p>
                            <p class="bio-desc"><?php the_author_meta('description'); ?></p>
                            <div class="clear"></div>
                        </div>
                    <?php endif; 

                    /**
                     *  Output comments wrapper if it's a post, or if comments are open,
                     * or if there's a comment number – and check for password.
                     * */
                    if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
                        ?>

                        <div class="comments-wrapper section-inner">

                            <?php comments_template(); ?>

                        </div><!-- .comments-wrapper -->

                        <?php
                    }
				}
				?>

			</main><!-- #main -->

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #single-wrapper -->

<?php
get_footer();