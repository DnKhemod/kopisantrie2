<?php
/**
 * Registrasi taxonomy.
 *
 * @package IramaSantriCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Mendaftarkan taxonomy product_category.
 *
 * Taxonomy tidak memiliki arsip publik pada versi pertama.
 *
 * @return void
 */
function irama_santri_register_taxonomies(): void {
	register_taxonomy(
		'product_category',
		array( 'product' ),
		array(
			'labels'            => array(
				'name'              => __( 'Kategori Produk', 'irama-santri' ),
				'singular_name'     => __( 'Kategori Produk', 'irama-santri' ),
				'search_items'      => __( 'Cari Kategori', 'irama-santri' ),
				'all_items'         => __( 'Semua Kategori', 'irama-santri' ),
				'parent_item'       => __( 'Kategori Induk', 'irama-santri' ),
				'parent_item_colon' => __( 'Kategori Induk:', 'irama-santri' ),
				'edit_item'         => __( 'Edit Kategori', 'irama-santri' ),
				'update_item'       => __( 'Perbarui Kategori', 'irama-santri' ),
				'add_new_item'      => __( 'Tambah Kategori Baru', 'irama-santri' ),
				'new_item_name'     => __( 'Nama Kategori Baru', 'irama-santri' ),
				'menu_name'         => __( 'Kategori Produk', 'irama-santri' ),
			),
			'hierarchical'      => true,
			'public'            => false,
			'publicly_queryable' => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => false,
		)
	);
}

/**
 * Membuat term kategori awal saat aktivasi.
 *
 * @return void
 */
function irama_santri_seed_default_terms(): void {
	$terms = array(
		'coffee'         => 'Coffee',
		'non-coffee'     => 'Non-Coffee',
		'snacks'         => 'Snacks',
		'dessert-pastry' => 'Dessert / Pastry / Bakery',
	);

	foreach ( $terms as $slug => $name ) {
		if ( ! term_exists( $slug, 'product_category' ) ) {
			wp_insert_term( $name, 'product_category', array( 'slug' => $slug ) );
		}
	}
}
