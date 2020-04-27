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

	if ( get_theme_mod( 'page_title_style' ) == 2 ) {
		$masthead_class = ' not-full';
	} else {
		$masthead_class = ' full';
	}
?>
<div id="page"<?php echo $page_class; ?>>

	<header id="masthead" class="site-header<?php echo $masthead_class; ?>">

		<?php if ( is_active_sidebar( 'azuma-top-bar' ) ) : ?>
		<div id="top-bar">
			<div class="container">
				<?php dynamic_sidebar( 'azuma-top-bar' ); ?>
			</div>
		</div>
		<?php endif; ?>

		<div class="container">
		<?php azuma_header_content(); ?>
		<?php azuma_header_menu(); ?>
		<?php azuma_header_content_extra(); ?>
		</div>

		<?php if ( is_active_sidebar( 'azuma-offers-bar' ) ) : ?>
		<div id="site-usp" class="clearfix">
			<div class="container">
				<?php dynamic_sidebar( 'azuma-offers-bar' ); ?>
			</div>
		</div>
		<?php endif; ?>

	</header><!-- #masthead -->

<?php if ( is_front_page() && 'page' == get_option( 'show_on_front' ) && is_active_sidebar( 'azuma-homepage-large-area' ) ) { ?>
	<div id="hero-above-wrapper"></div>
	<div id="home-hero-section" class="clearfix">
		<?php dynamic_sidebar( 'azuma-homepage-large-area' ); ?>
	</div>
<?php } else {
	azuma_header_title();
	}?>

	<div id="content" class="site-content clearfix">
		<div class="container clearfix">
