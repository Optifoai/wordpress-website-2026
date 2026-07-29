<?php
/**
 * Optifo Theme functions and definitions.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

define( 'OPTIFO_VERSION', '1.0.0' );
define( 'OPTIFO_DIR', get_template_directory() );
define( 'OPTIFO_URI', get_template_directory_uri() );

$optifo_includes = array(
	'/inc/setup.php',
	'/inc/enqueue.php',
	'/inc/default-data.php',
	'/inc/helpers.php',
	'/inc/custom-post-types.php',
	'/inc/taxonomies.php',
	'/inc/meta-boxes.php',
	'/inc/repeaters.php',
	'/inc/customizer.php',
	'/inc/theme-options.php',
	'/inc/widgets.php',
	'/inc/homepage-sections.php',
	'/inc/contact-form.php',
	'/inc/woocommerce.php',
	'/admin/theme-settings.php',
	'/admin/homepage-settings.php',
);

foreach ( $optifo_includes as $file ) {
	$path = OPTIFO_DIR . $file;
	if ( file_exists( $path ) ) {
		require_once $path;
	}
}

/**
 * Theme activation: seed default options and homepage sections.
 */
function optifo_theme_activation() {
	optifo_seed_default_data();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'optifo_theme_activation' );

/**
 * Ensure defaults exist after theme updates (without overwriting saved content).
 */
function optifo_maybe_seed_defaults() {
	if ( get_option( 'optifo_defaults_seeded' ) ) {
		return;
	}
	optifo_seed_default_data();
	update_option( 'optifo_defaults_seeded', 1 );
}
add_action( 'after_setup_theme', 'optifo_maybe_seed_defaults', 20 );
