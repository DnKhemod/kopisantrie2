<?php
/**
 * Plugin Name:       Irama Santri Core
 * Plugin URI:        https://kopisantrie.com
 * Description:       Data dan logika konten terstruktur untuk Website Kedai Kopi Irama Santri.
 * Version:           0.1.0
 * Requires at least: 6.5
 * Requires PHP:      8.2
 * Author:            Kedai Kopi Irama Santri
 * Text Domain:       irama-santri
 * Domain Path:       /languages
 *
 * @package IramaSantriCore
 */

defined( 'ABSPATH' ) || exit;

define( 'IRAMA_SANTRI_VERSION', '0.1.0' );
define( 'IRAMA_SANTRI_PLUGIN_FILE', __FILE__ );
define( 'IRAMA_SANTRI_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'IRAMA_SANTRI_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once IRAMA_SANTRI_PLUGIN_DIR . 'includes/helpers.php';
require_once IRAMA_SANTRI_PLUGIN_DIR . 'includes/post-types.php';
require_once IRAMA_SANTRI_PLUGIN_DIR . 'includes/taxonomies.php';
require_once IRAMA_SANTRI_PLUGIN_DIR . 'includes/meta.php';
require_once IRAMA_SANTRI_PLUGIN_DIR . 'includes/options.php';
require_once IRAMA_SANTRI_PLUGIN_DIR . 'includes/template-functions.php';

if ( is_admin() ) {
	require_once IRAMA_SANTRI_PLUGIN_DIR . 'includes/admin/product-fields.php';
	require_once IRAMA_SANTRI_PLUGIN_DIR . 'includes/admin/settings-page.php';
	require_once IRAMA_SANTRI_PLUGIN_DIR . 'includes/admin/facilities-page.php';
	require_once IRAMA_SANTRI_PLUGIN_DIR . 'includes/admin/gallery-page.php';
}

add_action( 'init', 'irama_santri_register_post_types' );
add_action( 'init', 'irama_santri_register_taxonomies' );
add_action( 'init', 'irama_santri_register_meta' );
add_action( 'admin_init', 'irama_santri_register_settings' );
add_action( 'admin_menu', 'irama_santri_register_admin_pages' );

/**
 * Menyiapkan data awal saat plugin diaktifkan.
 *
 * @return void
 */
function irama_santri_activate(): void {
	irama_santri_register_post_types();
	irama_santri_register_taxonomies();
	irama_santri_seed_default_terms();
	irama_santri_set_default_options();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'irama_santri_activate' );

/**
 * Membersihkan rewrite rules saat plugin dinonaktifkan.
 *
 * Data tidak dihapus.
 *
 * @return void
 */
function irama_santri_deactivate(): void {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'irama_santri_deactivate' );
