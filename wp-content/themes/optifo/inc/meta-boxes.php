<?php
/**
 * Custom meta boxes for CPTs and pages.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register meta boxes.
 */
function optifo_register_meta_boxes() {
	$cpt_boxes = array(
		'optifo_service'     => 'optifo_service_details',
		'optifo_testimonial' => 'optifo_testimonial_details',
		'optifo_team'          => 'optifo_team_details',
		'optifo_portfolio'     => 'optifo_portfolio_details',
		'optifo_pricing'       => 'optifo_pricing_details',
		'optifo_case_study'    => 'optifo_case_study_details',
	);

	foreach ( $cpt_boxes as $post_type => $callback ) {
		add_meta_box(
			$post_type . '_meta',
			__( 'Additional Details', 'optifo' ),
			$callback,
			$post_type,
			'normal',
			'high'
		);
	}

	add_meta_box(
		'optifo_page_seo',
		__( 'SEO Settings', 'optifo' ),
		'optifo_page_seo_meta_box',
		array( 'page', 'post' ),
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'optifo_register_meta_boxes' );

/**
 * Service meta box.
 *
 * @param WP_Post $post Post object.
 */
function optifo_service_details( $post ) {
	wp_nonce_field( 'optifo_save_meta', 'optifo_meta_nonce' );
	$icon     = get_post_meta( $post->ID, '_optifo_icon', true );
	$btn_text = get_post_meta( $post->ID, '_optifo_button_text', true );
	$btn_url  = get_post_meta( $post->ID, '_optifo_button_url', true );
	?>
	<p>
		<label><strong><?php esc_html_e( 'Icon Image', 'optifo' ); ?></strong></label><br>
		<input type="hidden" name="optifo_icon" value="<?php echo esc_attr( $icon ); ?>" class="optifo-image-id">
		<button type="button" class="button optifo-upload-image"><?php esc_html_e( 'Select Icon', 'optifo' ); ?></button>
	</p>
	<p>
		<label><strong><?php esc_html_e( 'Button Text', 'optifo' ); ?></strong></label><br>
		<input type="text" name="optifo_button_text" value="<?php echo esc_attr( $btn_text ); ?>" class="regular-text">
	</p>
	<p>
		<label><strong><?php esc_html_e( 'Button URL', 'optifo' ); ?></strong></label><br>
		<input type="url" name="optifo_button_url" value="<?php echo esc_url( $btn_url ); ?>" class="regular-text">
	</p>
	<?php
}

/**
 * Testimonial meta box.
 *
 * @param WP_Post $post Post object.
 */
function optifo_testimonial_details( $post ) {
	wp_nonce_field( 'optifo_save_meta', 'optifo_meta_nonce' );
	$role   = get_post_meta( $post->ID, '_optifo_role', true );
	$rating = get_post_meta( $post->ID, '_optifo_rating', true );
	?>
	<p>
		<label><strong><?php esc_html_e( 'Role / Company', 'optifo' ); ?></strong></label><br>
		<input type="text" name="optifo_role" value="<?php echo esc_attr( $role ); ?>" class="regular-text">
	</p>
	<p>
		<label><strong><?php esc_html_e( 'Rating (1-5)', 'optifo' ); ?></strong></label><br>
		<input type="number" name="optifo_rating" value="<?php echo esc_attr( $rating ); ?>" min="1" max="5" step="1">
	</p>
	<?php
}

/**
 * Team meta box.
 *
 * @param WP_Post $post Post object.
 */
function optifo_team_details( $post ) {
	wp_nonce_field( 'optifo_save_meta', 'optifo_meta_nonce' );
	$role = get_post_meta( $post->ID, '_optifo_role', true );
	$url  = get_post_meta( $post->ID, '_optifo_linkedin', true );
	?>
	<p>
		<label><strong><?php esc_html_e( 'Job Title', 'optifo' ); ?></strong></label><br>
		<input type="text" name="optifo_role" value="<?php echo esc_attr( $role ); ?>" class="regular-text">
	</p>
	<p>
		<label><strong><?php esc_html_e( 'LinkedIn URL', 'optifo' ); ?></strong></label><br>
		<input type="url" name="optifo_linkedin" value="<?php echo esc_url( $url ); ?>" class="regular-text">
	</p>
	<?php
}

/**
 * Portfolio meta box.
 *
 * @param WP_Post $post Post object.
 */
function optifo_portfolio_details( $post ) {
	wp_nonce_field( 'optifo_save_meta', 'optifo_meta_nonce' );
	$link = get_post_meta( $post->ID, '_optifo_project_url', true );
	?>
	<p>
		<label><strong><?php esc_html_e( 'Project URL', 'optifo' ); ?></strong></label><br>
		<input type="url" name="optifo_project_url" value="<?php echo esc_url( $link ); ?>" class="regular-text">
	</p>
	<?php
}

/**
 * Pricing meta box.
 *
 * @param WP_Post $post Post object.
 */
function optifo_pricing_details( $post ) {
	wp_nonce_field( 'optifo_save_meta', 'optifo_meta_nonce' );
	$price    = get_post_meta( $post->ID, '_optifo_price', true );
	$subtitle = get_post_meta( $post->ID, '_optifo_price_subtitle', true );
	$btn_text = get_post_meta( $post->ID, '_optifo_button_text', true );
	$btn_url  = get_post_meta( $post->ID, '_optifo_button_url', true );
	$icon     = get_post_meta( $post->ID, '_optifo_icon', true );
	?>
	<p>
		<label><strong><?php esc_html_e( 'Price Label', 'optifo' ); ?></strong></label><br>
		<input type="text" name="optifo_price" value="<?php echo esc_attr( $price ); ?>" class="regular-text" placeholder="€89 Per Transaction">
	</p>
	<p>
		<label><strong><?php esc_html_e( 'Subtitle', 'optifo' ); ?></strong></label><br>
		<input type="text" name="optifo_price_subtitle" value="<?php echo esc_attr( $subtitle ); ?>" class="regular-text">
	</p>
	<p>
		<label><strong><?php esc_html_e( 'Icon', 'optifo' ); ?></strong></label><br>
		<input type="hidden" name="optifo_icon" value="<?php echo esc_attr( $icon ); ?>" class="optifo-image-id">
		<button type="button" class="button optifo-upload-image"><?php esc_html_e( 'Select Icon', 'optifo' ); ?></button>
	</p>
	<p>
		<label><strong><?php esc_html_e( 'Button Text', 'optifo' ); ?></strong></label><br>
		<input type="text" name="optifo_button_text" value="<?php echo esc_attr( $btn_text ); ?>" class="regular-text">
	</p>
	<p>
		<label><strong><?php esc_html_e( 'Button URL', 'optifo' ); ?></strong></label><br>
		<input type="url" name="optifo_button_url" value="<?php echo esc_url( $btn_url ); ?>" class="regular-text">
	</p>
	<?php
}

/**
 * Case study meta box.
 *
 * @param WP_Post $post Post object.
 */
function optifo_case_study_details( $post ) {
	wp_nonce_field( 'optifo_save_meta', 'optifo_meta_nonce' );
	$client = get_post_meta( $post->ID, '_optifo_client', true );
	$url    = get_post_meta( $post->ID, '_optifo_case_url', true );
	?>
	<p>
		<label><strong><?php esc_html_e( 'Client Name', 'optifo' ); ?></strong></label><br>
		<input type="text" name="optifo_client" value="<?php echo esc_attr( $client ); ?>" class="regular-text">
	</p>
	<p>
		<label><strong><?php esc_html_e( 'Case Study URL', 'optifo' ); ?></strong></label><br>
		<input type="url" name="optifo_case_url" value="<?php echo esc_url( $url ); ?>" class="regular-text">
	</p>
	<?php
}

/**
 * Page SEO meta box.
 *
 * @param WP_Post $post Post object.
 */
function optifo_page_seo_meta_box( $post ) {
	wp_nonce_field( 'optifo_save_meta', 'optifo_meta_nonce' );
	$title = get_post_meta( $post->ID, '_optifo_seo_title', true );
	$desc  = get_post_meta( $post->ID, '_optifo_seo_description', true );
	?>
	<p>
		<label><?php esc_html_e( 'SEO Title', 'optifo' ); ?></label>
		<input type="text" name="optifo_seo_title" value="<?php echo esc_attr( $title ); ?>" class="widefat">
	</p>
	<p>
		<label><?php esc_html_e( 'SEO Description', 'optifo' ); ?></label>
		<textarea name="optifo_seo_description" class="widefat" rows="3"><?php echo esc_textarea( $desc ); ?></textarea>
	</p>
	<?php
}

/**
 * Save meta box data.
 *
 * @param int $post_id Post ID.
 */
function optifo_save_meta_boxes( $post_id ) {
	if ( ! isset( $_POST['optifo_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['optifo_meta_nonce'] ) ), 'optifo_save_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$text_fields = array( 'optifo_role', 'optifo_button_text', 'optifo_price', 'optifo_price_subtitle', 'optifo_client', 'optifo_seo_title' );
	foreach ( $text_fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, '_' . $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}

	$url_fields = array( 'optifo_button_url', 'optifo_linkedin', 'optifo_project_url', 'optifo_case_url' );
	foreach ( $url_fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, '_' . $field, esc_url_raw( wp_unslash( $_POST[ $field ] ) ) );
		}
	}

	if ( isset( $_POST['optifo_icon'] ) ) {
		update_post_meta( $post_id, '_optifo_icon', absint( $_POST['optifo_icon'] ) );
	}
	if ( isset( $_POST['optifo_rating'] ) ) {
		update_post_meta( $post_id, '_optifo_rating', absint( $_POST['optifo_rating'] ) );
	}
	if ( isset( $_POST['optifo_seo_description'] ) ) {
		update_post_meta( $post_id, '_optifo_seo_description', sanitize_textarea_field( wp_unslash( $_POST['optifo_seo_description'] ) ) );
	}
}
add_action( 'save_post', 'optifo_save_meta_boxes' );
