<?php
/**
 * Pengelolaan seluruh antarmuka admin Irama Santri.
 *
 * @package IramaSantriCore
 */

defined( 'ABSPATH' ) || exit;

/** Mendaftarkan halaman admin plugin. */
function irama_santri_register_admin_pages(): void {
	add_menu_page( __( 'Irama Santri', 'irama-santri' ), __( 'Irama Santri', 'irama-santri' ), 'manage_options', 'irama-santri', 'irama_santri_render_settings_page', 'dashicons-store', 3 );
	add_submenu_page( 'irama-santri', __( 'Info Kedai', 'irama-santri' ), __( 'Info Kedai', 'irama-santri' ), 'manage_options', 'irama-santri', 'irama_santri_render_settings_page' );
	add_submenu_page( 'irama-santri', __( 'Fasilitas', 'irama-santri' ), __( 'Fasilitas', 'irama-santri' ), 'manage_options', 'irama-santri-facilities', 'irama_santri_render_facilities_page' );
	add_submenu_page( 'irama-santri', __( 'Galeri', 'irama-santri' ), __( 'Galeri', 'irama-santri' ), 'manage_options', 'irama-santri-gallery', 'irama_santri_render_gallery_page' );
}
add_action( 'admin_menu', 'irama_santri_register_admin_pages' );

/** Menampilkan pengaturan informasi kedai dan halaman CTA. */
function irama_santri_render_settings_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) { return; }
	$info = irama_santri_get_business_info();
	$map  = irama_santri_get_page_map();
	?>
	<div class="wrap"><h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<form method="post" action="options.php"><?php settings_fields( 'irama_santri_settings' ); ?>
	<h2><?php esc_html_e( 'Info Kedai', 'irama-santri' ); ?></h2><table class="form-table" role="presentation">
	<tr><th scope="row"><label for="irama_santri_address"><?php esc_html_e( 'Alamat', 'irama-santri' ); ?></label></th><td><textarea id="irama_santri_address" name="irama_santri_business_info[address]" rows="3" class="large-text"><?php echo esc_textarea( $info['address'] ); ?></textarea></td></tr>
	<tr><th scope="row"><label for="irama_santri_hours"><?php esc_html_e( 'Jam operasional', 'irama-santri' ); ?></label></th><td><input type="text" id="irama_santri_hours" name="irama_santri_business_info[hours]" value="<?php echo esc_attr( $info['hours'] ); ?>" class="regular-text"></td></tr></table>
	<h2><?php esc_html_e( 'Pemetaan Halaman', 'irama-santri' ); ?></h2><p class="description"><?php esc_html_e( 'Pilih halaman tujuan tombol Menu dan Contact.', 'irama-santri' ); ?></p><table class="form-table" role="presentation">
	<tr><th scope="row"><label for="irama_santri_menu_page_id"><?php esc_html_e( 'Halaman Menu', 'irama-santri' ); ?></label></th><td><?php wp_dropdown_pages( array( 'name' => 'irama_santri_page_map[menu_page_id]', 'id' => 'irama_santri_menu_page_id', 'selected' => $map['menu_page_id'], 'show_option_none' => __( '— Pilih halaman —', 'irama-santri' ), 'option_none_value' => 0 ) ); ?></td></tr>
	<tr><th scope="row"><label for="irama_santri_contact_page_id"><?php esc_html_e( 'Halaman Contact', 'irama-santri' ); ?></label></th><td><?php wp_dropdown_pages( array( 'name' => 'irama_santri_page_map[contact_page_id]', 'id' => 'irama_santri_contact_page_id', 'selected' => $map['contact_page_id'], 'show_option_none' => __( '— Pilih halaman —', 'irama-santri' ), 'option_none_value' => 0 ) ); ?></td></tr></table>
	<?php submit_button(); ?></form></div><?php
}

