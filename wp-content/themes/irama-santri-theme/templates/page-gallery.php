<?php
/**
 * Template Name: Gallery
 *
 * @package IramaSantriTheme
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="primary" class="mx-auto max-w-6xl px-4 py-10">
	<header class="mb-8">
		<h1 class="mb-2 text-3xl font-semibold"><?php esc_html_e( 'Gallery', 'irama-santri' ); ?></h1>
		<p class="text-coffee-700"><?php esc_html_e( 'Lihat suasana dan kegiatan di Kedai Kopi Irama Santri.', 'irama-santri' ); ?></p>
	</header>

	<?php
	$gallery_ids = irama_santri_get_gallery_ids();
	if ( ! empty( $gallery_ids ) ) :
		?>
		<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
			<?php
			foreach ( $gallery_ids as $attachment_id ) :
				if ( 'attachment' !== get_post_type( $attachment_id ) ) {
					continue;
				}
				$url = wp_get_attachment_image_url( $attachment_id, 'gallery-thumb' );
				?>
				<figure class="overflow-hidden rounded border border-cream-100 bg-cream-100">
					<img src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( get_the_title( $attachment_id ) ); ?>" class="h-full w-full object-cover">
				</figure>
			<?php endforeach; ?>
		</div>
	<?php else : ?>
		<div class="rounded border border-cream-100 bg-cream-100 p-8 text-center">
			<?php esc_html_e( 'Galeri masih dalam pengembangan.', 'irama-santri' ); ?>
		</div>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
