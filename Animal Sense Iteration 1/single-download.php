<?php
/**
 * The template for displaying single download (EDD)
 *
 * @package Azuma
 */

get_header();

if ( get_theme_mod( 'edd_single_sidebar' ) && is_active_sidebar( 'azuma-sidebar-edd' ) ) {
	$page_full_width = '';
} else {
	$page_full_width = ' full-width';
}
?>

	<div id="primary" class="content-area<?php echo $page_full_width;?>">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php if ( get_theme_mod( 'edd_single_sidebar' ) ) {
get_sidebar( 'edd' );
} ?>

<?php get_footer(); ?>