/** Menampilkan daftar fasilitas dan tautan pengelolaannya. */
function irama_santri_render_facilities_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) { return; }
	$query = irama_santri_get_facilities();
	?>
	<div class="wrap"><h1><?php echo esc_html( get_admin_page_title() ); ?></h1><p><?php esc_html_e( 'Kelola fasilitas yang tampil di halaman Our Space.', 'irama-santri' ); ?></p>
	<p><a class="button button-primary" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=facility' ) ); ?>"><?php esc_html_e( 'Tambah Fasilitas', 'irama-santri' ); ?></a></p>
	<table class="widefat fixed striped"><thead><tr><th><?php esc_html_e( 'Nama', 'irama-santri' ); ?></th><th><?php esc_html_e( 'Urutan', 'irama-santri' ); ?></th><th><?php esc_html_e( 'Aksi', 'irama-santri' ); ?></th></tr></thead><tbody>
	<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?><tr><th scope="row"><?php echo esc_html( get_the_title() ); ?></th><td><?php echo (int) get_post_field( 'menu_order', get_the_ID() ); ?></td><td><a href="<?php echo esc_url( get_edit_post_link( get_the_ID() ) ); ?>"><?php esc_html_e( 'Sunting', 'irama-santri' ); ?></a></td></tr><?php endwhile; wp_reset_postdata(); else : ?><tr><td colspan="3"><?php esc_html_e( 'Belum ada fasilitas.', 'irama-santri' ); ?></td></tr><?php endif; ?>
	</tbody></table></div><?php
}

/** Menampilkan dan menyimpan pilihan foto galeri. */
function irama_santri_render_gallery_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) { return; }
	if ( isset( $_POST['irama_santri_gallery_save'] ) ) {
		check_admin_referer( 'irama_santri_gallery_save', 'irama_santri_gallery_nonce' );
		$raw_ids = isset( $_POST['irama_santri_gallery_ids'] ) ? array_map( 'absint', (array) wp_unslash( $_POST['irama_santri_gallery_ids'] ) ) : array();
		$ids          = array_slice( array_values( array_unique( array_filter( $raw_ids ) ) ), 0, 60 );
		$order_values = isset( $_POST['irama_santri_gallery_order'] ) && is_array( $_POST['irama_santri_gallery_order'] ) ? wp_unslash( $_POST['irama_santri_gallery_order'] ) : array();
		$valid        = array();
		foreach ( $ids as $id ) {
			if ( 'attachment' === get_post_type( $id ) && wp_attachment_is_image( $id ) ) {
				$valid[] = $id;
			}
		}
		usort(
			$valid,
			static function ( $first, $second ) use ( $order_values ): int {
				return absint( $order_values[ $first ] ?? PHP_INT_MAX ) <=> absint( $order_values[ $second ] ?? PHP_INT_MAX );
			}
		);
		update_option( 'irama_santri_gallery_ids', $valid );
		wp_safe_redirect( add_query_arg( array( 'page' => 'irama-santri-gallery', 'updated' => '1' ), admin_url( 'admin.php' ) ) );
		exit;
	}
	$current_ids = irama_santri_get_gallery_ids();
	$order_map   = array_flip( $current_ids );
	$query       = new WP_Query( array( 'post_type' => 'attachment', 'post_mime_type' => 'image', 'posts_per_page' => 100, 'orderby' => 'date', 'order' => 'DESC' ) );
	?>
	<div class="wrap"><h1><?php echo esc_html( get_admin_page_title() ); ?></h1><?php if ( isset( $_GET['updated'] ) ) : ?><div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Galeri berhasil disimpan.', 'irama-santri' ); ?></p></div><?php endif; ?>
	<p><?php esc_html_e( 'Pilih foto dari Media Library dan tentukan urutannya untuk halaman Gallery.', 'irama-santri' ); ?></p><form method="post"><?php wp_nonce_field( 'irama_santri_gallery_save', 'irama_santri_gallery_nonce' ); ?>
	<table class="widefat fixed striped"><thead><tr><th class="check-column"><?php esc_html_e( 'Pilih', 'irama-santri' ); ?></th><th><?php esc_html_e( 'Foto', 'irama-santri' ); ?></th><th><?php esc_html_e( 'Judul', 'irama-santri' ); ?></th><th><?php esc_html_e( 'Urutan', 'irama-santri' ); ?></th></tr></thead><tbody>
	<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); $attachment_id = get_the_ID(); ?><tr><td><input type="checkbox" name="irama_santri_gallery_ids[]" value="<?php echo (int) $attachment_id; ?>" <?php checked( in_array( $attachment_id, $current_ids, true ) ); ?>></td><td><?php echo wp_kses_post( wp_get_attachment_image( $attachment_id, 'thumbnail' ) ); ?></td><th scope="row"><?php echo esc_html( get_the_title() ); ?></th><td><input type="number" name="irama_santri_gallery_order[<?php echo (int) $attachment_id; ?>]" value="<?php echo esc_attr( (string) ( $order_map[ $attachment_id ] ?? count( $current_ids ) ) ); ?>" min="0" step="1" class="small-text"></td></tr><?php endwhile; wp_reset_postdata(); else : ?><tr><td colspan="4"><?php esc_html_e( 'Tidak ada gambar dalam Media Library.', 'irama-santri' ); ?></td></tr><?php endif; ?>
	</tbody></table><?php submit_button( __( 'Simpan Galeri', 'irama-santri' ), 'primary', 'irama_santri_gallery_save' ); ?></form></div><?php
}

