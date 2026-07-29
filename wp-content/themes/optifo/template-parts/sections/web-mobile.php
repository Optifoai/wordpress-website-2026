<?php
/**
 * Web or mobile carousel section.
 *
 * @package Optifo
 */
defined( 'ABSPATH' ) || exit;

$s      = get_query_var( 'optifo_section', optifo_get_section_data( 'web_mobile' ) );
$slides = ! empty( $s['cards'] ) ? $s['cards'] : optifo_default_web_mobile_section()['cards'];

// Only show slides that have an uploaded image or use theme fallback.
$slides = array_values( $slides );
if ( empty( $slides ) ) {
	$slides = array( array( 'image' => 0 ) );
}
?>
<div class="custom_container container mb-3 text-center">
	<div class="row">
		<div class="col-md-8 col-lg-6 col-xl-6 m-auto font-montserrat">
			<h5 class="font-34 text-uppercase letter-spacing-2">
				<span class="fw-normal"><?php echo esc_html( $s['heading_light'] ?? 'Web or Mobile—Your' ); ?></span>
				<span class="fw-semibold"><?php echo esc_html( $s['heading_bold'] ?? 'Convenience' ); ?></span><?php echo esc_html( $s['heading_middle'] ?? ', Your ' ); ?><span class="fw-semibold"><?php echo esc_html( $s['heading_bold_2'] ?? 'Choice' ); ?></span>
			</h5>
			<p class="fw-normal font-14"><?php echo esc_html( $s['description'] ?? '' ); ?></p>
		</div>
	</div>
</div>
<div class="carousel-wrapper">
	<div class="web_or_mobile owl-carousel">
		<?php foreach ( $slides as $slide ) : ?>
			<?php
			$image_id = isset( $slide['image'] ) ? absint( $slide['image'] ) : 0;
			?>
			<div><?php optifo_image( $image_id, 'large', 'mobile_img.png', '', 'img-fluid' ); ?></div>
		<?php endforeach; ?>
	</div>
</div>
