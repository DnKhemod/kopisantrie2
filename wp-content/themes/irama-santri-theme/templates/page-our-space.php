<?php
/**
 * Template Name: Our Space / Fasilitas
 *
 * @package IramaSantriTheme
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="primary" class="mx-auto max-w-6xl px-4 py-10">
	<?php
	$facilities_query = irama_santri_get_facilities();
	?>
	<header class="mb-8">
		<h1 class="mb-2 text-3xl font-semibold"><?php esc_html_e( 'Our Space', 'irama-santri' ); ?></h1>
		<p class="text-coffee-700"><?php esc_html_e( 'Temukan suasana dan fasilitas tepat di sini.', 'irama-santri' ); ?></p>
	</header>

	<?php if ( $facilities_query->have_posts() ) : ?>
		<div class="space-y-8">
			<?php
			while ( $facilities_query->have_posts() ) :
				$facilities_query->the_post();
				$featured_image = get_the_post_thumbnail_url( get_the_ID(), 'post-thumbnail' );
				?>
				<section class="overflow-hidden rounded border border-cream-100 bg-cream-100/50">
					<?php if ( $featured_image ) : ?>
						<div class="h-48">
							<img src="<?php echo esc_url( $featured_image ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="h-full w-full object-cover">
						</div>
					<?php endif; ?>
					<div class="p-6">
						<h2 class="mb-2 text-2xl font-semibold"><?php the_title(); ?></h2>
						<div class="prose text-coffee-700">
							<?php the_content(); ?>
						</div>
					</div>
				</section>
			<?php endwhile; ?>
		</div>
	<?php else : ?>
		<div class="rounded border border-cream-100 bg-cream-100 p-8 text-center">
			<?php esc_html_e( 'Fasilitas masih dalam pengembangan.', 'irama-santri' ); ?>
		</div>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
</main>

<?php get_footer(); ?>
