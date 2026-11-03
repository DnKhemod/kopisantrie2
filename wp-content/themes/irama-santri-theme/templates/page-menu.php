<?php
/** Template Name: Menu / Katalog Produk */
defined( 'ABSPATH' ) || exit;
get_header();
$selected_category = isset( $_GET['category'] ) ? sanitize_title( wp_unslash( $_GET['category'] ) ) : '';
$categories = get_terms( array( 'taxonomy' => 'product_category', 'hide_empty' => true ) );
$args = array( 'post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => -1, 'orderby' => array( 'menu_order' => 'ASC', 'title' => 'ASC' ), 'ignore_sticky_posts' => true, 'no_found_rows' => true );
if ( $selected_category ) { $args['tax_query'] = array( array( 'taxonomy' => 'product_category', 'terms' => array( $selected_category ), 'field' => 'slug' ) ); }
$product_query = new WP_Query( $args );
?>
<main id="primary" class="content-wrap section-wrap">
	<header class="page-heading"><p class="eyebrow"><?php esc_html_e( 'Dari bar kami', 'irama-santri' ); ?></p><h1><?php esc_html_e( 'Menu untuk menemani harimu.', 'irama-santri' ); ?></h1><p><?php esc_html_e( 'Jelajahi pilihan kopi, minuman, camilan, dan hidangan manis kami.', 'irama-santri' ); ?></p></header>
	<?php if ( ! is_wp_error( $categories ) && $categories ) : ?><nav class="category-nav" aria-label="<?php esc_attr_e( 'Kategori menu', 'irama-santri' ); ?>"><a class="<?php echo '' === $selected_category ? 'is-active' : ''; ?>" href="<?php echo esc_url( remove_query_arg( 'category' ) ); ?>"><?php esc_html_e( 'Semua menu', 'irama-santri' ); ?></a><?php foreach ( $categories as $category ) : ?><a class="<?php echo $selected_category === $category->slug ? 'is-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( 'category', $category->slug ) ); ?>"><?php echo esc_html( $category->name ); ?></a><?php endforeach; ?></nav><?php endif; ?>
	<?php if ( $product_query->have_posts() ) : ?><div class="product-grid">
		<?php while ( $product_query->have_posts() ) : $product_query->the_post(); $product = irama_santri_get_product_data( get_the_ID() ); ?>
		<article class="product-card<?php echo empty( $product['is_available'] ) ? ' product-card--unavailable' : ''; ?>"><a class="product-card__image" href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'product-card' ); else : ?><span><?php esc_html_e( 'Foto produk', 'irama-santri' ); ?></span><?php endif; ?><?php if ( ! empty( $product['is_featured'] ) ) : ?><span class="product-badge"><?php esc_html_e( 'Unggulan', 'irama-santri' ); ?></span><?php endif; ?></a><div class="product-card__body"><div class="product-card__title-row"><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><?php if ( empty( $product['is_available'] ) ) : ?><span class="availability-badge"><?php esc_html_e( 'Tidak tersedia', 'irama-santri' ); ?></span><?php endif; ?></div><p class="product-card__price"><?php echo esc_html( irama_santri_theme_price_label( get_the_ID() ) ); ?></p><p class="product-card__excerpt"><?php echo esc_html( $product['excerpt'] ?? '' ); ?></p></div></article>
		<?php endwhile; ?></div><?php else : ?><div class="empty-state"><h2><?php esc_html_e( 'Menu belum tersedia', 'irama-santri' ); ?></h2><p><?php esc_html_e( 'Pilihan menu akan segera ditambahkan.', 'irama-santri' ); ?></p></div><?php endif; wp_reset_postdata(); ?>
</main>
<?php get_footer(); ?>
