<?php
/**
 * The sidebar containing the main widget area for pages (EDD)
 *
 * @package Azuma
 */

if ( ! is_active_sidebar( 'azuma-sidebar-edd' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'azuma-sidebar-edd' ); ?>
</div><!-- #secondary -->
