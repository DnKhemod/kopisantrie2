<?php
/**
 * Kompatibilitas Theme dengan Plugin.
 *
 * Theme tidak boleh fatal jika Plugin nonaktif.
 *
 * @package IramaSantriTheme
 */

defined( 'ABSPATH' ) || exit;

/**
 * Memeriksa apakah Public API Plugin tersedia.
 *
 * @return bool
 */
function irama_santri_theme_has_plugin(): bool {
	return function_exists( 'irama_santri_get_products' );
}

/**
 * Mengambil info kedai dengan fallback.
 *
 * @return array<string, string>
 */
function irama_santri_theme_business_info(): array {
	if ( function_exists( 'irama_santri_get_business_info' ) ) {
		return irama_santri_get_business_info();
	}

	return array(
		'address' => '',
		'hours'   => '',
	);
}

/**
 * Mengambil URL halaman dengan fallback.
 *
 * @param string $key Kunci halaman: menu atau contact.
 * @return string
 */
function irama_santri_theme_page_url( string $key ): string {
	if ( function_exists( 'irama_santri_get_page_url' ) ) {
		return irama_santri_get_page_url( $key );
	}

	return home_url( '/' );
}

/**
 * Mengambil daftar attachment galeri dengan fallback.
 *
 * @return int[]
 */
function irama_santri_theme_gallery_ids(): array {
	if ( function_exists( 'irama_santri_get_gallery_ids' ) ) {
		return irama_santri_get_gallery_ids();
	}

	return array();
}
