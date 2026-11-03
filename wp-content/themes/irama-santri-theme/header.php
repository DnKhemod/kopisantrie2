<?php
/** Header Theme Irama Santri. */
defined( 'ABSPATH' ) || exit;
$menu_page    = get_page_by_path( 'menu' );
$about_page   = get_page_by_path( 'about' );
$space_page   = get_page_by_path( 'our-space' );
$gallery_page = get_page_by_path( 'gallery' );
$contact_page = get_page_by_path( 'contact' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#primary"><?php esc_html_e( 'Lewati ke konten', 'irama-santri' ); ?></a>
<div class="announcement-bar"><?php esc_html_e( 'Kedai Kopi · Community Space · Klayan, Cirebon', 'irama-santri' ); ?></div>
<header class="site-header">
	<div class="site-header__inner">
		<a class="site-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php if ( has_custom_logo() ) : ?><?php the_custom_logo(); ?><?php else : ?><span class="site-brand__mark" aria-hidden="true">IS</span><span class="site-brand__name"><?php bloginfo( 'name' ); ?></span><?php endif; ?>
		</a>
		<button type="button" class="mobile-menu-toggle" data-nav-toggle aria-expanded="false" aria-controls="primary-menu"><span class="screen-reader-text"><?php esc_html_e( 'Buka navigasi', 'irama-santri' ); ?></span><span aria-hidden="true">☰</span></button>
		<nav id="primary-menu" class="primary-nav" data-nav-menu aria-label="<?php esc_attr_e( 'Navigasi utama', 'irama-santri' ); ?>">
			<ul>
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Beranda', 'irama-santri' ); ?></a></li>
				<?php if ( $about_page ) : ?><li><a href="<?php echo esc_url( get_permalink( $about_page ) ); ?>"><?php esc_html_e( 'Cerita', 'irama-santri' ); ?></a></li><?php endif; ?>
				<?php if ( $menu_page ) : ?><li><a href="<?php echo esc_url( get_permalink( $menu_page ) ); ?>"><?php esc_html_e( 'Menu', 'irama-santri' ); ?></a></li><?php endif; ?>
				<?php if ( $space_page ) : ?><li><a href="<?php echo esc_url( get_permalink( $space_page ) ); ?>"><?php esc_html_e( 'Fasilitas', 'irama-santri' ); ?></a></li><?php endif; ?>
				<?php if ( $gallery_page ) : ?><li><a href="<?php echo esc_url( get_permalink( $gallery_page ) ); ?>"><?php esc_html_e( 'Galeri', 'irama-santri' ); ?></a></li><?php endif; ?>
			</ul>
		</nav>
		<?php if ( $contact_page ) : ?><a class="button button--small" href="<?php echo esc_url( get_permalink( $contact_page ) ); ?>"><?php esc_html_e( 'Kunjungi Kedai', 'irama-santri' ); ?></a><?php endif; ?>
	</div>
</header>
