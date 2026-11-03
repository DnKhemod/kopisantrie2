<?php
/**
 * Bootstrap Theme Irama Santri.
 *
 * @package IramaSantriTheme
 */

defined( 'ABSPATH' ) || exit;

define( 'IRAMA_SANTRI_THEME_VERSION', '0.1.0' );
define( 'IRAMA_SANTRI_THEME_DIR', get_template_directory() );
define( 'IRAMA_SANTRI_THEME_URI', get_template_directory_uri() );

require_once IRAMA_SANTRI_THEME_DIR . '/inc/setup.php';
require_once IRAMA_SANTRI_THEME_DIR . '/inc/enqueue.php';
require_once IRAMA_SANTRI_THEME_DIR . '/inc/plugin-compat.php';
require_once IRAMA_SANTRI_THEME_DIR . '/inc/template-tags.php';
