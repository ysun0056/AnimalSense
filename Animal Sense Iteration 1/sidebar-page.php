<?php
/**
 * The sidebar containing the main widget area for pages
 *
 * @package Azuma
 */

if ( ! is_active_sidebar( 'azuma-sidebar-page' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'azuma-sidebar-page' ); ?>
</div><!-- #secondary -->
