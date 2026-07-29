<?php
/**
 * Page template.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="site-main">
	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<!-- <h1 class="font-montserrat font-34 letter-spacing-2 text-white mb-4"><?php the_title(); ?></h1> -->
			<div class="entry-content font-montserrat font-14 text-white">
				<?php the_content(); ?>
			</div>
		</article>
	<?php endwhile; ?>
</main>
<?php
get_footer();
