<?php
/**
 * Studio quality carousel section.
 *
 * @package Optifo
 */
defined( 'ABSPATH' ) || exit;
$s = get_query_var( 'optifo_section', optifo_get_section_data( 'studio_quality' ) );
$slides = ! empty( $s['slides'] ) ? $s['slides'] : ( ! empty( $s['cards'] ) ? $s['cards'] : optifo_default_studio_quality_section()['slides'] );
?>
<section class="studio-quality">
	<div class="container-fluid">
		<div class="row h-100">
			<div class="studio-quality_content_owl_carousel owl-carousel p-0">
				<?php foreach ( $slides as $slide ) : ?>
					<div class="item h-100">
						<div class="row m-0">
							<div class="pt-xl-0 pb-xl-0 pt-5 pb-5 col-lg-12 col-xl-4 px-5 d-flex flex-column justify-content-center align-items-start text-white font-montserrat <?php echo esc_attr( $slide['bg'] ?? 'bg-primary-dark' ); ?>" <?php echo ! empty( $slide['bg_color'] ) ? 'style="background-color:' . esc_attr( $slide['bg_color'] ) . '"' : ''; ?>>
								<h2 class="text-uppercase font-montserrat letter-spacing-2 font-34" style="line-height:48px;"><?php echo esc_html( $slide['heading'] ?? $slide['title'] ?? '' ); ?></h2>
								<div class="mt-4 d-flex gap-3">
									<?php if ( ! empty( $slide['button_text'] ) ) : ?>
										<a href="<?php echo esc_url( $slide['button_url'] ?? '#contact' ); ?>" class="text-white font-montserrat fw-semibold text-uppercase font-13 btn rounded-pill get_in_touch"><?php echo esc_html( $slide['button_text'] ); ?></a>
									<?php endif; ?>
									<?php if ( ! empty( $slide['button2_text'] ) ) : ?>
										<a href="<?php echo esc_url( $slide['button2_url'] ?? '#' ); ?>" class="font-montserrat fw-semibold text-uppercase font-13 btn rounded-pill bg-white explore_in_ai"><?php echo esc_html( $slide['button2_text'] ); ?></a>
									<?php endif; ?>
								</div>
								<div class="custom-dots d-flex mt-5"></div>
							</div>
							<div class="col-lg-12 col-xl-8 order-first order-xl-0 p-0">
								<?php if ( ( $slide['type'] ?? '' ) === 'compare' ) : ?>
									<div class="slider-container">
										<div class="before-image"><?php optifo_image( $slide['image_before'] ?? 0, 'full', $slide['before'] ?? 'car_clear.png', 'Before', 'w-100 h-100' ); ?></div>
										<div class="after-image"><?php optifo_image( $slide['image_after'] ?? 0, 'full', $slide['after'] ?? 'car_blur.png', 'After', 'w-100 h-100' ); ?></div>
										<div class="slider-handle"></div>
										<div class="slider-line"><div class="pulse-container"><?php optifo_image( 0, 'full', 'slider_icon.png', '', 'position-relative z-1 w-auto' ); ?></div></div>
									</div>
								<?php else : ?>
									<?php optifo_image( $slide['image'] ?? 0, 'full', $slide['fallback'] ?? 's1.png', '', 'w-100' ); ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
