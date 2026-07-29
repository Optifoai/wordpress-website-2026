<?php
/**
 * Header template.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>


<nav class="navbar navbar-expand-xl custom-navbar pt-3 pb-3">
	<div class="container custom_container">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="align-items-center d-flex fw-bold navbar-brand text-white">
			<div class="me-4">
				<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				} else {
					optifo_image( 0, 'full', 'header_logo.png', get_bloginfo( 'name' ), '' );
				}
				?>
			</div>
			<div class="font-raleway">
				<span class="fw-bold font-34 letter-spacing-2"><?php bloginfo( 'name' ); ?></span>
				<span class="fw-normal font-14 d-block"><?php echo esc_html( get_theme_mod( 'optifo_site_tagline', get_bloginfo( 'description' ) ) ); ?></span>
			</div>
		</a>
		<button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'optifo' ); ?>">
			&#9776;
		</button>
		<div class="collapse navbar-collapse justify-content-end" id="navMenu">
			<?php
				$menu_name = 'primary';
				$locations = get_nav_menu_locations();
				if ( isset( $locations[$menu_name] ) ):
					$menu_id    = $locations[$menu_name];
					$menu_items = wp_get_nav_menu_items( $menu_id); ?>
					<?php if ( $menu_items ): ?>
						<ul class="navbar-nav align-items-center">
							<?php foreach ( $menu_items as $item ) : ?>
								<li class="nav-item">
									<a href="<?php echo esc_url( $item->url ); ?>"
									class="font-montserrat fw-medium nav-link font-13 letter-spacing-2 text-uppercase"
									style="color: white !important;">
										<?php echo esc_html( $item->title ); ?>
									</a>
								</li>
							<?php endforeach; ?>
							<li class="nav-item ms-3">
								<a href="#"	class="bg-white btn font-montserrat fw-semibold login-btn rounded-pill font-13">
									LOGIN
								</a>
							</li>
						</ul>
					<?php else: ?>
						<ul class="navbar-nav align-items-center">
							<li class="nav-item">
								<a href="#about" class="font-montserrat fw-medium nav-link font-13 letter-spacing-2 text-uppercase" style="color: white !important;">
									ABOUT US
								</a>
							</li>

							<li class="nav-item">
								<a href="#how-it-works" class="font-montserrat fw-medium nav-link font-13 letter-spacing-2 text-uppercase" style="color: white !important;">
									HOW IT WORKS
								</a>
							</li>

							<li class="nav-item">
								<a href="#customer" class="font-montserrat fw-medium nav-link font-13 letter-spacing-2 text-uppercase" style="color: white !important;">
									CUSTOMER
								</a>
							</li>

							<li class="nav-item">
								<a href="#pricing" class="font-montserrat fw-medium nav-link font-13 letter-spacing-2 text-uppercase" style="color: white !important;">
									PRICING
								</a>
							</li>

							<li class="nav-item">
								<a href="#contact" class="font-montserrat fw-medium nav-link font-13 letter-spacing-2 text-uppercase" style="color: white !important;">
									CONTACT
								</a>
							</li>

							<li class="nav-item ms-3">
								<a class="bg-white btn font-montserrat fw-semibold login-btn rounded-pill font-13">
									LOGIN
								</a>
							</li>
						</ul>
					<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</nav>
