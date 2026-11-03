<?php
/**
 * Template Name: Menu / Katalog Produk
 *
 * Menampilkan produk berdasarkan kategori terpilih.
 *
 * @package IramaSantriTheme
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="primary" class="mx-auto max-w-6xl px-4 py-10">
	<?php
	$selected_category = isset( $_GET['category'] ) ? sanitize_title( wp_unslash( $_GET['category'] ) ) : '';
	$args              = array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'title'      => 'ASC',
		),
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);

	if ( $selected_category ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_category',
				'terms'    => array( $selected_category ),
				'field'    => 'slug',
			),
		);
	}
	?>

	<header class="mb-8">
		<h1 class="mb-2 text-3xl font-semibold"><?php esc_html_e( 'Katalog Produk', 'irama-santri' ); ?></h1>
		<p class="text-coffee-700"><?php esc_html_e( 'Jelajahi menu kami.', 'irama-santri' ); ?></p>
	</header>

	<?php if ( $selected_category ) : ?>
		<p class="mb-6 text-coffee-700"><?php esc_html_e( 'Menampilkan produk dari kategori:', 'irama-santri' ); ?></p>
	<?php endif; ?>

	<?php
	$product_query = new WP_Query( $args );
	if ( $product_query->have_posts() ) :
		?>
		<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
			<?php
			while ( $product_query->have_posts() ) :
				$product_query->the_post();
				$product_id   = get_the_ID();
				$is_available = irama_santri_is_available( $product_id );
				$range        = irama_santri_get_price_range( $product_id );
				$price_label  = ! empty( $range['min'] ) ? irama_santri_format_price( (int) $range['min'] ) : __( 'Harga belum tersedia', 'irama-santri' );
				$featured     = (bool) get_post_meta( $product_id, '_is_featured', true );
				?>
				<div class="<?php echo $is_available ? 'opacity-100' : 'opacity-60'; ?>">
					<?php if ( $featured ) : ?>
						<span class="mb-2 inline-block rounded bg-accent-600 px-3 py-1 text-xs font-medium text-white">
							<?php esc_html_e( 'Unggulan', 'irama-santri' ); ?>
						</span>
					<?php endif; ?>
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'product-card' ); ?>
						</a>
					<?php else : ?>
						<div class="mb-3 flex h-48 items-center justify-center rounded border border-cream-100 bg-cream-100">
							<?php esc_html_e( 'Foto produk', 'irama-santri' ); ?>
						</div>
					<?php endif; ?>
					<h2 class="mb-1 text-lg font-semibold">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h2>
					<p class="mb-2 text-sm text-coffee-700"><?php echo esc_html( $price_label ); ?></p>
					<p class="mb-4 text-sm text-coffee-600">
						<?php
						$categories = get_the_terms( $product_id, 'product_category' );
						if ( is_array( $categories ) ) :
							$names = array_map( function( $term ) {
								return esc_html( $term->name );
							}, $categories );
							echo esc_html( implode( ', ', $names ) );
						endif;
						?>
					</p>
					<a
						href="<?php the_permalink(); ?>"
						class="inline-flex items-center rounded border border-coffee-900 px-4 py-2 text-sm font-medium text-coffee-900 hover:bg-coffee-900 hover:text-white"
					>
						<?php esc_html_e( 'Detail', 'irama-santri' ); ?>
					</a>
				</div>
			<?php endwhile; ?>
		</div>
		<?php
	else :
		?>
		<div class="rounded border border-cream-100 bg-cream-100 p-8 text-center">
			<?php esc_html_e( 'Produk tidak ditemukan.', 'irama-santri' ); ?>
		</div>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
</main>

<?php get_footer(); ?>
