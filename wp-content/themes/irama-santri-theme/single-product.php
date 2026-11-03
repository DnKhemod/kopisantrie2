<?php
/** Template detail produk. */
defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="primary" class="content-wrap section-wrap product-detail">
	<?php while ( have_posts() ) : the_post(); $product = irama_santri_get_product_data( get_the_ID() ); ?>
	<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'irama-santri' ); ?>"><a href="<?php echo esc_url( irama_santri_theme_page_url( 'menu' ) ); ?>"><?php esc_html_e( 'Menu', 'irama-santri' ); ?></a><span aria-hidden="true">/</span><span><?php the_title(); ?></span></nav>
	<article class="product-detail__layout"><div class="product-detail__image"><?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'product-detail' ); else : ?><div class="product-card__image"><span><?php esc_html_e( 'Foto produk', 'irama-santri' ); ?></span></div><?php endif; ?></div><div class="product-detail__content"><p class="eyebrow"><?php esc_html_e( 'Menu Irama Santri', 'irama-santri' ); ?></p><h1><?php the_title(); ?></h1><?php if ( ! empty( $product['is_featured'] ) ) : ?><span class="product-badge"><?php esc_html_e( 'Menu unggulan', 'irama-santri' ); ?></span><?php endif; ?><?php if ( empty( $product['is_available'] ) ) : ?><p class="availability-badge"><?php esc_html_e( 'Saat ini tidak tersedia', 'irama-santri' ); ?></p><?php endif; ?><div class="product-detail__description"><?php the_content(); ?></div>
	<?php if ( ! empty( $product['has_variants'] ) && ! empty( $product['variants'] ) ) : ?><section class="product-options"><h2><?php esc_html_e( 'Pilihan dan harga', 'irama-santri' ); ?></h2><ul><?php foreach ( $product['variants'] as $variant ) : ?><li><span><?php echo esc_html( $variant['label'] ); ?></span><strong><?php echo esc_html( irama_santri_format_price( (int) $variant['price'] ) ); ?></strong></li><?php endforeach; ?></ul></section><?php elseif ( ! empty( $product['base_price'] ) ) : ?><p class="product-detail__price"><?php echo esc_html( irama_santri_format_price( (int) $product['base_price'] ) ); ?></p><?php else : ?><p class="product-detail__price"><?php esc_html_e( 'Harga belum tersedia', 'irama-santri' ); ?></p><?php endif; ?>
	<?php if ( ! empty( $product['addons'] ) ) : ?><section class="product-options"><h2><?php esc_html_e( 'Tambahan', 'irama-santri' ); ?></h2><ul><?php foreach ( $product['addons'] as $addon ) : ?><li><span><?php echo esc_html( $addon['label'] ); ?></span><strong>+<?php echo esc_html( irama_santri_format_price( (int) $addon['price'] ) ); ?></strong></li><?php endforeach; ?></ul></section><?php endif; ?>
	</div></article><?php endwhile; ?>
</main>
<?php get_footer(); ?>
