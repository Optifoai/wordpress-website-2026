<?php
/**
 * Enqueue scripts and styles.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Front-end assets.
 */
function optifo_enqueue_assets() {
	$version = OPTIFO_VERSION;

	wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', array(), '5.3.0' );
	wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0' );
	wp_enqueue_style( 'owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', array(), '2.3.4' );
	wp_enqueue_style( 'owl-theme', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css', array( 'owl-carousel' ), '2.3.4' );
	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&family=Montaga&family=Oswald:wght@300;400;600&family=Poppins:wght@300;400;600&family=Raleway:wght@300;400;600&display=swap', array(), null );
	wp_enqueue_style( 'optifo-style', OPTIFO_URI . '/assets/css/style.css', array( 'bootstrap' ), $version );
	wp_enqueue_style( 'optifo-responsive', OPTIFO_URI . '/assets/css/responsive.css', array( 'optifo-style' ), $version );
	wp_enqueue_style( 'leaflet', 'https://unpkg.com/leaflet/dist/leaflet.css', array(), '1.9.0' );
	wp_enqueue_style( 'optifo-theme', get_stylesheet_uri(), array( 'optifo-responsive' ), $version );

	$primary   = get_theme_mod( 'optifo_color_primary', '#EA645F' );
	$secondary = get_theme_mod( 'optifo_color_secondary', '#111D40' );
	$body_font = get_theme_mod( 'optifo_body_font', 'Montserrat' );

	$custom_css = sprintf(
		'html{scroll-behavior:smooth;}
		:root{--optifo-primary:%1$s;--optifo-secondary:%2$s;}
		body{font-family:%3$s,sans-serif;}
		// .bg-primary,.btn-primary,.text-primary{color:var(--optifo-primary)!important;}
		.bg-main{background-color:var(--optifo-secondary)!important;}',
		esc_attr( $primary ),
		esc_attr( $secondary ),
		esc_attr( $body_font )
	);
	wp_add_inline_style( 'optifo-theme', $custom_css );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array( 'jquery' ), '2.3.4', true );
	wp_enqueue_script( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array(), '5.3.0', true );
	wp_enqueue_script( 'leaflet', 'https://unpkg.com/leaflet/dist/leaflet.js', array(), '1.9.0', true );
	wp_enqueue_script( 'optifo-script', OPTIFO_URI . '/assets/js/script.js', array( 'jquery', 'owl-carousel', 'bootstrap' ), $version, true );

	$recaptcha_key = optifo_get_option( 'recaptcha_site_key', '' );
	if ( $recaptcha_key && ( is_front_page() || is_page_template( 'page-contact.php' ) ) ) {
		wp_enqueue_script( 'google-recaptcha', 'https://www.google.com/recaptcha/api.js', array(), null, true );
	}

	wp_localize_script( 'optifo-script', 'optifoData', array(
		'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
		'nonce'     => wp_create_nonce( 'optifo_nonce' ),
		'themeUri'  => OPTIFO_URI,
		'mapConfig' => optifo_get_map_config(),
	) );
}
add_action( 'wp_enqueue_scripts', 'optifo_enqueue_assets' );

/**
 * Admin assets for theme settings.
 *
 * @param string $hook Current admin page hook.
 */
function optifo_admin_enqueue( $hook ) {
	if ( false === strpos( $hook, 'optifo' ) ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_style( 'optifo-admin', OPTIFO_URI . '/assets/css/admin.css', array(), OPTIFO_VERSION );
	$admin_js = OPTIFO_DIR . '/assets/js/admin.js';
	wp_enqueue_script( 'optifo-admin', OPTIFO_URI . '/assets/js/admin.js', array( 'jquery', 'jquery-ui-sortable' ), file_exists( $admin_js ) ? (string) filemtime( $admin_js ) : OPTIFO_VERSION, true );
	wp_localize_script( 'optifo-admin', 'optifoAdmin', array(
		'nonce' => wp_create_nonce( 'optifo_admin_nonce' ),
	) );
}
add_action( 'admin_enqueue_scripts', 'optifo_admin_enqueue' );
