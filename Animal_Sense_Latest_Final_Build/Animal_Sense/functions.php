<?php
/**
 * Azuma functions and definitions
 *
 * @package Azuma
 */

if ( ! function_exists( 'azuma_setup' ) ) :

//Sets up theme defaults and registers support for various WordPress features

function azuma_setup() {
	// Make theme available for translation
	load_theme_textdomain( 'azuma', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );

	// Support for WooCommerce
	add_theme_support( 'woocommerce', array(
		'product_grid' => array(
			'min_columns' => 2,
			'max_columns' => 8,
		),
	) );

	//Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in two locations
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'azuma' ),
		'footer' => esc_html__( 'Footer Menu', 'azuma' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Enable support for post formats
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat',
	) );

	// Set up the WordPress core custom background feature
	add_theme_support( 'custom-background', apply_filters( 'azuma_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Enable support for Custom Logo
	add_theme_support( 'custom-logo', array(
		'width'		=> '',
		'height'	=> '',
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// Enable support for widgets selective refresh
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Style the visual editor to resemble the theme style
	add_editor_style( array( 'css/editor-style.css', azuma_editor_fonts_url() ) );

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Support for Gutenberg (5.0+ block editor)
	add_theme_support( 'align-wide' );

	// https://jetpack.com/support/infinite-scroll/
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer' => false,
	) );

}
endif; // azuma_setup
add_action( 'after_setup_theme', 'azuma_setup' );

function azuma_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'azuma_content_width', 1160 );
}
add_action( 'after_setup_theme', 'azuma_content_width', 0 );

// Set up the WordPress core custom header feature
function azuma_custom_header_setup() {
	register_default_headers( array(
		'fashion' => array(
			'url'           => '%s/images/header-image.jpg',
			'thumbnail_url' => '%s/images/header-image-th.jpg',
			'description'   => esc_html__( 'Photographer: Ylanite Koppens', 'azuma' ),
		),
		'mountains' => array(
			'url'           => '%s/images/header-image-2.jpg',
			'thumbnail_url' => '%s/images/header-image-2-th.jpg',
			'description'   => esc_html__( 'Photographer: Carl Cerstrand', 'azuma' ),
		),
	) );

	add_theme_support( 'custom-header', apply_filters( 'azuma_custom_header_args', array(
		'default-image'			=> get_template_directory_uri().'/images/header-image.jpg',
		'default-text-color'	=> 'ffffff',
		'header_text'			=> true,
		'width'					=> '1920',
		'height'				=> '500',
		'flex-height'			=> false,
		'flex-width'			=> false,
		'wp-head-callback'		=> '',
	) ) );
}
add_action( 'after_setup_theme', 'azuma_custom_header_setup' );

// Enables the Excerpt meta box in Page edit screen
function azuma_add_excerpt_support_for_pages() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'azuma_add_excerpt_support_for_pages' );

// Register widget area
function azuma_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Blog Sidebar', 'azuma' ),
		'id'            => 'azuma-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="sidebar-widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Page Sidebar', 'azuma' ),
		'id'            => 'azuma-sidebar-page',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="page-sidebar-widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Shop Sidebar', 'azuma' ),
		'id'            => 'azuma-sidebar-shop',
		'description'   => esc_html__( 'Requires WooCommerce plugin.', 'azuma' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="shop-sidebar-widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'EDD Sidebar', 'azuma' ),
		'id'            => 'azuma-sidebar-edd',
		'description'   => esc_html__( 'For EDD pages including checkout, Download archives, category, tags and search pages. Requires Easy Digital Downloads plugin.', 'azuma' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="edd-sidebar-widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Shop Filters', 'azuma' ),
		'id'            => 'azuma-sidebar-shop-filters',
		'description'   => esc_html__( 'Horizontal widget area for product archives. Requires WooCommerce plugin.', 'azuma' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="shop-filters-widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Top Bar', 'azuma' ),
		'id'            => 'azuma-top-bar',
		'description'   => esc_html__( 'Add your own content above the header.', 'azuma' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="top-bar-widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Offers Bar', 'azuma' ),
		'id'            => 'azuma-offers-bar',
		'description'   => esc_html__( 'Add your own content below the site masthead.', 'azuma' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="offers-bar-widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Homepage Slider/Hero Section', 'azuma' ),
		'id'            => 'azuma-homepage-large-area',
		'description'   => esc_html__( 'The large image/hero/slider area below the masthead on the homepage. Add more than one Image Widget to automatically create a slider.', 'azuma' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="hero-widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Top Footer', 'azuma' ),
		'description'   => esc_html__( 'Full width area above the footer columns.', 'azuma' ),
		'id'            => 'azuma-above-footer',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="above-footer-widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 1', 'azuma' ),
		'id'            => 'azuma-footer1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="footer-column-widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 2', 'azuma' ),
		'id'            => 'azuma-footer2',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="footer-column-widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 3', 'azuma' ),
		'id'            => 'azuma-footer3',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="footer-column-widget-title">',
		'after_title'   => '</h5>',
	) );

}
add_action( 'widgets_init', 'azuma_widgets_init' );

if ( ! function_exists( 'azuma_fonts_url' ) ) :
/**
 * Register Google fonts for Azuma
 * @return string Google fonts URL for the theme
 */
function azuma_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Google fonts: on or off', 'azuma' ) ) {

		$fonts[] = get_theme_mod( 'font_site_title', 'Rajdhani:300,400,500,600,700' );
		$fonts[] = get_theme_mod( 'font_nav', 'Rajdhani:300,400,500,600,700' );
		$fonts[] = get_theme_mod( 'font_content', 'Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i' );
		$fonts[] = get_theme_mod( 'font_headings', 'Rajdhani:300,400,500,600,700' );

		$fonts = str_replace('Arial, Helvetica, sans-serif', '', $fonts);
		$fonts = str_replace('Impact, Charcoal, sans-serif', '', $fonts);
		$fonts = str_replace('"Lucida Sans Unicode", "Lucida Grande", sans-serif', '', $fonts);
		$fonts = str_replace('Tahoma, Geneva, sans-serif', '', $fonts);
		$fonts = str_replace('"Trebuchet MS", Helvetica, sans-serif', '', $fonts);
		$fonts = str_replace('Verdana, Geneva, sans-serif', '', $fonts);
		$fonts = str_replace('Georgia, serif', '', $fonts);
		$fonts = str_replace('"Palatino Linotype", "Book Antiqua", Palatino, serif', '', $fonts);
		$fonts = str_replace('"Times New Roman", Times, serif', '', $fonts);

	}

	$fonts = array_filter( $fonts );

	if ( empty( $fonts ) ) {
		$google_fonts_empty = 1;
	} else {
		$google_fonts_empty = 0;
	}

	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'azuma' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $google_fonts_empty == 0 ) {
		$fonts_url = add_query_arg( array(
			'family' =>  urlencode( implode( '|', array_unique($fonts) ) ),
			'subset' =>  urlencode( $subsets ),
		), '//fonts.googleapis.com/css' );
		return esc_url_raw($fonts_url);
	} else {
		return;
	}
}
endif;

