<?php
/**
 * Azuma Theme Customizer
 *
 * @package Azuma
 */

/**
 * @param WP_Customize_Manager $wp_customize Theme Customizer object
 */
function azuma_customize_register( $wp_customize ) {
	$wp_customize->get_setting('blogname')->transport         = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
	$wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

	$wp_customize->add_setting(
		'header_image_helper',
		array(
			'default'			=> '',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		new Azuma_Customize_Heading_Small(
			$wp_customize,
			'header_image_helper',
			array(
				'settings'		=> 'header_image_helper',
				'section'		=> 'header_image',
				'label'			=> esc_html__( 'See "Layout Options" > "Page Title Layout" for where the header image is used.', 'azuma' )
			)
		)
	);

	$wp_customize->add_setting(
		'hi_color',
		array(
			'default'			=> '#ff7800',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color'
		)
	);
	$wp_customize->add_control( 
		new WP_Customize_Color_Control(
			$wp_customize,
			'hi_color',
			array( 
				'label'      => esc_html__( 'Primary Color', 'azuma' ),
				'description'=> esc_html__( 'Site title, links, buttons and other highlights.', 'azuma' ),
				'settings'   => 'hi_color',
				'section'    => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'hi_color2',
		array(
			'default'			=> '#2d364c',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color'
		)
	);
	$wp_customize->add_control( 
		new WP_Customize_Color_Control(
			$wp_customize,
			'hi_color2',
			array( 
				'label'      => esc_html__( 'Secondary Color', 'azuma' ),
				'description'=> esc_html__( 'Header, sidebar, footer, posts (hover over) and products (hover over) background color.', 'azuma' ),
				'settings'   => 'hi_color2',
				'section'    => 'colors',
			)
		)
	);

	$wp_customize->add_section(
		'layout_options',
		array(
			'title'		=> esc_html__( 'Layout Options', 'azuma' ),
			'priority'	=> 26,
		)
	);

	$wp_customize->add_setting(
		'container_width',
		array(
			'default'			=> '1920',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
			'container_width',
			array(
				'settings'		=> 'container_width',
				'section'		=> 'layout_options',
				'label'			=> esc_html__( 'Container Width', 'azuma' ),
				'type'       	=> 'number',
				'input_attrs' => array(
                'min'   => 1120,
                'max'   => 2560,
                'step'  => 1,
            ),
			)
	);

	$wp_customize->add_setting(
		'header_search_off',
		array(
			'default'			=> 0,
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
			'header_search_off',
			array(
				'section'		=> 'layout_options',
				'label'			=> esc_html__( 'Disable Search Form in Header', 'azuma' ),
				'type'       	=> 'checkbox',
			)
	);

	$wp_customize->add_setting(
		'page_title_style',
		array(
			'default'			=> '',
			'sanitize_callback' => 'azuma_sanitize_radio_select'
		)
	);
	$wp_customize->add_control(
		new Azuma_Image_Radio_Control(
		$wp_customize,
		'page_title_style',
		array(
			'type' => 'radio',
			'label' => esc_html__( 'Page Title Layout', 'azuma' ),
			'description' => esc_html__( 'Large image header uses default "Header Image" or page/post "Featured Image" if available.', 'azuma' ),
			'section' => 'layout_options',
			'settings' => 'page_title_style',
			'choices' => array(
				'' => get_template_directory_uri() . '/images/header-title-style-1.png',
				'2' => get_template_directory_uri() . '/images/header-title-style-2.png',
				)
			)
		)
	);

	$wp_customize->add_setting(
		'grid_layout',
		array(
			'default'			=> '4',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'azuma_sanitize_radio_select'
		)
	);
	$wp_customize->add_control(
		new Azuma_Image_Radio_Control(
		$wp_customize,
		'grid_layout',
		array(
			'type' => 'radio',
			'label' => esc_html__( 'Blog - Grid Layout', 'azuma' ),
			'section' => 'layout_options',
			'settings' => 'grid_layout',
			'choices' => array(
				'1' => get_template_directory_uri() . '/images/mag-layout-1.png',
				'2' => get_template_directory_uri() . '/images/mag-layout-2.png',
				'3' => get_template_directory_uri() . '/images/mag-layout-3.png',
				'4' => get_template_directory_uri() . '/images/mag-layout-4.png',
				)
			)
		)
	);

	$wp_customize->add_setting(
		'archive_img_size',
		array(
			'default'			=> 'medium',
			'sanitize_callback'	=> 'azuma_sanitize_choices',
		)
	);
	$wp_customize->add_control(
		'archive_img_size',
		array(
			'label'		=> esc_html__( 'Blog - Posts Image Size', 'azuma' ),
			'description'	=> esc_html__( 'See: "Settings" > "Media" (or any active plugins that control image sizes)', 'azuma' ),
			'type'		=> 'select',
			'section'	=> 'layout_options',
			'choices' => azuma_image_size_options(),
		)
	);

	$wp_customize->add_setting(
		'sidebar_position',
		array(
			'default'			=> 'right',
			'sanitize_callback'	=> 'azuma_sanitize_choices',
		)
	);
	$wp_customize->add_control(
		'sidebar_position',
		array(
			'label'		=> esc_html__( 'Sidebar Position', 'azuma' ),
			'type'		=> 'select',
			'section'	=> 'layout_options',
			'choices'	=> array(
				'left'	=> esc_html__( 'Left', 'azuma' ),
				'right'	=> esc_html__( 'Right', 'azuma' ),
			),
		)
	);

	$wp_customize->add_setting(
		'sticky_footer',
		array(
			'default'			=> 0,
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
			'sticky_footer',
			array(
				'settings'		=> 'sticky_footer',
				'section'		=> 'layout_options',
				'label'			=> esc_html__( 'Enable Sticky Footer', 'azuma' ),
				'type'       	=> 'checkbox',
			)
	);



	$wp_customize->add_section(
		'homepage_options',
		array(
			'title'		=> esc_html__( 'Homepage Sections', 'azuma' ),
			'description'		=> esc_html__( 'You should first select a Static Homepage if you have not already done so. See: "Homepage Settings"', 'azuma' ),
			'priority'	=> 27,
		)
	);

	$wp_customize->add_setting(
		'woo_home_enable',
		array(
			'default'			=> 0,
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
			'woo_home_enable',
			array(
				'settings'		=> 'woo_home_enable',
				'section'		=> 'homepage_options',
				'label'			=> esc_html__( 'Activate Homepage Sections', 'azuma' ),
				'description'	=> esc_html__( 'Page Content is displayed by default if Homepage Sections is disabled.', 'azuma' ),
				'type'       	=> 'checkbox',
			)
	);

	$wp_customize->add_setting(
		'woo_home[tabs]',
		array(
			'default'			=> '',
			'sanitize_callback' => 'azuma_sanitize_woo_tabs',
			'transport'         => 'refresh',
			'capability'        => 'manage_options',
		)
	);

	$woo_home_choices = array();
	$woo_home_tabs = azuma_woo_home_tabs();
	foreach( $woo_home_tabs as $key => $val ){
		$woo_home_choices[$key] = $val['label'];
	}
	$wp_customize->add_control(
		new Azuma_Sortable_Checkboxes(
			$wp_customize,
			'woo_home',
			array(
				'section'     => 'homepage_options',
				'settings'    => 'woo_home[tabs]',
				'label'       => esc_html__( 'Homepage Sections', 'azuma' ),
				'description' => esc_html__( 'Check the box to display. Sortable: drag and drop into your preferred order.', 'azuma' ),
				'choices'     => $woo_home_choices,
			)
		)
	);

	$wp_customize->add_setting(
		'heading_featured_services',
		array(
			'default'			=> '',
			'sanitize_callback' => 'azuma_sanitize_text'
		)
	);
	$wp_customize->add_control(
		new Azuma_Customize_Heading_Large(
			$wp_customize,
			'heading_featured_services',
			array(
				'settings'		=> 'heading_featured_services',
				'section'		=> 'homepage_options',
				'label'			=> esc_html__( 'Featured Services', 'azuma' )
			)
		)
	);

	//FEATURES (MAX 3)
	for( $i = 1; $i < 4; $i++ ){
		$wp_customize->add_setting(
			'featured_header'.$i,
			array(
				'default'			=> '',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);
		$wp_customize->add_control(
			new Azuma_Customize_Heading_Small(
				$wp_customize,
				'featured_header'.$i,
				array(
					'settings'		=> 'featured_header'.$i,
					'section'		=> 'homepage_options',
					'label'			=> esc_html__( 'Feature ', 'azuma' ).$i
				)
			)
		);

		$wp_customize->add_setting(
			'featured_page_icon'.$i,
			array(
				'default'			=> azuma_featured_icon_defaults($i),
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);
		$wp_customize->add_control(
			new Azuma_Icon_Choices(
			$wp_customize,
			'featured_page_icon'.$i,
			array(
				'settings'		=> 'featured_page_icon'.$i,
				'section'		=> 'homepage_options',
				'type'			=> 'select',
				'label'			=> esc_html__( 'Icon', 'azuma' ),
				'description'	=> 'featuredpageicon'.$i //not for display, no translation as using only for unique element name
			)
			)
		);

		$wp_customize->add_setting(
			'featured_page_link'.$i,
			array(
				'default'			=> '',
				'sanitize_callback' => 'absint'
			)
		);
		$wp_customize->add_control(
			'featured_page_link'.$i,
			array(
				'settings'		=> 'featured_page_link'.$i,
				'section'		=> 'homepage_options',
				'type'			=> 'dropdown-pages',
				'label'			=> esc_html__( 'Select Page', 'azuma' ),
				'description'	=> esc_html__( 'Displays title and excerpt of selected page. You can add an optional hand-crafted excerpt in the page editor (make sure []excerpt is checked in Screen Options).', 'azuma' )
			)
		);
	}

	// SECTION - Typography
	$wp_customize->add_section(
		'typography',
		array(
			'title'		=> esc_html__( 'Typography & Fonts', 'azuma' ),
			'priority'	=> 42,
		)
	);

	// Setting - Font - Header
	$wp_customize->add_setting( 'font_site_title', array(
		'default'           => 'Rajdhani:300,400,500,600,700',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'azuma_sanitize_choices',
	) );
	$wp_customize->add_control( 'font_site_title', array(
		'label'   => esc_html__( 'Site Title', 'azuma' ),
		'type'    => 'select',
		'section' => 'typography',
		'choices' => azuma_google_fonts_array(),
	) );

	// Setting - Font - Navigation
	$wp_customize->add_setting( 'font_nav', array(
		'default'           => 'Rajdhani:300,400,500,600,700',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'azuma_sanitize_choices',
	) );
	$wp_customize->add_control( 'font_nav', array(
		'label'   => esc_html__( 'Navigation', 'azuma' ),
		'type'    => 'select',
		'section' => 'typography',
		'choices' => azuma_google_fonts_array(),
	) );

	// Setting - Font - Content
	$wp_customize->add_setting( 'font_content', array(
		'default'           => 'Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'azuma_sanitize_choices',
	) );
	$wp_customize->add_control( 'font_content', array(
		'label'   => esc_html__( 'Content', 'azuma' ),
		'type'    => 'select',
		'section' => 'typography',
		'choices' => azuma_google_fonts_array(),
	) );

	// Setting - Font - Headings
	$wp_customize->add_setting( 'font_headings', array(
		'default'           => 'Rajdhani:300,400,500,600,700',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'azuma_sanitize_choices',
	) );
	$wp_customize->add_control( 'font_headings', array(
		'label'   => esc_html__( 'Headings', 'azuma' ),
		'type'    => 'select',
		'section' => 'typography',
		'choices' => azuma_google_fonts_array(),
	) );

	$wp_customize->add_setting(
		'heading_font_site_title',
		array(
			'default'			=> '',
			'sanitize_callback' => 'azuma_sanitize_text'
		)
	);
	$wp_customize->add_control(
		new Azuma_Customize_Heading_Small(
			$wp_customize,
			'heading_font_site_title',
			array(
				'settings'		=> 'heading_font_site_title',
				'section'		=> 'typography',
				'label'			=> esc_html__( 'Site Title', 'azuma' )
			)
		)
	);

	$wp_customize->add_setting(
		'fs_site_title',
		array(
			'default'			=> '56',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
			'fs_site_title',
			array(
				'settings'		=> 'fs_site_title',
				'section'		=> 'typography',
				'label'			=> esc_html__( 'Size', 'azuma' ),
				'type'       	=> 'number',
				'input_attrs' => array(
                'min'   => 14,
                'max'   => 80,
                'step'  => 1,
            ),
			)
	);

	$wp_customize->add_setting(
		'fw_site_title',
		array(
			'default'			=> '700',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'azuma_sanitize_choices'
		)
	);
	$wp_customize->add_control(
		'fw_site_title',
		array(
			'label'		=> esc_html__( 'Weight', 'azuma' ),
			'type'		=> 'select',
			'section'	=> 'typography',
			'choices'	=> array( '100' => '100', '200' => '200', '300' => '300', '400' => '400', '500' => '500', '600' => '600', '700' => '700', '800' => '800', '900' => '900' )
		)
	);

	$wp_customize->add_setting(
		'ft_site_title',
		array(
			'default'			=> 'uppercase',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'azuma_sanitize_choices'
		)
	);
	$wp_customize->add_control(
		'ft_site_title',
		array(
			'label'		=> esc_html__( 'Transform', 'azuma' ),
			'type'		=> 'select',
			'section'	=> 'typography',
			'choices'	=> array( 'none' => esc_html__( 'none', 'azuma' ), 'capitalize' => esc_html__( 'capitalize', 'azuma' ), 'lowercase' => esc_html__( 'lowercase', 'azuma' ), 'uppercase' => esc_html__( 'uppercase', 'azuma' ),  )
		)
	);

	$wp_customize->add_setting(
		'fl_site_title',
		array(
			'default'			=> '2',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
			'fl_site_title',
			array(
				'settings'		=> 'fl_site_title',
				'section'		=> 'typography',
				'label'			=> esc_html__( 'Letter Spacing', 'azuma' ),
				'type'       	=> 'number',
				'input_attrs' => array(
                'min'   => -6,
                'max'   => 20,
                'step'  => 1,
            ),
			)
	);

	$wp_customize->add_setting(
		'heading_font_site_title_laptop',
		array(
			'default'			=> '',
			'sanitize_callback' => 'azuma_sanitize_text'
		)
	);
	$wp_customize->add_control(
		new Azuma_Customize_Heading_Small(
			$wp_customize,
			'heading_font_site_title_laptop',
			array(
				'settings'		=> 'heading_font_site_title_laptop',
				'section'		=> 'typography',
				'label'			=> esc_html__( 'Site Title', 'azuma' )
			)
		)
	);

	$wp_customize->add_setting(
		'fs_site_title_laptop',
		array(
			'default'			=> '56',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
			'fs_site_title_laptop',
			array(
				'settings'		=> 'fs_site_title_laptop',
				'section'		=> 'typography',
				'label'			=> esc_html__( 'Size', 'azuma' ),
				'type'       	=> 'number',
				'input_attrs' => array(
                'min'   => 14,
                'max'   => 80,
                'step'  => 1,
            ),
			)
	);

	$wp_customize->add_setting(
		'heading_font_site_title_tablet',
		array(
			'default'			=> '',
			'sanitize_callback' => 'azuma_sanitize_text'
		)
	);
	$wp_customize->add_control(
		new Azuma_Customize_Heading_Small(
			$wp_customize,
			'heading_font_site_title_tablet',
			array(
				'settings'		=> 'heading_font_site_title_tablet',
				'section'		=> 'typography',
				'label'			=> esc_html__( 'Site Title', 'azuma' )
			)
		)
	);

	$wp_customize->add_setting(
		'fs_site_title_tablet',
		array(
			'default'			=> '56',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
			'fs_site_title_tablet',
			array(
				'settings'		=> 'fs_site_title_tablet',
				'section'		=> 'typography',
				'label'			=> esc_html__( 'Size', 'azuma' ),
				'type'       	=> 'number',
				'input_attrs' => array(
                'min'   => 14,
                'max'   => 80,
                'step'  => 1,
            ),
			)
	);

	$wp_customize->add_setting(
		'heading_font_site_title_mobile',
		array(
			'default'			=> '',
			'sanitize_callback' => 'azuma_sanitize_text'
		)
	);
	$wp_customize->add_control(
		new Azuma_Customize_Heading_Small(
			$wp_customize,
			'heading_font_site_title_mobile',
			array(
				'settings'		=> 'heading_font_site_title_mobile',
				'section'		=> 'typography',
				'label'			=> esc_html__( 'Site Title', 'azuma' )
			)
		)
	);

	$wp_customize->add_setting(
		'fs_site_title_mobile',
		array(
			'default'			=> '56',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
			'fs_site_title_mobile',
			array(
				'settings'		=> 'fs_site_title_mobile',
				'section'		=> 'typography',
				'label'			=> esc_html__( 'Size', 'azuma' ),
				'type'       	=> 'number',
				'input_attrs' => array(
                'min'   => 14,
                'max'   => 80,
                'step'  => 1,
            ),
			)
	);


if ( function_exists( 'EDD' ) ) {

	// Section - EDD
	$wp_customize->add_section( 'edd_section' , array(
		'title'      => esc_html__( 'EDD Options', 'azuma' ),
		'priority'   => 80,
		'description' => esc_html__( 'Easy Digital Downloads options for Azuma theme. Requires Easy Digital Downloads plugin.', 'azuma' ),
	) );

	$wp_customize->add_setting(
		'edd_color_note',
		array(
			'default'			=> '',
			'sanitize_callback' => 'azuma_sanitize_text'
		)
	);
	$wp_customize->add_control(
		new Azuma_Customize_Heading_Small(
			$wp_customize,
			'edd_color_note',
			array(
				'settings'		=> 'edd_color_note',
				'section'		=> 'edd_section',
				'description'	=> esc_html__( 'Selecting "Azuma Theme" in Downloads > Settings > Styles > Default Button Color will make the EDD buttons follow the theme color/styling.', 'azuma' )
			)
		)
	);

	$wp_customize->add_setting(
		'edd_search',
		array(
			'default'			=> '',
			'sanitize_callback'	=> 'azuma_sanitize_choices',
		)
	);
	$wp_customize->add_control(
		'edd_search',
		array(
			'label'		=> esc_html__( 'Header Search', 'azuma' ),
			'description'		=> esc_html__( 'What should be searched for? Select downloads or all content.', 'azuma' ),
			'type'		=> 'select',
			'section'	=> 'edd_section',
			'choices'	=> array(
				''	=> esc_html__( 'Downloads', 'azuma' ),
				'all'	=> esc_html__( 'All content', 'azuma' ),
			),
		)
	);

	$wp_customize->add_setting(
		'edd_account_heading',
		array(
			'default'			=> '',
			'sanitize_callback' => 'azuma_sanitize_text'
		)
	);
	$wp_customize->add_control(
		new Azuma_Customize_Heading_Large(
			$wp_customize,
			'edd_account_heading',
			array(
				'settings'		=> 'edd_account_heading',
				'section'		=> 'edd_section',
				'label'			=> esc_html__( 'Header Account', 'azuma' )
			)
		)
	);

	$wp_customize->add_setting(
		'edd_account_heading_in',
		array(
			'default'			=> '',
			'sanitize_callback' => 'azuma_sanitize_text'
		)
	);
	$wp_customize->add_control(
		new Azuma_Customize_Heading_Small(
			$wp_customize,
			'edd_account_heading_in',
			array(
				'settings'		=> 'edd_account_heading_in',
				'section'		=> 'edd_section',
				'label'			=> esc_html__( 'User Logged In', 'azuma' )
			)
		)
	);

	$wp_customize->add_setting(
		'edd_account_page',
		array(
			'default'			=> '',
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
		'edd_account_page',
		array(
			'settings'		=> 'edd_account_page',
			'section'		=> 'edd_section',
			'type'			=> 'dropdown-pages',
			'label'			=> esc_html__( 'Customer Account/Profile Page', 'azuma' ),
			'description'	=> esc_html__( 'If you have created a customer account page, select it here and the account icon will link to it.', 'azuma' )
		)
	);

	$wp_customize->add_setting(
		'edd_purchase_history',
		array(
			'default'			=> 0,
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
		'edd_purchase_history',
		array(
			'section'		=> 'edd_section',
			'label'			=> esc_html__( 'Enable Purchase History in Account Dropdown', 'azuma' ),
			'type'       	=> 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'edd_download_history',
		array(
			'default'			=> 0,
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
		'edd_download_history',
		array(
			'section'		=> 'edd_section',
			'label'			=> esc_html__( 'Enable Download History in Account Dropdown', 'azuma' ),
			'type'       	=> 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'edd_profile',
		array(
			'default'			=> 0,
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
		'edd_profile',
		array(
			'section'		=> 'edd_section',
			'label'			=> esc_html__( 'Enable Profile Editor in Account Dropdown', 'azuma' ),
			'type'       	=> 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'edd_account_heading_out',
		array(
			'default'			=> '',
			'sanitize_callback' => 'azuma_sanitize_text'
		)
	);
	$wp_customize->add_control(
		new Azuma_Customize_Heading_Small(
			$wp_customize,
			'edd_account_heading_out',
			array(
				'settings'		=> 'edd_account_heading_out',
				'section'		=> 'edd_section',
				'label'			=> esc_html__( 'User Not Logged In', 'azuma' )
			)
		)
	);

	$wp_customize->add_setting(
		'edd_loginreg_page',
		array(
			'default'			=> '',
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
		'edd_loginreg_page',
		array(
			'settings'		=> 'edd_loginreg_page',
			'section'		=> 'edd_section',
			'type'			=> 'dropdown-pages',
			'label'			=> esc_html__( 'Customer Login/Registration Page', 'azuma' ),
			'description'	=> esc_html__( 'If you have created a customer login and registration page, select it here and the account icon will link to it.', 'azuma' )
		)
	);

	$wp_customize->add_setting(
		'edd_account_login',
		array(
			'default'			=> 0,
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
		'edd_account_login',
		array(
			'section'		=> 'edd_section',
			'label'			=> esc_html__( 'Enable Login Form in Account Dropdown', 'azuma' ),
			'type'       	=> 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'edd_account_reg',
		array(
			'default'			=> 0,
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
		'edd_account_reg',
		array(
			'section'		=> 'edd_section',
			'label'			=> esc_html__( 'Enable Registration Form in Account Dropdown', 'azuma' ),
			'type'       	=> 'checkbox',
		)
	);

	$wp_customize->add_control(
		new Azuma_Customize_Extra_Control(
			$wp_customize,
			'edd_account_reg_line',
			array(
				'section'   => 'edd_section',
				'type'      => 'line',
				'label'		=> '',
				'url'		=> '',
			)
		)
	);

	$wp_customize->add_setting(
		'grid_layout_edd',
		array(
			'default'			=> '4',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'azuma_sanitize_radio_select'
		)
	);
	$wp_customize->add_control(
		new Azuma_Image_Radio_Control(
		$wp_customize,
		'grid_layout_edd',
		array(
			'type' => 'radio',
			'label' => esc_html__( 'Downloads - Grid Layout', 'azuma' ),
			'description' => esc_html__( 'Download product archives, categories, search results. Note: pages using [downloads] shortcode should use columns option e.g. [downloads columns="4"]', 'azuma' ),
			'section' => 'edd_section',
			'settings' => 'grid_layout_edd',
			'choices' => array(
				'1' => get_template_directory_uri() . '/images/mag-layout-1.png',
				'2' => get_template_directory_uri() . '/images/mag-layout-2.png',
				'3' => get_template_directory_uri() . '/images/mag-layout-3.png',
				'4' => get_template_directory_uri() . '/images/mag-layout-4.png',
				)
			)
		)
	);

	$wp_customize->add_setting(
		'edd_archive_title',
		array(
			'default'			=> '',
			'sanitize_callback' => 'azuma_sanitize_text'
		)
	);
	$wp_customize->add_control(
		'edd_archive_title',
		array(
			'section'		=> 'edd_section',
			'label'			=> esc_html__( 'Downloads Archive Title', 'azuma' ),
			'description'	=> esc_html__( 'When you create at least one download, EDD creates a special "/downloads/" archive with "Downloads" page title. Change this here.', 'azuma' ),
			'type'       	=> 'text',
		)
	);

	$wp_customize->add_setting(
		'edd_archive_description',
		array(
			'default'			=> '',
			'sanitize_callback' => 'azuma_sanitize_text'
		)
	);
	$wp_customize->add_control(
		'edd_archive_description',
		array(
			'section'		=> 'edd_section',
			'label'			=> esc_html__( 'Downloads Archive Description', 'azuma' ),
			'type'       	=> 'textarea',
		)
	);

	$wp_customize->add_setting(
		'edd_archive_img_size',
		array(
			'default'			=> 'medium',
			'sanitize_callback'	=> 'azuma_sanitize_choices',
		)
	);
	$wp_customize->add_control(
		'edd_archive_img_size',
		array(
			'label'		=> esc_html__( 'Download Image Size', 'azuma' ),
			'description'	=> esc_html__( 'See: "Settings" > "Media" (or any active plugins that control image sizes)', 'azuma' ),
			'type'		=> 'select',
			'section'	=> 'edd_section',
			'choices' => azuma_image_size_options(),
		)
	);

	$wp_customize->add_setting(
		'edd_placeholder',
		array(
			'default'           => get_template_directory_uri() . '/images/edd-placeholder.png',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'edd_placeholder',
			array(
				'label'    => esc_html__( 'Download Placeholder Image', 'azuma' ),
				'section'  => 'edd_section',
			)
		)
	);

	$wp_customize->add_setting(
		'heading_edd_sidebar',
		array(
			'default'			=> '',
			'sanitize_callback' => 'azuma_sanitize_text'
		)
	);
	$wp_customize->add_control(
		new Azuma_Customize_Heading_Small(
			$wp_customize,
			'heading_edd_sidebar',
			array(
				'section'		=> 'edd_section',
				'label'			=> esc_html__( 'Sidebar', 'azuma' )
			)
		)
	);

	$wp_customize->add_setting(
		'edd_single_sidebar',
		array(
			'default'			=> 0,
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
		'edd_single_sidebar',
		array(
			'section'		=> 'edd_section',
			'label'			=> esc_html__( 'Enable EDD Sidebar on Single Download Pages', 'azuma' ),
			'type'       	=> 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'edd_shortcode_sidebar',
		array(
			'default'			=> 0,
			'sanitize_callback' => 'absint'
		)
	);
	$wp_customize->add_control(
		'edd_shortcode_sidebar',
		array(
			'section'		=> 'edd_section',
			'label'			=> esc_html__( 'Enable EDD Sidebar instead of Page Sidebar on Standard Pages containing the [downloads] Shortcode. Please note this can use a lot of resources if you have pages with a large amount of content.', 'azuma' ),
			'type'       	=> 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'heading_edd_sidebar2',
		array(
			'default'			=> '',
			'sanitize_callback' => 'azuma_sanitize_text'
		)
	);
	$wp_customize->add_control(
		new Azuma_Customize_Heading_Small(
			$wp_customize,
			'heading_edd_sidebar2',
			array(
				'section'		=> 'edd_section',
				'description'	=> esc_html__( 'Sidebar will only be visible if it contains active widget(s).', 'azuma' )
			)
		)
	);

	$wp_customize->add_setting(
		'heading_edd_sidebar3',
		array(
			'default'			=> '',
			'sanitize_callback' => 'azuma_sanitize_text'
		)
	);
	$wp_customize->add_control(
		new Azuma_Customize_Heading_Small(
			$wp_customize,
			'heading_edd_sidebar3',
			array(
				'section'		=> 'edd_section',
				'description'	=> esc_html__( 'See also "No Sidebar" template in page/download editor.', 'azuma' )
			)
		)
	);
}

	// Section - Go Pro
	$wp_customize->add_section( 'go_pro_sec' , array(
		'title'      => esc_html__( 'Go Pro', 'azuma' ),
		'priority'   => 1,
		'description' => esc_html__( 'Upgrade to Azuma Pro for even more cool features and customization options.', 'azuma' ),
	) );
	$wp_customize->add_control(
		new Azuma_Customize_Extra_Control(
			$wp_customize,
			'go_pro',
			array(
				'section'   => 'go_pro_sec',
				'type'      => 'pro-link',
				'label'		=> esc_html__( 'Go Pro', 'azuma' ),
				'url'		=> 'https://uxlthemes.com/theme/azuma-pro/',
				'priority'	=> 10
			)
		)
	);

}
add_action('customize_register', 'azuma_customize_register');


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function azuma_customize_preview_js() {
	wp_enqueue_script('azuma_customizer', get_template_directory_uri() . '/functions/js/customizer.js', array('customize-preview'), '1.0', true );
}
add_action('customize_preview_init', 'azuma_customize_preview_js');


function azuma_customizer_script() {
	wp_enqueue_script('azuma-customizer-script', get_template_directory_uri() .'/functions/js/customizer-scripts.js', array("jquery","jquery-ui-draggable"),'', true  );
	wp_enqueue_script('azuma-sortable-checkbox', get_template_directory_uri() . '/functions/js/azuma-sortable-checkbox.js', array( 'jquery', 'jquery-ui-sortable', 'customize-controls' ) );
	wp_enqueue_style( 'azuma-fontawesome', get_template_directory_uri() . '/fontawesome/css/all.min.css' );
	wp_enqueue_style('azuma-customizer-style', get_template_directory_uri() .'/functions/css/customizer-style.css');	
}
add_action('customize_controls_enqueue_scripts', 'azuma_customizer_script');


if( class_exists('WP_Customize_Control') ):

class Azuma_Image_Radio_Control extends WP_Customize_Control {

	public function render_content() {

		if ( empty( $this->choices ) )
			return;

		$name = '_customize-radio-' . $this->id;

		?>
		<style>
			#azuma-img-container-<?php echo $this->id; ?> .azuma-radio-img-img {
			border: 2px solid #f5f5f5;
			cursor: pointer;
			margin: 0 4px 4px 0;
			}
			#azuma-img-container-<?php echo $this->id; ?> .azuma-radio-img-selected {
			border: 2px solid #0085BA;
			margin: 0 4px 4px 0;
			}
			input[type=checkbox]:before {
			content: '';
			margin: -3px 0 0 -4px;
			}
		</style>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<?php if ( $this->description ) {
			echo '<span class="customize-control-description">' . esc_html( $this->description ) . '</span>';
		}
		?>
		<ul class="controls" id='azuma-img-container-<?php echo $this->id; ?>'>
		<?php
		foreach ( $this->choices as $value => $label ) :
			$class = ($this->value() == $value)?'azuma-radio-img-selected azuma-radio-img-img':'azuma-radio-img-img';
			?>
			<li style="display: inline;">
				<label>
					<input <?php $this->link(); ?>style='display:none' type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
					<img src = '<?php echo esc_html( $label ); ?>' class = '<?php echo esc_html( $class ); ?>' />
				</label>
			</li>
			<?php
			endforeach;
		?>
		</ul>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('.controls#azuma-img-container-<?php echo $this->id; ?> li img').click(function(){
					$('.controls#azuma-img-container-<?php echo $this->id; ?> li').each(function(){
						$(this).find('img').removeClass ('azuma-radio-img-selected') ;
				});
				$(this).addClass ('azuma-radio-img-selected') ;
				});
			});
		</script>
	<?php
	}
}


class Azuma_Icon_Choices extends WP_Customize_Control{
	public $type = 'icon';

	public function render_content(){
		$func_append = $this->description;
		?>
            <label>
                <span class="customize-control-title">
                <?php echo esc_html( $this->label ); ?>
                </span>

                <div class="selected-icon">
                	<i class="<?php echo esc_attr($this->value()); ?>"></i>
                	<span><i class="fa fa-angle-down"></i></span>
                </div>

                <ul id="icon-box<?php echo esc_html( $func_append ); ?>" class="icon-list">
				<form class="icon-search-input" action="#">
					<input id="input<?php echo esc_html( $func_append ); ?>" class="" type="text" placeholder="<?php esc_html_e( 'Search...', 'azuma' ); ?>">
				</form>
                	<?php
                	$fontawesome_array = azuma_fontawesome_array_all();
                	foreach ($fontawesome_array as $fontawesome_array_single) {
							$icon_class = $this->value() == $fontawesome_array_single ? 'icon-active' : '';
								if ($fontawesome_array_single == 'not-a-real-icon') {
									$zero_icon = 'NONE';
									$b_class = ' class="visible"';
								} else {
									$zero_icon = $fontawesome_array_single;
									$b_class = '';
								}
							echo '<li class='.esc_html($icon_class).'><i class="'.esc_html($fontawesome_array_single).'"></i><b'.$b_class.'>'.esc_html($zero_icon).'</b></li>';
						}
                	?>
                </ul>
                <input type="hidden" value="<?php $this->value(); ?>" <?php $this->link(); ?> />

<script>
(function ($) {
	$(function () {
		azumaListFilter($("#icon-box<?php echo esc_html( $func_append ); ?>"), $("#input<?php echo esc_html( $func_append ); ?>"));
	});
}(jQuery));
</script>

            </label>
		<?php
	}
}


class Azuma_Customize_Heading_Large extends WP_Customize_Control {
    public function render_content() {
    	?>

        <?php if ( !empty( $this->label ) ) : ?>
            <h3 class="azuma-accordion-section-title"><?php echo esc_html( $this->label ); ?></h3>
        <?php endif; ?>
        <?php if ( !empty( $this->description ) ) : ?>
            <p class="azuma-accordion-section-paragraph"><?php echo esc_html( $this->description ); ?></p>
        <?php endif; ?>
    <?php }
}


class Azuma_Customize_Heading_Small extends WP_Customize_Control {
    public function render_content() {
    	?>

        <?php if ( !empty( $this->label ) ) : ?>
            <h5 class="azuma-accordion-section-title"><?php echo esc_html( $this->label ); ?></h5>
        <?php endif; ?>
        <?php if ( !empty( $this->description ) ) : ?>
            <p class="azuma-accordion-section-paragraph"><?php echo esc_html( $this->description ); ?></p>
        <?php endif; ?>
    <?php }
}


class Azuma_Customize_Extra_Control extends WP_Customize_Control {
	public $settings = 'blogname';
	public $description = '';
	public $url = '';
	public $group = '';

	public function render_content() {
		switch ( $this->type ) {
			default:

			case 'extra':
				echo '<p style="margin-top:40px;">' . sprintf(
							'<a href="%1$s" target="_blank">%2$s</a>',
							esc_url( $this->url ),
							esc_html__( 'More options available', 'azuma' )
						) . '</p>';
				echo '<p class="description" style="margin-top:5px;">' . $this->description . '</p>';
				break;

			case 'docs':
				echo sprintf(
							'<a href="%1$s" class="button-primary" target="_blank">%2$s</a>',
							esc_url( $this->url ),
							esc_html__( 'Documentation', 'azuma' )
						);
				break;

			case 'pro-link':
				echo sprintf(
							'<a href="%1$s" class="button-primary" target="_blank">%2$s</a>',
							esc_url( $this->url ),
							esc_html__( 'Go Pro', 'azuma' )
						);
				break;
					
			case 'line' :
				echo '<hr />';
				break;
		}
	}
}


/**
 * Sortable multi check boxes custom control.
 * @since 0.1.0
 * @author David Chandra Purnama <david@genbu.me>
 * @copyright Copyright (c) 2015, Genbu Media
 * @license https://www.gnu.org/licenses/gpl-2.0.html
 */
class Azuma_Sortable_Checkboxes extends WP_Customize_Control {
	/**
	 * Control Type
	 */
	public $type = 'azuma-multicheck-sortable';
	/**
	 * Enqueue Scripts
	 */
	public function enqueue() {
		wp_enqueue_style( 'azuma-customize' );
		wp_enqueue_script( 'azuma-customize' );
	}
	/**
	 * Render Settings
	 */
	public function render_content() {
		/* if no choices, bail. */
		if ( empty( $this->choices ) ){
			return;
		} ?>

		<?php if ( !empty( $this->label ) ){ ?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<?php } // add label if needed. ?>

		<?php if ( !empty( $this->description ) ){ ?>
			<span class="description customize-control-description"><?php echo $this->description; ?></span>
		<?php } // add desc if needed. ?>

		<?php
		/* Data */
		$values = explode( ',', $this->value() );
		$choices = $this->choices;
		/* If values exist, use it. */
		$options = array();
		if( $values ){
			/* get individual item */
			foreach( $values as $value ){
				/* separate item with option */
				$value = explode( ':', $value );
				/* build the array. remove options not listed on choices. */
				if ( array_key_exists( $value[0], $choices ) ){
					$options[$value[0]] = $value[1] ? '1' : '0'; 
				}
			}
		}
		/* if there's new options (not saved yet), add it in the end. */
		foreach( $choices as $key => $val ){
			/* if not exist, add it in the end. */
			if ( ! array_key_exists( $key, $options ) ){
				$options[$key] = '0'; // use zero to deactivate as default for new items.
			}
		}
		?>

		<ul class="azuma-multicheck-sortable-list">

			<?php foreach ( $options as $key => $value ){ ?>

				<li>
					<label>
						<input name="<?php echo esc_attr( $key ); ?>" class="azuma-multicheck-sortable-item" type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php checked( $value ); ?> /> 
						<?php echo esc_html( $choices[$key] ); ?>
					</label>
					<i class="dashicons dashicons-menu azuma-multicheck-sortable-handle"></i>
				</li>

			<?php } // end choices. ?>

				<li class="azuma-hideme">
					<input type="hidden" class="azuma-multicheck-sortable" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" />
				</li>

		</ul>


	<?php
	}
}


endif;


/**
 * Sanitization functions
 */

function azuma_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}


function azuma_sanitize_choices( $input, $setting ) {
    global $wp_customize;
 
    $control = $wp_customize->get_control( $setting->id );
 
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}


function azuma_sanitize_radio_select( $input, $setting ) {
	// Ensuring that the input is a slug.
	$input = sanitize_key( $input );
	// Get the list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	// If the input is a valid key, return it, else, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}


function azuma_sanitize_woo_tabs( $input ){

	/* Var */
	$output = array();

	/* Get valid tabs */
	$valid_tabs = azuma_woo_home_tabs();

	/* Make array */
	$tabs = explode( ',', $input );

	/* Bail. */
	if( ! $tabs ){
		return null;
	}

	/* Loop and verify */
	foreach( $tabs as $tab ){

		/* Separate tab and status */
		$tab = explode( ':', $tab );

		if( isset( $tab[0] ) && isset( $tab[1] ) ){
			if( array_key_exists( $tab[0], $valid_tabs ) ){
				$status = $tab[1] ? '1' : '0';
				$output[] = trim( $tab[0] . ':' . $status );
			}
		}

	}

	return trim( esc_attr( implode( ',', $output ) ) );
}


function azuma_get_image_sizes() {
	global $_wp_additional_image_sizes;

	$sizes = array();

	foreach ( get_intermediate_image_sizes() as $_size ) {
		if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
			$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
			$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
			$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
		} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
			$sizes[ $_size ] = array(
				'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
				'height' => $_wp_additional_image_sizes[ $_size ]['height'],
				'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
			);
		}
	}

	return $sizes;
}

function azuma_image_size_options() {
	$image_size_configs = azuma_get_image_sizes();
	// Hardcoded 'full' because not a registered image size
	// 'full' will result in the original uploaded image size being used
	$sizes = array(
		'full' => esc_html__( 'Full (original full size image)', 'azuma' ),
	);
	foreach( $image_size_configs as $name => $size_config) {
		if ( $size_config['crop'] == 1 ) {
			$hardcrop = esc_html__( '(exact dimensions)', 'azuma' );
		} else {
			$hardcrop = esc_html__( '(proportional)', 'azuma' );
		}
		$sizes[$name] = ucwords(preg_replace('/[-_]/', ' ', $name)) . ' (' . $size_config['width'] . 'x' . $size_config['height'] . ') ' . $hardcrop;
	}

	return $sizes;
}
