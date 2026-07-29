<?php
/**
 * Custom repeater field handlers.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Sanitize repeater rows.
 *
 * @param array $rows Raw rows.
 * @return array
 */
function optifo_sanitize_repeater( $rows ) {
	if ( ! is_array( $rows ) ) {
		return array();
	}

	$clean = array();
	foreach ( $rows as $row_key => $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		// Skip template placeholder rows submitted accidentally.
		if ( '{{INDEX}}' === (string) $row_key || '{{index}}' === strtolower( (string) $row_key ) ) {
			continue;
		}
		$clean_row = array();
		foreach ( $row as $key => $value ) {
			$key = sanitize_key( $key );
			if ( is_array( $value ) ) {
				$clean_row[ $key ] = optifo_sanitize_repeater( $value );
			} elseif ( false !== strpos( $key, 'url' ) ) {
				$clean_row[ $key ] = esc_url_raw( $value );
			} elseif ( false !== strpos( $key, 'image' ) || false !== strpos( $key, 'icon' ) ) {
				$clean_row[ $key ] = absint( $value );
			} elseif ( false !== strpos( $key, 'description' ) || false !== strpos( $key, 'content' ) ) {
				$clean_row[ $key ] = wp_kses_post( $value );
			} else {
				$clean_row[ $key ] = sanitize_text_field( $value );
			}
		}
		$clean[] = $clean_row;
	}
	return $clean;
}

/**
 * Get repeater meta for a post.
 *
 * @param int    $post_id Post ID.
 * @param string $key     Meta key.
 * @return array
 */
function optifo_get_repeater( $post_id, $key ) {
	$data = get_post_meta( $post_id, $key, true );
	return is_array( $data ) ? $data : array();
}

/**
 * Render admin repeater row fields (flat).
 *
 * @param string $name_prefix Field name prefix.
 * @param array  $row         Row data.
 * @param array  $fields      Field definitions.
 * @param int    $index       Row index.
 */
function optifo_render_repeater_row( $name_prefix, $row, $fields, $index, $is_template = false ) {
	echo '<div class="optifo-repeater-row postbox" data-index="' . esc_attr( $index ) . '">';
	echo '<div class="optifo-repeater-row-header"><span class="dashicons dashicons-move"></span> <button type="button" class="button-link-delete optifo-remove-row">' . esc_html__( 'Remove', 'optifo' ) . '</button></div>';
	echo '<div class="inside">';
	foreach ( $fields as $field_key => $field ) {
		$value = isset( $row[ $field_key ] ) ? $row[ $field_key ] : '';
		$name  = $is_template ? '' : $name_prefix . '[' . $index . '][' . $field_key . ']';
		optifo_render_field( $name, $value, $field, $field_key, $is_template );
	}
	echo '</div></div>';
}

/**
 * Render nested repeater (cards inside section).
 *
 * @param string $name_prefix Prefix.
 * @param array  $cards       Card rows.
 * @param array  $fields      Card fields.
 */
function optifo_render_nested_repeater( $name_prefix, $cards, $fields ) {
	echo '<div class="optifo-nested-repeater" data-prefix="' . esc_attr( $name_prefix ) . '">';
	if ( empty( $cards ) ) {
		$cards = array( array() );
	}
	foreach ( $cards as $i => $card ) {
		optifo_render_repeater_row( $name_prefix, $card, $fields, $i );
	}
	echo '<div class="optifo-repeater-row-template" style="display:none;" aria-hidden="true">';
	optifo_render_repeater_row( $name_prefix, array(), $fields, 0, true );
	echo '</div>';
	echo '<p><button type="button" class="button optifo-add-row">' . esc_html__( 'Add Card', 'optifo' ) . '</button></p>';
	echo '</div>';
}


/**
 * Render a single admin field.
 *
 * @param string $name  Field name.
 * @param mixed  $value Field value.
 * @param array  $field     Field config.
 * @param string $field_key Field key for reindexing.
 */
function optifo_render_field( $name, $value, $field, $field_key = '', $is_template = false ) {
	$type     = $field['type'] ?? 'text';
	$label    = $field['label'] ?? '';
	$disabled = $is_template ? ' disabled="disabled"' : '';
	$name_attr = $name ? ' name="' . esc_attr( $name ) . '"' : '';

	echo '<p class="optifo-field optifo-field-' . esc_attr( $type ) . '" data-field-key="' . esc_attr( $field_key ) . '">';
	if ( $label ) {
		echo '<label><strong>' . esc_html( $label ) . '</strong></label><br>';
	}
	switch ( $type ) {
		case 'textarea':
			printf(
				'<textarea%1$s rows="3" class="large-text"%2$s>%3$s</textarea>',
				$name_attr,
				$disabled,
				esc_textarea( $value )
			);
			break;
		case 'image':
			$preview = $value ? wp_get_attachment_image_url( (int) $value, 'thumbnail' ) : '';
			printf(
				'<input type="hidden"%1$s value="%2$s" class="optifo-image-id"%3$s>',
				$name_attr,
				esc_attr( $value ),
				$disabled
			);
			echo '<button type="button" class="button optifo-upload-image"' . $disabled . '>' . esc_html__( 'Select Image', 'optifo' ) . '</button>';
			if ( $preview ) {
				echo '<br><img src="' . esc_url( $preview ) . '" style="max-width:80px;margin-top:8px;">';
			}
			break;
		case 'url':
			printf(
				'<input type="url"%1$s value="%2$s" class="regular-text"%3$s>',
				$name_attr,
				esc_url( $value ),
				$disabled
			);
			break;
		case 'checkbox':
			printf(
				'<input type="checkbox"%1$s value="1" %2$s%3$s>',
				$name_attr,
				checked( $value, '1', false ),
				$disabled
			);
			break;
		default:
			printf(
				'<input type="text"%1$s value="%2$s" class="regular-text"%3$s>',
				$name_attr,
				esc_attr( $value ),
				$disabled
			);
	}
	echo '</p>';
}

/**
 * Card field schema for nested repeaters.
 *
 * @return array
 */
function optifo_card_fields() {
	return array(
		'image'       => array( 'type' => 'image', 'label' => __( 'Image', 'optifo' ) ),
		'title'       => array( 'type' => 'text', 'label' => __( 'Title', 'optifo' ) ),
		'subtitle'    => array( 'type' => 'text', 'label' => __( 'Subtitle', 'optifo' ) ),
		'description' => array( 'type' => 'textarea', 'label' => __( 'Description', 'optifo' ) ),
		'button_text' => array( 'type' => 'text', 'label' => __( 'Button Text', 'optifo' ) ),
		'button_url'  => array( 'type' => 'url', 'label' => __( 'Button URL', 'optifo' ) ),
		'icon'        => array( 'type' => 'image', 'label' => __( 'Icon', 'optifo' ) ),
	);
}
