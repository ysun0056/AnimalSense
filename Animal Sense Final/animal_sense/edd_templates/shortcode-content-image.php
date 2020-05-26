<?php if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail( get_the_ID() ) ) : ?>
	<div class="edd_download_image">
		<a href="<?php the_permalink(); ?>">
			<?php echo get_the_post_thumbnail( get_the_ID(), get_theme_mod( 'edd_archive_img_size', 'medium' ) ); ?>
		</a>
	</div>
<?php else : 
	$placeholder_img = get_theme_mod( 'edd_placeholder', get_template_directory_uri() . '/images/edd-placeholder.png' );
	if ( $placeholder_img ) { ?>
		<div class="edd_download_image">
			<a href="<?php the_permalink(); ?>">
				<img src="<?php echo esc_url( $placeholder_img ) ?>" />
			</a>
		</div>
	<?php }
	?>
<?php endif; ?>
