<?php
/**
 * The template for displaying all single posts
 *
 * @package Azuma
 */

get_header();

if ( ! is_active_sidebar( 'azuma-sidebar' ) ) {
	$page_full_width = ' full-width';
} else {
	$page_full_width = '';
}
?>

	<div id="primary" class="content-area<?php echo $page_full_width;?>">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'single' ); ?>

				<?php
					the_post_navigation( array(
						'prev_text' => '<span class="nav-title"><i class="fa fa-chevron-left"></i>%title</span>',
						'next_text' => '<span class="nav-title">%title<i class="fa fa-chevron-right"></i></span>',
					) );

					get_template_part( 'content', 'related' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
