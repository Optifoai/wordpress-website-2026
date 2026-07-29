<?php
/**
 * Worldwide trust / testimonials section.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

$s = get_query_var( 'optifo_section', optifo_get_section_data( 'worldwide_trust' ) );
?>
<section class="worldwide-trust-section bg-main" id="customer">
	<div class="container custom_container mb-4">
		<div class="row">
			<div class="col-md-7 m-auto text-center font-montserrat text-white">
				<h2 class="font-34 fw-normal letter-spacing-2 text-uppercase">
					<span><?php echo esc_html( $s['heading_light'] ?? 'Worldwide' ); ?></span>
					<span class="fw-semibold"><?php echo esc_html( $s['heading_bold'] ?? 'Trust' ); ?></span>
				</h2>
				<p class="fw-normal font-14"><?php echo esc_html( $s['description'] ?? "We're proud that Optifo is being actively used by car dealerships worldwide." ); ?></p>
			</div>
		</div>
		<?php
		$testimonials = new WP_Query( array(
			'post_type'      => 'optifo_testimonial',
			'posts_per_page' => 3,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		) );
		if ( $testimonials->have_posts() ) : ?>
			<div class="row mt-4 g-3">
				<?php while ( $testimonials->have_posts() ) : $testimonials->the_post(); ?>
					<div class="col-md-4">
						<div class="card bg-transparent border border-light text-white h-100 p-3">
							<?php the_excerpt(); ?>
							<strong class="font-12 mt-2"><?php the_title(); ?></strong>
							<span class="font-10"><?php echo esc_html( get_post_meta( get_the_ID(), '_optifo_role', true ) ); ?></span>
						</div>
					</div>
				<?php endwhile;
				wp_reset_postdata(); ?>
			</div>
		<?php endif; ?>
	</div>
	<div id="map" style="width:100%;height:600px;"></div>
</section>
