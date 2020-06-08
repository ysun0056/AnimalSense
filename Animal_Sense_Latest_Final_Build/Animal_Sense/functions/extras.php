<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Azuma
 */

function azuma_get_installed_version() {
	return wp_get_theme()->get( 'Version' );
}

/**
 * Adds custom classes to the array of body classes
 *
 * @param array $classes Classes for the body element
 * @return array
 */
if ( !function_exists( 'azuma_body_classes' ) ) {
	function azuma_body_classes( $classes ) {
		// Adds a class of group-blog to blogs with more than 1 published author
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		if ( get_theme_mod( 'header_textcolor' ) == 'blank' ) {
			$classes[] = 'title-tagline-hidden';
		}

		if ( post_password_required() ) {
			$classes[] = 'post-password-required';
		}

		$sidebar_position = get_theme_mod( 'sidebar_position' );
		if ( $sidebar_position == "left" ) {
			$classes[] = 'sidebar-left';
		}

		return $classes;
	}
}
add_filter( 'body_class', 'azuma_body_classes' );


if ( !function_exists( 'azuma_primary_menu_fallback' ) ) {
	function azuma_primary_menu_fallback() {
		echo '<ul id="primary-menu" class="demo-menu">';
		wp_list_pages( array( 'depth' => 3, 'sort_column' => 'post_name', 'title_li' => '' ) );
		echo '</ul>';
	}
}


if ( !function_exists( 'azuma_footer_menu_fallback' ) ) {
	function azuma_footer_menu_fallback() {
		if ( function_exists( 'the_privacy_policy_link' ) ) {
			echo '<div class="site-info-right">';
			the_privacy_policy_link( '', '' );
			echo '</div>';
		}
	}
}


if ( !function_exists( 'azuma_custom_excerpt_length' ) ) {
	function azuma_custom_excerpt_length( $length ) {
		if ( is_admin() ) {
			return $length;
		} else {
			return 20;
		}
	}
}
add_filter( 'excerpt_length', 'azuma_custom_excerpt_length', 999 );


if ( !function_exists( 'azuma_excerpt_more' ) ) {
	function azuma_excerpt_more( $more ) {
		return '&hellip;';
	}
}
add_filter( 'excerpt_more', 'azuma_excerpt_more' );


if ( !function_exists( 'azuma_archive_title_prefix' ) ) {
	function azuma_archive_title_prefix( $title ) {
		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		} elseif ( is_author() ) {
			$title = '<span class="author vcard">' . get_avatar( get_the_author_meta( 'ID' ), '80' ) . esc_html( get_the_author() ) . '</span>' ;
		} elseif ( is_tax( 'download_category' ) ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tax( 'download_tag' ) ) {
			$title = single_tag_title( '', false );
		} elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		}
		return $title;
	}
}
add_filter( 'get_the_archive_title', 'azuma_archive_title_prefix' );


if ( !function_exists( 'azuma_header_menu' ) ) {
	function azuma_header_menu() {
		?>
		<button class="toggle-nav"></button>
		<div id="site-navigation" role="navigation">
			<div class="site-main-menu">
			<?php wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_id'		=> 'primary-menu',
					'fallback_cb'	=> 'azuma_primary_menu_fallback',
				)
			); ?>
			</div>
		</div>
		<?php
	}
}


if ( !function_exists( 'azuma_header_content' ) ) {
	function azuma_header_content() {
		?>
			<div id="site-branding">
				<?php if ( get_theme_mod( 'custom_logo' ) ) {
						the_custom_logo();
					} else { ?>
					<?php if ( is_front_page() ) { ?>
						<h1 class="site-title"><a class="<?php echo esc_attr( get_theme_mod( 'site_title_style' ) );?>" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php } else { ?>
						<p class="site-title"><a class="<?php echo esc_attr( get_theme_mod( 'site_title_style' ) );?>" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php } 
					} ?>				
						<div class="site-description"><?php bloginfo( 'description' ); ?></div>
			</div><!-- #site-branding -->
		<?php
	}
}


if ( !function_exists( 'azuma_header_content_extra' ) ) {
	function azuma_header_content_extra() {
		?>
			<div id="site-top-right">
				<?php azuma_header_search() ?>
				<?php azuma_header_account(); ?>
				<?php azuma_header_wishlist(); ?>
				<?php azuma_header_cart(); ?>
			</div><!-- #site-top-right -->
		<?php
	}
}


/**
 * Login/register/account in header. Priority is WooCommerce, then EDD
 */
