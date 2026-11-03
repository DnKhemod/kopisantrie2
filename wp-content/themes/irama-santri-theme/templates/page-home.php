<?php
/**
 * Template Name: Homepage
 *
 * @package IramaSantriTheme
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<!-- Hero Section -->
<section class="relative overflow-hidden bg-cream-100">
	<div class="mx-auto max-w-6xl px-4 py-16 sm:py-24">
		<div class="mx-auto max-w-3xl text-center">
			<p class="mb-3 text-sm font-semibold uppercase tracking-wide text-accent-600">
				<?php esc_html_e( 'Kedai Kopi Irama Santri', 'irama-santri' ); ?>
			</p>
			<h1 class="mb-4 text-4xl font-bold leading-tight text-coffee-900 sm:text-5xl">
				<?php esc_html_e( 'More Than Just Coffee', 'irama-santri' ); ?>
			</h1>
			<p class="mb-8 max-w-xl text-lg text-coffee-700">
				<?php esc_html_e( 'A place to connect, create, learn, and share.', 'irama-santri' ); ?>
			</p>
			<div class="flex flex-col justify-center gap-4 sm:flex-row">
				<a
					href="<?php echo esc_url( irama_santri_theme_page_url( 'menu' ) ); ?>"
					class="inline-flex items-center justify-center rounded border border-accent-600 px-6 py-3 text-base font-medium text-accent-600 hover:bg-accent-600 hover:text-white"
				>
					<?php esc_html_e( 'Lihat Menu', 'irama-santri' ); ?>
				</a>
				<a
					href="<?php echo esc_url( irama_santri_theme_page_url( 'contact' ) ); ?>"
					class="inline-flex items-center justify-center rounded border border-coffee-900 px-6 py-3 text-base font-medium text-coffee-900 hover:bg-coffee-900 hover:text-white"
				>
					<?php esc_html_e( 'Kunjungi Kedai', 'irama-santri' ); ?>
				</a>
			</div>
		</div>
	</div>
	<div class="absolute inset-0 bg-cream-50/60" aria-hidden="true"></div>
</section>

<!-- Featured Menu -->
<section class="bg-cream-50 py-12">
	<div class="mx-auto max-w-6xl px-4">
		<div class="mb-8 flex items-center justify-between">
			<h2 class="text-2xl font-semibold">
				<?php esc_html_e( 'Menu Unggulan', 'irama-santri' ); ?>
			</h2>
			<a
				href="<?php echo esc_url( irama_santri_theme_page_url( 'menu' ) ); ?>"
				class="text-sm font-medium text-coffee-700 hover:text-coffee-900"
			>
				<?php esc_html_e( 'Lihat semua &rarr;', 'irama-santri' ); ?>
			</a>
		</div>

		<?php
		$featured_query = irama_santri_get_featured_products( 4 );
		if ( $featured_query->have_posts() ) :
			?>
			<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
				<?php
				while ( $featured_query->have_posts() ) :
					$featured_query->the_post();
					$range = irama_santri_get_price_range( get_the_ID() );
					$price_label = ! empty( $range['min'] ) ? irama_santri_format_price( (int) $range['min'] ) : __( 'Harga belum tersedia', 'irama-santri' );
					?>
					<div class="flex flex-col rounded border border-cream-100 bg-white p-4">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'product-card' ); ?>
						<?php else : ?>
							<div class="mb-3 flex h-32 items-center justify-center rounded border border-cream-100 bg-cream-100">
								<?php esc_html_e( 'Foto produk', 'irama-santri' ); ?>
							</div>
						<?php endif; ?>
						<h3 class="mb-1 text-lg font-semibold"><?php the_title(); ?></h3>
						<p class="mb-2 text-sm text-coffee-700"><?php echo esc_html( $price_label ); ?></p>
						<p class="text-xs text-coffee-600">
							<?php
							$categories = get_the_terms( get_the_ID(), 'product_category' );
							if ( is_array( $categories ) ) :
								$names = array_map( function( $term ) {
									return esc_html( $term->name );
								}, $categories );
								echo esc_html( implode( ', ', $names ) );
							endif;
							?>
						</p>
					</div>
				<?php endwhile; ?>
			</div>
			<?php
		else :
			?>
			<p class="text-coffee-700"><?php esc_html_e( 'Belum ada menu unggulan.', 'irama-santri' ); ?></p>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>

<!-- Brand Concept -->
<section class="bg-white py-12">
	<div class="mx-auto max-w-6xl px-4">
		<div class="grid gap-8 lg:grid-cols-2">
			<div>
				<h2 class="mb-4 text-2xl font-semibold">
					<?php esc_html_e( 'Konsep Community Space', 'irama-santri' ); ?>
				</h2>
				<p class="text-coffee-700">
					<?php esc_html_e( 'Irama Santri mengusung konsep Community Space dan modern coffee shop. Kedai tidak hanya menjadi tempat menikmati kopi, tetapi juga ruang untuk berkumpul, bersosialisasi, berdiskusi, belajar, berkolaborasi, dan berbagi pengalaman.', 'irama-santri' ); ?>
				</p>
			</div>
			<div>
				<h2 class="mb-4 text-2xl font-semibold">
					<?php esc_html_e( 'Cerita Brand', 'irama-santri' ); ?>
				</h2>

<!-- Facilities Preview -->
<section class="bg-white py-12">
	<div class="mx-auto max-w-6xl px-4">
		<h2 class="mb-8 text-2xl font-semibold">
			<?php esc_html_e( 'Our Space', 'irama-santri' ); ?>
		</h2>
		<?php
		$facilities_query = irama_santri_get_facilities();
		$facility_count   = $facilities_query->post_count;
		?>
		<?php if ( $facility_count > 0 ) : ?>
			<div class="grid gap-6 md:grid-cols-3">
				<?php
				$shown = 0;
				while ( $facilities_query->have_posts() && $shown < 3 ) :
					$facilities_query->the_post();
					$featured_image = get_the_post_thumbnail_url( get_the_ID(), 'post-thumbnail' );
					?>
					<div class="overflow-hidden rounded border border-cream-100">
						<?php if ( $featured_image ) : ?>
							<div class="h-32">
								<img src="<?php echo esc_url( $featured_image ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="h-full w-full object-cover">
							</div>
						<?php endif; ?>
						<div class="p-4">
							<h3 class="mb-1 text-lg font-semibold"><?php the_title(); ?></h3>
							<p class="text-sm text-coffee-600 line-clamp-2">
								<?php echo wp_kses_post( $featured_image ? '' : get_the_excerpt() ); ?>
							</p>
						</div>
					</div>
					<?php
					$shown++;
				endwhile;
				wp_reset_postdata();
				?>
			</div>
			<p class="mt-6 text-sm text-coffee-700">
				<?php
				$all_count = $facilities_query->post_count;
				printf(
					/* translators: %d: total facility count */
					esc_html( _n( '%d fasilitas lainnya &rarr;', '%d fasilitas lainnya &rarr;', $all_count - 3, 'irama-santri' ) ),
					$all_count - 3
				);
				?>
				<a href="<?php echo esc_url( irama_santri_theme_page_url( 'our-space' ) ); ?>" class="text-coffee-900 font-medium">
					<?php esc_html_e( 'Lihat selengkapnya', 'irama-santri' ); ?>
				</a>
			</p>
		<?php else : ?>
			<p class="text-coffee-700"><?php esc_html_e( 'Fasilitas masih dalam pengembangan.', 'irama-santri' ); ?></p>
		<?php endif; ?>
	</div>

