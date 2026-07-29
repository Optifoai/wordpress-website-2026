<?php
/**
 * Hero section template part.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

$s       = get_query_var( 'optifo_section', optifo_get_section_data( 'hero' ) );
$app_ios = optifo_get_option( 'app_store_url', 'https://apps.apple.com/us/app/optifo-automated-car-studio/id1539383737' );
$app_and = optifo_get_option( 'play_store_url', 'https://play.google.com/store/apps/details?id=com.mobcoder.optifo' );
$email   = get_theme_mod( 'optifo_contact_email', 'info@optifo.com' );
$phone   = get_theme_mod( 'optifo_contact_phone', 'Tel. +45 28 49 50 60' );

$badge_light = $s['heading_light'] ?? 'AI';
$badge_bold  = $s['heading_bold'] ?? 'IMAGING APP';
$title_light = $s['title_light'] ?? 'ELEVATE YOUR SALES WITH';
$title_bold  = $s['title_bold'] ?? "OPTIFOS AI IMAGING APP";
$title_end   = $s['title_end'] ?? ' FOR CAR DEALERS!';
$desc        = $s['description'] ?? 'Professional, AI-powered photo & video editing for car dealers— create consistent, high-quality vehicle images effortlessly.';
$price_label = $s['price_label'] ?? '129 EURO/MONTH';
$price_sub   = $s['price_subtitle'] ?? 'UNLIMITED CREDITS';
?>
<section class="hero-section">
	<div class="custom_container container">
		<div class="row align-items-center">
			<div class="col-lg-12 col-xl-6 text-center">
				<div class="badge-ai font-montserrat font-34 fw-semibold d-inline letter-spacing-2">
					<span class="pe-2"><?php echo esc_html( $badge_light ); ?></span><br>
					<span class="ps-2"><?php echo esc_html( $badge_bold ); ?></span>
				</div>
				<h1 class="mt-4 font-34 font-montserrat letter-spacing-2">
					<span class="fw-light"><?php echo esc_html( $title_light ); ?></span><br>
					<strong class="fw-semibold"><?php echo esc_html( $title_bold ); ?></strong>
					<span class="fw-light"><?php echo esc_html( $title_end ); ?></span>
				</h1>
				<p class="mt-3 font-montserrat font-16 fw-normal"><?php echo wp_kses_post( nl2br( $desc ) ); ?></p>
				<div class="mt-5 d-sm-flex gap-3 justify-content-center">
					<a href="<?php echo esc_url( $app_ios ); ?>" class="d-block mb-3" target="_blank" rel="noopener">
						<?php optifo_image( $s['app_store_image'] ?? 0, 'full', 'app_store_white_button.png', 'App Store' ); ?>
					</a>
					<a href="<?php echo esc_url( $app_and ); ?>" class="d-block mb-3" target="_blank" rel="noopener">
						<?php optifo_image( $s['play_store_image'] ?? 0, 'full', 'play_store_white_button.png', 'Play Store' ); ?>
					</a>
				</div>
			</div>
			<div class="col-lg-12 col-xl-5 ms-auto mt-5 mt-xl-0">
				<div class="banner_section position-relative">
					<div class="banner_image_content font-montserrat fw-bold position-absolute text-center">
						<span class="font-24"><?php echo esc_html( $price_label ); ?></span><br>
						<span class="font-18"><?php echo esc_html( $price_sub ); ?></span>
					</div>
					<?php optifo_image( $s['banner_image'] ?? 0, 'full', 'banner_img.png', '', 'w-100' ); ?>
					<div class="image_button_content">
						<ul class="d-flex list-unstyled justify-content-end">
							<li><a href="mailto:<?php echo esc_attr( $email ); ?>" class="text-decoration-none font-montserrat fw-semibold font-12 text-primary"><?php echo esc_html( $email ); ?></a></li>
							<li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" class="text-decoration-none font-montserrat fw-semibold font-12 text-primary"><?php echo esc_html( $phone ); ?></a></li>
						</ul>
					</div>
					<div class="banner_right_menu"><?php optifo_social_links( 'banner' ); ?></div>
				</div>
			</div>
		</div>
	</div>
</section>