if ( !function_exists( 'azuma_header_account' ) ) {
	function azuma_header_account() {
		if ( class_exists( 'WooCommerce' ) ) { ?>
			<div class="top-account">
			<?php $woo_account_page_id = get_option( 'woocommerce_myaccount_page_id' );
			if ( $woo_account_page_id ) {
				$woo_account_page_url = get_permalink( $woo_account_page_id ); ?>
				<a class="azuma-account" href="<?php echo get_permalink( $woo_account_page_id ); ?>" role="button"><span id="icon-user" class="icons azuma-icon-user"></span></a>
			<?php } else {
				$woo_account_page_url = wp_login_url( get_permalink() ); ?>
				<span class="azuma-account" role="button"><span id="icon-user" class="icons azuma-icon-user"></span></span>
			<?php } ?>
				<div class="mini-account">
				<?php if ( is_user_logged_in() ) {
					echo '<p class="display-name"><i class="fa fa-user"></i> <strong>' . esc_html( wp_get_current_user()->display_name ) . '</strong></p>';
					woocommerce_account_navigation();
				} else {
					wc_get_template( 'myaccount/form-login.php' );
				} ?>
				</div>
			</div>
		<?php } else {


			if ( function_exists( 'EDD' ) ) { ?>

				<div class="top-account">
				<?php if ( is_user_logged_in() ) {
					$edd_account_page_id = get_theme_mod( 'edd_account_page' );
				} else {
					$edd_account_page_id = get_theme_mod( 'edd_loginreg_page' );
				}
				
				if ( $edd_account_page_id ) {
					$edd_account_page_url = get_permalink( $edd_account_page_id ); ?>
					<a class="azuma-account" href="<?php echo get_permalink( $edd_account_page_id ); ?>" role="button"><span id="icon-user" class="icons azuma-icon-user"></span></a>
				<?php } else {
					$edd_account_page_url = wp_login_url( get_permalink() ); ?>
					<span class="azuma-account" role="button"><span id="icon-user" class="icons azuma-icon-user"></span></span>
				<?php } ?>
					
				<?php if ( is_user_logged_in() ) {
					if ( get_theme_mod( 'edd_purchase_history' ) || get_theme_mod( 'edd_download_history' ) || get_theme_mod( 'edd_profile' ) ) { ?>
						<div class="mini-account">
						<?php if ( get_theme_mod( 'edd_purchase_history' ) ) {
							edd_get_template_part( 'history-purchases' );
						}
						if ( get_theme_mod( 'edd_download_history' ) ) {
							edd_get_template_part( 'history-downloads' );
						}
						if ( get_theme_mod( 'edd_profile' ) ) {
							edd_get_template_part( 'shortcode', 'profile-editor' );
						} ?>
						</div>
					<?php }
				} else {
					if ( get_theme_mod( 'edd_account_login' ) || get_theme_mod( 'edd_account_reg' ) ) { ?>
						<div class="mini-account">
						<?php if ( get_theme_mod( 'edd_account_login' ) ) {
							echo do_shortcode( '[edd_login redirect="' . azuma_current_page_url() . '"]' );
						}
						if ( get_theme_mod( 'edd_account_reg' ) ) {
							echo do_shortcode( '[edd_register redirect="' . azuma_current_page_url() . '"]' );
						} ?>
						</div>
					<?php }
				} ?>
					
				</div>

			<?php }

		}
	}
}


/**
 * Return translated post ID
 */
if(!function_exists( 'azuma_wpml_page_id' )){
	function azuma_wpml_page_id($id){
		if ( function_exists( 'wpml_object_id' ) ) {
			return apply_filters( 'wpml_object_id', $id, 'page' );
		} elseif ( function_exists( 'icl_object_id' ) ) {
			return icl_object_id( $id, 'page', true );
		} else {
			return $id;
		}
	}
}


/**
 * Return current page
 */
if ( !function_exists( 'azuma_current_page_url' ) ) {
	function azuma_current_page_url() {
		global $wp;
		if ( !$wp->did_permalink ) {
			$azuma_current_page_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
		} else {
			$azuma_current_page_url = home_url( add_query_arg( array(), $wp->request ) );
		}
		if ( is_404( $azuma_current_page_url ) ) {
			$azuma_current_page_url  = home_url( '/' );
		}
		return esc_url( $azuma_current_page_url );
	}
}


if ( !function_exists( 'azuma_header_search' ) ) {
	function azuma_header_search() {
		?>
		<div class="top-search">
			<a href="#" class="icons azuma-icon-search"></a>
			<div class="mini-search">
			<?php if ( class_exists( 'WooCommerce' ) ) {
				get_product_search_form();
			} else {
				if ( function_exists( 'EDD' ) && get_theme_mod( 'edd_search' ) == '' ) {
					azuma_edd_search_form();
				} else {
					get_search_form();
				}
			} ?>
			</div>
		</div>
	<?php }
}


if ( !function_exists( 'azuma_edd_search_form' ) ) {
	function azuma_edd_search_form() {
		?>

		<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
			<label>
				<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'azuma' ); ?></span>
				<input type="search" class="search-field" placeholder="<?php echo esc_attr__( 'Search downloads&hellip;', 'azuma' ); ?>" value="<?php echo get_search_query();?>" name="s" />
			</label>
			<button type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'azuma' ); ?>"><?php echo esc_html_x( 'Search', 'submit button', 'azuma' ); ?></button>
			<input type="hidden" name="post_type" value="download" />
		</form>
		
	<?php }
}