/** Mendaftarkan meta box produk. */
function irama_santri_add_product_meta_boxes(): void {
	add_meta_box( 'irama_santri_product_details', __( 'Detail Produk', 'irama-santri' ), 'irama_santri_render_product_meta_box', 'product', 'side', 'high' );
	add_meta_box( 'irama_santri_product_variants', __( 'Varian Produk', 'irama-santri' ), 'irama_santri_render_variants', 'product', 'normal', 'default' );
	add_meta_box( 'irama_santri_product_addons', __( 'Add-On Produk', 'irama-santri' ), 'irama_santri_render_addons', 'product', 'normal', 'default' );
}
add_action( 'add_meta_boxes_product', 'irama_santri_add_product_meta_boxes' );

/** Menampilkan field harga, ketersediaan, dan featured. */
function irama_santri_render_product_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'irama_santri_product_meta', 'irama_santri_product_nonce' );
	?>
	<p><label for="irama_santri_base_price"><strong><?php esc_html_e( 'Harga dasar (Rp)', 'irama-santri' ); ?></strong></label><input type="number" min="0" step="1" class="widefat" id="irama_santri_base_price" name="irama_santri_base_price" value="<?php echo esc_attr( (string) get_post_meta( $post->ID, '_is_base_price', true ) ); ?>"></p>
	<p class="description"><?php esc_html_e( 'Isi 0 jika harga ditentukan oleh varian.', 'irama-santri' ); ?></p>
	<p><label><input type="checkbox" name="irama_santri_available" value="1" <?php checked( irama_santri_is_available( $post->ID ) ); ?>> <?php esc_html_e( 'Tersedia', 'irama-santri' ); ?></label></p>
	<p><label><input type="checkbox" name="irama_santri_featured" value="1" <?php checked( (bool) get_post_meta( $post->ID, '_is_featured', true ) ); ?>> <?php esc_html_e( 'Tampilkan sebagai menu unggulan', 'irama-santri' ); ?></label></p><?php
}

/** Menampilkan daftar field berulang produk. */
function irama_santri_render_product_repeater( int $post_id, string $kind ): void {
	$is_variants = 'variants' === $kind;
	$items       = $is_variants ? irama_santri_get_variants( $post_id ) : irama_santri_get_addons( $post_id );
	$singular    = $is_variants ? 'variant' : 'addon';
	?>
	<div class="irama-santri-admin-repeaters" data-target="<?php echo esc_attr( $kind ); ?>">
	<?php foreach ( $items as $index => $item ) : ?><div class="irama-santri-admin-repeater-item mb-3"><div class="grid gap-2 sm:grid-cols-2">
	<div><label class="screen-reader-text" for="irama_santri_<?php echo esc_attr( $singular ); ?>_label_<?php echo (int) $index; ?>"><?php echo esc_html( $is_variants ? __( 'Label varian', 'irama-santri' ) : __( 'Nama add-on', 'irama-santri' ) ); ?></label><input type="text" id="irama_santri_<?php echo esc_attr( $singular ); ?>_label_<?php echo (int) $index; ?>" name="irama_santri_<?php echo esc_attr( $kind ); ?>[<?php echo (int) $index; ?>][label]" value="<?php echo esc_attr( $item['label'] ); ?>" class="widefat" placeholder="<?php echo esc_attr( $is_variants ? __( 'Contoh: Regular, Large', 'irama-santri' ) : __( 'Contoh: Extra Shot, Oat Milk', 'irama-santri' ) ); ?>"></div>
	<div><label class="screen-reader-text" for="irama_santri_<?php echo esc_attr( $singular ); ?>_price_<?php echo (int) $index; ?>"><?php esc_html_e( 'Harga', 'irama-santri' ); ?></label><input type="number" id="irama_santri_<?php echo esc_attr( $singular ); ?>_price_<?php echo (int) $index; ?>" name="irama_santri_<?php echo esc_attr( $kind ); ?>[<?php echo (int) $index; ?>][price]" value="<?php echo esc_attr( (string) $item['price'] ); ?>" min="0" step="1" class="widefat"></div></div>
	<button type="button" class="irama-santri-admin-remove-btn button-link"><?php echo esc_html( $is_variants ? __( 'Hapus varian', 'irama-santri' ) : __( 'Hapus add-on', 'irama-santri' ) ); ?></button></div><?php endforeach; ?>
	<button type="button" class="irama-santri-admin-add-btn button" data-target="<?php echo esc_attr( $kind ); ?>"><?php echo esc_html( $is_variants ? __( 'Tambah varian', 'irama-santri' ) : __( 'Tambah add-on', 'irama-santri' ) ); ?></button></div><?php
}

