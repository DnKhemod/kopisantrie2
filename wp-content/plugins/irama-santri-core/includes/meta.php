<?php
/**
 * Registrasi post meta produk.
 *
 * @package IramaSantriCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Memeriksa apakah pengguna boleh mengubah meta produk.
 *
 * @param bool   $allowed  Nilai awal.
 * @param string $meta_key Kunci meta.
 * @param mixed  $post_id  ID post atau subtype.
 * @return bool
 */
function irama_santri_meta_auth_callback( $allowed, $meta_key, $post_id = 0 ): bool {
	unset( $allowed, $meta_key );

	if ( is_numeric( $post_id ) && (int) $post_id > 0 ) {
		return current_user_can( 'edit_post', (int) $post_id );
	}

	return current_user_can( 'edit_posts' );
}

/**
 * Mendaftarkan seluruh meta produk.
 *
 * @return void
 */
function irama_santri_register_meta(): void {
	$auth = 'irama_santri_meta_auth_callback';

	register_post_meta(
		'product',
		'_is_base_price',
		array(
			'type'              => 'integer',
			'single'            => true,
			'default'           => 0,
			'show_in_rest'      => true,
			'sanitize_callback' => 'irama_santri_sanitize_price',
			'auth_callback'     => $auth,
		)
	);

	register_post_meta(
		'product',
		'_is_variants',
		array(
			'type'              => 'string',
			'single'            => true,
			'default'           => '[]',
			'show_in_rest'      => true,
			'sanitize_callback' => static function ( $value ): string {
				return irama_santri_sanitize_json_items( $value, 20 );
			},
			'auth_callback'     => $auth,
		)
	);

	register_post_meta(
		'product',
		'_is_addons',
		array(
			'type'              => 'string',
			'single'            => true,
			'default'           => '[]',
			'show_in_rest'      => true,
			'sanitize_callback' => static function ( $value ): string {
				return irama_santri_sanitize_json_items( $value, 20 );
			},
			'auth_callback'     => $auth,
		)
	);

	register_post_meta(
		'product',
		'_is_available',
		array(
			'type'              => 'boolean',
			'single'            => true,
			'default'           => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'rest_sanitize_boolean',
			'auth_callback'     => $auth,
		)
	);

	register_post_meta(
		'product',
		'_is_featured',
		array(
			'type'              => 'boolean',
			'single'            => true,
			'default'           => false,
			'show_in_rest'      => true,
			'sanitize_callback' => 'rest_sanitize_boolean',
			'auth_callback'     => $auth,
		)
	);
}