if ( !function_exists( 'azuma_header_wishlist' ) ) {
	function azuma_header_wishlist() {
		if ( class_exists( 'WooCommerce' ) ) {
			if ( class_exists( 'YITH_WCWL' ) ) { ?>
				<div class="top-wishlist"><a class="azuma-wishlist" href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url() ); ?>" role="button"><span class="icons azuma-icon-heart"></span><span class="wishlist_products_counter_number"><?php echo yith_wcwl_count_all_products(); ?></span></a></div>
			<?php } elseif ( class_exists( 'TInvWL' ) ) {
				echo do_shortcode( '[ti_wishlist_products_counter show_icon="off" show_text="off"]' );
			}
		}
	}
}


if ( !function_exists( 'azuma_update_wishlist_count' ) ) {
	function azuma_update_wishlist_count() {
		if( class_exists( 'YITH_WCWL' ) ){
			wp_send_json( array(
				'count' => yith_wcwl_count_all_products()
			) );
		}
	}
}
add_action( 'wp_ajax_yith_wcwl_update_wishlist_count', 'azuma_update_wishlist_count' );
add_action( 'wp_ajax_nopriv_yith_wcwl_update_wishlist_count', 'azuma_update_wishlist_count' );


/**
 * Shopping cart in header. Priority is WooCommerce, then EDD
 */
if ( !function_exists( 'azuma_header_cart' ) ) {
	function azuma_header_cart() {

		if ( class_exists( 'WooCommerce' ) ) {
			$cart_items = WC()->cart->get_cart_contents_count();
			if ( $cart_items > 0 ) {
				$cart_class = ' items';
			} else {
				$cart_class = '';
			} ?>
					<div class="top-cart"><a class="azuma-cart<?php echo $cart_class; ?>" href="<?php echo esc_url( wc_get_cart_url() ); ?>" role="button"><span class="icons azuma-icon-shopping-cart"></span><?php echo sprintf ( '<span class="item-count">%d</span>', $cart_items ); ?></a><div class="mini-cart"><?php woocommerce_mini_cart();?></div></div>
		<?php } else {

			if ( function_exists( 'EDD' ) ) {
				$cart_items = edd_get_cart_quantity(); ?>
						<div class="top-cart"><a class="azuma-cart" href="<?php echo esc_url( edd_get_checkout_uri() ); ?>" role="button"><span class="icons azuma-icon-shopping-cart"></span><?php echo sprintf ( '<span class="item-count edd-cart-quantity">%d</span>', $cart_items ); ?></a><div class="mini-cart"><?php the_widget( 'edd_cart_widget' );?></div></div>
			<?php }

		}

	}
}


/**
 * Update header mini-cart contents when products are added to the cart via AJAX
 */
if ( !function_exists( 'azuma_header_cart_update' ) ) {
	function azuma_header_cart_update( $fragments ) {
		$cart_items = WC()->cart->get_cart_contents_count();
		if ( $cart_items > 0 ) {
			$cart_class = ' items';
		} else {
			$cart_class = '';
		}
		ob_start();
		?>
					<div class="top-cart"><a class="azuma-cart<?php echo $cart_class; ?>" href="<?php echo esc_url( wc_get_cart_url() ); ?>" role="button"><span class="icons azuma-icon-shopping-cart"></span><?php echo sprintf ( '<span class="item-count">%d</span>', $cart_items ); ?></a><div class="mini-cart"><?php woocommerce_mini_cart();?></div></div>
		<?php	
		$fragments['.top-cart'] = ob_get_clean();	
		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'azuma_header_cart_update' );


if ( !function_exists( 'azuma_yith_wishlist_icon' ) ) {
	function azuma_yith_wishlist_icon() {
		if ( class_exists( 'YITH_WCWL' ) ) {
			echo do_shortcode( '[yith_wcwl_add_to_wishlist label="" product_added_text="" already_in_wishslist_text="" browse_wishlist_text=""]' );
		}
	}
}
add_action( 'woocommerce_after_shop_loop_item', 'azuma_yith_wishlist_icon', 9 );


/**
 * Powered by WordPress
 */
if ( !function_exists( 'azuma_powered_by' ) ) {
	function azuma_powered_by() {
		?>
				<div class="site-info">
					<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'azuma' ) ); ?>"><?php printf( esc_html__( 'Powered by %s', 'azuma' ), 'WordPress' ); ?></a>
					<i class="fa fa-chevron-right sep"></i>
					<?php printf( esc_html__( 'Theme: %s', 'azuma' ), '<a href="https://uxlthemes.com/theme/azuma/" rel="designer">Azuma</a>' ); ?>
				</div>
		<?php
	}
}


/**
 * WooCommerce product sticky cart form 
 */
