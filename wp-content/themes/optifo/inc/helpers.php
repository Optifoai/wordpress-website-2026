<?php
/**
 * Helper functions.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get theme option from registered settings.
 *
 * @param string $key     Option key.
 * @param mixed  $default Default value.
 * @return mixed
 */
function optifo_get_option( $key, $default = '' ) {
	$options = get_option( 'optifo_theme_options', array() );
	if ( ! is_array( $options ) ) {
		$options = array();
	}
	$fallbacks = function_exists( 'optifo_default_theme_options' ) ? optifo_default_theme_options() : array();
	if ( '' === $default && isset( $fallbacks[ $key ] ) ) {
		$default = $fallbacks[ $key ];
	}
	return isset( $options[ $key ] ) && '' !== $options[ $key ] ? $options[ $key ] : $default;
}

/**
 * Get image URL from attachment ID or fallback path.
 *
 * @param mixed  $image_id  Attachment ID.
 * @param string $size      Image size.
 * @param string $fallback  Fallback relative path in theme assets.
 * @return string
 */
function optifo_get_image_url( $image_id, $size = 'full', $fallback = '' ) {
	$image_id = absint( $image_id );
	if ( $image_id > 0 ) {
		$url = wp_get_attachment_image_url( $image_id, $size );
		if ( $url ) {
			return esc_url( $url );
		}
	}
	if ( $fallback ) {
		return esc_url( OPTIFO_URI . '/assets/images/' . ltrim( $fallback, '/' ) );
	}
	return '';
}

/**
 * Output image tag.
 *
 * @param mixed  $image_id Attachment ID.
 * @param string $size     Size.
 * @param string $fallback Fallback filename.
 * @param string $alt      Alt text.
 * @param string $class    CSS class.
 */
function optifo_image( $image_id, $size = 'full', $fallback = '', $alt = '', $class = 'img-fluid' ) {
	$url = optifo_get_image_url( $image_id, $size, $fallback );
	if ( ! $url ) {
		return;
	}
	printf(
		'<img src="%1$s" alt="%2$s" class="%3$s" loading="lazy">',
		esc_url( $url ),
		esc_attr( $alt ),
		esc_attr( $class )
	);
}

/**
 * Get homepage sections ordered and enabled.
 *
 * @return array
 */
function optifo_get_homepage_sections() {
	$sections = get_option( 'optifo_homepage_sections', optifo_default_homepage_sections() );
	if ( ! is_array( $sections ) ) {
		return optifo_default_homepage_sections();
	}

	usort( $sections, function ( $a, $b ) {
		return (int) ( $a['order'] ?? 0 ) - (int) ( $b['order'] ?? 0 );
	} );

	return array_filter( $sections, function ( $section ) {
		return ! empty( $section['enabled'] );
	} );
}

/**
 * Default homepage sections configuration.
 *
 * @return array
 */
function optifo_default_homepage_sections() {
	$order = 0;
	$keys  = array(
		'hero', 'counter', 'why_use', 'how_it_works', 'web_mobile', 'store_buttons',
		'dashboard', 'pricing', 'featured_in', 'studio_quality', 'behind_design',
		'worldwide_trust', 'contact', 'faqs',
	);

	$sections = array();
	foreach ( $keys as $key ) {
		++$order;
		$sections[] = array(
			'id'      => $key,
			'enabled' => 1,
			'order'   => $order,
		);
	}
	return $sections;
}

/**
 * Get section data by ID.
 *
 * @param string $section_id Section identifier.
 * @return array
 */
