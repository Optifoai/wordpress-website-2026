<?php
/**
 * App store buttons section.
 *
 * @package Optifo
 */
defined( 'ABSPATH' ) || exit;
$app_ios = optifo_get_option( 'app_store_url', 'https://apps.apple.com/us/app/optifo-automated-car-studio/id1539383737' );
$app_and = optifo_get_option( 'play_store_url', 'https://play.google.com/store/apps/details?id=com.mobcoder.optifo' );
?>
<div class="custom_container container py-5 text-center">
	<div class="d-flex justify-content-center gap-3 mt-5 flex-wrap">
		<a href="<?php echo esc_url( $app_ios ); ?>" target="_blank" rel="noopener"><?php optifo_image( 0, 'full', 'app_store_black_button.png', 'App Store' ); ?></a>
		<a href="<?php echo esc_url( $app_and ); ?>" target="_blank" rel="noopener"><?php optifo_image( 0, 'full', 'play_store_black_button.png', 'Play Store' ); ?></a>
	</div>
</div>
