<?php
/**
 * Homepage section loader.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Map section ID to template part slug.
 *
 * @return array
 */
function optifo_section_template_map() {
	return array(
		'hero'            => 'hero',
		'counter'         => 'sections/counter',
		'why_use'         => 'sections/why-use',
		'how_it_works'    => 'sections/how-it-works',
		'web_mobile'      => 'sections/web-mobile',
		'store_buttons'   => 'sections/store-buttons',
		'dashboard'       => 'sections/dashboard',
		'pricing'         => 'pricing',
		'featured_in'     => 'sections/featured-in',
		'studio_quality'  => 'sections/studio-quality',
		'behind_design'   => 'sections/behind-design',
		'worldwide_trust' => 'testimonials',
		'contact'         => 'contact',
		'faqs'            => 'sections/faqs',
		'services'        => 'services',
	);
}

/**
 * Render a homepage section.
 *
 * @param string $section_id Section identifier.
 */
function optifo_render_section( $section_id ) {
	$map  = optifo_section_template_map();
	$slug = $map[ $section_id ] ?? 'sections/' . str_replace( '_', '-', $section_id );

	$path = locate_template( 'template-parts/' . $slug . '.php' );
	if ( $path ) {
		$section_data = optifo_get_section_data( $section_id );
		set_query_var( 'optifo_section', $section_data );
		set_query_var( 'optifo_section_id', $section_id );
		load_template( $path, false );
	}
}

/**
 * Render all homepage sections in order.
 */
function optifo_render_homepage() {
	foreach ( optifo_get_homepage_sections() as $section ) {
		if ( empty( $section['id'] ) ) {
			continue;
		}
		optifo_render_section( $section['id'] );
	}
}
