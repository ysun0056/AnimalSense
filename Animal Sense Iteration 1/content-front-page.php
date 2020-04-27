<?php
/**
 * Template part for displaying page content in page.php
 *
 * @package Azuma
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php azuma_post_thumbnail(); ?>

	<div class="entry-content single-entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'azuma' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Edit %s', 'azuma' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				),
				'<span class="edit-link"><span class="azuma-icon-edit-2"></span>',
				'</span>'
			);
		?>
	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
