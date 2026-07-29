<?php
/**
 * Counter stats section.
 *
 * @package Optifo
 */
defined( 'ABSPATH' ) || exit;
$s        = get_query_var( 'optifo_section', optifo_get_section_data( 'counter' ) );
$counters = ! empty( $s['counters'] ) ? $s['counters'] : optifo_default_counter_section()['counters'];
?>
<section class="counter-section">
	<div class="custom_container container">
		<div class="row text-center fw-normal">
			<?php foreach ( $counters as $item ) : ?>
				<div class="col-md-6 col-lg-3">
					<div class="counter-item h-100">
						<h2 class="font-montaga font-70"><?php echo esc_html( $item['title'] ?? '' ); ?></h2>
						<p class="font-montserrat font-18"><?php echo esc_html( $item['subtitle'] ?? '' ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
