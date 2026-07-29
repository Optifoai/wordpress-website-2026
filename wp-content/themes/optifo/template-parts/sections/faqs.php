<?php
/**
 * FAQ section.
 *
 * @package Optifo
 */
defined( 'ABSPATH' ) || exit;
$s = get_query_var( 'optifo_section', optifo_get_section_data( 'faqs' ) );

$faqs = new WP_Query( array(
	'post_type'      => 'optifo_faq',
	'posts_per_page' => 10,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
) );
$use_dummy = ! $faqs->have_posts();
?>
<div class="container-fluid pe-lg-5 ps-lg-5 py-5">
	<div class="row g-5">
		<div class="col-lg-6 pe-0">
			<?php optifo_image( $s['image'] ?? 0, 'large', 'faqs.png', 'FAQs', 'img-fluid w-100' ); ?>
		</div>
		<div class="col-lg-6 align-content-center" style="background:linear-gradient(136.83deg,#F2F2F2 4.75%,#F5F5F6 13.22%,#F5F5F7 22.69%,#F2F2F6 33.91%,#F2F2F5 45.58%,#F1F0F4 56.8%,#F0F1F4 66.05%,#ECEDF1 76.61%,#F6F6F8 85.2%,#FCFCFE 94.33%);">
			<h1 class="font-34 letter-spacing-2 text-uppercase font-montserrat">
				<span class="fw-normal"><?php echo nl2br( esc_html( $s['heading_light'] ?? 'Questions? We have' ) ); ?></span>
				<span class="fw-semibold"><?php echo esc_html( $s['heading_bold'] ?? 'got answers.' ); ?></span>
			</h1>
			<p class="font-montserrat fw-normal font-14 mb-4"><?php echo esc_html( $s['description'] ?? 'Everything you need to know, all in one place.' ); ?></p>
			<div class="accordion accordion-flush" id="faqAccordion">
				<?php
				$i = 0;
				if ( ! $use_dummy ) :
					while ( $faqs->have_posts() ) :
						$faqs->the_post();
						++$i;
						$collapse_id = 'faq-' . get_the_ID();
						$open        = 1 === $i ? 'show' : '';
						$collapsed   = 1 === $i ? '' : 'collapsed';
						?>
						<div class="accordion-item border-bottom bg-transparent">
							<h2 class="accordion-header">
								<button class="shadow-none pb-4 pt-4 text-dark bg-transparent accordion-button font-montserrat font-14 fw-medium px-0 <?php echo esc_attr( $collapsed ); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr( $collapse_id ); ?>">
									<span class="me-4 fw-semibold"><?php echo esc_html( str_pad( (string) $i, 2, '0', STR_PAD_LEFT ) ); ?></span> <?php the_title(); ?>
								</button>
							</h2>
							<div id="<?php echo esc_attr( $collapse_id ); ?>" class="accordion-collapse collapse <?php echo esc_attr( $open ); ?>" data-bs-parent="#faqAccordion">
								<div class="accordion-body ps-4"><div class="font-montserrat fw-light font-12"><?php the_content(); ?></div></div>
							</div>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
				else :
					foreach ( optifo_get_default_faq_items() as $faq ) :
						++$i;
						$collapse_id = 'faq-dummy-' . $i;
						$open        = ! empty( $faq['open'] ) ? 'show' : '';
						$collapsed   = ! empty( $faq['open'] ) ? '' : 'collapsed';
						?>
						<div class="accordion-item border-bottom bg-transparent">
							<h2 class="accordion-header">
								<button class="shadow-none pb-4 pt-4 text-dark bg-transparent accordion-button font-montserrat font-14 fw-medium px-0 <?php echo esc_attr( $collapsed ); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr( $collapse_id ); ?>">
									<span class="me-4 fw-semibold"><?php echo esc_html( str_pad( (string) $i, 2, '0', STR_PAD_LEFT ) ); ?></span> <?php echo esc_html( $faq['question'] ); ?>
								</button>
							</h2>
							<div id="<?php echo esc_attr( $collapse_id ); ?>" class="accordion-collapse collapse <?php echo esc_attr( $open ); ?>" data-bs-parent="#faqAccordion">
								<div class="accordion-body ps-4">
									<p class="font-montserrat fw-light font-12"><?php echo esc_html( $faq['answer'] ); ?></p>
								</div>
							</div>
						</div>
						<?php
					endforeach;
				endif;
				?>
			</div>
		</div>
	</div>
</div>