if ( ! function_exists( 'azuma_editor_fonts_url' ) ) :
/**
 * Register Google fonts for Azuma
 * @return string Google fonts URL for the tinyMCE editor
 */
function azuma_editor_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Google fonts: on or off', 'azuma' ) ) {

		$fonts[] = get_theme_mod( 'font_site_title', 'Rajdhani:300,400,500,600,700' );
		$fonts[] = get_theme_mod( 'font_nav', 'Rajdhani:300,400,500,600,700' );
		$fonts[] = get_theme_mod( 'font_content', 'Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i' );
		$fonts[] = get_theme_mod( 'font_headings', 'Rajdhani:300,400,500,600,700' );

		$fonts = str_replace('Arial, Helvetica, sans-serif', '', $fonts);
		$fonts = str_replace('Impact, Charcoal, sans-serif', '', $fonts);
		$fonts = str_replace('"Lucida Sans Unicode", "Lucida Grande", sans-serif', '', $fonts);
		$fonts = str_replace('Tahoma, Geneva, sans-serif', '', $fonts);
		$fonts = str_replace('"Trebuchet MS", Helvetica, sans-serif', '', $fonts);
		$fonts = str_replace('Verdana, Geneva, sans-serif', '', $fonts);
		$fonts = str_replace('Georgia, serif', '', $fonts);
		$fonts = str_replace('"Palatino Linotype", "Book Antiqua", Palatino, serif', '', $fonts);
		$fonts = str_replace('"Times New Roman", Times, serif', '', $fonts);

	}

	$fonts = array_filter( $fonts );

	if ( empty( $fonts ) ) {
		$google_fonts_empty = 1;
	} else {
		$google_fonts_empty = 0;
	}

	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'azuma' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $google_fonts_empty == 0 ) {
		$fonts_url = add_query_arg( array(
			'family' =>  urlencode( implode( '|', array_unique($fonts) ) ),
			'subset' =>  urlencode( $subsets ),
		), '//fonts.googleapis.com/css' );
		return esc_url_raw($fonts_url);
	} else {
		return;
	}
}
endif;

/**
 * Enqueue scripts and styles.
 */
function azuma_scripts() {
	wp_enqueue_script( 'imagesloaded' );
	wp_enqueue_script( 'jquery-bxslider', get_template_directory_uri() . '/js/jquery.bxslider.js', array( 'jquery' ), '4.1.2', true );
	wp_enqueue_script( 'azuma-custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'azuma-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '1.0', true );
	wp_enqueue_style( 'azuma-fonts', azuma_fonts_url(), array(), null );
	wp_enqueue_style( 'azuma-fontawesome', get_template_directory_uri() . '/fontawesome/css/all.min.css' );
	wp_enqueue_style( 'azuma-bx-slider', get_template_directory_uri() . '/css/bx-slider.css' );
	wp_enqueue_style( 'azuma-style', get_stylesheet_uri() );
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'azuma-customize-preview', get_template_directory_uri() . '/css/customize-preview.css' );
	}
	wp_add_inline_style( 'azuma-style', azuma_dynamic_style() );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'azuma_scripts' );

/**
 * Enqueue scripts and styles for Block Editor.
 */
function azuma_enqueue_gutenberg_block_editor_assets() {
	wp_enqueue_style( 'azuma-block-editor-fonts', azuma_editor_fonts_url() );
	wp_enqueue_style( 'azuma-block-editor-style', get_template_directory_uri() . '/css/block-editor-style.css' );
	wp_add_inline_style( 'azuma-block-editor-style', azuma_block_editor_dynamic_style() );
}
add_action( 'enqueue_block_editor_assets', 'azuma_enqueue_gutenberg_block_editor_assets' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/functions/template-tags.php';

/**
 * Custom functions.
 */
require get_template_directory() . '/functions/extras.php';
require get_template_directory() . '/functions/style-output.php';
require get_template_directory() . '/functions/header-title.php';
require get_template_directory() . '/functions/icons.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/functions/customizer.php';

/**
 * Theme help page.
 */
if ( is_admin() ) {
	require get_template_directory() . '/functions/theme-help.php';
}