if ( !function_exists( 'azuma_wc_sticky_addtocart' ) ) {
	function azuma_wc_sticky_addtocart() {

		if ( get_theme_mod( 'disable_wc_sticky_cart' ) == 1 ) {
			return;
		}

		if ( class_exists( 'WooCommerce' ) && is_product() ) {
			echo '<div id="wc-sticky-addtocart">';
			the_post_thumbnail( 'woocommerce_thumbnail' );
			woocommerce_template_single_title();
			woocommerce_template_single_price();
			if ( in_array( 'product-type-variable', get_post_class() ) ) {
				echo '<div class="options-button">' . esc_html__( 'options', 'azuma' ) . '</div>';
			}
			woocommerce_template_single_add_to_cart();
			echo '</div>';
		}

	}
}


remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

add_action( 'woocommerce_before_main_content', 'azuma_theme_wrapper_start', 10);
add_action( 'woocommerce_after_main_content', 'azuma_theme_wrapper_end', 10);
add_action( 'woocommerce_before_shop_loop', 'azuma_shop_filter_section', 15);

add_action( 'woocommerce_before_shop_loop_item', 'azuma_before_shop_loop_item', 0);
add_action( 'woocommerce_before_subcategory', 'azuma_before_shop_loop_item', 0);

add_action( 'woocommerce_shop_loop_item_title', 'azuma_before_shop_loop_item_title', 0);
add_action( 'woocommerce_after_shop_loop_item_title', 'azuma_after_shop_loop_item_title', 100);

add_action( 'woocommerce_shop_loop_subcategory_title', 'azuma_before_shop_loop_cat_title', 0);
add_action( 'woocommerce_shop_loop_subcategory_title', 'azuma_after_shop_loop_item_title', 100);

add_action( 'woocommerce_after_shop_loop_item', 'azuma_before_shop_loop_addtocart', 6);
add_action( 'woocommerce_after_shop_loop_item', 'azuma_after_shop_loop_addtocart', 100);
add_action( 'woocommerce_after_subcategory', 'azuma_after_subcategory', 100);


if ( !function_exists( 'azuma_before_shop_loop_item' ) ) {
	function azuma_before_shop_loop_item() {
		echo '<div class="product-wrap">';
	}
}


if ( !function_exists( 'azuma_before_shop_loop_item_title' ) ) {
	function azuma_before_shop_loop_item_title() {
		$product_excerpt = get_the_excerpt();
		if ( $product_excerpt ) {
			echo '<div class="product-excerpt-wrap">' . $product_excerpt . '</div>';
		}
		echo '<div class="product-detail-wrap">';
	}
}


if ( !function_exists( 'azuma_before_shop_loop_cat_title' ) ) {
	function azuma_before_shop_loop_cat_title() {
		echo '<div class="product-detail-wrap">';
	}
}


if ( !function_exists( 'azuma_after_shop_loop_item_title' ) ) {
	function azuma_after_shop_loop_item_title() {
		echo '</div>';
	}
}


if ( !function_exists( 'azuma_before_shop_loop_addtocart' ) ) {
	function azuma_before_shop_loop_addtocart() {
		echo '<div class="product-addtocart-wrap">';
	}
}


if ( !function_exists( 'azuma_after_shop_loop_addtocart' ) ) {
	function azuma_after_shop_loop_addtocart() {
		echo '</div></div>';
	}
}


if ( !function_exists( 'azuma_after_subcategory' ) ) {
	function azuma_after_subcategory() {
		echo '</div>';
	}
}


if ( !function_exists( 'azuma_shop_filter_section' ) ) {
	function azuma_shop_filter_section() {
		if ( !is_product() ) {
			get_sidebar( 'shop-filters' );
		}
	}
}


if ( !function_exists( 'azuma_theme_wrapper_start' ) ) {
	function azuma_theme_wrapper_start() {
		if ( !is_active_sidebar( 'azuma-sidebar-shop' ) || is_product() ) {
			$page_full_width = ' full-width';
		} else {
			$page_full_width = '';
		}
		echo '<div id="primary" class="content-area'.$page_full_width.'">
			<main id="main" class="site-main" role="main">';
	}
}


if ( !function_exists( 'azuma_theme_wrapper_end' ) ) {
	function azuma_theme_wrapper_end() {
		echo '</main><!-- #main -->
		</div><!-- #primary -->';
		if ( !is_product() ) {
			get_sidebar( 'shop' );
		}
	}
}


if ( !function_exists( 'azuma_change_prev_next' ) ) {
	function azuma_change_prev_next( $args ) {
		$args['prev_text'] = '<i class="fa fa-chevron-left"></i>';
		$args['next_text'] = '<i class="fa fa-chevron-right"></i>';
		return $args;
	}
}
add_filter( 'woocommerce_pagination_args', 'azuma_change_prev_next' );


if ( !function_exists( 'azuma_woocommerce_placeholder_img_src' ) ) {
	function azuma_woocommerce_placeholder_img_src() {
		return get_template_directory_uri().'/images/woocommerce-placeholder.png';
	}
}
if ( !get_option( 'woocommerce_placeholder_image', 0 ) ) {
	add_filter('woocommerce_placeholder_img_src', 'azuma_woocommerce_placeholder_img_src');
}


