<?php

if ( !function_exists( 'azuma_header_title' ) ) {
	function azuma_header_title() {

		if ( get_theme_mod( 'page_title_style' ) == 2 ) {
			return NULL;
		}

		if ( is_singular() ) {
			if ( class_exists( 'WooCommerce' ) ) {
				if ( is_product() ) {
					azuma_header_title_product();
				} else {
					azuma_header_title_singular();
				}
			} else {
				azuma_header_title_singular();
			}			
		}

		elseif ( is_archive() ) {
			if ( class_exists( 'WooCommerce' ) ) {
				if ( is_shop() ) {
					azuma_header_title_shop();
				} elseif ( is_product_category() || is_product_tag() ) {
					azuma_header_title_archive_wc();
				} else {
					azuma_header_title_archive();
				}
			} else {
				azuma_header_title_archive();
			}
		}

		elseif ( is_home() && 'page' == get_option( 'show_on_front' ) ) {
			azuma_header_title_home();
		}

		elseif ( is_search() ) {
			azuma_header_title_search();
		}

		elseif ( is_404() ) {
			azuma_header_title_404();
		}

		else {
			azuma_header_title_fallback();
		}

	}
}


if ( !function_exists( 'azuma_header_title_singular' ) ) {
	function azuma_header_title_singular() {

		if ( has_post_thumbnail() ) {
			$bg_image_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
		} else {
			$bg_image_url = get_header_image();
		}
		?>
		<header class="entry-header with-image full" style="background-image: url('<?php echo $bg_image_url; ?>')">
			<div class="title-meta-wrapper">
				<div class="container">
		<?php

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				azuma_posted_by();
				azuma_posted_on();
				?>
			</div><!-- .entry-meta -->
		<?php
		endif;

					the_title( '<h1 class="entry-title">', '</h1>' );
					azuma_single_excerpt();
		?>
				</div>
			</div>
		</header><!-- .entry-header -->

		<?php
	}
}


