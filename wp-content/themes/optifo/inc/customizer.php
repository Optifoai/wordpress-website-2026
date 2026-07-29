<?php
/**
 * Theme Customizer.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function optifo_customize_register( $wp_customize ) {
	$wp_customize->add_panel( 'optifo_theme_panel', array(
		'title'    => __( 'Optifo Theme', 'optifo' ),
		'priority' => 30,
	) );

	// Colors.
	$wp_customize->add_section( 'optifo_colors', array(
		'title' => __( 'Colors', 'optifo' ),
		'panel' => 'optifo_theme_panel',
	) );
	$wp_customize->add_setting( 'optifo_color_primary', array(
		'default'           => '#EA645F',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'optifo_color_primary', array(
		'label'   => __( 'Primary Color', 'optifo' ),
		'section' => 'optifo_colors',
	) ) );
	$wp_customize->add_setting( 'optifo_color_secondary', array(
		'default'           => '#111D40',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'optifo_color_secondary', array(
		'label'   => __( 'Secondary Color', 'optifo' ),
		'section' => 'optifo_colors',
	) ) );

	// Typography.
	$wp_customize->add_section( 'optifo_typography', array(
		'title' => __( 'Typography', 'optifo' ),
		'panel' => 'optifo_theme_panel',
	) );
	$wp_customize->add_setting( 'optifo_body_font', array(
		'default'           => 'Montserrat',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'optifo_body_font', array(
		'label'   => __( 'Body Font Family', 'optifo' ),
		'section' => 'optifo_typography',
		'type'    => 'select',
		'choices' => array(
			'Montserrat' => 'Montserrat',
			'Poppins'    => 'Poppins',
			'Raleway'    => 'Raleway',
			'Oswald'     => 'Oswald',
		),
	) );

	// Header.
	$wp_customize->add_section( 'optifo_header', array(
		'title' => __( 'Header', 'optifo' ),
		'panel' => 'optifo_theme_panel',
	) );
	$wp_customize->add_setting( 'optifo_site_tagline', array(
		'default'           => __( 'Optimize your online showroom', 'optifo' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'optifo_site_tagline', array(
		'label'   => __( 'Site Tagline', 'optifo' ),
		'section' => 'optifo_header',
		'type'    => 'text',
	) );
	$wp_customize->add_setting( 'optifo_header_login_text', array(
		'default'           => 'LOGIN',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'optifo_header_login_text', array(
		'label'   => __( 'Login Button Text', 'optifo' ),
		'section' => 'optifo_header',
		'type'    => 'text',
	) );
	$wp_customize->add_setting( 'optifo_header_login_url', array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'optifo_header_login_url', array(
		'label'   => __( 'Login Button URL', 'optifo' ),
		'section' => 'optifo_header',
		'type'    => 'url',
	) );

	// Footer.
	$wp_customize->add_section( 'optifo_footer', array(
		'title' => __( 'Footer', 'optifo' ),
		'panel' => 'optifo_theme_panel',
	) );
	$wp_customize->add_setting( 'optifo_footer_copyright', array(
		'default'           => '© Copyright 2025 Optifo ApS, All Rights Reserved.',
		'sanitize_callback' => 'wp_kses_post',
	) );
	$wp_customize->add_control( 'optifo_footer_copyright', array(
		'label'   => __( 'Copyright Text', 'optifo' ),
		'section' => 'optifo_footer',
		'type'    => 'textarea',
	) );

	// Social.
	$wp_customize->add_section( 'optifo_social', array(
		'title' => __( 'Social Media', 'optifo' ),
		'panel' => 'optifo_theme_panel',
	) );
	$networks = array( 'facebook', 'instagram', 'youtube', 'whatsapp', 'tiktok' );
	foreach ( $networks as $network ) {
		$wp_customize->add_setting( 'optifo_social_' . $network, array(
			'default'           => '#',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( 'optifo_social_' . $network, array(
			'label'   => ucfirst( $network ) . ' URL',
			'section' => 'optifo_social',
			'type'    => 'url',
		) );
	}

	// Contact.
	$wp_customize->add_section( 'optifo_contact', array(
		'title' => __( 'Contact Details', 'optifo' ),
		'panel' => 'optifo_theme_panel',
	) );
	$wp_customize->add_setting( 'optifo_contact_email', array(
		'default'           => 'info@optifo.com',
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'optifo_contact_email', array(
		'label'   => __( 'Email', 'optifo' ),
		'section' => 'optifo_contact',
		'type'    => 'email',
	) );
	$wp_customize->add_setting( 'optifo_contact_phone', array(
		'default'           => 'Tel. +45 28 49 50 60',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'optifo_contact_phone', array(
		'label'   => __( 'Phone', 'optifo' ),
		'section' => 'optifo_contact',
		'type'    => 'text',
	) );
}
add_action( 'customize_register', 'optifo_customize_register' );