if ( !function_exists( 'azuma_upsell_products_args' ) ) {
	function azuma_upsell_products_args( $args ) {
		$col_per_page = esc_attr( get_option( 'woocommerce_catalog_columns', 4 ) );
		$args['posts_per_page'] = $col_per_page;
		$args['columns'] = $col_per_page;
		return $args;
	}
}
add_filter( 'woocommerce_upsell_display_args', 'azuma_upsell_products_args' );


if ( !function_exists( 'azuma_related_products_args' ) ) {
	function azuma_related_products_args( $args ) {
		$col_per_page = esc_attr( get_option( 'woocommerce_catalog_columns', 4 ) );
		$args['posts_per_page'] = $col_per_page;
		$args['columns'] = $col_per_page;
		return $args;
	}
}
add_filter( 'woocommerce_output_related_products_args', 'azuma_related_products_args' );


if ( !function_exists( 'azuma_woocommerce_gallery_thumbnail_size' ) ) {
	function azuma_woocommerce_gallery_thumbnail_size( $size ) {
		return 'woocommerce_thumbnail';
	}
}
add_filter( 'woocommerce_gallery_thumbnail_size', 'azuma_woocommerce_gallery_thumbnail_size' );


remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );

add_action( 'woocommerce_before_shop_loop_item_title', 'azuma_before_loop_sale_flash', 7);
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 8 );
add_action( 'woocommerce_before_shop_loop_item_title', 'azuma_after_loop_sale_flash', 9);

add_action( 'woocommerce_before_single_product_summary', 'azuma_before_loop_sale_flash', 9);
add_action( 'woocommerce_before_single_product_summary', 'azuma_after_loop_sale_flash', 11);


if ( !function_exists('azuma_before_loop_sale_flash') ) {
	function azuma_before_loop_sale_flash() {
		global $product;
		if ( $product->is_on_sale() ) {
			echo '<div class="sale-flash">';
		}
	}
}


if ( !function_exists('azuma_after_loop_sale_flash') ) {
	function azuma_after_loop_sale_flash() {
		global $product;
		if ( $product->is_on_sale() ) {			
			if ( ! $product->is_type( 'variable' ) && $product->get_regular_price() && $product->get_sale_price() ) {
				$discount_price = $product->get_regular_price() - $product->get_sale_price();
				if ( $discount_price > 0 ) {
					$max_percentage = ( $discount_price  / $product->get_regular_price() ) * 100;
				} else {
					$max_percentage = 0;
				}
			} else {
				$max_percentage = 0;				
				foreach ( $product->get_children() as $child_id ) {
					$variation = wc_get_product( $child_id );
					$price = $variation->get_regular_price();
					$sale = $variation->get_sale_price();
					$percentage = '';
					if ( $price != 0 && ! empty( $sale ) ) {
						$percentage = ( $price - $sale ) / $price * 100;
					}
					if ( $percentage > $max_percentage ) {
						$max_percentage = $percentage;
					}
				}
			}
			echo '<br /><span class="sale-percentage">-' . esc_attr( round($max_percentage) ) . '%</span>';
			echo '</div>';
		}
	}
}


/**
 * Available homepage WooCommerce sections
 */
if ( !function_exists( 'azuma_woo_home_tabs' ) ) {
	function azuma_woo_home_tabs() {
		$tabs = array();
		$tabs['services'] = array(
			'id'	   => 'services',
			'label'	=> esc_html__( 'Featured Services', 'azuma' ),
			'callback' => 'azuma_services',
			'shortcode'=> 'services',
		);
		$tabs['pagecontent'] = array(
			'id'	   => 'pagecontent',
			'label'	=> esc_html__( 'Page Content', 'azuma' ),
			'callback' => 'azuma_pagecontent',
			'shortcode'=> 'page_content',
		);

if ( class_exists( 'WooCommerce' ) ) {
		$tabs['categories'] = array(
			'id'		=> 'categories',
			'label'		=> esc_html__( 'Product Categories', 'azuma' ),
			'callback'	=> 'azuma_categories',
			'shortcode'	=> 'product_categories',
		);
		$tabs['recent'] = array(
			'id'		=> 'recent',
			'label'		=> esc_html__( 'New products', 'azuma' ),
			'callback'	=> 'azuma_recent',
			'shortcode'	=> 'recent_products',
		);
		$tabs['featured'] = array(
			'id'		=> 'featured',
			'label'		=> esc_html__( 'Featured products', 'azuma' ),
			'callback'	=> 'azuma_featured',
			'shortcode'	=> 'featured_products',
		);
		$tabs['sale'] = array(
			'id'		=> 'sale',
			'label'		=> esc_html__( 'On-sale products', 'azuma' ),
			'callback'	=> 'azuma_sale',
			'shortcode'	=> 'sale_products',
		);
		$tabs['best'] = array(
			'id'		=> 'best',
			'label'		=> esc_html__( 'Top sellers', 'azuma' ),
			'callback'	=> 'azuma_best',
			'shortcode'	=> 'best_selling_products',
		);
		$tabs['rated'] = array(
			'id'		=> 'rated',
			'label'		=> esc_html__( 'Top rated products', 'azuma' ),
			'callback'	=> 'azuma_rated',
			'shortcode'	=> 'top_rated_products',
		);
}

		return apply_filters( 'azuma_woo_home_tabs', $tabs );
	}
}


