<?php
/**
 * Public read API untuk Theme.
 *
 * Theme hanya boleh membaca data melalui fungsi di file ini.
 *
 * @package IramaSantriCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Mengambil daftar produk.
 *
 * @param array<string, mixed> $args Argumen WP_Query tambahan.
 * @return WP_Query
 */
function irama_santri_get_products( array $args = array() ): WP_Query {
	$defaults = array(
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'posts_per_page'      => -1,
		'orderby'             => array(
			'menu_order' => 'ASC',
			'title'      => 'ASC',
		),
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);

	return new WP_Query( wp_parse_args( $args, $defaults ) );
}

/**
 * Mengambil produk unggulan yang tersedia.
 *
 * @param int $limit Jumlah maksimal.
 * @return WP_Query
 */
function irama_santri_get_featured_products( int $limit = 4 ): WP_Query {
	$limit = max( 1, $limit );

	return irama_santri_get_products(
		array(
			'posts_per_page' => $limit,
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'   => '_is_featured',
					'value' => '1',
				),
				array(
					'key'   => '_is_available',
					'value' => '1',
				),
			),
		)
	);
}

/**
 * Mengambil varian produk.
 *
 * @param int $post_id ID produk.
 * @return array<int, array<string, int|string>>
 */
function irama_santri_get_variants( int $post_id ): array {
	return irama_santri_decode_items( get_post_meta( $post_id, '_is_variants', true ) );
}

/**
 * Mengambil add-on produk.
 *
 * @param int $post_id ID produk.
 * @return array<int, array<string, int|string>>
 */
function irama_santri_get_addons( int $post_id ): array {
	return irama_santri_decode_items( get_post_meta( $post_id, '_is_addons', true ) );
}

/**
 * Menghitung rentang harga produk.
 *
 * @param int $post_id ID produk.
 * @return array<string, int|bool>
 */
function irama_santri_get_price_range( int $post_id ): array {
	$variants = irama_santri_get_variants( $post_id );

	if ( ! empty( $variants ) ) {
		$prices = array();

		foreach ( $variants as $variant ) {
			$price = (int) $variant['price'];

			if ( $price > 0 ) {
				$prices[] = $price;
			}
		}

		if ( ! empty( $prices ) ) {
			return array(
				'min'          => min( $prices ),
				'max'          => max( $prices ),
				'has_variants' => true,
			);
		}

		return array(
			'min'          => 0,
			'max'          => 0,
			'has_variants' => true,
		);
	}

	$base = irama_santri_sanitize_price( get_post_meta( $post_id, '_is_base_price', true ) );

	return array(
		'min'          => $base,
		'max'          => $base,
		'has_variants' => false,
	);
}

/**
 * Memformat harga rupiah.
 *
 * @param int $amount Harga dalam rupiah penuh.
 * @return string
 */
function irama_santri_format_price( int $amount ): string {
	if ( $amount <= 0 ) {
		return '';
	}

	return sprintf( 'Rp %s', number_format_i18n( $amount, 0 ) );
}

/**
 * Memeriksa status ketersediaan produk.
 *
 * @param int $post_id ID produk.
 * @return bool
 */
function irama_santri_is_available( int $post_id ): bool {
	if ( ! metadata_exists( 'post', $post_id, '_is_available' ) ) {
		return true;
	}

	return (bool) get_post_meta( $post_id, '_is_available', true );
}

/**
 * Mengambil data produk ternormalisasi.
 *
 * @param int $post_id ID produk.
 * @return array<string, mixed>
 */
function irama_santri_get_product_data( int $post_id ): array {
	$post = get_post( $post_id );

	if ( ! $post || 'product' !== $post->post_type ) {
		return array();
	}

	$variants = irama_santri_get_variants( $post_id );
	$addons   = irama_santri_get_addons( $post_id );
	$range    = irama_santri_get_price_range( $post_id );
	$terms    = wp_get_post_terms( $post_id, 'product_category', array( 'fields' => 'ids' ) );

	return array(
		'id'           => $post_id,
		'name'         => get_the_title( $post_id ),
		'permalink'    => (string) get_permalink( $post_id ),
		'description'  => $post->post_content,
		'excerpt'      => $post->post_excerpt,
		'thumbnail_id' => (int) get_post_thumbnail_id( $post_id ),
		'category_ids' => is_wp_error( $terms ) ? array() : array_map( 'intval', $terms ),
		'base_price'   => irama_santri_sanitize_price( get_post_meta( $post_id, '_is_base_price', true ) ),
		'variants'     => $variants,
		'addons'       => $addons,
		'price_min'    => (int) $range['min'],
		'price_max'    => (int) $range['max'],
		'has_variants' => (bool) $range['has_variants'],
		'is_available' => irama_santri_is_available( $post_id ),
		'is_featured'  => (bool) get_post_meta( $post_id, '_is_featured', true ),
		'order'        => (int) $post->menu_order,
	);
}

/**
 * Mengambil daftar fasilitas.
 *
 * @param array<string, mixed> $args Argumen WP_Query tambahan.
 * @return WP_Query
 */
function irama_santri_get_facilities( array $args = array() ): WP_Query {
	$defaults = array(
		'post_type'           => 'facility',
		'post_status'         => 'publish',
		'posts_per_page'      => -1,
		'orderby'             => array(
			'menu_order' => 'ASC',
			'title'      => 'ASC',
		),
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);

	return new WP_Query( wp_parse_args( $args, $defaults ) );
}
