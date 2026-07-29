<?php
/**
 * Behind the design / portfolio carousel section.
 *
 * @package Optifo
 */
defined( 'ABSPATH' ) || exit;
$s = get_query_var( 'optifo_section', optifo_get_section_data( 'behind_design' ) );

$portfolio = new WP_Query( array(
	'post_type'      => 'optifo_portfolio',
	'posts_per_page' => 10,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
) );
?>
<div class="mt-5 py-5 text-center">
	<span class="badge bg-overlay-soft-pink font-20 font-georgia fw-normal letter-spacing-2 mb-3 rounded-pill text-dark" style="padding:10px 20px;">
		<?php echo esc_html( $s['badge_text'] ?? 'BEHIND THE DESIGN' ); ?>
	</span>
	<h3 class="font-34 font-montserrat fw-normal letter-spacing-2 text-uppercase"><?php echo esc_html( $s['heading_bold'] ?? "CURIOUS WHAT ELSE I'VE CREATED?" ); ?></h3>
	<p class="font-14 font-montserrat fw-normal mt-3"><?php echo esc_html( $s['description'] ?? '' ); ?></p>
	<?php if ( ! empty( $s['button_text'] ) ) : ?>
		<button onclick="window.location.href='<?php echo esc_url( $s['button_url'] ?? get_post_type_archive_link( 'optifo_portfolio' ) ); ?>';"
			class="btn font-13 font-montserrat fw-semibold rounded-pill text-white mb-4 mt-3"
			style="height:44px;width:220px;background-color:#EA645F;">
			<?php echo esc_html( $s['button_text'] ); ?>
			<?php optifo_image( 0, 'full', 'button_arrow_icon.png', '' ); ?>
		</button>
	<?php endif; ?>
	<div class="behind_right_left_carousel_wrapper position-relative">
		<div class="behind_left_carousel owl-carousel">
			<?php
			if ( $portfolio->have_posts() ) :
				while ( $portfolio->have_posts() ) :
					$portfolio->the_post();
					echo '<div>';
					the_post_thumbnail( 'medium', array( 'class' => 'img-fluid' ) );
					echo '</div>';
				endwhile;
				wp_reset_postdata();
			else :
				for ( $i = 0; $i < 5; $i++ ) {
					echo '<div>';
					optifo_image( 0, 'medium', 'car.png', '', 'img-fluid' );
					echo '</div>';
				}
			endif;
			?>
		</div>
		<div class="behind_right_carousel owl-carousel mt-3">
			<?php for ( $i = 0; $i < 5; $i++ ) {
				echo '<div>';
				optifo_image( 0, 'medium', 'car1.png', '', 'img-fluid' );
				echo '</div>';
			} ?>
		</div>
	</div>
	<?php
	$process = $s['process_items'] ?? array(
		array( 'title' => 'Strategy & Planning' ),
		array( 'title' => 'Design & Development' ),
		array( 'title' => 'Launch & Growth' ),
		array( 'title' => 'Ongoing Support' ),
	);
	?>
	<div class="container custom_container mt-4">
		<div class="justify-content-center row text-center">
			<div class="col-md-12 col-lg-7">
				<div class="row">
					<?php foreach ( $process as $idx => $item ) : ?>
						<div class="col-6 col-md-3 mb-4">
							<small class="font-14 font-montserrat fw-semibold"><span class="text-primary">#</span> <?php echo esc_html( str_pad( (string) ( $idx + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></small>
							<p class="font-12 font-montserrat fw-normal mb-0"><?php echo esc_html( $item['title'] ?? '' ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