/**
 * Output the homepage sections without WooCommerce
 */
if ( !function_exists('azuma_home_nonwoo_section') ) {
	function azuma_home_nonwoo_section() {

		$woo_home_tabs = get_theme_mod( 'woo_home' );

		if ( !empty( $woo_home_tabs['tabs'] ) ) {

			echo '<div id="homepage-sections">';

			$woo_home = get_theme_mod( 'woo_home', true );

			$woo_tabs = azuma_woo_home_tabs();
	
			?>

			<?php
			$tabs = explode( ',', $woo_home['tabs'] );

			foreach ($tabs as $tab) {
				$tab = explode(":", $tab);
				$tab_id = $tab[0];
				if ( $tab_id == 'categories' || $tab_id == 'recent' || $tab_id == 'featured' || $tab_id == 'sale' || $tab_id == 'best' || $tab_id == 'rated' ) {
					// no WC sections if WC not active
				} else {
					$tab_active = $tab[1];
					$tab_shortcode = $woo_tabs[$tab_id]['shortcode'];
					if ( $tab_active == 1 ) {
						echo '<div id="section-'.$tab_id.'" class="section '.$tab_id.'">';
							if ( $woo_tabs[$tab_id]['shortcode'] == 'services' ) {
								azuma_homepage_features();
							} elseif ( $woo_tabs[$tab_id]['shortcode'] == 'page_content' ) {
								azuma_homepage_content();
							}
						echo '</div>';
					}
				}
			}

			echo '</div>';

		}
	}
}


/**
 * Output the homepage sections with WooCommerce
 */
if ( !function_exists('azuma_home_woo_section') ) {
	function azuma_home_woo_section() {

		$woo_home_tabs = get_theme_mod( 'woo_home' );

		if ( !empty( $woo_home_tabs['tabs'] ) ) {

			echo '<div id="homepage-sections">';

			$woo_home = get_theme_mod( 'woo_home', true );

			$woo_tabs = azuma_woo_home_tabs();

			$woo_column_option = esc_attr( get_option( 'woocommerce_catalog_columns', 4 ) );
	
			?>

			<?php
			$tabs = explode( ',', $woo_home['tabs'] );

			foreach ($tabs as $tab) {
				$tab = explode(":", $tab);
				$tab_id = $tab[0];
				$tab_active = $tab[1];
				$tab_shortcode = $woo_tabs[$tab_id]['shortcode'];

				if ( $tab_active == 1 ) {
					echo '<div id="section-'.$tab_id.'" class="section '.$tab_id.'">';
						if ( $woo_tabs[$tab_id]['shortcode'] == 'services' ) {
							azuma_homepage_features();
						} elseif ( $woo_tabs[$tab_id]['shortcode'] == 'page_content' ) {
							azuma_homepage_content();
						} elseif ( $woo_tabs[$tab_id]['shortcode'] == 'product_categories' ) {
							echo '<h2 class="section-title">' . $woo_tabs[$tab_id]['label'] . '</h2>';
							echo do_shortcode('[product_categories number="0" parent="0" columns="' . $woo_column_option . '"]');
						} else {
							echo '<h2 class="section-title">' . $woo_tabs[$tab_id]['label'] . '</h2>';
							echo do_shortcode('[' . $tab_shortcode . ' limit="' . $woo_column_option . '" columns="' . $woo_column_option . '"]');
						}
					echo '</div>';
				}

			}

			echo '</div>';

		}
	}
}