<!-- Gallery Preview -->
<section class="bg-cream-50 py-12">
	<div class="mx-auto max-w-6xl px-4">
		<h2 class="mb-8 text-2xl font-semibold">
			<?php esc_html_e( 'Gallery', 'irama-santri' ); ?>
		</h2>
		<?php
		$gallery_ids = irama_santri_get_gallery_ids();
		if ( ! empty( $gallery_ids ) ) :
			?>
			<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
				<?php
				$shown = 0;
				foreach ( $gallery_ids as $attachment_id ) :
					if ( 'attachment' !== get_post_type( $attachment_id ) ) {
						continue;
					}
					if ( $shown >= 4 ) {
						break;
					}
					$url = wp_get_attachment_image_url( $attachment_id, 'gallery-thumb' );
					?>
					<figure class="overflow-hidden rounded border border-cream-100">
						<img src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( get_the_title( $attachment_id ) ); ?>" class="h-32 w-full object-cover">
					</figure>
					<?php
					$shown++;
				endforeach;
				?>
			</div>
			<p class="mt-6 text-sm text-coffee-700">
				<?php
				$total = count( $gallery_ids );
				printf(
					/* translators: %d: total gallery count */
					esc_html( _n( '%d foto lainnya &rarr;', '%d foto lainnya &rarr;', $total - 4, 'irama-santri' ) ),
					$total - 4
				);
				?>
				<a href="<?php echo esc_url( irama_santri_theme_page_url( 'gallery' ) ); ?>" class="text-coffee-900 font-medium">
					<?php esc_html_e( 'Lihat galeri', 'irama-santri' ); ?>
				</a>
			</p>
		<?php else : ?>
			<p class="text-coffee-700"><?php esc_html_e( 'Galeri masih dalam pengembangan.', 'irama-santri' ); ?></p>
		<?php endif; ?>
	</div>

