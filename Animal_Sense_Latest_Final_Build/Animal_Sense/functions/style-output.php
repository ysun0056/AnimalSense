<?php
/**
 * Outputs the styling options from the customizer
 *
 * @package Azuma
 */

if ( !function_exists( 'azuma_css_font_family' ) ) {
	function azuma_css_font_family( $font_family ) {
		if ( strpos( $font_family, ':' ) ) {
			$font_family = substr( $font_family, 0, strpos( $font_family, ':' ) );
			return 'font-family:\'' . $font_family . '\'';
		} else {			
			return 'font-family:' . $font_family;
		}
	}
}

if ( !function_exists( 'azuma_dynamic_style' ) ) {
	function azuma_dynamic_style( $css = array() ) {

		$font_content = get_theme_mod( 'font_content' );
		$font_headings = get_theme_mod( 'font_headings' );
		$font_site_title = get_theme_mod( 'font_site_title' );
		$font_nav = get_theme_mod( 'font_nav' );

		if ( $font_content ) {
			$font_site_title_on = 1;
			$font_nav_on = 1;
			$css[] = 'body,button,input,select,textarea{' . azuma_css_font_family( $font_content ) . ';}';
			if ( $font_site_title ) {
				$css[] = '.site-title{' . azuma_css_font_family( $font_site_title ) . ';}';
			} else {
				$css[] = '.site-title{font-family:\'Rajdhani\';}';
			}
			if ( $font_nav ) {
				$css[] = '#site-navigation{' . azuma_css_font_family( $font_nav ) . ';}';
			} else {
				$css[] = '#site-navigation{font-family:\'Rajdhani\';}';
			}
		} else {
			$font_site_title_on = 0;
			$font_nav_on = 0;
		}

		if ( $font_headings ) {
			$css[] = 'h1:not(.site-title),h2,h3,h4,h5,h6{' . azuma_css_font_family( $font_headings ) . ';}';
		}

		if ( $font_site_title && $font_site_title_on == 0 ) {
			$css[] = '.site-title{' . azuma_css_font_family( $font_site_title ) . ';}';
		}

		if ( $font_nav && $font_nav_on == 0 ) {
			$css[] = '#site-navigation{' . azuma_css_font_family( $font_nav ) . ';}';
		}

		if ( azuma_get_installed_version() < '1.1.1' ) {
			$fs_site_title = get_theme_mod( 'fs_site_title', '56' );
			if ( $fs_site_title && $fs_site_title != '56' ) {
				$css[] = '.site-title{font-size:' . esc_attr($fs_site_title) . 'px;}';
			}
		} else {
			$fs_site_title = get_theme_mod( 'fs_site_title' );
			$fs_site_title_laptop = get_theme_mod( 'fs_site_title_laptop' );
			$fs_site_title_tablet = get_theme_mod( 'fs_site_title_tablet' );
			$fs_site_title_mobile = get_theme_mod( 'fs_site_title_mobile' );
			if ( $fs_site_title_laptop || $fs_site_title_tablet || $fs_site_title_mobile ) {
				if ( $fs_site_title ) {
					$css[] = '@media only screen and (min-width: 1025px){.site-title{font-size:' . esc_attr($fs_site_title) . 'px;}}';
				}
				if ( $fs_site_title_laptop ) {
					$css[] = '@media only screen and (min-width: 769px) and (max-width: 1024px){.site-title{font-size:' . esc_attr($fs_site_title_laptop) . 'px;}}';
				}
				if ( $fs_site_title_tablet ) {
					$css[] = '@media only screen and (min-width: 481px) and (max-width: 768px){.site-title{font-size:' . esc_attr($fs_site_title_tablet) . 'px;}}';
				}
				if ( $fs_site_title_mobile ) {
					$css[] = '@media only screen and (max-width: 480px){.site-title{font-size:' . esc_attr($fs_site_title_mobile) . 'px;}}';
				}
			} else {
				if ( $fs_site_title && $fs_site_title != '56' ) {
					$css[] = '.site-title{font-size:' . esc_attr($fs_site_title) . 'px;}';
				}
			}
		}

		$fw_site_title = get_theme_mod( 'fw_site_title', '700' );
		if ( $fw_site_title && $fw_site_title != '700' ) {
			$css[] = '.site-title{font-weight:' . esc_attr($fw_site_title) . ';}';
		}
		$ft_site_title = get_theme_mod( 'ft_site_title', 'uppercase' );
		if ( $ft_site_title && $ft_site_title != 'uppercase' ) {
			$css[] = '.site-title{text-transform:' . esc_html($ft_site_title) . ';}';
		}		
		$fl_site_title = get_theme_mod( 'fl_site_title', '2' );
		if ( $fl_site_title && $fl_site_title != '2' ) {
			$css[] = '.site-title{letter-spacing:' . esc_attr($fl_site_title) . 'px;}';
		}

		if ( class_exists( 'WooCommerce' ) ) {
			$woo_uncat_id = term_exists( 'uncategorized', 'product_cat' );
			if ( $woo_uncat_id != NULL ) {
				$woo_uncat_id = $woo_uncat_id['term_id'];
				$css[] = '#shop-filters .widget_product_categories li.cat-item-' . $woo_uncat_id . '{display:none;}';
			}
		}

		$container_width = get_theme_mod( 'container_width', '1920' );
		if ( $container_width && $container_width != '1920' ) {
			$css[] = '.container{max-width:' . esc_attr($container_width) . 'px;}';
		}

		$header_textcolor = get_theme_mod( 'header_textcolor', 'ffffff' );
		if ( $header_textcolor && $header_textcolor != 'ffffff' ) {
			$css[] = '.site-description,#primary-menu,#primary-menu li a,#primary-menu li.highlight.current-menu-item > a,#site-top-right,#site-top-right a,#site-top-right h1,#site-top-right h2,#site-top-right h3,#site-top-right h4,#site-top-right h5,#site-top-right h6,.top-account h2,.toggle-nav,.toggle-nav:hover,.toggle-nav:focus,#masthead .search-form input[type="search"],#masthead .woocommerce-product-search input[type="search"],#masthead .search-form input[type="submit"]:after,#masthead .woocommerce-product-search button[type="submit"]:after,#masthead .search-form input[type="search"]::placeholder, #masthead .woocommerce-product-search input[type="search"]::placeholder{color:#' . esc_attr($header_textcolor) . ';}';
		}

		$hi_color = get_theme_mod( 'hi_color', '#ff7800' );
		if ( $hi_color && $hi_color != '#ff7800' ) {
			$hi_color = esc_attr($hi_color);
			$hi_color_rgb = azuma_hex2RGB($hi_color);
			
			$css[] = '.button,a.button,button,input[type="button"],input[type="reset"],input[type="submit"],#infinite-handle span button,#infinite-handle span button:hover,#infinite-handle span button:focus,#infinite-handle span button:active,.woocommerce #respond input#submit,.woocommerce a.button,.woocommerce button.button,.woocommerce input.button,.woocommerce #respond input#submit.alt,.woocommerce a.button.alt,.woocommerce button.button.alt,.woocommerce input.button.alt,.woocommerce a.added_to_cart,.woocommerce #respond input#submit.alt.disabled,.woocommerce #respond input#submit.alt.disabled:hover,.woocommerce #respond input#submit.alt:disabled,.woocommerce #respond input#submit.alt:disabled:hover,.woocommerce #respond input#submit.alt:disabled[disabled],.woocommerce #respond input#submit.alt:disabled[disabled]:hover,.woocommerce a.button.alt.disabled,.woocommerce a.button.alt.disabled:hover,.woocommerce a.button.alt:disabled,.woocommerce a.button.alt:disabled:hover,.woocommerce a.button.alt:disabled[disabled],.woocommerce a.button.alt:disabled[disabled]:hover,.woocommerce button.button.alt.disabled,.woocommerce button.button.alt.disabled:hover,.woocommerce button.button.alt:disabled,.woocommerce button.button.alt:disabled:hover,.woocommerce button.button.alt:disabled[disabled],.woocommerce button.button.alt:disabled[disabled]:hover,.woocommerce input.button.alt.disabled,.woocommerce input.button.alt.disabled:hover,.woocommerce input.button.alt:disabled,.woocommerce input.button.alt:disabled:hover,.woocommerce input.button.alt:disabled[disabled],.woocommerce input.button.alt:disabled[disabled]:hover,.edd-submit.button.azuma,.mini-account .edd-submit,.mini-account [type="submit"].edd-submit,.bx-wrapper .bx-controls-direction a:hover,#primary-menu li.highlight > a,.featured-post:hover .featured-icon,#footer-menu a[href^="mailto:"]:before,.widget_nav_menu a[href^="mailto:"]:before,#footer-menu a[href^="tel:"]:before,.widget_nav_menu a[href^="tel:"]:before,.bx-wrapper .bx-pager.bx-default-pager a:hover,.bx-wrapper .bx-pager.bx-default-pager a.active,#masthead .top-cart .mini-cart .edd-cart .edd_checkout a,ul.archive-sub-cats li{background:' . $hi_color . ';}';
			
			$css[] = '.woocommerce .sale-flash,.woocommerce ul.products li.product .sale-flash,#yith-quick-view-content .onsale,.woocommerce .widget_price_filter .ui-slider .ui-slider-range,.woocommerce .widget_price_filter .ui-slider .ui-slider-handle{background-color:' . $hi_color . ';}';
			
			$css[] = 'a,#masthead a.azuma-cart.items .azuma-icon-shopping-cart,#masthead a.azuma-cart.items .item-count,.site-title a,.site-title a:hover,.site-title a:active,.site-title a:focus,#primary-menu li.current-menu-item > a,.pagination a:hover,.pagination .current,.woocommerce nav.woocommerce-pagination ul li a:focus,.woocommerce nav.woocommerce-pagination ul li a:hover,.woocommerce nav.woocommerce-pagination ul li span.current,#wc-sticky-addtocart .options-button,#add_payment_method .cart-collaterals .cart_totals .discount td,.woocommerce-cart .cart-collaterals .cart_totals .discount td,.woocommerce-checkout .cart-collaterals .cart_totals .discount td,.infinite-loader{color:' . $hi_color . ';}';
			
			$css[] = '.top-search .mini-search,#masthead .top-account .mini-account,#masthead .top-cart .mini-cart,#primary-menu ul,.woocommerce-info,.woocommerce-message,.bx-wrapper .bx-pager.bx-default-pager a:hover,.bx-wrapper .bx-pager.bx-default-pager a.active{border-color:' . $hi_color . ';}';

			$css[] = '.featured-post:hover .featured-icon{box-shadow: 0px 0px 0px 4px rgba('.$hi_color_rgb['r'].','.$hi_color_rgb['g'].','.$hi_color_rgb['b'].',.5);}';

		}

		$hi_color2 = get_theme_mod( 'hi_color2', '#2d364c' );
		if ( $hi_color2 && $hi_color2 != '#2d364c' ) {
			$hi_color2 = esc_attr($hi_color2);
			$hi_color2_rgb = azuma_hex2RGB($hi_color2);
			
			$css[] = '.button:hover,a.button:hover,button:hover,input[type="button"]:hover,input[type="reset"]:hover,input[type="submit"]:hover,#infinite-handle span button:hover,.woocommerce #respond input#submit:hover,.woocommerce a.button:hover,.woocommerce button.button:hover,.woocommerce input.button:hover,.woocommerce #respond input#submit.alt:hover,.woocommerce a.button.alt:hover,.woocommerce button.button.alt:hover,.woocommerce input.button.alt:hover,.woocommerce a.added_to_cart,.woocommerce a.added_to_cart:hover,.edd-submit.button.azuma:hover,#grid-loop article:hover,#main.infinite-grid .infinite-wrap article:hover,.woocommerce ul.products li.product:hover,.woocommerce-page ul.products li.product:hover,.edd_download:hover,.single:not(.single-download) .entry-footer,aside,#shop-filters,.comment-navigation .nav-previous a,.comment-navigation .nav-next a,.top-search .mini-search,#masthead .top-account .mini-account,#masthead .top-cart .mini-cart,#home-hero-section .widget_media_image:before,#primary-menu ul,.posts-navigation,.post-navigation,.featured-post:hover,.featured-post .featured-icon{background:' . $hi_color2 . ';}';
			
			$css[] = '#masthead.not-full,#masthead.full.scrolled,#colophon{background-color:' . $hi_color2 . ';}';
			
			$css[] = '#grid-loop article:hover a.button:hover,#main.infinite-grid .infinite-wrap article:hover a.button:hover,.woocommerce ul.products li.product:hover a.button:hover,.woocommerce ul.products li.product:hover button.button:hover,.woocommerce ul.products li.product:hover input.button:hover,.woocommerce ul.products li.product:hover a.button.alt:hover,.woocommerce ul.products li.product:hover button.button.alt:hover,.woocommerce ul.products li.product:hover input.button.alt:hover,.woocommerce ul.products li.product:hover a.added_to_cart,.woocommerce ul.products li.product:hover a.added_to_cart:hover,.edd_download:hover .edd-submit.button.azuma:hover{color:' . $hi_color2 . ';}';
			
			$css[] = '.top-account p.mini-account-footer,#wc-sticky-addtocart{border-color:' . $hi_color2 . ';}';

			$css[] = '.sticky{border-top:5px solid ' . $hi_color2 . ';}';

			$css[] = '.comment-navigation .nav-next a:after{border-left:11px solid ' . $hi_color2 . ';}';

			$css[] = '.comment-navigation .nav-previous a:after{border-right:11px solid ' . $hi_color2 . ';}';

			$css[] = '.entry-header.with-image,.archive-header.with-image{background-color:rgba('.$hi_color2_rgb['r'].','.$hi_color2_rgb['g'].','.$hi_color2_rgb['b'].',.5);}';

			$css[] = '.entry-header .title-meta-wrapper,.archive-header .title-meta-wrapper{background:rgba('.$hi_color2_rgb['r'].','.$hi_color2_rgb['g'].','.$hi_color2_rgb['b'].',.7);}';

			$css[] = '.entry-header.with-image.full:before,.archive-header.with-image.full:before{background:rgba('.$hi_color2_rgb['r'].','.$hi_color2_rgb['g'].','.$hi_color2_rgb['b'].',.5);}';

			$css[] = '.featured-post .featured-icon{box-shadow: 0px 0px 0px 4px rgba('.$hi_color2_rgb['r'].','.$hi_color2_rgb['g'].','.$hi_color2_rgb['b'].',.5);}';

			$css[] = '@media only screen and (max-width: 1024px){#site-navigation{background:' . $hi_color2 . ';}}';
			
		}

		if ( get_theme_mod( 'header_search_off' ) ) {
			$css[] = '#masthead .top-search{display:none;}';
		}

		return implode( '', $css );

	}
}


