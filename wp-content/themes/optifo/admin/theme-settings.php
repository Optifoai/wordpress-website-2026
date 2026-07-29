<?php
/**
 * Theme settings admin pages.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add admin menu pages.
 */
function optifo_admin_menu() {
	add_menu_page(
		__( 'Optifo Theme', 'optifo' ),
		__( 'Optifo Theme', 'optifo' ),
		'manage_options',
		'optifo-theme',
		'optifo_render_global_settings',
		'dashicons-admin-customizer',
		59
	);

	add_submenu_page(
		'optifo-theme',
		__( 'Global Settings', 'optifo' ),
		__( 'Global Settings', 'optifo' ),
		'manage_options',
		'optifo-theme',
		'optifo_render_global_settings'
	);

	add_submenu_page(
		'optifo-theme',
		__( 'Homepage Sections', 'optifo' ),
		__( 'Homepage', 'optifo' ),
		'manage_options',
		'optifo-homepage',
		'optifo_render_homepage_settings'
	);

	add_submenu_page(
		'optifo-theme',
		__( 'Header & Footer', 'optifo' ),
		__( 'Header & Footer', 'optifo' ),
		'manage_options',
		'optifo-header-footer',
		'optifo_render_header_footer_settings'
	);

	add_submenu_page(
		'optifo-theme',
		__( 'Map Locations', 'optifo' ),
		__( 'Map Locations', 'optifo' ),
		'manage_options',
		'optifo-map',
		'optifo_render_map_settings'
	);
}
add_action( 'admin_menu', 'optifo_admin_menu' );

/**
 * Global settings page.
 */
function optifo_render_global_settings() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$options = get_option( 'optifo_theme_options', array() );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Optifo Global Settings', 'optifo' ); ?></h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'optifo_theme_options_group' ); ?>
			<table class="form-table">
				<tr>
					<th><?php esc_html_e( 'App Store URL', 'optifo' ); ?></th>
					<td><input type="url" name="optifo_theme_options[app_store_url]" value="<?php echo esc_url( $options['app_store_url'] ?? 'https://apps.apple.com/us/app/optifo-automated-car-studio/id1539383737' ); ?>" class="large-text"></td>
				</tr>
				<tr>
					<th><?php esc_html_e( 'Play Store URL', 'optifo' ); ?></th>
					<td><input type="url" name="optifo_theme_options[play_store_url]" value="<?php echo esc_url( $options['play_store_url'] ?? 'https://play.google.com/store/apps/details?id=com.mobcoder.optifo' ); ?>" class="large-text"></td>
				</tr>
				<tr>
					<th><?php esc_html_e( 'SEO Description', 'optifo' ); ?></th>
					<td><textarea name="optifo_theme_options[seo_description]" class="large-text" rows="3"><?php echo esc_textarea( $options['seo_description'] ?? '' ); ?></textarea></td>
				</tr>
				<tr>
					<th><?php esc_html_e( 'SEO Keywords', 'optifo' ); ?></th>
					<td><input type="text" name="optifo_theme_options[seo_keywords]" value="<?php echo esc_attr( $options['seo_keywords'] ?? '' ); ?>" class="large-text"></td>
				</tr>
				<tr>
					<th><?php esc_html_e( 'Analytics Code', 'optifo' ); ?></th>
					<td><textarea name="optifo_theme_options[analytics_code]" class="large-text code" rows="5"><?php echo esc_textarea( $options['analytics_code'] ?? '' ); ?></textarea>
					<p class="description"><?php esc_html_e( 'Paste Google Analytics or other tracking scripts.', 'optifo' ); ?></p></td>
				</tr>
				<tr>
					<th><?php esc_html_e( 'reCAPTCHA Site Key', 'optifo' ); ?></th>
					<td><input type="text" name="optifo_theme_options[recaptcha_site_key]" value="<?php echo esc_attr( $options['recaptcha_site_key'] ?? '' ); ?>" class="large-text"></td>
				</tr>
				<tr>
					<th><?php esc_html_e( 'reCAPTCHA Secret Key', 'optifo' ); ?></th>
					<td><input type="text" name="optifo_theme_options[recaptcha_secret_key]" value="<?php echo esc_attr( $options['recaptcha_secret_key'] ?? '' ); ?>" class="large-text"></td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
		<p><?php esc_html_e( 'Logo, colors, typography, and social links are managed in Appearance → Customize.', 'optifo' ); ?></p>
	</div>
	<?php
}

