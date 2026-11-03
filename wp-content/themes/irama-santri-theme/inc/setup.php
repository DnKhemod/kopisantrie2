<?php
/**
 * Setup Theme.
 *
 * @package IramaSantriTheme
 */

defined( 'ABSPATH' ) || exit;

/**
 * Mendaftarkan dukungan Theme dan ukuran gambar.
 *
 * @return void
 */
function irama_santri_theme_setup(): void {
	load_theme_textdomain( 'irama-santri', IRAMA_SANTRI_THEME_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Navigasi Utama', 'irama-santri' ),
			'footer'  => __( 'Navigasi Footer', 'irama-santri' ),
		)
	);

	add_image_size( 'product-card', 600, 600, true );
	add_image_size( 'product-detail', 1200, 1200, false );
	add_image_size( 'gallery-thumb', 480, 480, true );
}
add_action( 'after_setup_theme', 'irama_santri_theme_setup' );
