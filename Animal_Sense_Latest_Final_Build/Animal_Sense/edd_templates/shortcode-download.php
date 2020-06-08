<?php
/**
 * A single download inside of the [downloads] shortcode.
 *
 * @package Azuma
 */

global $edd_download_shortcode_item_atts, $edd_download_shortcode_item_i;
?>

<?php $schema = edd_add_schema_microdata() ? 'itemscope itemtype="http://schema.org/Product" ' : ''; ?>

<div <?php echo $schema; ?>class="<?php echo esc_attr( apply_filters( 'edd_download_class', 'edd_download', get_the_ID(), $edd_download_shortcode_item_atts, $edd_download_shortcode_item_i ) ); ?>" id="edd_download_<?php the_ID(); ?>">

	<div class="<?php echo esc_attr( apply_filters( 'edd_download_inner_class', 'edd_download_inner', get_the_ID(), $edd_download_shortcode_item_atts, $edd_download_shortcode_item_i ) ); ?>">

		<?php
			do_action( 'edd_download_before' );

			if ( 'false' !== $edd_download_shortcode_item_atts['thumbnails'] ) :
				edd_get_template_part( 'shortcode', 'content-image' );
				do_action( 'edd_download_after_thumbnail' );
			endif;

			edd_get_template_part( 'shortcode', 'content-title' );

			do_action( 'edd_download_after_title' );

			if ( 'yes' === $edd_download_shortcode_item_atts['excerpt'] && 'yes' !== $edd_download_shortcode_item_atts['full_content'] ) :
				edd_get_template_part( 'shortcode', 'content-excerpt' );
				do_action( 'edd_download_after_content' );
			elseif ( 'yes' === $edd_download_shortcode_item_atts['full_content'] ) :
				edd_get_template_part( 'shortcode', 'content-full' );
				do_action( 'edd_download_after_content' );
			endif;

			if ( 'yes' === $edd_download_shortcode_item_atts['price'] ) :
				edd_get_template_part( 'shortcode', 'content-price' );
				if ( edd_has_variable_prices( get_the_ID() ) ) {
					echo '<div class="price-range">';
						echo edd_price_range( get_the_ID() );
					echo '</div>';
				}
				do_action( 'edd_download_after_price' );
			endif;

			if ( 'yes' === $edd_download_shortcode_item_atts['buy_button'] ) :
				if ( edd_has_variable_prices( get_the_ID() ) ) {
					echo '<div class="edd_download_buy_button variable-prices">';
						echo '<a href="' . get_the_permalink() . '" class="button ' . edd_get_option( 'checkout_color', 'blue' ) . ' edd-submit">' . esc_html__( 'Select Options', 'azuma' ) . '</a>';
				} else {
					echo '<div class="edd_download_buy_button">';
						echo edd_get_purchase_link( array( 'download_id' => get_the_ID(), 'price' => '0' ) );
				}
			echo '</div>';
			endif;

			do_action( 'edd_download_after' );
		?>

	</div>

</div>