/**
 * Header & footer settings.
 */
function optifo_render_header_footer_settings() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$options = get_option( 'optifo_theme_options', array() );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Header & Footer Settings', 'optifo' ); ?></h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'optifo_theme_options_group' ); ?>
			<h2><?php esc_html_e( 'Header', 'optifo' ); ?></h2>
			<table class="form-table">
				<tr>
					<th><?php esc_html_e( 'Login Button Text', 'optifo' ); ?></th>
					<td><input type="text" name="optifo_theme_options[header_login_text]" value="<?php echo esc_attr( $options['header_login_text'] ?? 'LOGIN' ); ?>"></td>
				</tr>
				<tr>
					<th><?php esc_html_e( 'Login Button URL', 'optifo' ); ?></th>
					<td><input type="url" name="optifo_theme_options[header_login_url]" value="<?php echo esc_url( $options['header_login_url'] ?? '#' ); ?>" class="large-text"></td>
				</tr>
			</table>
			<h2><?php esc_html_e( 'Social Links', 'optifo' ); ?></h2>
			<table class="form-table">
				<?php foreach ( array( 'facebook', 'instagram', 'youtube', 'whatsapp', 'tiktok' ) as $network ) : ?>
				<tr>
					<th><?php echo esc_html( ucfirst( $network ) ); ?></th>
					<td><input type="url" name="optifo_theme_options[social_<?php echo esc_attr( $network ); ?>]" value="<?php echo esc_url( $options[ 'social_' . $network ] ?? '#' ); ?>" class="large-text"></td>
				</tr>
				<?php endforeach; ?>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/**
 * Map locations settings with repeater.
 */
function optifo_render_map_settings() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$options   = get_option( 'optifo_theme_options', array() );
	$locations = get_option( 'optifo_map_locations', optifo_default_map_locations() );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Map Locations', 'optifo' ); ?></h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'optifo_theme_options_group' ); ?>
			<table class="form-table">
				<tr>
					<th><?php esc_html_e( 'Map Center Lat', 'optifo' ); ?></th>
					<td><input type="text" name="optifo_theme_options[map_center_lat]" value="<?php echo esc_attr( $options['map_center_lat'] ?? '22.9734' ); ?>"></td>
				</tr>
				<tr>
					<th><?php esc_html_e( 'Map Center Lng', 'optifo' ); ?></th>
					<td><input type="text" name="optifo_theme_options[map_center_lng]" value="<?php echo esc_attr( $options['map_center_lng'] ?? '78.6569' ); ?>"></td>
				</tr>
				<tr>
					<th><?php esc_html_e( 'Zoom Level', 'optifo' ); ?></th>
					<td><input type="number" name="optifo_theme_options[map_zoom]" value="<?php echo esc_attr( $options['map_zoom'] ?? '5' ); ?>" min="1" max="18"></td>
				</tr>
			</table>
			<h2><?php esc_html_e( 'Office Locations', 'optifo' ); ?></h2>
			<?php
			optifo_render_nested_repeater(
				'optifo_map_locations',
				$locations,
				array(
					'name'    => array( 'type' => 'text', 'label' => __( 'Name', 'optifo' ) ),
					'lat'     => array( 'type' => 'text', 'label' => __( 'Latitude', 'optifo' ) ),
					'lng'     => array( 'type' => 'text', 'label' => __( 'Longitude', 'optifo' ) ),
					'address' => array( 'type' => 'textarea', 'label' => __( 'Address', 'optifo' ) ),
				)
			);
			?>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