function optifo_get_section_data( $section_id ) {
	$defaults = function_exists( 'optifo_get_section_defaults' )
		? optifo_get_section_defaults( $section_id )
		: array();
	$saved = get_option( 'optifo_section_' . $section_id, array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	if ( function_exists( 'optifo_merge_section_data' ) ) {
		return optifo_merge_section_data( $defaults, $saved );
	}
	return ! empty( $defaults ) ? $defaults : $saved;
}

/**
 * Map configuration for Leaflet.
 *
 * @return array
 */
function optifo_get_map_config() {
	$locations = get_option( 'optifo_map_locations', array() );
	if ( empty( $locations ) ) {
		$locations = optifo_default_map_locations();
	}

	return array(
		'center'    => array(
			'lat' => (float) optifo_get_option( 'map_center_lat', '22.9734' ),
			'lng' => (float) optifo_get_option( 'map_center_lng', '78.6569' ),
		),
		'zoom'      => (int) optifo_get_option( 'map_zoom', 5 ),
		'locations' => $locations,
	);
}

/**
 * Default map marker locations.
 *
 * @return array
 */
function optifo_default_map_locations() {
	return array(
		array(
			'name'    => 'Mumbai Office',
			'lat'     => '19.0005',
			'lng'     => '72.8258',
			'address' => 'Unit No-901, 9th Floor, Tower-B, Peninsula Business Park, Senapati Bapat Marg, Lower Parel (W), Mumbai-400013',
		),
		array(
			'name'    => 'Pune Office',
			'lat'     => '18.5074',
			'lng'     => '73.8077',
			'address' => 'GDA House, Plot No. 85, Bhusari Colony (Right), Paud Road, Kothrud, Pune – 411038',
		),
		array(
			'name'    => 'New Delhi Office',
			'lat'     => '28.6289',
			'lng'     => '77.2195',
			'address' => '9th Floor, Office No. 910-911, Kailash Building, 26, Kasturba Gandhi Marg, New Delhi – 110001',
		),
		array(
			'name'    => 'Bengaluru Office',
			'lat'     => '12.9352',
			'lng'     => '77.6146',
			'address' => 'Cabin 5, 3rd Floor, Bhive Workspace, Koramangala 5th Block, Bengaluru – 560095',
		),
		array(
			'name'    => 'Chennai Office',
			'lat'     => '13.0400',
			'lng'     => '80.1430',
			'address' => 'Plot No 5A, Bharathiar Street, Karpagambal Nagar, Madhanandapuram, Chennai – 600125',
		),
		array(
			'name'    => 'GIFT City Office',
			'lat'     => '23.1645',
			'lng'     => '72.6830',
			'address' => '627, Hiranandani Signature, 6th Floor, Block 13B, Zone 1, SEZ, GIFT City, Gandhinagar – 382355',
		),
		array(
			'name'    => 'Kolkata Office',
			'lat'     => '22.5534',
			'lng'     => '88.3526',
			'address' => 'COSPACIO, 24 Park Street, 8th Floor, Park Center, Kolkata',
		),
		array(
			'name'    => 'Hyderabad Office',
			'lat'     => '17.4156',
			'lng'     => '78.4347',
			'address' => 'NSL Icon, 3rd floor, Road No.12, Banjara Hills, Hyderabad – 500034',
		),
		array(
			'name'    => 'Dubai Office',
			'lat'     => '25.2115',
			'lng'     => '55.2796',
			'address' => 'Unit 409, Level 4, Damac Park Tower A, DIFC, Dubai, UAE',
		),
	);
}

/**
 * Render social links from customizer/options.
 *
 * @param string $context banner|footer.
 */
function optifo_social_links( $context = 'banner' ) {
	$networks = array(
		'facebook'  => array( 'label' => 'FACEBOOK', 'icon' => 'facebook_icon.png' ),
		'instagram' => array( 'label' => 'INSTAGRAM', 'icon' => 'instagram_icon.png' ),
		'youtube'   => array( 'label' => 'YOUTUBE', 'icon' => 'youtube_icon.png' ),
		'whatsapp'  => array( 'label' => 'WHATSAPP', 'icon' => 'whatsapp_icon.png' ),
		'tiktok'    => array( 'label' => 'TIKTOK', 'icon' => 'tiktok_icon.png' ),
	);

	if ( 'footer' === $context ) {
		echo '<div class="d-flex gap-2 mb-3">';
		foreach ( $networks as $key => $data ) {
			$url = get_theme_mod( 'optifo_social_' . $key, optifo_get_option( 'social_' . $key, '#' ) );
			if ( ! $url ) {
				$url = '#';
			}
			printf(
				'<a href="%1$s" class="btn btn-dark rounded-circle" target="_blank" rel="noopener noreferrer"><img src="%2$s" alt="%3$s"></a>',
				esc_url( $url ),
				esc_url( OPTIFO_URI . '/assets/images/' . $data['icon'] ),
				esc_attr( $data['label'] )
			);
		}
		echo '</div>';
		return;
	}

	echo '<ul class="d-flex list-unstyled">';
	foreach ( $networks as $key => $data ) {
		$url = get_theme_mod( 'optifo_social_' . $key, optifo_get_option( 'social_' . $key, '#' ) );
		printf(
			'<li><a href="%1$s" class="text-decoration-none font-montserrat fw-semibold font-12 text-secondary" target="_blank" rel="noopener noreferrer">%2$s</a></li>',
			esc_url( $url ),
			esc_html( $data['label'] )
		);
	}
	echo '</ul>';
}

/**
 * Primary navigation fallback.
 */
function optifo_fallback_menu() {
	$items = array(
		array( 'url' => '#about', 'label' => 'ABOUT US' ),
		array( 'url' => '#how-it-works', 'label' => 'HOW IT WORKS' ),
		array( 'url' => '#customer', 'label' => 'CUSTOMER' ),
		array( 'url' => '#pricing', 'label' => 'PRICING' ),
		array( 'url' => '#contact', 'label' => 'CONTACT' ),
	);

	echo '<ul class="navbar-nav align-items-center">';
	foreach ( $items as $item ) {
		printf(
			'<li class="nav-item"><a href="%1$s" class="font-montserrat fw-medium nav-link font-13 letter-spacing-2 text-uppercase" style="color:white!important;">%2$s</a></li>',
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}
	$login_url = optifo_get_option( 'header_login_url', '#' );
	printf(
		'<li class="nav-item ms-3"><a href="%1$s" class="bg-white btn font-montserrat fw-semibold login-btn rounded-pill font-13">%2$s</a></li>',
		esc_url( $login_url ),
		esc_html( optifo_get_option( 'header_login_text', 'LOGIN' ) )
	);
	echo '</ul>';
}

/**
 * SEO meta tags from theme options.
 */
function optifo_seo_meta() {
	$description = optifo_get_option( 'seo_description', get_bloginfo( 'description' ) );
	$keywords    = optifo_get_option( 'seo_keywords', '' );
	$og_image    = optifo_get_image_url( optifo_get_option( 'seo_og_image', 0 ), 'full' );

	if ( $description ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) );
	}
	if ( $keywords ) {
		printf( '<meta name="keywords" content="%s">' . "\n", esc_attr( $keywords ) );
	}
	if ( $og_image ) {
		printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $og_image ) );
	}

	$analytics = optifo_get_option( 'analytics_code', '' );
	if ( $analytics ) {
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Admin-controlled analytics snippet.
		echo $analytics;
	}
}
add_action( 'wp_head', 'optifo_seo_meta', 1 );
