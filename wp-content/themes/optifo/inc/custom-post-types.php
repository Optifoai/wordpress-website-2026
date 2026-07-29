<?php
/**
 * Custom Post Types.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register all custom post types.
 */
function optifo_register_post_types() {
	$post_types = array(
		'optifo_service' => array(
			'labels' => array(
				'name'          => __( 'Services', 'optifo' ),
				'singular_name' => __( 'Service', 'optifo' ),
				'add_new_item'  => __( 'Add New Service', 'optifo' ),
			),
			'menu_icon' => 'dashicons-hammer',
			'supports'  => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
		),
		'optifo_testimonial' => array(
			'labels' => array(
				'name'          => __( 'Testimonials', 'optifo' ),
				'singular_name' => __( 'Testimonial', 'optifo' ),
			),
			'menu_icon' => 'dashicons-format-quote',
			'supports'  => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		),
		'optifo_team' => array(
			'labels' => array(
				'name'          => __( 'Team', 'optifo' ),
				'singular_name' => __( 'Team Member', 'optifo' ),
			),
			'menu_icon' => 'dashicons-groups',
			'supports'  => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		),
		'optifo_portfolio' => array(
			'labels' => array(
				'name'          => __( 'Portfolio', 'optifo' ),
				'singular_name' => __( 'Portfolio Item', 'optifo' ),
			),
			'menu_icon' => 'dashicons-portfolio',
			'supports'  => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
		),
		'optifo_faq' => array(
			'labels' => array(
				'name'          => __( 'FAQs', 'optifo' ),
				'singular_name' => __( 'FAQ', 'optifo' ),
			),
			'menu_icon' => 'dashicons-editor-help',
			'supports'  => array( 'title', 'editor', 'page-attributes' ),
		),
		'optifo_pricing' => array(
			'labels' => array(
				'name'          => __( 'Pricing Plans', 'optifo' ),
				'singular_name' => __( 'Pricing Plan', 'optifo' ),
			),
			'menu_icon' => 'dashicons-money-alt',
			'supports'  => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		),
		'optifo_case_study' => array(
			'labels' => array(
				'name'          => __( 'Case Studies', 'optifo' ),
				'singular_name' => __( 'Case Study', 'optifo' ),
			),
			'menu_icon' => 'dashicons-analytics',
			'supports'  => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
		),
	);

	foreach ( $post_types as $post_type => $args ) {
		register_post_type( $post_type, array_merge( array(
			'public'       => true,
			'has_archive'  => true,
			'show_in_rest' => true,
			'rewrite'      => array( 'slug' => str_replace( 'optifo_', '', $post_type ) ),
		), $args ) );
	}
}
add_action( 'init', 'optifo_register_post_types' );
