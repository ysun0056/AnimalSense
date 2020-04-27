<?php
/**
 * The theme header.
 *
 * @package Azuma
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php endif; ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'azuma' ); ?></a>
<?php
	if ( get_theme_mod( 'sticky_footer' ) ) {
		$page_class = ' class="sticky-footer"';
	} else {
		$page_class = '';
	}
?>
<div id="page"<?php echo $page_class; ?>>

	<header id="masthead" class="site-header not-full">

		<div class="container">
		<?php azuma_header_content(); ?>
		<?php azuma_header_menu(); ?>
		<?php azuma_header_content_extra(); ?>
		</div>

	</header><!-- #masthead -->

	<div id="content" class="site-content clearfix">
		<div class="container clearfix">
