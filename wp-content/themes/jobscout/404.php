<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package JobScout
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Uh - oh...', 'jobscout' ); ?></h1>
				</header><!-- .page-header -->
				<div class="page-content">
					<p class="error-text"><?php esc_html_e( 'The page you are looking for may have been moved, deleted, or possibly never existed.', 'jobscout' ); ?></p>
					<div class="error-num"><?php esc_html_e( '404','jobscout' ); ?></div>
					<a class="btn-readmore" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Take me to the home page', 'jobscout' ); ?></a>
					<?php get_search_form(); ?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
