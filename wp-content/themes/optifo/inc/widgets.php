<?php
/**
 * Custom widgets.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Contact info widget.
 */
class Optifo_Contact_Widget extends WP_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct( 'optifo_contact', __( 'Optifo: Contact Info', 'optifo' ) );
	}

	/**
	 * Front-end output.
	 *
	 * @param array $args     Widget args.
	 * @param array $instance Instance.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		$email = ! empty( $instance['email'] ) ? $instance['email'] : get_theme_mod( 'optifo_contact_email', 'info@optifo.com' );
		$phone = ! empty( $instance['phone'] ) ? $instance['phone'] : get_theme_mod( 'optifo_contact_phone', '' );
		echo '<ul class="list-unstyled small font-montserrat font-12">';
		if ( $email ) {
			printf( '<li class="mb-2"><a href="mailto:%1$s" class="text-white">%2$s</a></li>', esc_attr( $email ), esc_html( $email ) );
		}
		if ( $phone ) {
			printf( '<li>%s</li>', esc_html( $phone ) );
		}
		echo '</ul>';
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Admin form.
	 *
	 * @param array $instance Instance.
	 */
	public function form( $instance ) {
		$title = $instance['title'] ?? __( 'Support', 'optifo' );
		$email = $instance['email'] ?? '';
		$phone = $instance['phone'] ?? '';
		?>
		<p><label><?php esc_html_e( 'Title:', 'optifo' ); ?></label>
		<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>"></p>
		<p><label><?php esc_html_e( 'Email:', 'optifo' ); ?></label>
		<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" value="<?php echo esc_attr( $email ); ?>"></p>
		<p><label><?php esc_html_e( 'Phone:', 'optifo' ); ?></label>
		<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'phone' ) ); ?>" value="<?php echo esc_attr( $phone ); ?>"></p>
		<?php
	}

	/**
	 * Update instance.
	 *
	 * @param array $new_instance New.
	 * @param array $old_instance Old.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		return array(
			'title' => sanitize_text_field( $new_instance['title'] ?? '' ),
			'email' => sanitize_email( $new_instance['email'] ?? '' ),
			'phone' => sanitize_text_field( $new_instance['phone'] ?? '' ),
		);
	}
}

/**
 * Register widgets.
 */
function optifo_register_widgets() {
	register_widget( 'Optifo_Contact_Widget' );
}
add_action( 'widgets_init', 'optifo_register_widgets' );
