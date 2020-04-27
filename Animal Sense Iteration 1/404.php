<?php
/**
 * The template for displaying 404 page
 *
 * @package Azuma
 */

get_header();
?>

	<p><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'azuma' ); ?></p>

	<p><?php esc_html_e( 'Maybe try a search?', 'azuma' ); ?> <?php echo get_search_form(); ?></p>

	<p><?php esc_html_e( 'Browse our pages.', 'azuma' ); ?></p>
	<ul>
	<?php wp_list_pages( array( 'title_li' => '' ) ); ?>
	</ul>		

<?php get_footer(); ?>
