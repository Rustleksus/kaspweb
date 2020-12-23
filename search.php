<?php
/**
 * The template for displaying search results pages
 *
 * @package kaspweb
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'kaspweb_container_type' );

?>

<div class="wrapper" id="search-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check and opens the primary div -->
			<?php get_template_part( 'global-sidebar/left-sidebar-template' ); ?>

			<main class="site-main" id="main">

				<!-- Есть и у текущего запроса к WP результаты для вывода, т.е. есть ли в наличии посты, которые можно вывести для текущей страницы --> 
				<?php if ( have_posts() ) : ?>

					<header class="page-header">

							<h1 class="page-title">
								<?php
								printf(
									/* translators: %s: query term */
									esc_html__( 'Search Results for: %s', 'kaspweb' ),
									/* get_search_query() - Получает поисковой запрос (строку) */
									'<span>' . get_search_query() . '</span>'   
								);
								?>
							</h1>

					</header><!-- .page-header -->

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>  <!-- Есть ли у текущего запроса к WP результаты для вывода, выводим все посты -->

						<?php
						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'global-templates/content', 'search' );
						?>

					<?php endwhile; ?>

				<?php else : ?>

					<?php get_template_part( 'global-templates/content', 'none' ); ?>

				<?php endif; ?>

			</main><!-- #main -->

			<!-- The pagination component -->
			<?php understrap_pagination(); ?>

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-sidebar/right-sidebar-template' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #search-wrapper -->

<?php get_footer();
