<?php
/**
 * Theme options registration (used with admin settings pages).
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register theme option settings.
 */
function optifo_register_settings() {
	register_setting( 'optifo_theme_options_group', 'optifo_theme_options', 'optifo_sanitize_theme_options' );
	register_setting( 'optifo_homepage_group', 'optifo_homepage_sections', 'optifo_sanitize_homepage_sections' );

	if ( function_exists( 'optifo_get_all_section_defaults' ) ) {
		$sections = array_keys( optifo_get_all_section_defaults() );
	} else {
		$sections = array( 'hero', 'counter', 'why_use', 'how_it_works', 'web_mobile', 'store_buttons', 'dashboard', 'pricing', 'featured_in', 'studio_quality', 'behind_design', 'worldwide_trust', 'contact', 'faqs' );
	}
	foreach ( $sections as $section_id ) {
		register_setting( 'optifo_homepage_group', 'optifo_section_' . $section_id, 'optifo_sanitize_section_data' );
	}

	register_setting( 'optifo_theme_options_group', 'optifo_map_locations', 'optifo_sanitize_repeater' );
}
add_action( 'admin_init', 'optifo_register_settings' );

/**
 * Sanitize theme options array.
 *
 * @param array $input Raw input.
 * @return array
 */
function optifo_sanitize_theme_options( $input ) {
	if ( ! is_array( $input ) ) {
		return array();
	}
	$clean = array();
	$text  = array( 'site_name', 'header_login_text', 'header_login_url', 'seo_description', 'seo_keywords', 'contact_email', 'contact_phone', 'map_center_lat', 'map_center_lng', 'app_store_url', 'play_store_url', 'recaptcha_site_key', 'recaptcha_secret_key' );
	foreach ( $text as $key ) {
		if ( isset( $input[ $key ] ) ) {
			$clean[ $key ] = 'contact_email' === $key ? sanitize_email( $input[ $key ] ) : sanitize_text_field( $input[ $key ] );
		}
	}
	if ( isset( $input['seo_og_image'] ) ) {
		$clean['seo_og_image'] = absint( $input['seo_og_image'] );
	}
	if ( isset( $input['map_zoom'] ) ) {
		$clean['map_zoom'] = absint( $input['map_zoom'] );
	}
	if ( isset( $input['analytics_code'] ) ) {
		$clean['analytics_code'] = wp_kses_post( $input['analytics_code'] );
	}
	foreach ( array( 'facebook', 'instagram', 'youtube', 'whatsapp', 'tiktok' ) as $social ) {
		if ( isset( $input[ 'social_' . $social ] ) ) {
			$clean[ 'social_' . $social ] = esc_url_raw( $input[ 'social_' . $social ] );
		}
	}
	return $clean;
}

/**
 * Sanitize homepage section order.
 *
 * @param array $input Sections.
 * @return array
 */
function optifo_sanitize_homepage_sections( $input ) {
	if ( ! is_array( $input ) ) {
		return optifo_default_homepage_sections();
	}
	$clean = array();
	foreach ( $input as $section ) {
		$clean[] = array(
			'id'      => sanitize_key( $section['id'] ?? '' ),
			'enabled' => ! empty( $section['enabled'] ) ? 1 : 0,
			'order'   => absint( $section['order'] ?? 0 ),
		);
	}
	return $clean;
}

/**
 * Sanitize section content option.
 *
 * @param array $input Section data.
 * @return array
 */
function optifo_sanitize_section_data( $input ) {
	if ( ! is_array( $input ) ) {
		return array();
	}
	$clean = array();
	$clean['enabled'] = ! empty( $input['enabled'] ) ? 1 : 0;
	$text_keys        = array(
		'title', 'subtitle', 'heading_light', 'heading_bold', 'heading_bold_2', 'heading_bold_line2', 'heading_light_2', 'heading_middle',
		'title_light', 'title_bold', 'title_end', 'price_label', 'price_subtitle', 'description', 'badge_text', 'video_url',
		'button_text', 'button_url', 'button2_text', 'button2_url', 'type', 'before', 'after', 'fallback', 'bg', 'bg_color',
	);
	foreach ( $text_keys as $key ) {
		if ( isset( $input[ $key ] ) ) {
			$clean[ $key ] = sanitize_text_field( $input[ $key ] );
		}
	}
	$html_keys = array( 'content', 'footnote' );
	foreach ( $html_keys as $key ) {
		if ( isset( $input[ $key ] ) ) {
			$clean[ $key ] = wp_kses_post( $input[ $key ] );
		}
	}
	$image_keys = array( 'image', 'image_before', 'image_after', 'banner_image', 'poster', 'icon' );
	foreach ( $image_keys as $key ) {
		if ( isset( $input[ $key ] ) ) {
			$clean[ $key ] = absint( $input[ $key ] );
		}
	}
	if ( isset( $input['cards'] ) ) {
		$clean['cards'] = optifo_sanitize_repeater( $input['cards'] );
	}
	if ( isset( $input['counters'] ) ) {
		$clean['counters'] = optifo_sanitize_repeater( $input['counters'] );
	}
	if ( isset( $input['steps'] ) ) {
		$clean['steps'] = optifo_sanitize_repeater( $input['steps'] );
	}
	if ( isset( $input['info_boxes'] ) ) {
		$clean['info_boxes'] = optifo_sanitize_repeater( $input['info_boxes'] );
	}
	if ( isset( $input['slides'] ) ) {
		$clean['slides'] = optifo_sanitize_repeater( $input['slides'] );
	}
	if ( isset( $input['info_boxes'] ) ) {
		$clean['info_boxes'] = optifo_sanitize_repeater( $input['info_boxes'] );
	}
	if ( isset( $input['process_items'] ) ) {
		$clean['process_items'] = optifo_sanitize_repeater( $input['process_items'] );
	}
	return $clean;
}
