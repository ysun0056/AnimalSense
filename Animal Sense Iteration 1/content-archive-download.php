<?php
/**
 * download archive template (EDD)
 *
 * @package Azuma
 */
?>

<?php $schema = edd_add_schema_microdata() ? 'itemscope itemtype="http://schema.org/Product" ' : ''; ?>

<div <?php echo $schema; ?>class="<?php echo esc_attr( apply_filters( 'edd_download_class', 'edd_download', get_the_ID() ) ); ?>" id="edd_download_<?php the_ID(); ?>">

	<div class="<?php echo esc_attr( apply_filters( 'edd_download_inner_class', 'edd_download_inner', get_the_ID() ) ); ?>">

		<?php
			do_action( 'edd_download_before' );

			edd_get_template_part( 'shortcode', 'content-image' );
			do_action( 'edd_download_after_thumbnail' );

			edd_get_template_part( 'shortcode', 'content-title' );

			do_action( 'edd_download_after_title' );

			edd_get_template_part( 'shortcode', 'content-excerpt' );
			do_action( 'edd_download_after_content' );

			edd_get_template_part( 'shortcode', 'content-price' );

			if ( edd_has_variable_prices( get_the_ID() ) ) {
				echo '<div class="price-range">';
					echo edd_price_range( get_the_ID() );
				echo '</div>';
				do_action( 'edd_download_after_price' );
				echo '<div class="edd_download_buy_button variable-prices">';
					echo '<a href="' . get_the_permalink() . '" class="button ' . edd_get_option( 'checkout_color', 'blue' ) . ' edd-submit">' . esc_html__( 'Select Options', 'azuma' ) . '</a>';
			} else {
				do_action( 'edd_download_after_price' );
				echo '<div class="edd_download_buy_button">';
					echo edd_get_purchase_link( array( 'download_id' => get_the_ID(), 'price' => '0' ) );
			}
				echo '</div>';

			do_action( 'edd_download_after' );
		?>

	</div>

</div>
