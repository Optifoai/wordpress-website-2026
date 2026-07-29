<?php
/**
 * Why use Optifo section.
 *
 * @package Optifo
 */
defined( 'ABSPATH' ) || exit;
$s     = get_query_var( 'optifo_section', optifo_get_section_data( 'why_use' ) );
$boxes = ! empty( $s['info_boxes'] ) ? $s['info_boxes'] : optifo_default_why_use_section()['info_boxes'];
?>
<section class="why-use-section" id="about">
	<div class="container custom_container">
		<h3 class="font-34 font-montserrat letter-spacing-2 text-white text-uppercase mb-3">
			<span class="fw-light"><?php echo esc_html( $s['heading_light'] ?? 'WHY USE' ); ?></span>
			<strong class="fw-semibold"><?php echo esc_html( $s['heading_bold'] ?? 'OPTIFO.AI?' ); ?></strong>
		</h3>
		<div class="row align-items-center">
			<div class="col-lg-7">
				<div class="slider-container">
					<div class="before-image">
						<?php optifo_image( $s['image_before'] ?? 0, 'full', 'why_use_before.png', 'Before', 'h-100 w-100' ); ?>
						<div class="before-text text-center font-montserrat fw-semibold font-14 text-uppercase"><?php esc_html_e( 'Before', 'optifo' ); ?></div>
					</div>
					<div class="after-image">
						<?php optifo_image( $s['image_after'] ?? 0, 'full', 'why_use_after.png', 'After', 'h-100 w-100' ); ?>
						<div class="after-text text-center font-montserrat fw-semibold font-14 text-uppercase"><?php esc_html_e( 'After', 'optifo' ); ?></div>
					</div>
					<div class="slider-handle"></div>
					<div class="border slider-line">
						<div class="pulse-container"><?php optifo_image( 0, 'full', 'slider_icon.png', '', 'position-relative z-1' ); ?></div>
					</div>
				</div>
			</div>
			<div class="col-lg-5 text-white font-montserrat font-14 mt-5 mt-lg-0">
				<?php foreach ( $boxes as $box ) : ?>
					<div class="info-box mb-3">
						<h6 class="fw-semibold"><?php echo esc_html( $box['title'] ?? '' ); ?></h6>
						<?php if ( ! empty( $box['items'] ) ) : ?>
							<ul class="fw-normal mt-2">
								<?php foreach ( (array) $box['items'] as $li ) : ?>
									<li class="mb-1"><?php echo esc_html( $li ); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php elseif ( ! empty( $box['description'] ) ) : ?>
							<p class="fw-normal mt-2"><?php echo wp_kses_post( $box['description'] ); ?></p>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
