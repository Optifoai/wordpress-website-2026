<?php
/**
 * Contact form handler.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Handle AJAX contact form submission.
 */
function optifo_handle_contact_form() {
	check_ajax_referer( 'optifo_nonce', 'nonce' );

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( empty( $name ) || empty( $email ) || empty( $message ) ) {
		wp_send_json_error( array( 'message' => __( 'Please fill in all required fields.', 'optifo' ) ) );
	}

	if ( ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => __( 'Please enter a valid email address.', 'optifo' ) ) );
	}

	$secret = optifo_get_option( 'recaptcha_secret_key', '' );
	if ( $secret && isset( $_POST['g-recaptcha-response'] ) ) {
		$response = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', array(
			'body' => array(
				'secret'   => $secret,
				'response' => sanitize_text_field( wp_unslash( $_POST['g-recaptcha-response'] ) ),
			),
		) );
		if ( ! is_wp_error( $response ) ) {
			$body = json_decode( wp_remote_retrieve_body( $response ), true );
			if ( empty( $body['success'] ) ) {
				wp_send_json_error( array( 'message' => __( 'Captcha verification failed.', 'optifo' ) ) );
			}
		}
	}

	$to      = get_theme_mod( 'optifo_contact_email', optifo_get_option( 'contact_email', get_option( 'admin_email' ) ) );
	$subject = sprintf( /* translators: %s: sender name */ __( 'Contact from %s - Optifo', 'optifo' ), $name );
	$body    = sprintf( "Name: %s\nEmail: %s\n\nMessage:\n%s", $name, $email, $message );
	$headers = array( 'Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>' );

	$sent = wp_mail( $to, $subject, $body, $headers );

	if ( $sent ) {
		wp_send_json_success( array( 'message' => __( 'Thank you! We will contact you soon.', 'optifo' ) ) );
	}

	wp_send_json_error( array( 'message' => __( 'Unable to send message. Please try again later.', 'optifo' ) ) );
}
add_action( 'wp_ajax_optifo_contact', 'optifo_handle_contact_form' );
add_action( 'wp_ajax_nopriv_optifo_contact', 'optifo_handle_contact_form' );
