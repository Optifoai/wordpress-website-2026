<?php
/**
 * Custom Taxonomies.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register taxonomies.
 */
function optifo_register_taxonomies() {
	register_taxonomy( 'service_category', 'optifo_service', array(
		'labels'       => array(
			'name'          => __( 'Service Categories', 'optifo' ),
			'singular_name' => __( 'Service Category', 'optifo' ),
		),
		'hierarchical' => true,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'service-category' ),
	) );

	register_taxonomy( 'portfolio_category', 'optifo_portfolio', array(
		'labels'       => array(
			'name'          => __( 'Portfolio Categories', 'optifo' ),
			'singular_name' => __( 'Portfolio Category', 'optifo' ),
		),
		'hierarchical' => true,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'portfolio-category' ),
	) );

	register_taxonomy( 'case_study_tag', 'optifo_case_study', array(
		'labels'       => array(
			'name'          => __( 'Case Study Tags', 'optifo' ),
			'singular_name' => __( 'Case Study Tag', 'optifo' ),
		),
		'hierarchical' => false,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'case-study-tag' ),
	) );

	register_taxonomy( 'faq_category', 'optifo_faq', array(
		'labels'       => array(
			'name'          => __( 'FAQ Categories', 'optifo' ),
			'singular_name' => __( 'FAQ Category', 'optifo' ),
		),
		'hierarchical' => true,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'faq-category' ),
	) );
}
add_action( 'init', 'optifo_register_taxonomies' );
