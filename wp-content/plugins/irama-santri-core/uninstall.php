<?php
/**
 * Uninstall plugin.
 *
 * Data hanya dihapus jika konstanta IRAMA_SANTRI_REMOVE_DATA_ON_UNINSTALL
 * bernilai true di wp-config.php.
 *
 * @package IramaSantriCore
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

if ( ! defined( 'IRAMA_SANTRI_REMOVE_DATA_ON_UNINSTALL' ) || true !== IRAMA_SANTRI_REMOVE_DATA_ON_UNINSTALL ) {
	return;
}

$irama_santri_posts = get_posts(
	array(
		'post_type'   => array( 'product', 'facility' ),
		'post_status' => 'any',
		'numberposts' => -1,
		'fields'      => 'ids',
	)
);

foreach ( $irama_santri_posts as $irama_santri_post_id ) {
	wp_delete_post( (int) $irama_santri_post_id, true );
}

$irama_santri_terms = get_terms(
	array(
		'taxonomy'   => 'product_category',
		'hide_empty' => false,
		'fields'     => 'ids',
	)
);

if ( ! is_wp_error( $irama_santri_terms ) ) {
	foreach ( $irama_santri_terms as $irama_santri_term_id ) {
		wp_delete_term( (int) $irama_santri_term_id, 'product_category' );
	}
}

$irama_santri_meta_keys = array(
	'_is_base_price',
	'_is_variants',
	'_is_addons',
	'_is_available',
	'_is_featured',
);

foreach ( $irama_santri_meta_keys as $irama_santri_meta_key ) {
	delete_post_meta_by_key( $irama_santri_meta_key );
}

$irama_santri_options = array(
	'irama_santri_business_info',
	'irama_santri_page_map',
	'irama_santri_gallery_ids',
	'irama_santri_schema_version',
);

foreach ( $irama_santri_options as $irama_santri_option ) {
	delete_option( $irama_santri_option );
}
