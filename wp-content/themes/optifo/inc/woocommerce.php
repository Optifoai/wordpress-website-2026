<?php
/**
 * WooCommerce compatibility.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Declare WooCommerce support.
 */
function optifo_woocommerce_support() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'optifo_woocommerce_support' );

/**
 * WooCommerce wrappers.
 */
function optifo_woocommerce_wrapper_start() {
	echo '<main id="primary" class="site-main custom_container container py-5"><div class="row"><div class="col-12">';
}
add_action( 'woocommerce_before_main_content', 'optifo_woocommerce_wrapper_start', 10 );

function optifo_woocommerce_wrapper_end() {
	echo '</div></div></main>';
}
add_action( 'woocommerce_after_main_content', 'optifo_woocommerce_wrapper_end', 10 );

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
 * Products per row.
 *
 * @return int
 */
function optifo_loop_columns() {
	return 3;
}
add_filter( 'loop_shop_columns', 'optifo_loop_columns' );
