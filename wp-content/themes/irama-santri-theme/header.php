<?php
/**
 * Header.
 *
 * Struktur dasar; styling final menunggu design system.
 *
 * @package IramaSantriTheme
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-cream-50 text-coffee-900 antialiased' ); ?>>
<?php wp_body_open(); ?>
<a class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded focus:bg-white focus:px-4 focus:py-2 focus:text-coffee-900" href="#primary">
	<?php esc_html_e( 'Lewati ke konten', 'irama-santri' ); ?>
</a>
<header class="border-b border-cream-100">
	<div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4">
		<div class="site-branding">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="text-lg font-semibold" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php bloginfo( 'name' ); ?>
				</a>
			<?php endif; ?>
		</div>

		<button
			type="button"
			class="rounded border border-cream-100 px-3 py-2 text-sm md:hidden"
			data-nav-toggle
			aria-expanded="false"
			aria-controls="primary-menu"
		>
			<?php esc_html_e( 'Menu', 'irama-santri' ); ?>
		</button>

		<nav
			id="primary-menu"
			class="hidden w-full md:block md:w-auto"
			data-nav-menu
			aria-label="<?php esc_attr_e( 'Navigasi utama', 'irama-santri' ); ?>"
		>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'flex flex-col gap-3 text-sm md:flex-row md:items-center md:gap-5',
					'fallback_cb'    => false,
					'depth'          => 2,
				)
			);
			?>
		</nav>
	</div>
</header>
