<?php
/**
 * Services section (optional homepage block).
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

$s = get_query_var( 'optifo_section', optifo_get_section_data( 'services' ) );

$services = new WP_Query( array(
	'post_type'      => 'optifo_service',
	'posts_per_page' => -1,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
) );

if ( ! $services->have_posts() && empty( $s['cards'] ) ) {
	return;
}
?>
<section class="optifo-services-section py-5" id="services">
	<div class="container custom_container">
		<?php if ( ! empty( $s['heading_bold'] ) ) : ?>
			<h2 class="font-34 font-montserrat text-center mb-5 letter-spacing-2 text-white text-uppercase">
				<span class="fw-light"><?php echo esc_html( $s['heading_light'] ?? '' ); ?></span>
				<strong class="fw-semibold"><?php echo esc_html( $s['heading_bold'] ); ?></strong>
			</h2>
		<?php endif; ?>
		<div class="row g-4">
			<?php if ( $services->have_posts() ) : ?>
				<?php while ( $services->have_posts() ) : $services->the_post();
					$icon     = get_post_meta( get_the_ID(), '_optifo_icon', true );
					$btn_text = get_post_meta( get_the_ID(), '_optifo_button_text', true );
					$btn_url  = get_post_meta( get_the_ID(), '_optifo_button_url', true );
					?>
					<div class="col-md-6 col-lg-4">
						<div class="card h-100 border-0 text-center p-4">
							<?php if ( has_post_thumbnail() || $icon ) : ?>
								<div class="mb-3"><?php echo $icon ? wp_kses_post( wp_get_attachment_image( $icon, 'thumbnail' ) ) : get_the_post_thumbnail( null, 'thumbnail' ); ?></div>
							<?php endif; ?>
							<h3 class="font-16 font-montserrat fw-semibold"><?php the_title(); ?></h3>
							<div class="font-12"><?php the_excerpt(); ?></div>
							<?php if ( $btn_text ) : ?>
								<a href="<?php echo esc_url( $btn_url ?: get_permalink() ); ?>" class="btn btn-light rounded-pill font-13 mt-3"><?php echo esc_html( $btn_text ); ?></a>
							<?php endif; ?>
						</div>
					</div>
				<?php endwhile;
				wp_reset_postdata(); ?>
			<?php else : ?>
				<?php foreach ( (array) ( $s['cards'] ?? array() ) as $card ) : ?>
					<div class="col-md-6 col-lg-4">
						<div class="card h-100 border-0 text-center p-4">
							<?php optifo_image( $card['image'] ?? 0, 'optifo-card', '', $card['title'] ?? '' ); ?>
							<h3 class="font-16 font-montserrat fw-semibold"><?php echo esc_html( $card['title'] ?? '' ); ?></h3>
							<p class="font-12"><?php echo esc_html( $card['subtitle'] ?? '' ); ?></p>
							<p class="font-12"><?php echo wp_kses_post( $card['description'] ?? '' ); ?></p>
							<?php if ( ! empty( $card['button_text'] ) ) : ?>
								<a href="<?php echo esc_url( $card['button_url'] ?? '#' ); ?>" class="btn btn-light rounded-pill font-13"><?php echo esc_html( $card['button_text'] ); ?></a>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>
