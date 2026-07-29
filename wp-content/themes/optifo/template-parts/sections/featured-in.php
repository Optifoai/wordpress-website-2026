<?php
/**
 * Featured in logos section.
 *
 * @package Optifo
 */
defined( 'ABSPATH' ) || exit;
$s = get_query_var( 'optifo_section', optifo_get_section_data( 'featured_in' ) );
$logos = $s['cards'] ?? array(
	array( 'image' => 0, 'fallback' => 'featured_in_logo_1.png' ),
	array( 'image' => 0, 'fallback' => 'featured_in_logo_2.png' ),
	array( 'image' => 0, 'fallback' => 'featured_in_logo_3.png' ),
);
?>
<section class="featuree_in_logo text-center">
	<div class="container custom_container">
		<h2 class="mb-3 fw-normal font-34 letter-spacing-2 font-montserrat"><?php echo esc_html( $s['title'] ?? 'FEATURED IN' ); ?></h2>
		<div class="row g-0 border">
			<?php foreach ( $logos as $i => $logo ) :
				$border = $i < count( $logos ) - 1 ? 'border-end' : '';
				?>
				<div class="col-md-4 <?php echo esc_attr( $border ); ?> py-5 align-items-center d-flex justify-content-center">
					<?php optifo_image( $logo['image'] ?? 0, 'medium', $logo['fallback'] ?? 'featured_in_logo_1.png', '', 'img-fluid' ); ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
