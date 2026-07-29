<?php
/**
 * Homepage sections admin.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Admin tabs for each editable homepage section.
 *
 * @return array
 */
function optifo_get_homepage_admin_tabs() {
	return array(
		'hero'            => __( 'Hero', 'optifo' ),
		'counter'         => __( 'Counters', 'optifo' ),
		'why_use'         => __( 'Why Use', 'optifo' ),
		'how_it_works'    => __( 'How It Works', 'optifo' ),
		'web_mobile'      => __( 'Web / Mobile', 'optifo' ),
		'store_buttons'   => __( 'Store Buttons', 'optifo' ),
		'dashboard'       => __( 'Dashboard', 'optifo' ),
		'pricing'         => __( 'Pricing', 'optifo' ),
		'featured_in'     => __( 'Featured In', 'optifo' ),
		'studio_quality'  => __( 'Studio Quality', 'optifo' ),
		'behind_design'   => __( 'Behind Design', 'optifo' ),
		'worldwide_trust' => __( 'Worldwide Trust', 'optifo' ),
		'contact'         => __( 'Contact', 'optifo' ),
		'faqs'            => __( 'FAQs', 'optifo' ),
	);
}

/**
 * Homepage settings page (section order + per-section content).
 */
function optifo_render_homepage_settings() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$sections     = get_option( 'optifo_homepage_sections', optifo_default_homepage_sections() );
	$section_tabs = optifo_get_homepage_admin_tabs();

	$active_tab = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'order'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	?>
	<div class="wrap optifo-admin-wrap">
		<h1><?php esc_html_e( 'Homepage Sections', 'optifo' ); ?></h1>
		<p class="description">
			<?php esc_html_e( 'Manage section order on the first tab. Edit each section using the tabs below. App store URLs for store buttons are under Optifo Theme → Global Settings.', 'optifo' ); ?>
		</p>

		<h2 class="nav-tab-wrapper" style="display:flex;flex-wrap:wrap;">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=optifo-homepage&tab=order' ) ); ?>" class="nav-tab <?php echo 'order' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Section Order', 'optifo' ); ?></a>
			<?php foreach ( $section_tabs as $id => $label ) : ?>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=optifo-homepage&tab=' . $id ) ); ?>" class="nav-tab <?php echo $active_tab === $id ? 'nav-tab-active' : ''; ?>"><?php echo esc_html( $label ); ?></a>
			<?php endforeach; ?>
		</h2>

		<?php if ( 'order' === $active_tab ) : ?>
			<form method="post" action="options.php">
				<?php settings_fields( 'optifo_homepage_group' ); ?>
				<p><?php esc_html_e( 'Drag rows to reorder. Uncheck to disable a section.', 'optifo' ); ?></p>
				<ul id="optifo-section-sortable" class="optifo-sortable">
					<?php foreach ( $sections as $i => $section ) : ?>
					<li class="optifo-sortable-item">
						<span class="dashicons dashicons-menu"></span>
						<strong><?php echo esc_html( str_replace( '_', ' ', ucwords( $section['id'], '_' ) ) ); ?></strong>
						<code><?php echo esc_html( $section['id'] ); ?></code>
						<label>
							<input type="checkbox" name="optifo_homepage_sections[<?php echo esc_attr( $i ); ?>][enabled]" value="1" <?php checked( ! empty( $section['enabled'] ) ); ?>>
							<?php esc_html_e( 'Enabled', 'optifo' ); ?>
						</label>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=optifo-homepage&tab=' . $section['id'] ) ); ?>" class="button button-small"><?php esc_html_e( 'Edit', 'optifo' ); ?></a>
						<input type="hidden" name="optifo_homepage_sections[<?php echo esc_attr( $i ); ?>][id]" value="<?php echo esc_attr( $section['id'] ); ?>">
						<input type="hidden" class="optifo-order-input" name="optifo_homepage_sections[<?php echo esc_attr( $i ); ?>][order]" value="<?php echo esc_attr( $section['order'] ?? ( $i + 1 ) ); ?>">
					</li>
					<?php endforeach; ?>
				</ul>
				<?php submit_button( __( 'Save Section Order', 'optifo' ) ); ?>
			</form>
		<?php elseif ( isset( $section_tabs[ $active_tab ] ) ) : ?>
			<?php optifo_render_section_settings_form( $active_tab ); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Invalid section.', 'optifo' ); ?></p>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Output a generic text field row.
 *
 * @param string $option Option name prefix.
 * @param array  $data   Section data.
 * @param string $key    Field key.
 * @param string $label  Label.
 * @param string $type   Input type.
 */
