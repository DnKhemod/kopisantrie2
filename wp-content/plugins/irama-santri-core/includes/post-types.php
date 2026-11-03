<?php
/**
 * Registrasi Custom Post Type.
 *
 * @package IramaSantriCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Mendaftarkan CPT product dan facility.
 *
 * @return void
 */
function irama_santri_register_post_types(): void {
	register_post_type(
		'product',
		array(
			'labels'       => array(
				'name'                  => __( 'Produk', 'irama-santri' ),
				'singular_name'         => __( 'Produk', 'irama-santri' ),
				'menu_name'             => __( 'Produk', 'irama-santri' ),
				'add_new'               => __( 'Tambah Produk', 'irama-santri' ),
				'add_new_item'          => __( 'Tambah Produk Baru', 'irama-santri' ),
				'edit_item'             => __( 'Edit Produk', 'irama-santri' ),
				'new_item'              => __( 'Produk Baru', 'irama-santri' ),
				'view_item'             => __( 'Lihat Produk', 'irama-santri' ),
				'search_items'          => __( 'Cari Produk', 'irama-santri' ),
				'not_found'             => __( 'Produk tidak ditemukan', 'irama-santri' ),
				'not_found_in_trash'    => __( 'Tidak ada produk di Trash', 'irama-santri' ),
				'all_items'             => __( 'Semua Produk', 'irama-santri' ),
				'featured_image'        => __( 'Foto Produk', 'irama-santri' ),
				'set_featured_image'    => __( 'Pilih Foto Produk', 'irama-santri' ),
				'remove_featured_image' => __( 'Hapus Foto Produk', 'irama-santri' ),
				'use_featured_image'    => __( 'Gunakan sebagai Foto Produk', 'irama-santri' ),
				'archives'              => __( 'Daftar Produk', 'irama-santri' ),
			),
			'public'       => true,
			'show_ui'      => true,
			'show_in_rest' => true,
			'rest_base'    => 'products',
			'has_archive'  => false,
			'rewrite'      => array(
				'slug'       => 'menu',
				'with_front' => false,
			),
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
			'menu_icon'    => 'dashicons-coffee',
			'menu_position' => 20,
		)
	);

	register_post_type(
		'facility',
		array(
			'labels'       => array(
				'name'               => __( 'Fasilitas', 'irama-santri' ),
				'singular_name'      => __( 'Fasilitas', 'irama-santri' ),
				'menu_name'          => __( 'Fasilitas', 'irama-santri' ),
				'add_new'            => __( 'Tambah Fasilitas', 'irama-santri' ),
				'add_new_item'       => __( 'Tambah Fasilitas Baru', 'irama-santri' ),
				'edit_item'          => __( 'Edit Fasilitas', 'irama-santri' ),
				'new_item'           => __( 'Fasilitas Baru', 'irama-santri' ),
				'view_item'          => __( 'Lihat Fasilitas', 'irama-santri' ),
				'search_items'       => __( 'Cari Fasilitas', 'irama-santri' ),
				'not_found'          => __( 'Fasilitas tidak ditemukan', 'irama-santri' ),
				'not_found_in_trash' => __( 'Tidak ada fasilitas di Trash', 'irama-santri' ),
				'all_items'          => __( 'Semua Fasilitas', 'irama-santri' ),
				'featured_image'     => __( 'Foto Fasilitas', 'irama-santri' ),
				'set_featured_image' => __( 'Pilih Foto Fasilitas', 'irama-santri' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'rest_base'           => 'facilities',
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'menu_icon'           => 'dashicons-building',
			'menu_position'       => 21,
		)
	);
}
