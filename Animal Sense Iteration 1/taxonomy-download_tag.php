<?php
/**
 * The template for displaying downloads tags archive pages (EDD)
 *
 * @package Azuma
 */

get_header();

if ( ! is_active_sidebar( 'azuma-sidebar-edd' ) ) {
	$page_full_width = ' full-width';
} else {
	$page_full_width = '';
}

$grid_layout = get_theme_mod( 'grid_layout_edd', '4' );
$grid_loop_layout = ' class="edd_downloads_list layout-'. esc_attr( $grid_layout ) .'"';
$grid_loop_main = ' infinite-grid layout-'. esc_attr( $grid_layout );
?>

	<div id="primary" class="content-area<?php echo $page_full_width;?>">
		<main id="main" class="site-main<?php echo $grid_loop_main;?>" role="main">

		<?php if ( have_posts() ) : ?>

			<?php if ( get_theme_mod( 'page_title_style' ) == 2 ) { ?>
			<header class="archive-header">
				<?php
				the_archive_title( '<h1 class="archive-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .archive-header -->
			<?php } ?>

			<ul class="archive-sub-cats downloads tags">
				<?php wp_list_categories( array(
					'child_of' => get_queried_object_id(),
					'taxonomy' => 'download_tag',
					'depth' => 1,
					'orderby' => 'name',
					'title_li' => '',
					'show_option_none' => ''
				) ); ?>
			</ul>

			<div id="grid-loop"<?php echo $grid_loop_layout;?>>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'archive-download' ); ?>

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

<?php get_sidebar( 'edd' ); ?>

<?php get_footer(); ?>
