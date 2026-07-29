<?php
/**
 * Dashboard preview section.
 *
 * @package Optifo
 */
defined( 'ABSPATH' ) || exit;
$s = get_query_var( 'optifo_section', optifo_get_section_data( 'dashboard' ) );
?>
<section class="mt-5 pt-4">
	<div class="custom_container container">
		<div class="col-md-9 m-auto">
			<div class="dashbaord_img">
				<?php optifo_image( $s['image'] ?? 0, 'full', 'dashbaord.png', 'Dashboard', 'w-100' ); ?>
			</div>
		</div>
	</div>
</section>
