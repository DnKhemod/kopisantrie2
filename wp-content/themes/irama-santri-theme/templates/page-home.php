<?php
/** Template Name: Homepage */
defined( 'ABSPATH' ) || exit;
get_header();
$menu_url    = irama_santri_theme_page_url( 'menu' );
$contact_url = irama_santri_theme_page_url( 'contact' );
$gallery_ids = irama_santri_theme_gallery_ids();
$hero_image  = ! empty( $gallery_ids ) ? wp_get_attachment_image_url( $gallery_ids[0], 'large' ) : '';
$featured    = irama_santri_theme_has_plugin() ? irama_santri_get_featured_products( 4 ) : new WP_Query();
$facilities  = irama_santri_theme_has_plugin() ? irama_santri_get_facilities( array( 'posts_per_page' => 3 ) ) : new WP_Query();
$business    = irama_santri_theme_business_info();
?>
<main id="primary">
	<section class="hero-section<?php echo $hero_image ? ' hero-section--photo' : ''; ?>" <?php if ( $hero_image ) : ?>style="--hero-image:url('<?php echo esc_url( $hero_image ); ?>')"<?php endif; ?>>
		<div class="hero-section__content">
			<p class="eyebrow"><?php esc_html_e( 'Kopi · Ruang · Cerita', 'irama-santri' ); ?></p>
			<h1><?php esc_html_e( 'Lebih dari sekadar', 'irama-santri' ); ?> <em><?php esc_html_e( 'kopi.', 'irama-santri' ); ?></em></h1>
			<p class="hero-section__lead"><?php esc_html_e( 'Tempat untuk terhubung, berkarya, belajar, dan berbagi. Temukan ruang nyamanmu di Irama Santri.', 'irama-santri' ); ?></p>
			<div class="button-row"><a class="button" href="<?php echo esc_url( $menu_url ); ?>"><?php esc_html_e( 'Jelajahi Menu', 'irama-santri' ); ?> <span aria-hidden="true">↗</span></a><a class="button button--outline" href="<?php echo esc_url( $contact_url ); ?>"><?php esc_html_e( 'Kunjungi Kedai', 'irama-santri' ); ?></a></div>
		</div>
		<?php if ( ! $hero_image ) : ?><div class="hero-illustration" role="img" aria-label="<?php esc_attr_e( 'Ilustrasi suasana hangat kedai kopi', 'irama-santri' ); ?>"><div class="hero-illustration__window"></div><div class="hero-illustration__cup"></div><span><?php esc_html_e( 'Suasana Irama Santri', 'irama-santri' ); ?></span></div><?php endif; ?>
	</section>
	<section class="intro-section"><div class="content-wrap content-wrap--narrow"><p class="eyebrow"><?php esc_html_e( 'Kenalan dengan Irama', 'irama-santri' ); ?></p><h2><?php esc_html_e( 'Ruang temu yang terasa seperti rumah.', 'irama-santri' ); ?></h2><p><?php esc_html_e( 'Irama Santri adalah kedai kopi dan community space yang terbuka untuk semua. Datang untuk menikmati secangkir kopi, menyelesaikan pekerjaan, atau berbagi obrolan yang berarti.', 'irama-santri' ); ?></p></div></section>
	<?php if ( $featured instanceof WP_Query && $featured->have_posts() ) : ?>
	<section class="section-wrap"><div class="section-heading"><div><p class="eyebrow"><?php esc_html_e( 'Dari bar kami', 'irama-santri' ); ?></p><h2><?php esc_html_e( 'Teman untuk harimu.', 'irama-santri' ); ?></h2></div><a class="text-link" href="<?php echo esc_url( $menu_url ); ?>"><?php esc_html_e( 'Lihat semua menu', 'irama-santri' ); ?> ↗</a></div><div class="product-grid product-grid--featured">
		<?php while ( $featured->have_posts() ) : $featured->the_post(); $product = irama_santri_get_product_data( get_the_ID() ); ?>
		<article class="product-card"><a class="product-card__image" href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'product-card' ); else : ?><span><?php esc_html_e( 'Foto produk', 'irama-santri' ); ?></span><?php endif; ?></a><div class="product-card__body"><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><p class="product-card__price"><?php echo esc_html( irama_santri_theme_price_label( get_the_ID() ) ); ?></p><p class="product-card__excerpt"><?php echo esc_html( $product['excerpt'] ?? '' ); ?></p></div></article>
		<?php endwhile; wp_reset_postdata(); ?></div></section>
	<?php endif; ?>
	<?php if ( $facilities instanceof WP_Query && $facilities->have_posts() ) : ?>
	<section class="space-section"><div class="content-wrap"><div class="section-heading"><div><p class="eyebrow"><?php esc_html_e( 'Lebih dari secangkir kopi', 'irama-santri' ); ?></p><h2><?php esc_html_e( 'Ruang untuk berbagai irama.', 'irama-santri' ); ?></h2></div><a class="text-link" href="<?php echo esc_url( get_permalink( get_page_by_path( 'our-space' ) ) ?: home_url( '/' ) ); ?>"><?php esc_html_e( 'Jelajahi fasilitas', 'irama-santri' ); ?> ↗</a></div><div class="facility-grid">
		<?php while ( $facilities->have_posts() ) : $facilities->the_post(); ?><article class="facility-card"><div class="facility-card__icon" aria-hidden="true">✳</div><h3><?php the_title(); ?></h3><p><?php echo esc_html( get_the_excerpt() ); ?></p></article><?php endwhile; wp_reset_postdata(); ?></div></div></section>
	<?php endif; ?>
	<?php if ( ! empty( $gallery_ids ) ) : ?><section class="section-wrap"><div class="section-heading"><div><p class="eyebrow"><?php esc_html_e( 'Sepotong suasana', 'irama-santri' ); ?></p><h2><?php esc_html_e( 'Lihat lebih dekat.', 'irama-santri' ); ?></h2></div><a class="text-link" href="<?php echo esc_url( get_permalink( get_page_by_path( 'gallery' ) ) ?: home_url( '/' ) ); ?>"><?php esc_html_e( 'Buka galeri', 'irama-santri' ); ?> ↗</a></div><div class="gallery-preview"><?php foreach ( array_slice( $gallery_ids, 0, 4 ) as $attachment_id ) : echo wp_kses_post( wp_get_attachment_image( $attachment_id, 'gallery-thumb' ) ); endforeach; ?></div></section><?php endif; ?>
	<section class="visit-section"><div class="content-wrap visit-section__inner"><div><p class="eyebrow"><?php esc_html_e( 'Sampai jumpa di sini', 'irama-santri' ); ?></p><h2><?php esc_html_e( 'Meja untukmu selalu tersedia.', 'irama-santri' ); ?></h2><div class="visit-details"><p><strong><?php esc_html_e( 'Alamat', 'irama-santri' ); ?></strong><span><?php echo esc_html( $business['address'] ?? '' ); ?></span></p><p><strong><?php esc_html_e( 'Jam buka', 'irama-santri' ); ?></strong><span><?php echo esc_html( $business['hours'] ?? '' ); ?></span></p></div></div><a class="button button--light" href="<?php echo esc_url( $contact_url ); ?>"><?php esc_html_e( 'Temukan kami', 'irama-santri' ); ?> ↗</a></div></section>
</main>
<?php get_footer(); ?>