/** Menampilkan field varian. */
function irama_santri_render_variants( int $post_id ): void { esc_html_e( 'Tambahkan ukuran atau rasa beserta harganya.', 'irama-santri' ); irama_santri_render_product_repeater( $post_id, 'variants' ); }
/** Menampilkan field add-on. */
function irama_santri_render_addons( int $post_id ): void { esc_html_e( 'Tambahkan pilihan tambahan beserta harganya.', 'irama-santri' ); irama_santri_render_product_repeater( $post_id, 'addons' ); }

/** Menyimpan seluruh metadata produk lewat satu handler. */
function irama_santri_save_product_admin_meta( int $post_id ): void {
	if ( ! isset( $_POST['irama_santri_product_nonce'] ) ) { return; }
	$nonce = sanitize_text_field( wp_unslash( $_POST['irama_santri_product_nonce'] ) );
	if ( ! wp_verify_nonce( $nonce, 'irama_santri_product_meta' ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_revision( $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) { return; }
	$price = isset( $_POST['irama_santri_base_price'] ) ? irama_santri_sanitize_price( wp_unslash( $_POST['irama_santri_base_price'] ) ) : 0;
	update_post_meta( $post_id, '_is_base_price', $price );
	update_post_meta( $post_id, '_is_available', isset( $_POST['irama_santri_available'] ) ? 1 : 0 );
	update_post_meta( $post_id, '_is_featured', isset( $_POST['irama_santri_featured'] ) ? 1 : 0 );
	foreach ( array( 'variants', 'addons' ) as $kind ) {
		$items = array();
		if ( isset( $_POST[ 'irama_santri_' . $kind ] ) && is_array( $_POST[ 'irama_santri_' . $kind ] ) ) {
			foreach ( wp_unslash( $_POST[ 'irama_santri_' . $kind ] ) as $item ) {
				if ( ! is_array( $item ) || ! isset( $item['label'] ) || '' === trim( (string) $item['label'] ) ) { continue; }
				$items[] = array( 'label' => sanitize_text_field( $item['label'] ), 'price' => irama_santri_sanitize_price( $item['price'] ?? 0 ) );
			}
		}
		update_post_meta( $post_id, '_is_' . $kind, irama_santri_sanitize_json_items( $items, 20 ) );
	}
}
add_action( 'save_post_product', 'irama_santri_save_product_admin_meta' );

/** Memuat JavaScript repeater hanya pada halaman editor produk. */
function irama_santri_enqueue_admin_assets( string $hook_suffix ): void {
	if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ), true ) ) { return; }
	$screen = get_current_screen();
	if ( $screen && 'product' === $screen->post_type ) { wp_enqueue_script( 'irama-santri-admin-repeaters', IRAMA_SANTRI_PLUGIN_URL . 'assets/js/admin-repeaters.js', array( 'jquery' ), IRAMA_SANTRI_VERSION, true ); }
}
add_action( 'admin_enqueue_scripts', 'irama_santri_enqueue_admin_assets' );



