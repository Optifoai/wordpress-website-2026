<?php
/**
 * Single post template.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="site-main">
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'text-white' ); ?>>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="mb-4"><?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid rounded' ) ); ?></div>
				<?php endif; ?>
				<h1 class="font-montserrat font-34 mb-3"><?php the_title(); ?></h1>
				<p class="font-12 text-white-50 mb-4"><?php echo esc_html( get_the_date() ); ?></p>
				<div class="entry-content font-montserrat font-14"><?php the_content(); ?></div>
			</article>
			<?php the_post_navigation(); ?>
			<?php comments_template(); ?>
		<?php endwhile; ?>
		<?php get_sidebar(); ?>
</main>
<?php
get_footer();
