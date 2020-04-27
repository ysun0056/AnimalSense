<?php
/**
 * Template Name: Landing Page
 *
 * An empty page template with no masthead, page title, sidebars, comments or footer.
 *
 * @package Azuma
 */

get_header( 'landing-page' );

?>
	<div id="primary" class="content-area full-width">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer( 'landing-page' ); ?>