function optifo_admin_field_row( $option, $data, $key, $label, $type = 'text' ) {
	echo '<tr><th><label>' . esc_html( $label ) . '</label></th><td>';
	if ( 'textarea' === $type ) {
		printf(
			'<textarea name="%1$s[%2$s]" class="large-text" rows="3">%3$s</textarea>',
			esc_attr( $option ),
			esc_attr( $key ),
			esc_textarea( $data[ $key ] ?? '' )
		);
	} else {
		printf(
			'<input type="text" name="%1$s[%2$s]" value="%3$s" class="large-text">',
			esc_attr( $option ),
			esc_attr( $key ),
			esc_attr( $data[ $key ] ?? '' )
		);
	}
	echo '</td></tr>';
}

/**
 * Output image upload field row.
 *
 * @param string $option Option prefix.
 * @param array  $data   Section data.
 * @param string $key    Field key.
 * @param string $label  Label.
 */
function optifo_admin_image_row( $option, $data, $key, $label ) {
	$val     = $data[ $key ] ?? '';
	$preview = $val ? wp_get_attachment_image_url( (int) $val, 'thumbnail' ) : '';
	echo '<tr><th><label>' . esc_html( $label ) . '</label></th><td>';
	printf( '<input type="hidden" name="%1$s[%2$s]" value="%3$s" class="optifo-image-id">', esc_attr( $option ), esc_attr( $key ), esc_attr( $val ) );
	echo '<button type="button" class="button optifo-upload-image">' . esc_html__( 'Select Image', 'optifo' ) . '</button>';
	if ( $preview ) {
		echo '<br><img src="' . esc_url( $preview ) . '" style="max-width:120px;margin-top:8px;">';
	}
	echo '</td></tr>';
}

/**
 * Render section-specific settings with nested repeaters.
 *
 * @param string $section_id Section ID.
 */
