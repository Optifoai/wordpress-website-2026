<?php
/**
 * Main template fallback.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="site-main custom_container container py-5">
	<div class="row">
		<div class="col-lg-8">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-5' ); ?>>
						<h1 class="font-montserrat font-34 mb-3"><?php the_title(); ?></h1>
						<div class="entry-content font-montserrat font-14">
							<?php the_content(); ?>
						</div>
					</article>
				<?php endwhile; ?>
				<?php the_posts_navigation(); ?>
			<?php else : ?>
				<p><?php esc_html_e( 'No content found.', 'optifo' ); ?></p>
			<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</main>
<?php
get_footer();
