<?php
/**
 * Contact section template part.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

$s              = get_query_var( 'optifo_section', optifo_get_section_data( 'contact' ) );
$recaptcha_key  = optifo_get_option( 'recaptcha_site_key', '' );
$heading_light  = $s['heading_light'] ?? 'WE WOULD LOVE TO';
$heading_bold   = $s['heading_bold'] ?? 'TALK TO YOU!';
$description    = $s['description'] ?? 'If you would like to know more about Optifo and how we can help your dealer, please fill in your details below and a sales specialist will contact you.';
$video_url      = $s['video_url'] ?? 'https://www.youtube.com/embed/CBS-qVEGb5k?si=MtLM6Nw0p0Wvzquy&start=1';
$poster         = optifo_get_image_url( $s['poster'] ?? 0, 'large', 'video_banner.png' );

?>
<div class="custom_container container py-5 mt-5" id="contact">
	<div class="col-sm-12 col-md-8 col-lg-6 m-auto text-center mb-5">
		<h2 class="font-montserrat fw-normal letter-spacing-2 text-uppercase">
			<?php echo esc_html( $heading_light ); ?> <span class="fw-semibold"><?php echo esc_html( $heading_bold ); ?></span>
		</h2>
		<p class="font-14 font-montserrat fw-normal"><?php echo esc_html( $description ); ?></p>
	</div>
	<div class="row m-0 align-items-center g-5">
		<div class="col-md-12 col-lg-7">
			<div class="card video_wrap position-relative">
			    <img src="<?php echo esc_url( $poster ); ?>"
					class="posterImg w-100 position-absolute top-0 start-0"
					style="height:500px; object-fit:cover; border-radius:25px; z-index:0;">

				<iframe style="border-radius: 25px;" class="youtubeVideo" width="100%" height="500" src="<?php echo esc_url( $video_url ); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
				 
				<div class="overlay position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50" style="border-radius:25px;"></div>
				<div class="playBtn position-absolute top-50 start-50 translate-middle">
					<button type="button" class="btn btn-light rounded-circle d-flex align-items-center justify-content-center" style="width:70px;height:70px;">
						<?php optifo_image( 0, 'full', 'video_play_icon.png', 'Play' ); ?>
					</button>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-lg-5">
			<form id="optifo-contact-form" class="d-flex flex-column gap-3" method="post">
				<input type="text" name="name" class="font-14 font-montserrat form-control fst-italic fw-normal py-3 rounded-pill ps-4" placeholder="<?php esc_attr_e( 'Your Name', 'optifo' ); ?>" required>
				<input type="email" name="email" class="font-14 font-montserrat form-control fst-italic fw-normal py-3 rounded-pill ps-4" placeholder="<?php esc_attr_e( 'Email Address', 'optifo' ); ?>" required>
				<textarea name="message" class="font-14 font-montserrat fst-italic fw-normal form-control rounded-4 py-3 ps-4" rows="4" placeholder="<?php esc_attr_e( 'Your Message', 'optifo' ); ?>" required></textarea>
				<?php if ( $recaptcha_key ) : ?>
					<div class="g-recaptcha" data-sitekey="<?php echo esc_attr( $recaptcha_key ); ?>"></div>
				<?php endif; ?>
				<button type="submit" class="align-self-start bg-primary btn font-13 font-montserrat fw-semibold rounded-pill text-white" style="width:134px;height:44px;">
				SEND
					<?php optifo_image( 0, 'full', 'button_arrow_icon.png', '', 'ms-2' ); ?>
				</button>
				<div class="optifo-form-message font-12"></div>
			</form>
		</div>
	</div>
</div>
