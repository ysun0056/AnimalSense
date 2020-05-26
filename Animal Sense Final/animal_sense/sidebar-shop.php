<?php
/**
 * The sidebar containing the main widget area for WooCommerce archives
 *
 * @package Azuma
 */

if ( ! is_active_sidebar( 'azuma-sidebar-shop' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'azuma-sidebar-shop' ); ?>
</div><!-- #secondary -->
