<?php
/**
 * The template for displaying search results pages
 *
 * @package Azuma
 */

get_header();

$azuma_post_type = get_query_var( 'post_type' );

if ( $azuma_post_type == 'download' ) {
	$grid_theme_mod = 'grid_layout_edd';
	$dl_grid_class = 'edd_downloads_list ';
} else {
	$grid_theme_mod = 'grid_layout';
	$dl_grid_class = '';
}

if ( ! is_active_sidebar( 'azuma-sidebar' ) ) {
	$page_full_width = ' full-width';
} else {
	$page_full_width = '';
}

$grid_layout = get_theme_mod( $grid_theme_mod, '4' );
$grid_loop_layout = ' class="'. $dl_grid_class .'layout-'. esc_attr( $grid_layout ) .'"';
$grid_loop_main = ' infinite-grid layout-'. esc_attr( $grid_layout );
?>

	<div id="primary" class="content-area<?php echo $page_full_width;?>">
		<main id="main" class="site-main<?php echo $grid_loop_main;?>" role="main">

		<?php if ( have_posts() ) : ?>

			<?php if ( get_theme_mod( 'page_title_style' ) == 2 ) { ?>
			<header class="page-header">
				<h1 class="page-title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'azuma' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header><!-- .page-header -->
			<?php } ?>

			<div id="grid-loop"<?php echo $grid_loop_layout;?>>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
					if ( $azuma_post_type == 'download' ) {
						get_template_part( 'content', 'archive-download' );
					} else {
						get_template_part( 'content', 'search' );
					}
					?>

				<?php endwhile; ?>

			</div><!-- #grid-loop -->
		
			<?php the_posts_pagination( array(
						'prev_text' => '<i class="fa fa-chevron-left"></i>',
						'next_text' => '<i class="fa fa-chevron-right"></i>',
					) ); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
if ( $azuma_post_type == 'download' ) {
	get_sidebar( 'edd' );
} else {
	get_sidebar();
}
?>

<?php get_footer(); ?>
