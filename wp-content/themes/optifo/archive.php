<?php
/**
 * Archive template for CPTs and blog.
 *
 * @package Optifo
 */

defined( 'ABSPATH' ) || exit;

get_header();
$post_type_obj = get_post_type_object( get_post_type() );
?>
<main id="primary" class="site-main">
	<header class="page-header mb-5 text-center">
		<h1 class="font-montserrat font-34 text-white letter-spacing-2">
			<?php
			if ( $post_type_obj ) {
				echo esc_html( $post_type_obj->labels->name );
			} else {
				the_archive_title();
			}
			?>
		</h1>
		<?php the_archive_description( '<div class="font-14 text-white">', '</div>' ); ?>
	</header>
	<div class="row g-4">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="col-md-6 col-lg-4">
					<article <?php post_class( 'card h-100 border-0' ); ?>>
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'optifo-card', array( 'class' => 'card-img-top' ) ); ?></a>
						<?php endif; ?>
						<div class="card-body">
							<h2 class="font-16 font-montserrat"><a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark"><?php the_title(); ?></a></h2>
							<p class="font-12"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
						</div>
					</article>
				</div>
			<?php endwhile; ?>
			<div class="col-12"><?php the_posts_pagination(); ?></div>
		<?php else : ?>
			<p class="text-white"><?php esc_html_e( 'No items found.', 'optifo' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