if ( !function_exists('azuma_homepage_features') ) {
	function azuma_homepage_features() {


	$enable_featured_link = get_theme_mod( 'enable_featured_link', true);
?>
	<section id="featured-post-section" class="section">
		<div class="featured-post-wrap">
			<?php
			$featured_page_link1 = get_theme_mod( 'featured_page_link1' );
			if (!$featured_page_link1) {
			 	# display latest posts
				$azuma_recent_args = array(
					'numberposts' => '3',
					'orderby' => 'post_date',
					'order' => 'DESC',
					'post_type' => 'post',
					'post_status' => 'publish',
					'suppress_filters' => false
					);
				$recent_posts = wp_get_recent_posts( $azuma_recent_args );
				$featured_post_number = 1;
				foreach( $recent_posts as $recent ){
					$featured_page_icon = get_theme_mod( 'featured_page_icon'.$featured_post_number, azuma_featured_icon_defaults($featured_post_number) );
					?>
					<div class="featured-post featured-post<?php echo $featured_post_number; ?>">
						<a href="<?php echo esc_url( get_permalink( $recent["ID"] ) ); ?>"><span class="featured-icon"><i class="<?php echo esc_attr( $featured_page_icon ); ?>"></i></span>
						<h4><?php echo wp_kses_post( get_the_title($recent["ID"]) ); ?></h4></a>
						<div class="featured-excerpt">
						<?php
						$featured_page_excerpt = wp_kses_post( wpautop( get_post_field( 'post_excerpt', $recent["ID"] ) ) );
						if ( $featured_page_excerpt == '' ) {
							$featured_page_excerpt = wpautop( wp_trim_words( strip_shortcodes( get_post_field( 'post_content', $recent["ID"] ) ), 15 ) );
						}
						if ( $featured_page_excerpt != '' ) {
							echo $featured_page_excerpt;
						}
						if ( $enable_featured_link ) {
						?>
						<a href="<?php echo esc_url( get_permalink( $recent["ID"] ) ); ?>" class="button featured-readmore"><?php echo esc_html__( 'Read More', 'azuma' );?></a>
						<?php
						}
						?>
						</div>
					</div>
					<?php
					$featured_post_number++;
				}
				wp_reset_postdata();
			} else {
				# display selected pages
				for( $i = 1; $i < 4; $i++ ){
					$featured_page_icon = get_theme_mod( 'featured_page_icon'.$i, azuma_featured_icon_defaults($i) );
					$featured_page_link = azuma_wpml_page_id( get_theme_mod( 'featured_page_link'.$i) );					
					if($featured_page_link){
					?>
					<div class="featured-post featured-post<?php echo $i ;?>">
						<a href="<?php echo esc_url( get_page_link( $featured_page_link ) ); ?>"><span class="featured-icon"><i class="<?php echo esc_attr( $featured_page_icon ); ?>"></i></span>
						<h4><?php echo wp_kses_post( get_the_title($featured_page_link) ); ?></h4></a>
						<div class="featured-excerpt">
						<?php
						$featured_page_excerpt = wp_kses_post( wpautop( get_post_field( 'post_excerpt', $featured_page_link ) ) );
						if ( $featured_page_excerpt == '' ) {
							$featured_page_excerpt = wpautop( wp_trim_words( strip_shortcodes( get_post_field( 'post_content', $featured_page_link ) ), 15 ) );
						}
						if ( $featured_page_excerpt != '' ) {
							echo $featured_page_excerpt;
						}
						if ( $enable_featured_link ) {
						?>
						<a href="<?php echo esc_url( get_page_link( $featured_page_link ) ); ?>" class="button featured-readmore"><?php echo esc_html__( 'Read More', 'azuma' );?></a>
						<?php
						}
						?>
						</div>
					</div>
				<?php
					}
				}
			}
			?>
		</div>
	</section>
<?php

	}
}


function azuma_featured_icon_defaults( $input ) {
	if ( $input == 1 ) {
		$output = 'fa fa-camera';
	} elseif ( $input == 2 ) {
		$output = 'fa fa-laptop';
	} elseif ( $input == 3 ) {
		$output = 'fa fa-rocket';
	} else {
		$output = 'fa fa-check';
	}
	return $output;
}


