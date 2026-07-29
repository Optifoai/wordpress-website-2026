<?php
/**
 * How it works section.
 *
 * @package Optifo
 */
defined( 'ABSPATH' ) || exit;
$s = get_query_var( 'optifo_section', optifo_get_section_data( 'how_it_works' ) );
$steps     = ! empty( $s['steps'] ) ? $s['steps'] : optifo_default_how_it_works_section()['steps'];
$video_url = $s['video_url'] ?? optifo_default_how_it_works_section()['video_url'];
$poster    = optifo_get_image_url( $s['poster'] ?? 0, 'large', 'video_banner.png' );
?>
<section class="how-to-use-section" id="how-it-works">
	<div class="container custom_container text-center">
		<div class="row mb-4">
			<div class="col-12 col-sm-10 col-md-5 m-auto">
				<h2 class="font-34 letter-spacing-2 font-montserrat">
					<span class="fw-normal"><?php echo esc_html( $s['heading_light'] ?? 'HOW TO' ); ?></span>
					<strong class="fw-semibold"><?php echo esc_html( $s['heading_bold'] ?? 'USE OPTIFO?' ); ?></strong>
				</h2>
				<p class="font-montserrat mb-4 fw-normal font-14"><?php echo esc_html( $s['description'] ?? 'In the video below, we briefly explain how Optifo works.' ); ?></p>
			</div>

			<div class="col-md-8 m-auto">
				<div class="card video_wrap position-relative">

                     <!-- Poster Image -->
					<img src="<?php echo esc_url( $poster ); ?>"
					class="posterImg w-100 position-absolute top-0 start-0"
					style="height:500px; object-fit:cover; border-radius:25px; z-index:0;">

				    <iframe style="border-radius: 25px;" class="youtubeVideo" width="100%" height="500" src="<?php echo esc_url( $video_url ); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

					<!-- Overlay -->
					<div class="overlay position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50" style="border-radius:25px;">
					</div>
					<!-- Play Button -->
					<div class="playBtn position-absolute top-50 start-50 translate-middle">
						<button class="btn btn-light rounded-circle d-flex align-items-center justify-content-center"
							style="width:70px;height:70px;">
							<?php optifo_image( 0, 'full', 'video_play_icon.png', 'Play' ); ?>
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row g-3 justify-content-center font-montserrat">
			<?php foreach ( $steps as $step ) : ?>
				<div class="col-6 col-md-4 col-lg-4 col-xl-2">
					<div class="card text-center h-100 step_item">
						<div class="card-body pb-5 pt-5">
							<span class="fw-bold font-24 d-inline-block"><?php echo esc_html( $step['number'] ?? '' ); ?></span>
							<p class="mb-0 font-14 text-uppercase fw-semibold mt-2"><?php echo esc_html( $step['title'] ?? '' ); ?></p>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
