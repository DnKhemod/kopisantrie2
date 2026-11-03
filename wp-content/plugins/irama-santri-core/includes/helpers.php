<?php
/**
 * Fungsi bantuan umum.
 *
 * @package IramaSantriCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Nilai default info kedai.
 *
 * @return array<string, string>
 */
function irama_santri_default_business_info(): array {
	return array(
		'address' => 'Jln. Rawa Kelem Blok S. No. 72, Klayan, Gunungjati, Cirebon.',
		'hours'   => 'Setiap hari, 10.00–22.00 WIB',
	);
}

/**
 * Nilai default pemetaan halaman.
 *
 * @return array<string, int>
 */
function irama_santri_default_page_map(): array {
	return array(
		'menu_page_id'    => 0,
		'contact_page_id' => 0,
	);
}

/**
 * Menyanitasi nilai harga menjadi integer rupiah.
 *
 * @param mixed $value Nilai mentah.
 * @return int
 */
function irama_santri_sanitize_price( $value ): int {
	if ( is_string( $value ) ) {
		$value = str_replace( array( '.', ',' ), '', $value );
	}

	return max( 0, absint( $value ) );
}

/**
 * Mengubah string JSON atau array menjadi daftar item tervalidasi.
 *
 * Setiap item memiliki bentuk array( 'label' => string, 'price' => int ).
 *
 * @param mixed $value Nilai mentah.
 * @return array<int, array<string, int|string>>
 */
function irama_santri_decode_items( $value ): array {
	if ( is_array( $value ) ) {
		$items = $value;
	} elseif ( is_string( $value ) && '' !== trim( $value ) ) {
		$decoded = json_decode( $value, true );
		$items   = is_array( $decoded ) ? $decoded : array();
	} else {
		return array();
	}

	$clean = array();

	foreach ( $items as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}

		$label = isset( $item['label'] ) ? sanitize_text_field( (string) $item['label'] ) : '';
		$price = isset( $item['price'] ) ? irama_santri_sanitize_price( $item['price'] ) : 0;

		if ( '' === $label ) {
			continue;
		}

		$clean[] = array(
			'label' => mb_substr( $label, 0, 60 ),
			'price' => $price,
		);
	}

	return $clean;
}

/**
 * Menyanitasi daftar item dan menyimpannya sebagai JSON.
 *
 * @param mixed $value Nilai mentah.
 * @param int   $limit Jumlah maksimal item.
 * @return string
 */
function irama_santri_sanitize_json_items( $value, int $limit = 20 ): string {
	$items = irama_santri_decode_items( $value );
	$clean = array();
	$seen  = array();

	foreach ( $items as $item ) {
		$key = strtolower( $item['label'] );

		if ( isset( $seen[ $key ] ) ) {
			continue;
		}

		$seen[ $key ] = true;
		$clean[]      = $item;

		if ( count( $clean ) >= $limit ) {
			break;
		}
	}

	return (string) wp_json_encode( $clean );
}

/**
 * Mengambil info kedai dari option dengan fallback default.
 *
 * @return array<string, string>
 */
function irama_santri_get_business_info(): array {
	$defaults = irama_santri_default_business_info();
	$stored   = get_option( 'irama_santri_business_info', array() );

	if ( ! is_array( $stored ) ) {
		return $defaults;
	}

	$address = isset( $stored['address'] ) ? trim( (string) $stored['address'] ) : '';
	$hours   = isset( $stored['hours'] ) ? trim( (string) $stored['hours'] ) : '';

	return array(
		'address' => '' !== $address ? $address : $defaults['address'],
		'hours'   => '' !== $hours ? $hours : $defaults['hours'],
	);
}

/**
 * Mengambil pemetaan halaman dengan validasi tipe post.
 *
 * @return array<string, int>
 */
function irama_santri_get_page_map(): array {
	$defaults = irama_santri_default_page_map();
	$stored   = get_option( 'irama_santri_page_map', array() );

	if ( ! is_array( $stored ) ) {
		return $defaults;
	}

	$map = $defaults;

	foreach ( array_keys( $defaults ) as $key ) {
		$page_id = isset( $stored[ $key ] ) ? absint( $stored[ $key ] ) : 0;

		if ( $page_id && 'page' === get_post_type( $page_id ) ) {
			$map[ $key ] = $page_id;
		}
	}

	return $map;
}

/**
 * Mengambil URL halaman berdasarkan kunci pemetaan.
 *
 * @param string $key Kunci: menu atau contact.
 * @return string
 */
function irama_santri_get_page_url( string $key ): string {
	$map     = irama_santri_get_page_map();
	$page_id = isset( $map[ $key . '_page_id' ] ) ? (int) $map[ $key . '_page_id' ] : 0;

	if ( $page_id ) {
		$permalink = get_permalink( $page_id );

		if ( $permalink ) {
			return (string) $permalink;
		}
	}

	return home_url( '/' );
}

/**
 * Mengambil daftar attachment ID galeri yang masih valid.
 *
 * @return int[]
 */
function irama_santri_get_gallery_ids(): array {
	$ids = get_option( 'irama_santri_gallery_ids', array() );

	if ( ! is_array( $ids ) ) {
		return array();
	}

	$ids = array_values( array_unique( array_filter( array_map( 'absint', $ids ) ) ) );
	$ids = array_slice( $ids, 0, 60 );
	$valid = array();

	foreach ( $ids as $id ) {
		if ( 'attachment' === get_post_type( $id ) ) {
			$valid[] = $id;
		}
	}

	return $valid;
}
