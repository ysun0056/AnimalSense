<?php
/**
 * Template part for displaying page content in page.php
 *
 * @package Azuma
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php
if ( get_theme_mod( 'page_title_style' ) == 2 ) {

	if ( has_post_thumbnail() ) {
	$thumbnail_on = true; ?>
	<header class="entry-header with-image" style="background-image: url('<?php echo get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>')">
		<div class="title-meta-wrapper">
			<div class="container">
<?php } else {
	$thumbnail_on = false; ?>
	<header class="entry-header">
		<?php }
		the_title( '<h1 class="entry-title">', '</h1>' );
		?>
	<?php if ( $thumbnail_on ) { ?>
			</div>
		</div>
	<?php } ?>
	</header><!-- .entry-header -->

<?php
} ?>

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
