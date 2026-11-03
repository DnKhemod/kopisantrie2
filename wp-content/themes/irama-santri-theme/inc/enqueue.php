<?php
/**
 * Enqueue aset frontend.
 *
 * @package IramaSantriTheme
 */

defined( 'ABSPATH' ) || exit;

/**
 * Memuat CSS hasil build dan JavaScript navigasi.
 *
 * @return void
 */
function irama_santri_theme_enqueue_assets(): void {
	$css_path = IRAMA_SANTRI_THEME_DIR . '/assets/css/app.css';
	$css_ver  = file_exists( $css_path ) ? (string) filemtime( $css_path ) : IRAMA_SANTRI_THEME_VERSION;

	wp_enqueue_style(
		'irama-santri-app',
		IRAMA_SANTRI_THEME_URI . '/assets/css/app.css',
		array(),
		$css_ver
	);

	$js_path = IRAMA_SANTRI_THEME_DIR . '/assets/js/navigation.js';
	$js_ver  = file_exists( $js_path ) ? (string) filemtime( $js_path ) : IRAMA_SANTRI_THEME_VERSION;

	wp_enqueue_script(
		'irama-santri-navigation',
		IRAMA_SANTRI_THEME_URI . '/assets/js/navigation.js',
		array(),
		$js_ver,
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'irama_santri_theme_enqueue_assets' );
