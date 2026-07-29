<?php
/**
 * Footer template.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

$privacy = get_page_by_path( 'privacy-policy' );
$terms   = get_page_by_path( 'terms' );
$privacy_url = $privacy ? get_permalink( $privacy ) : home_url( '/privacy-policy/' );
$terms_url   = $terms ? get_permalink( $terms ) : home_url( '/terms/' );
$app_store   = optifo_get_option( 'app_store_url', 'https://apps.apple.com/us/app/optifo-automated-car-studio/id1539383737' );
$play_store  = optifo_get_option( 'play_store_url', 'https://play.google.com/store/apps/details?id=com.mobcoder.optifo' );
$email       = get_theme_mod( 'optifo_contact_email', optifo_get_option( 'contact_email', 'info@optifo.com' ) );
$phone       = get_theme_mod( 'optifo_contact_phone', optifo_get_option( 'contact_phone', 'Tel. +45 28 49 50 60' ) );
?>
<footer class="py-5 mt-5 bg-main">
	<div class="container-fluid" style="padding:55px 100px;">
		<div class="row g-5 text-white">
			<div class="col-lg-3 col-xl-2">
				<div class="bg-overlay-medium p-4 text-center" style="padding:46px 0px !important;">
					<div class="mb-4">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php optifo_image( 0, 'full', 'header_logo.png', get_bloginfo( 'name' ), '' ); ?>
						</a>
					</div>
					<h4 class="fw-bold mb-1 font-raleway font-24 letter-spacing-2"><?php bloginfo( 'name' ); ?></h4>
					<small class="font-raleway text-white font-10 fw-normal"><?php echo esc_html( get_theme_mod( 'optifo_site_tagline', get_bloginfo( 'description' ) ) ); ?></small>
				</div>
			</div>

			<div class="col-6 col-lg-3 col-xl-2">
				<h6 class="font-14 font-montserrat fw-semibold mb-4 text-uppercase"><?php esc_html_e( 'Product', 'optifo' ); ?></h6>
				<ul class="list-unstyled small">
					<li class="mb-2"><a href="<?php echo esc_url( $app_store ); ?>" class="text-decoration-none font-montserrat font-12 text-white fw-normal" target="_blank" rel="noopener"><?php esc_html_e( 'Download iOS app', 'optifo' ); ?></a></li>
					<li class="mb-2"><a href="<?php echo esc_url( $play_store ); ?>" class="text-decoration-none font-montserrat font-12 text-white fw-normal" target="_blank" rel="noopener"><?php esc_html_e( 'Download android app', 'optifo' ); ?></a></li>
					<li class="mb-2"><a href="<?php echo esc_url( home_url( '/#pricing' ) ); ?>" class="text-decoration-none font-montserrat font-12 text-white fw-normal"><?php esc_html_e( 'Pricing', 'optifo' ); ?></a></li>
					<li class="mb-2"><a href="<?php echo esc_url( optifo_get_option( 'header_login_url', '#' ) ); ?>" class="text-decoration-none font-montserrat font-12 text-white fw-normal"><?php echo esc_html( optifo_get_option( 'header_login_text', 'LOGIN' ) ); ?></a></li>
				</ul>
			</div>

			<div class="col-6 col-lg-3 col-xl-2">
				<h6 class="font-14 font-montserrat fw-semibold mb-4 text-uppercase"><?php esc_html_e( 'Optifo', 'optifo' ); ?></h6>
				<ul class="list-unstyled small">
					<li class="mb-2"><a href="<?php echo esc_url( $terms_url ); ?>" class="text-decoration-none font-montserrat font-12 text-white fw-normal"><?php esc_html_e( 'Terms & conditions', 'optifo' ); ?></a></li>
					<li><a href="<?php echo esc_url( $privacy_url ); ?>" class="text-decoration-none font-montserrat font-12 text-white fw-normal"><?php esc_html_e( 'Privacy policy', 'optifo' ); ?></a></li>
				</ul>
			</div>

			<div class="col-lg-3">
				<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
					<?php dynamic_sidebar( 'footer-1' ); ?>
				<?php else : ?>
					<h6 class="font-14 font-montserrat fw-semibold mb-4 text-uppercase"><?php esc_html_e( 'Support', 'optifo' ); ?></h6>
					<ul class="list-unstyled small font-montserrat font-12 text-white fw-normal">
						<li class="mb-2"><?php esc_html_e( 'Contact', 'optifo' ); ?></li>
						<li class="mb-2"><?php printf( 'Email Us: <a href="mailto:%1$s" class="text-white">%1$s</a>', esc_html( $email ) ); ?></li>
						<li>
							<a href="tel:<?php echo preg_replace('/[^0-9]/', '', $phone); ?>" class="text-decoration-none font-montserrat font-12 text-white fw-normal">
								<?php echo esc_html( $phone ); ?>
							</a>
						</li>
					</ul>
				<?php endif; ?>
			</div>

			<div class="col-lg-2">
				<h6 class="font-14 font-montserrat fw-semibold mb-4 text-uppercase"><?php esc_html_e( 'Follow us on', 'optifo' ); ?></h6>
				<?php optifo_social_links( 'footer' ); ?>
				<small class="text-decoration-none font-montserrat font-12 text-white fw-normal">
					<?php echo wp_kses_post( get_theme_mod( 'optifo_footer_copyright', '© Copyright 2025 Optifo ApS,<br>All Rights Reserved.' ) ); ?>
				</small>
			</div>
		</div>
	</div>
</footer>
 
<?php if ( is_front_page() ) : ?>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			if (typeof L === 'undefined' || !document.getElementById('map')) return;
			var cfg = typeof optifoData !== 'undefined' ? optifoData.mapConfig : {};
			var map = L.map('map', {
				center: [cfg.center?.lat || 22.9734, cfg.center?.lng || 78.6569],
				zoom: cfg.zoom || 5,
				minZoom: 2
			});
			L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
				attribution: '&copy; OpenStreetMap &copy; CARTO'
			}).addTo(map);
			(cfg.locations || []).forEach(function(city) {
				L.circleMarker([parseFloat(city.lat), parseFloat(city.lng)], {
					radius: 8, fillColor: '#ff704c', color: '#ffffff', weight: 2, opacity: 1, fillOpacity: 0.9
				}).addTo(map).bindPopup('<b>' + city.name + '</b><br>' + city.address);
			});
		});
	</script>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