if ( !function_exists('azuma_homepage_content') ) {
	function azuma_homepage_content() {

		while ( have_posts() ) : the_post();

			get_template_part( 'content', 'front-page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

		endwhile; // End of the loop.

	}
}


/**
 * Array of Google fonts
 */
if ( !function_exists( 'azuma_google_fonts_array' ) ) {
	function azuma_google_fonts_array() {
	return array(
		'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
		'Impact, Charcoal, sans-serif' => 'Impact, Charcoal, sans-serif',
		'"Lucida Sans Unicode", "Lucida Grande", sans-serif' => '"Lucida Sans Unicode", "Lucida Grande", sans-serif',
		'Tahoma, Geneva, sans-serif' => 'Tahoma, Geneva, sans-serif',
		'"Trebuchet MS", Helvetica, sans-serif' => '"Trebuchet MS", Helvetica, sans-serif',
		'Verdana, Geneva, sans-serif' => 'Verdana, Geneva, sans-serif',
		'Georgia, serif' => 'Georgia, serif',
		'"Palatino Linotype", "Book Antiqua", Palatino, serif' => '"Palatino Linotype", "Book Antiqua", Palatino, serif',
		'"Times New Roman", Times, serif' => '"Times New Roman", Times, serif',
		'' => '---------------',
		'Alegreya Sans:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' => 'Alegreya Sans',
		'Arimo:400,400i,700,700i' => 'Arimo',
		'Arvo:400,400i,700,700i' => 'Arvo',
		'Asap:400,400i,700,700i' => 'Asap',
		'Bitter:400,400i,700' => 'Bitter',
		'Bree Serif:400' => 'Bree Serif',
		'Cabin:400,400i,500,500i,600,600i,700,700i' => 'Cabin',
		'Catamaran:300,400,600,700,800' => 'Catamaran',
		'Crimson Text:400,400i,600,600i,700,700i' => 'Crimson Text',
		'Cuprum:400,400i,700,700i' => 'Cuprum', 'Dosis:200,300,400,500,600,700,800' => 'Dosis',
		'Droid Sans:400,700' => 'Droid Sans',
		'Droid Serif:400,400i,700,700i' => 'Droid Serif',
		'Exo:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' => 'Exo',
		'Exo 2:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' => 'Exo 2',
		'Hind:300,400,500,600,700' => 'Hind',
		'Josefin Sans:100,100i,300,300i,400,400i,600,600i,700,700i' => 'Josefin Sans',
		'Lato:100,100i,300,300i,400,400i,700,700i,900,900i' => 'Lato',
		'Libre Franklin:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' => 'Libre Franklin',
		'Maven Pro:400,500,700,900' => 'Maven Pro',
		'Merriweather:300,300i,400,400i,700,700i,900,900i' => 'Merriweather',
		'Merriweather Sans:300,300i,400,400i,700,700i,800,800i' => 'Merriweather Sans',
		'Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' => 'Montserrat',
		'Muli:300,300i,400,400i' => 'Muli',
		'Noto Sans:400,400i,700,700i' => 'Noto Sans',
		'Noto Serif:400,400i,700,700i' => 'Noto Serif',
		'Nunito:300,400,700' => 'Nunito',
		'Open Sans:300,300i,400,400i,600,600i,700,700i,800,800i' => 'Open Sans',
		'Orbitron:400,500,700,900' => 'Orbitron',
		'Oswald:300,400,700' => 'Oswald',
		'Oxygen:300,400,700' => 'Oxygen',
		'Playfair Display:400,400i,700,700i,900,900i' => 'Playfair Display',
		'Poppins:300,400,500,600,700' => 'Poppins',
		'PT Sans:400,400i,700,700i' => 'PT Sans',
		'PT Serif:400,400i,700,700i' => 'PT Serif',
		'Rajdhani:300,400,500,600,700' => 'Rajdhani',
		'Raleway:100,200,300,400,500,600,700,800,900' => 'Raleway',
		'Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i' => 'Roboto',
		'Roboto Slab:100,300,400,700' => 'Roboto Slab',
		'Source Sans Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i' => 'Source Sans Pro',
		'Titillium Web:200,200i,300,300i,400,400i,600,600i,700,700i,900' => 'Titillium Web',
		'Ubuntu:300,300i,400,400i,500,500i,700,700i' => 'Ubuntu',
	);
	}
}


if ( !function_exists( 'azuma_edd_button_colors' ) ) {
	function azuma_edd_button_colors( $colors ) {
		$azuma_colors = array(
			'azuma'	=> array(
				'label' => esc_html__( 'Azuma Theme', 'azuma' ),
				'hex'   => '#ff7800'
			)
		);
		$colors = array_merge( $azuma_colors, $colors );
		return $colors;
	}
}
add_filter( 'edd_button_colors', 'azuma_edd_button_colors' );


if ( !function_exists( 'azuma_edd_registered_settings' ) ) {
	function azuma_edd_registered_settings( $edd_settings ) {
		$azuma_section_query['autofocus[section]'] = 'edd_section';
		$azuma_section_link = add_query_arg( $azuma_section_query, admin_url( 'customize.php' ) );
		$azuma_edd_settings = array(
			'azuma' => array(
				'main' => array(
					'azuma_help' => array(
						'id'   => 'azuma_help',
						'name' => esc_html__( 'Azuma Theme', 'azuma' ),
						'desc' => sprintf(
							wp_kses(
								/* translators: %s: link to the customizer */
								__( 'More options can be found at Appearance &gt; <a href="%s">Customize</a>', 'azuma' ),
								array(
									'a' => array(
										'href' => array(),
									),
								)
							),
							$azuma_section_link
						),
						'type' => 'descriptive_text',
					),
				),
			)
		);
		$edd_settings = array_merge( $edd_settings, $azuma_edd_settings );
		return $edd_settings;
	}
}
add_filter( 'edd_registered_settings', 'azuma_edd_registered_settings' );


if ( !function_exists( 'azuma_edd_settings_tab' ) ) {
	function azuma_edd_settings_tab( $tabs ) {
		$tabs['azuma'] = esc_html__( 'Azuma Theme', 'azuma' );
		return $tabs;
	}
}
add_filter( 'edd_settings_tabs', 'azuma_edd_settings_tab' );


if ( !function_exists( 'azuma_edd_settings_section' ) ) {
	function azuma_edd_settings_section( $sections ) {
		$azuma_section = array(
			'azuma' => array(
				'main' => ''
			)
		);
		$sections = array_merge( $sections, $azuma_section );
		return $sections;
	}
}
add_filter( 'edd_settings_sections', 'azuma_edd_settings_section' );