<!-- Business Info -->
<section class="bg-white py-12">
	<div class="mx-auto max-w-6xl px-4">
		<div class="grid gap-8 lg:grid-cols-2">
			<div>
				<h2 class="mb-4 text-2xl font-semibold">
					<?php esc_html_e( 'Visit Us', 'irama-santri' ); ?>
				</h2>
				<address class="not-italic text-coffee-700">
					<?php
					$business_info = irama_santri_get_business_info();
					if ( ! empty( $business_info['address'] ) ) :
						echo esc_html( $business_info['address'] );
					else :
						esc_html_e( 'Alamat akan ditambahkan.', 'irama-santri' );
					endif;
					?>
				</address>
			</div>
			<div>
				<h2 class="mb-4 text-2xl font-semibold">
					<?php esc_html_e( 'Opening Hours', 'irama-santri' ); ?>
				</h2>
				<p class="text-coffee-700">
					<?php
					if ( ! empty( $business_info['hours'] ) ) :
						echo esc_html( $business_info['hours'] );
					else :
						esc_html_e( 'Jam operasional akan ditambahkan.', 'irama-santri' );
					endif;
					?>
				</p>
				<div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row">
					<a
						href="<?php echo esc_url( irama_santri_theme_page_url( 'menu' ) ); ?>"
						class="inline-flex items-center justify-center rounded border border-accent-600 px-6 py-3 text-base font-medium text-accent-600 hover:bg-accent-600 hover:text-white"
					>
						<?php esc_html_e( 'Lihat Menu', 'irama-santri' ); ?>
					</a>
					<a
						href="<?php echo esc_url( irama_santri_theme_page_url( 'contact' ) ); ?>"
						class="inline-flex items-center justify-center rounded border border-coffee-900 px-6 py-3 text-base font-medium text-coffee-900 hover:bg-coffee-900 hover:text-white"
					>
						<?php esc_html_e( 'Kunjungi Kedai', 'irama-santri' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
</section>
</section>
				<p class="text-coffee-700">
					<?php esc_html_e( 'Kedai ini lahir dari semangat komitmen dan kerja keras para santri. Kopi di sini dinikmati sebagai sarana tersenyum, bersosialisasi, dan belajar bersama.', 'irama-santri' ); ?>
				</p>
			</div>
		</div>
	</div>
</section>