function optifo_render_section_settings_form( $section_id ) {
	$data   = optifo_get_section_data( $section_id );
	$option = 'optifo_section_' . $section_id;
	$tabs   = optifo_get_homepage_admin_tabs();
	?>
	<form method="post" action="options.php">
		<?php settings_fields( 'optifo_homepage_group' ); ?>
		<input type="hidden" name="<?php echo esc_attr( $option ); ?>[enabled]" value="1">
		<h2><?php echo esc_html( $tabs[ $section_id ] ?? $section_id ); ?></h2>

		<table class="form-table">
			<?php
			switch ( $section_id ) {
				case 'hero':
					optifo_admin_field_row( $option, $data, 'heading_light', __( 'Badge line 1', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'heading_bold', __( 'Badge line 2', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'title_light', __( 'Title (light)', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'title_bold', __( 'Title (bold)', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'title_end', __( 'Title (end)', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'description', __( 'Description', 'optifo' ), 'textarea' );
					optifo_admin_field_row( $option, $data, 'price_label', __( 'Banner price label', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'price_subtitle', __( 'Banner price subtitle', 'optifo' ) );
					optifo_admin_image_row( $option, $data, 'banner_image', __( 'Banner image', 'optifo' ) );
					break;

				case 'web_mobile':
					optifo_admin_field_row( $option, $data, 'heading_light', __( 'Heading (normal)', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'heading_bold', __( 'Heading (bold 1)', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'heading_middle', __( 'Heading (middle text)', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'heading_bold_2', __( 'Heading (bold 2)', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'description', __( 'Description', 'optifo' ), 'textarea' );
					break;

				case 'why_use':
					optifo_admin_field_row( $option, $data, 'heading_light', __( 'Heading (light)', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'heading_bold', __( 'Heading (bold)', 'optifo' ) );
					optifo_admin_image_row( $option, $data, 'image_before', __( 'Before image', 'optifo' ) );
					optifo_admin_image_row( $option, $data, 'image_after', __( 'After image', 'optifo' ) );
					break;

				case 'how_it_works':
					optifo_admin_field_row( $option, $data, 'heading_light', __( 'Heading (light)', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'heading_bold', __( 'Heading (bold)', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'description', __( 'Description', 'optifo' ), 'textarea' );
					optifo_admin_field_row( $option, $data, 'video_url', __( 'Video URL', 'optifo' ) );
					optifo_admin_image_row( $option, $data, 'poster', __( 'Video poster', 'optifo' ) );
					break;

				case 'dashboard':
					optifo_admin_image_row( $option, $data, 'image', __( 'Dashboard screenshot', 'optifo' ) );
					break;

				case 'pricing':
					optifo_admin_field_row( $option, $data, 'heading_light', __( 'Heading line 1', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'heading_bold', __( 'Heading bold 1', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'heading_bold_line2', __( 'Heading bold 2', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'heading_light_2', __( 'Heading line 2', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'heading_bold_2', __( 'Heading bold 3', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'subtitle', __( 'Subtitle', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'footnote', __( 'Footnote', 'optifo' ), 'textarea' );
					break;

				case 'featured_in':
					optifo_admin_field_row( $option, $data, 'title', __( 'Section title', 'optifo' ) );
					break;

				case 'studio_quality':
				case 'behind_design':
				case 'worldwide_trust':
				case 'contact':
				case 'faqs':
					optifo_admin_field_row( $option, $data, 'heading_light', __( 'Heading (light)', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'heading_bold', __( 'Heading (bold)', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'description', __( 'Description', 'optifo' ), 'textarea' );
					if ( 'contact' === $section_id ) {
						optifo_admin_field_row( $option, $data, 'video_url', __( 'Video URL', 'optifo' ) );
						optifo_admin_image_row( $option, $data, 'poster', __( 'Video poster', 'optifo' ) );
					}
					if ( 'faqs' === $section_id ) {
						optifo_admin_image_row( $option, $data, 'image', __( 'Side image', 'optifo' ) );
					}
					if ( 'behind_design' === $section_id ) {
						optifo_admin_field_row( $option, $data, 'badge_text', __( 'Badge text', 'optifo' ) );
						optifo_admin_field_row( $option, $data, 'button_text', __( 'Button text', 'optifo' ) );
						optifo_admin_field_row( $option, $data, 'button_url', __( 'Button URL', 'optifo' ) );
					}
					if ( 'dashboard' !== $section_id ) {
						// fallthrough ok
					}
					break;

				case 'store_buttons':
					echo '<tr><td colspan="2"><p class="description">';
					esc_html_e( 'Store button images and URLs are managed under Optifo Theme → Global Settings (App Store URL & Play Store URL). This section has no extra fields.', 'optifo' );
					echo '</p></td></tr>';
					break;

				default:
					optifo_admin_field_row( $option, $data, 'heading_light', __( 'Heading (light)', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'heading_bold', __( 'Heading (bold)', 'optifo' ) );
					optifo_admin_field_row( $option, $data, 'description', __( 'Description', 'optifo' ), 'textarea' );
			}
			?>
		</table>

		<!-- <?php if ( in_array( $section_id, array( 'web_mobile', 'featured_in', 'pricing', 'hero' ), true ) ) : ?>
			<h2><?php esc_html_e( 'Carousel / card images', 'optifo' ); ?></h2>
			<p class="description">
				<?php
				if ( 'web_mobile' === $section_id ) {
					esc_html_e( 'Add one card per mobile screenshot shown in the owl carousel.', 'optifo' );
				} else {
					esc_html_e( 'Each card supports image, title, subtitle, description, button text, button URL, and icon.', 'optifo' );
				}
				?>
			</p>
			<?php
			optifo_render_nested_repeater(
				$option . '[cards]',
				$data['cards'] ?? array(),
				'web_mobile' === $section_id
					? array( 'image' => array( 'type' => 'image', 'label' => __( 'Screenshot', 'optifo' ) ) )
					: optifo_card_fields()
			);
			?>
		<?php endif; ?> -->

		<?php if ( 'counter' === $section_id ) : ?>
			<h2><?php esc_html_e( 'Counter items', 'optifo' ); ?></h2>
			<?php
			optifo_render_nested_repeater(
				$option . '[counters]',
				$data['counters'] ?? array(),
				array(
					'title'    => array( 'type' => 'text', 'label' => __( 'Value', 'optifo' ) ),
					'subtitle' => array( 'type' => 'text', 'label' => __( 'Label', 'optifo' ) ),
				)
			);
			?>
		<?php endif; ?>

		<?php if ( 'how_it_works' === $section_id ) : ?>
			<h2><?php esc_html_e( 'Steps', 'optifo' ); ?></h2>
			<?php
			optifo_render_nested_repeater(
				$option . '[steps]',
				$data['steps'] ?? array(),
				array(
					'number' => array( 'type' => 'text', 'label' => __( 'Step number', 'optifo' ) ),
					'title'  => array( 'type' => 'text', 'label' => __( 'Step title', 'optifo' ) ),
				)
			);
			?>
		<?php endif; ?>

		<?php if ( 'why_use' === $section_id ) : ?>
			<h2><?php esc_html_e( 'Info boxes', 'optifo' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Use description field for bullet items separated by line breaks, or use the items array in defaults.', 'optifo' ); ?></p>
			<?php
			optifo_render_nested_repeater(
				$option . '[info_boxes]',
				$data['info_boxes'] ?? array(),
				array(
					'title'       => array( 'type' => 'text', 'label' => __( 'Title', 'optifo' ) ),
					'description' => array( 'type' => 'textarea', 'label' => __( 'Content (one bullet per line)', 'optifo' ) ),
				)
			);
			?>
		<?php endif; ?>

		<?php if ( 'studio_quality' === $section_id ) : ?>
			<h2><?php esc_html_e( 'Carousel slides', 'optifo' ); ?></h2>
			<?php
			optifo_render_nested_repeater(
				$option . '[slides]',
				$data['slides'] ?? array(),
				array(
					'heading'      => array( 'type' => 'text', 'label' => __( 'Heading', 'optifo' ) ),
					'type'         => array( 'type' => 'text', 'label' => __( 'Type (compare or image)', 'optifo' ) ),
					'before'       => array( 'type' => 'text', 'label' => __( 'Before image filename', 'optifo' ) ),
					'after'        => array( 'type' => 'text', 'label' => __( 'After image filename', 'optifo' ) ),
					'fallback'     => array( 'type' => 'text', 'label' => __( 'Image filename', 'optifo' ) ),
					'button_text'  => array( 'type' => 'text', 'label' => __( 'Button 1 text', 'optifo' ) ),
					'button_url'   => array( 'type' => 'url', 'label' => __( 'Button 1 URL', 'optifo' ) ),
					'button2_text' => array( 'type' => 'text', 'label' => __( 'Button 2 text', 'optifo' ) ),
					'button2_url'  => array( 'type' => 'url', 'label' => __( 'Button 2 URL', 'optifo' ) ),
				)
			);
			?>
		<?php endif; ?>

		<?php if ( 'behind_design' === $section_id ) : ?>
			<h2><?php esc_html_e( 'Process steps', 'optifo' ); ?></h2>
			<?php
			optifo_render_nested_repeater(
				$option . '[process_items]',
				$data['process_items'] ?? array(),
				array(
					'title' => array( 'type' => 'text', 'label' => __( 'Title', 'optifo' ) ),
				)
			);
			?>
		<?php endif; ?>

		<?php if ( 'faqs' === $section_id ) : ?>
			<p class="description">
				<?php
				printf(
					/* translators: %s: admin menu link */
					esc_html__( 'FAQ accordion items are managed under %s in the WordPress sidebar.', 'optifo' ),
					'<strong>' . esc_html__( 'FAQs', 'optifo' ) . '</strong>'
				);
				?>
			</p>
		<?php endif; ?>

		<?php submit_button(); ?>
	</form>
	<?php
}
