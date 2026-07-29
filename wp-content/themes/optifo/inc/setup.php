<?php
/**
 * Theme setup.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function optifo_setup() {
	load_theme_textdomain( 'optifo', OPTIFO_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 80,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );

	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'optifo' ),
		'footer'  => esc_html__( 'Footer Menu', 'optifo' ),
	) );

	add_image_size( 'optifo-hero', 1200, 800, true );
	add_image_size( 'optifo-card', 600, 400, true );
	add_image_size( 'optifo-portfolio', 800, 600, true );
}
add_action( 'after_setup_theme', 'optifo_setup' );

/**
 * Set content width.
 */
function optifo_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'optifo_content_width', 1200 );
}
add_action( 'after_setup_theme', 'optifo_content_width', 0 );

/**
 * Register widget areas.
 */
function optifo_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'optifo' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Main sidebar.', 'optifo' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s mb-4">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title font-montserrat font-18 fw-semibold mb-3">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 1', 'optifo' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Footer widget area 1.', 'optifo' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6 class="font-14 font-montserrat fw-semibold mb-4 text-uppercase">',
		'after_title'   => '</h6>',
	) );
}
add_action( 'widgets_init', 'optifo_widgets_init' );
