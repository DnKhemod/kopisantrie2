<?php
/**
 * Registrasi option dan sanitasi.
 *
 * @package IramaSantriCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Mendaftarkan setting plugin.
 *
 * @return void
 */
function irama_santri_register_settings(): void {
	register_setting(
		'irama_santri_settings',
		'irama_santri_business_info',
		array(
			'type'              => 'array',
			'default'           => irama_santri_default_business_info(),
			'sanitize_callback' => 'irama_santri_sanitize_business_info',
		)
	);

	register_setting(
		'irama_santri_settings',
		'irama_santri_page_map',
		array(
			'type'              => 'array',
			'default'           => irama_santri_default_page_map(),
			'sanitize_callback' => 'irama_santri_sanitize_page_map',
		)
	);

	register_setting(
		'irama_santri_settings',
		'irama_santri_gallery_ids',
		array(
			'type'              => 'array',
			'default'           => array(),
			'sanitize_callback' => 'irama_santri_sanitize_gallery_ids',
		)
	);
}

/**
 * Menyanitasi info kedai.
 *
 * @param mixed $value Nilai mentah.
 * @return array<string, string>
 */
function irama_santri_sanitize_business_info( $value ): array {
	$defaults = irama_santri_default_business_info();

	if ( ! is_array( $value ) ) {
		return $defaults;
	}

	$address = isset( $value['address'] ) ? sanitize_textarea_field( (string) $value['address'] ) : '';
	$hours   = isset( $value['hours'] ) ? sanitize_text_field( (string) $value['hours'] ) : '';

	return array(
		'address' => '' !== trim( $address ) ? $address : $defaults['address'],
		'hours'   => '' !== trim( $hours ) ? $hours : $defaults['hours'],
	);
}

/**
 * Menyanitasi pemetaan halaman.
 *
 * @param mixed $value Nilai mentah.
 * @return array<string, int>
 */
function irama_santri_sanitize_page_map( $value ): array {
	$defaults = irama_santri_default_page_map();

	if ( ! is_array( $value ) ) {
		return $defaults;
	}

	$map = $defaults;

	foreach ( array_keys( $defaults ) as $key ) {
		$page_id = isset( $value[ $key ] ) ? absint( $value[ $key ] ) : 0;

		if ( $page_id && 'page' === get_post_type( $page_id ) ) {
			$map[ $key ] = $page_id;
		}
	}

	return $map;
}

/**
 * Menyanitasi daftar attachment ID galeri.
 *
 * @param mixed $value Nilai mentah.
 * @return int[]
 */
function irama_santri_sanitize_gallery_ids( $value ): array {
	if ( ! is_array( $value ) ) {
		return array();
	}

	$ids   = array_map( 'absint', $value );
	$ids   = array_values( array_unique( array_filter( $ids ) ) );
	$ids   = array_slice( $ids, 0, 60 );
	$valid = array();

	foreach ( $ids as $id ) {
		if ( 'attachment' === get_post_type( $id ) ) {
			$valid[] = $id;
		}
	}

	return $valid;
}

/**
 * Mengisi option default saat aktivasi tanpa menimpa nilai yang sudah ada.
 *
 * @return void
 */
function irama_santri_set_default_options(): void {
	add_option( 'irama_santri_business_info', irama_santri_default_business_info() );
	add_option( 'irama_santri_page_map', irama_santri_default_page_map() );
	add_option( 'irama_santri_gallery_ids', array() );
	add_option( 'irama_santri_schema_version', 1 );
}
