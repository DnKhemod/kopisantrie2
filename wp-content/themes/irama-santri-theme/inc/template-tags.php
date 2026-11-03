<?php
/**
 * Template tags Theme.
 *
 * @package IramaSantriTheme
 */

defined( 'ABSPATH' ) || exit;

/**
 * Menghasilkan label harga produk.
 *
 * @param int $post_id ID produk.
 * @return string
 */
function irama_santri_theme_price_label( int $post_id ): string {
	if ( ! function_exists( 'irama_santri_get_price_range' ) ) {
		return '';
	}

	$range = irama_santri_get_price_range( $post_id );

	if ( empty( $range['min'] ) ) {
		return __( 'Harga belum tersedia', 'irama-santri' );
	}

	$formatted = irama_santri_format_price( (int) $range['min'] );

	if ( ! empty( $range['has_variants'] ) && (int) $range['max'] > (int) $range['min'] ) {
		/* translators: %s: harga terendah. */
		return sprintf( __( 'Mulai dari %s', 'irama-santri' ), $formatted );
	}

	return $formatted;
}

/**
 * Memeriksa ketersediaan produk dengan fallback.
 *
 * @param int $post_id ID produk.
 * @return bool
 */
function irama_santri_theme_is_available( int $post_id ): bool {
	if ( function_exists( 'irama_santri_is_available' ) ) {
		return irama_santri_is_available( $post_id );
	}

	return true;
}