if ( !function_exists( 'azuma_editor_dynamic_style' ) ) {
	function azuma_editor_dynamic_style( $mceInit, $css = array() ) {

		$font_content = get_theme_mod( 'font_content' );
		if ( $font_content ) {
			$css[] = 'body.mce-content-body{' . azuma_css_font_family( $font_content ) . ';}';
		}

		$font_headings = get_theme_mod( 'font_headings' );
		if ( $font_headings ) {
			$css[] = '.mce-content-body h1,.mce-content-body h2,.mce-content-body h3,.mce-content-body h4,.mce-content-body h5,.mce-content-body h6{' . azuma_css_font_family( $font_headings ) . ';}';
		}

		$hi_color = get_theme_mod( 'hi_color' );
		if ( $hi_color ) {
			$css[] = '.mce-content-body a:not(.button),.mce-content-body a:hover:not(.button),.mce-content-body a:focus:not(.button),.mce-content-body a:active:not(.button){color:' . esc_attr( $hi_color ) . '}';
		}

		$styles = implode( '', $css );

		if ( isset( $mceInit['content_style'] ) ) {
			$mceInit['content_style'] .= ' ' . $styles . ' ';
		} else {
			$mceInit['content_style'] = $styles . ' ';
		}
		return $mceInit;

	}
}
add_filter( 'tiny_mce_before_init', 'azuma_editor_dynamic_style' );


