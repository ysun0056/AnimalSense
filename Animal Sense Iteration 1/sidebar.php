<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Azuma
 */

if ( ! is_active_sidebar( 'azuma-sidebar' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'azuma-sidebar' ); ?>
</div><!-- #secondary -->