if ( !function_exists( 'azuma_header_title_home' ) ) {
	function azuma_header_title_home() {

		$blog_page_id = get_option( 'page_for_posts' );
	
		$bg_image_url = get_the_post_thumbnail_url( $blog_page_id, 'full' );

		if ( !$bg_image_url ) {
			$bg_image_url = get_header_image();
		}

		$home_excerpt = wp_kses_post( wpautop( get_post_field( 'post_excerpt', $blog_page_id ) ) );

		?>
		<header class="archive-header with-image full" style="background-image: url('<?php echo $bg_image_url; ?>')">
			<div class="title-meta-wrapper">
				<div class="container">
					<h1 class="archive-title"><?php echo get_the_title( $blog_page_id ); ?></h1>
					<?php
					if ( $home_excerpt ) { ?>
						<div class="archive-description">
							<?php echo $home_excerpt; ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</header><!-- .entry-header -->

		<?php
	}
}


if ( !function_exists( 'azuma_header_title_archive' ) ) {
	function azuma_header_title_archive() {

		$bg_image_url = get_header_image();
		?>
		<header class="archive-header with-image full" style="background-image: url('<?php echo $bg_image_url; ?>')">
			<div class="title-meta-wrapper">
				<div class="container">
					<?php
					if ( is_search() ) {
						echo '<h1 class="archive-title search">';
						printf( esc_html__( 'Search results for: %s', 'azuma' ), '<span class="search-query">' . get_search_query() . '</span>' );
						echo'</h1>';
					} else {
						if ( is_post_type_archive( 'download' ) ) {
							if ( get_theme_mod( 'edd_archive_title' ) ) {
								echo '<h1 class="archive-title downloads">' . esc_html( get_theme_mod( 'edd_archive_title' ) ) . '</h1>';
							} else {
								the_archive_title( '<h1 class="archive-title downloads">', '</h1>' );
							}
							if ( get_theme_mod( 'edd_archive_description' ) ) {
								echo '<div class="archive-description downloads">' . wp_kses_post( wpautop( get_theme_mod( 'edd_archive_description' ) ) ) . '</div>';
							} else {
								the_archive_description( '<div class="archive-description downloads">', '</div>' );
							}
						} else {
							the_archive_title( '<h1 class="archive-title">', '</h1>' );
							the_archive_description( '<div class="archive-description">', '</div>' );
						}
					}					
					?>
				</div>
			</div>
		</header><!-- .archive-header -->

		<?php
	}
}


if ( !function_exists( 'azuma_header_title_search' ) ) {
	function azuma_header_title_search() {

		$bg_image_url = get_header_image();
		?>
		<header class="archive-header with-image full" style="background-image: url('<?php echo $bg_image_url; ?>')">
			<div class="title-meta-wrapper">
				<div class="container">
					<?php
					echo '<h1 class="archive-title search">';
					printf( esc_html__( 'Search results for: %s', 'azuma' ), '<span class="search-query">' . get_search_query() . '</span>' );
					echo'</h1>';
					?>
				</div>
			</div>
		</header><!-- .archive-header -->

		<?php
	}
}


if ( !function_exists( 'azuma_header_title_404' ) ) {
	function azuma_header_title_404() {

		$bg_image_url = get_header_image();
		?>
		<header class="archive-header with-image full" style="background-image: url('<?php echo $bg_image_url; ?>')">
			<div class="title-meta-wrapper">
				<div class="container">
					<?php
					echo '<h1 class="archive-title 404">' . esc_html__( '404 Error', 'azuma' ) . '</h1>';
					?>
				</div>
			</div>
		</header><!-- .archive-header -->

		<?php
	}
}


if ( !function_exists( 'azuma_header_title_archive_wc' ) ) {
	function azuma_header_title_archive_wc() {

		add_filter( 'woocommerce_show_page_title', '__return_false' );

		remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
		remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10);

		add_action( 'azuma_woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
		add_action( 'azuma_woocommerce_archive_description', 'woocommerce_product_archive_description', 10);

		$bg_image_url = azuma_wc_archive_image_url();

		if ( !$bg_image_url ) {
			$bg_image_url = get_header_image();
		}
		?>
		<header class="archive-header with-image full" style="background-image: url('<?php echo $bg_image_url; ?>')">
			<div class="title-meta-wrapper">
				<div class="container">
					<?php
					echo '<h1 class="archive-title">';
					woocommerce_page_title();
					echo '</h1>';
					do_action( 'azuma_woocommerce_archive_description' );
					?>
				</div>
			</div>
		</header><!-- .archive-header -->

		<?php
	}
}


if ( !function_exists( 'azuma_wc_archive_image_url' ) ) {
	function azuma_wc_archive_image_url() {
		if ( is_product_category() ) {
			global $wp_query;
			$cat = $wp_query->get_queried_object();
			$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
			$image = wp_get_attachment_url( $thumbnail_id );
			return $image;
		} else {
			return NULL;
		}
	}
}


if ( !function_exists( 'azuma_header_title_product' ) ) {
	function azuma_header_title_product() {

		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);

		if ( has_post_thumbnail() ) {
			$bg_image_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
		} else {
			$bg_image_url = get_header_image();
		}
		?>
		<header class="entry-header with-image full" style="background-image: url('<?php echo $bg_image_url; ?>')">
			<div class="title-meta-wrapper">
				<div class="container">
		<?php
					the_title( '<h1 class="entry-title">', '</h1>' );
		?>
				</div>
			</div>
		</header><!-- .entry-header -->

		<?php
	}
}


if ( !function_exists( 'azuma_header_title_shop' ) ) {
	function azuma_header_title_shop() {

		add_filter( 'woocommerce_show_page_title', '__return_false' );

		$shop_page_id = wc_get_page_id( 'shop' );

		$bg_image_url = get_the_post_thumbnail_url( $shop_page_id, 'full' );

		if ( !$bg_image_url ) {
			$bg_image_url = get_header_image();
		}

		$shop_excerpt = wp_kses_post( wpautop( get_post_field( 'post_excerpt', $shop_page_id ) ) );

		?>
		<header class="archive-header with-image full" style="background-image: url('<?php echo $bg_image_url; ?>')">
			<div class="title-meta-wrapper">
				<div class="container">
					<?php
					echo '<h1 class="archive-title">';
					woocommerce_page_title();
					echo '</h1>';
					if ( $shop_excerpt ) { ?>
						<div class="archive-description">
							<?php echo $shop_excerpt; ?>
						</div>
					<?php }
					?>
				</div>
			</div>
		</header><!-- .archive-header -->

		<?php
	}
}


if ( !function_exists( 'azuma_header_title_fallback' ) ) {
	function azuma_header_title_fallback() {

		$bg_image_url = get_header_image();

		?>
		<header class="archive-header with-image full" style="background-image: url('<?php echo $bg_image_url; ?>')">
		</header><!-- .entry-header -->

		<?php
	}
}