function azuma_block_editor_dynamic_style( $css = array() ) {

	$font_content = get_theme_mod( 'font_content', 'Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i' );
	if ($font_content && $font_content != 'Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i' ) {
		$css[] = '.editor-default-block-appender textarea.editor-default-block-appender__content,.editor-styles-wrapper p,.editor-styles-wrapper ul,.editor-styles-wrapper li{' . azuma_css_font_family( $font_content ) . ';}';
	}

	$font_headings = get_theme_mod( 'font_headings', 'Rajdhani:300,400,500,600,700' );
	if ($font_headings && $font_headings != 'Rajdhani:300,400,500,600,700' ) {
		$css[] = '.editor-post-title__block .editor-post-title__input,.editor-styles-wrapper h1,.editor-styles-wrapper h2,.editor-styles-wrapper h3,.editor-styles-wrapper h4,.editor-styles-wrapper h5,.editor-styles-wrapper h6{' . azuma_css_font_family( $font_headings ) . ';}';
	}

	$hi_color = get_theme_mod( 'hi_color' );
	if ($hi_color && $hi_color != "#ff7800") {		
		$css[] = '.editor-rich-text__tinymce a,.editor-rich-text__tinymce a:hover,.editor-rich-text__tinymce a:focus,.editor-rich-text__tinymce a:active{color:'.esc_attr($hi_color).'}';
	}

	return implode( '', $css );

}


function azuma_hex2RGB( $hex ) {
	$hex = str_replace("#", "", $hex);

	preg_match("/^#{0,1}([0-9a-f]{1,6})$/i",$hex,$match);
	if ( !isset( $match[1] ) ) {
		return false;
	}

	if ( strlen( $match[1] ) == 6 ) {
		list($r, $g, $b) = array($hex[0].$hex[1],$hex[2].$hex[3],$hex[4].$hex[5]);
	}
	elseif ( strlen($match[1]) == 3 ) {
		list($r, $g, $b) = array($hex[0].$hex[0],$hex[1].$hex[1],$hex[2].$hex[2]);
	}
	elseif ( strlen($match[1]) == 2 ) {
		list($r, $g, $b) = array($hex[0].$hex[1],$hex[0].$hex[1],$hex[0].$hex[1]);
	}
	elseif ( strlen($match[1]) == 1 ) {
		list($r, $g, $b) = array($hex.$hex,$hex.$hex,$hex.$hex);
	}
	else {
		return false;
	}

	$color = array();
	$color['r'] = hexdec($r);
	$color['g'] = hexdec($g);
	$color['b'] = hexdec($b);

	return $color;
}
