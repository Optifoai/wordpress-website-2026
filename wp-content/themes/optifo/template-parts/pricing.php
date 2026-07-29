<?php
/**
 * Pricing section template part.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

$s = get_query_var( 'optifo_section', optifo_get_section_data( 'pricing' ) );

$plans = new WP_Query( array(
	'post_type'      => 'optifo_pricing',
	'posts_per_page' => -1,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
) );
?>
<section class="packs-and-pricing-section" id="pricing">
	<div class="container custom_container py-5">
		<div class="row align-items-center g-5 m-0">
			<div class="col-lg-6 text-center font-montserrat">
				<h2 class="font-34 text-white letter-spacing-2 text-uppercase" style="line-height:48px;">
					<span class="fw-normal"><?php echo esc_html( $s['heading_light'] ?? 'PACKS AND' ); ?></span>
					<span class="fw-semibold"><?php echo esc_html( $s['heading_bold'] ?? 'PRICING' ); ?> <br> <?php echo esc_html( $s['heading_bold_line2'] ?? 'CRAFTED' ); ?></span>
					<span class="fw-normal"><?php echo esc_html( $s['heading_light_2'] ?? 'TO MEET' ); ?></span>
					<span class="fw-semibold"><?php echo esc_html( $s['heading_bold_2'] ?? 'ANY SIZE' ); ?></span>
				</h2>
				<p class="font-montserrat fw-semibold mb-4 mt-4 text-white"><?php echo esc_html( $s['subtitle'] ?? '1 Credit = 1 Image' ); ?></p>
				<div class="btn-group rounded-pill overflow-hidden mt-3 mb-3" role="group">
					<input type="radio" class="btn-check" name="currency" id="eur" checked="">
					<label class="btn btn-danger px-4 font-montserrat fw-semibold font-18 border-0" for="eur" style="background-color:#EA645F;width:100px;height:44px;line-height: 30px;">EUR</label>

					<input type="radio" class="btn-check" name="currency" id="dkk">
					<label class="btn btn-dark px-4 font-montserrat fw-semibold font-18 border-0" style="background-color:#EA645F21;width:100px;height:44px;line-height: 30px;" for="dkk">DKK</label>
				</div>
				<p class="font-montserrat font-12 mt-4 text-white w-75 m-auto" style="font-style:italic;">
					<?php echo wp_kses_post( $s['footnote'] ?? '*All packs exclude VAT.' ); ?>
				</p>
			</div>
			<div class="col-lg-6">
				<div class="row g-4">
					<?php if ( $plans->have_posts() ) : ?>
						<?php while ( $plans->have_posts() ) : $plans->the_post();
							$price    = get_post_meta( get_the_ID(), '_optifo_price', true );
							$subtitle = get_post_meta( get_the_ID(), '_optifo_price_subtitle', true );
							$btn_text = get_post_meta( get_the_ID(), '_optifo_button_text', true ) ?: 'GET STARTED';
							$btn_url  = get_post_meta( get_the_ID(), '_optifo_button_url', true ) ?: '#';
							$icon_id  = get_post_meta( get_the_ID(), '_optifo_icon', true );
							?>
							<div class="col-md-6">
								<div class="card text-center border-0 h-100 packs-and-pricing">
									<div class="mb-4">
										<?php optifo_image( $icon_id, 'thumbnail', 'transaction_box_icon.png', get_the_title() ); ?>
									</div>
									<h5 class="fw-bold font-16 font-oswald"><?php the_title(); ?></h5>
									<?php if ( $price ) : ?><p class="fw-normal font-12 font-poppins text-white"><?php echo esc_html( $price ); ?></p><?php endif; ?>
									<?php if ( $subtitle ) : ?><p class="fw-normal font-12 font-poppins text-white"><?php echo esc_html( $subtitle ); ?></p><?php endif; ?>
										
									<button onclick="window.location.href='<?php echo esc_url( $btn_url ); ?>';" 	class="btn btn-light rounded-pill font-montserrat fw-semibold font-13">
										<?php echo esc_html( $btn_text ); ?>
									</button>

								</div>
							</div>
						<?php endwhile;
						wp_reset_postdata(); ?>
					<?php else :
						$cards = ! empty( $s['cards'] ) ? $s['cards'] : optifo_get_default_pricing_cards();
						foreach ( $cards as $card ) : ?>
							<div class="col-md-6">
								<div class="card text-center border-0 h-100 packs-and-pricing">
									<div class="mb-4"><?php optifo_image( $card['image'] ?? 0, 'thumbnail', 'transaction_box_icon.png', '' ); ?></div>
									<h5 class="fw-bold font-16 font-oswald"><?php echo esc_html( $card['title'] ?? '' ); ?></h5>
									<p class="fw-normal font-12 font-poppins text-white"><?php echo esc_html( $card['subtitle'] ?? '' ); ?></p>

									<?php if ( ! empty( $card['button_text'] ) ) : ?>
										<button onclick="window.location.href='<?php echo esc_url( $card['button_url'] ?? '#' ); ?>';" 	class="btn btn-light rounded-pill font-montserrat fw-semibold font-13">
											<?php echo esc_html( $card['button_text'] ); ?>
										</button>
									<?php endif; ?>

								</div>
							</div>
						<?php endforeach;
					endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
