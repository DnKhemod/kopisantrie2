<?php
/**
 * Meta box produk.
 *
 * Variasi harga dan add-on dikelola pada tahap implementasi fitur.
 *
 * @package IramaSantriCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Menampilkan meta box detail produk.
 *
 * @param WP_Post $post Post yang sedang diedit.
 * @return void
 */
function irama_santri_render_product_meta_box( WP_Post $post ): void {
	$price     = (int) get_post_meta( $post->ID, '_is_base_price', true );
	$available = irama_santri_is_available( $post->ID );
	$featured  = (bool) get_post_meta( $post->ID, '_is_featured', true );

	wp_nonce_field( 'irama_santri_product_meta', 'irama_santri_product_nonce' );
	?>
	<p>
		<label for="irama_santri_base_price">
			<strong><?php esc_html_e( 'Harga dasar (Rp)', 'irama-santri' ); ?></strong>
		</label>
		<input
			type="number"
			min="0"
			step="1"
			class="widefat"
			id="irama_santri_base_price"
			name="irama_santri_base_price"
			value="<?php echo esc_attr( (string) $price ); ?>"
		>
	</p>
	<p class="description">
		<?php esc_html_e( 'Isi 0 jika harga ditentukan oleh varian.', 'irama-santri' ); ?>
	</p>
	<p>
		<label>
			<input
				type="checkbox"
				name="irama_santri_available"
				value="1"
				<?php checked( $available ); ?>
			>
			<?php esc_html_e( 'Tersedia', 'irama-santri' ); ?>
		</label>
	</p>
	<p>
		<label>
			<input
				type="checkbox"
				name="irama_santri_featured"
				value="1"
				<?php checked( $featured ); ?>
			>
			<?php esc_html_e( 'Tampilkan sebagai menu unggulan', 'irama-santri' ); ?>
		</label>
	</p>
	<?php
}

/**
 * Mendaftarkan meta box.
 *
 * @return void
 */
function irama_santri_add_product_meta_box(): void {
	add_meta_box(
		'irama_santri_product_details',
		__( 'Detail Produk', 'irama-santri' ),
		'irama_santri_render_product_meta_box',
		'product',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes_product', 'irama_santri_add_product_meta_box' );

/**
 * Menyimpan meta produk.
 *
 * @param int $post_id ID produk.
 * @return void
 */
function irama_santri_save_product_meta( int $post_id ): void {
	if ( ! isset( $_POST['irama_santri_product_nonce'] ) ) {
		return;
	}

	$nonce = sanitize_text_field( wp_unslash( $_POST['irama_santri_product_nonce'] ) );

	if ( ! wp_verify_nonce( $nonce, 'irama_santri_product_meta' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$price = isset( $_POST['irama_santri_base_price'] )
		? irama_santri_sanitize_price( wp_unslash( $_POST['irama_santri_base_price'] ) )
		: 0;

	update_post_meta( $post_id, '_is_base_price', $price );
	update_post_meta( $post_id, '_is_available', isset( $_POST['irama_santri_available'] ) ? 1 : 0 );
	update_post_meta( $post_id, '_is_featured', isset( $_POST['irama_santri_featured'] ) ? 1 : 0 );
}

/** ==================================================================
 * Varian (Ukuran / Rasa)
 * ================================================================== */

/**
 * Menampilkan input varian untuk produk.
 */
function irama_santri_render_variants( int $post_id ): void {
	$variants = irama_santri_get_variants( $post_id );
	$index    = 0;
	?>
	<div class="irama-santri-admin-repeaters" data-target="variants">
		<?php if ( ! empty( $variants ) ) : ?>
			<?php foreach ( $variants as $index => $variant ) : ?>
				<div class="irama-santri-admin-repeater-item mb-3" data-item-id="variant-<?php echo (int) $index; ?>">
					<div class="grid gap-2 sm:grid-cols-2">
						<div>
							<label class="sr-only" for="irama_santri_variant_label_<?php echo (int) $index; ?>"><?php esc_html_e( 'Label varian', 'irama-santri' ); ?></label>
							<input
								type="text"
								id="irama_santri_variant_label_<?php echo (int) $index; ?>"
								name="irama_santri_variants[<?php echo (int) $index; ?>][label]"
								value="<?php echo esc_attr( $variant['label'] ); ?>"
								class="widefat"
								placeholder="<?php esc_attr_e( 'Contoh: Regular, Large', 'irama-santri' ); ?>"
							>
						</div>
						<div>
							<label class="sr-only" for="irama_santri_variant_price_<?php echo (int) $index; ?>"><?php esc_html_e( 'Harga', 'irama-santri' ); ?></label>
							<input
								type="number"
								id="irama_santri_variant_price_<?php echo (int) $index; ?>"
								name="irama_santri_variants[<?php echo (int) $index; ?>][price]"
								value="<?php echo esc_attr( (string) $variant['price'] ); ?>"
								min="0"
								step="1"
								class="widefat"
								placeholder="<?php esc_attr_e( '0', 'irama-santri' ); ?>"
							>
						</div>
					</div>
					<button type="button" class="irama-santri-admin-remove-btn ml-2 text-sm text-coffee-700 underline">
						<?php esc_html_e( 'Hapus varian', 'irama-santri' ); ?>
					</button>
				</div>

/**
 * Menampilkan input add-on untuk produk.
 */
function irama_santri_render_addons( int $post_id ): void {
	$addons = irama_santri_get_addons( $post_id );
	$index  = 0;
	?>
	<div class="irama-santri-admin-repeaters" data-target="addons">
		<?php if ( ! empty( $addons ) ) : ?>
			<?php foreach ( $addons as $index => $addon ) : ?>
				<div class="irama-santri-admin-repeater-item mb-3" data-item-id="addon-<?php echo (int) $index; ?>">
					<div class="grid gap-2 sm:grid-cols-2">
						<div>
							<label class="sr-only" for="irama_santri_addon_label_<?php echo (int) $index; ?>"><?php esc_html_e( 'Nama add-on', 'irama-santri' ); ?></label>
							<input
								type="text"
								id="irama_santri_addon_label_<?php echo (int) $index; ?>"
								name="irama_santri_addons[<?php echo (int) $index; ?>][label]"
								value="<?php echo esc_attr( $addon['label'] ); ?>"
								class="widefat"
								placeholder="<?php esc_attr_e( 'Contoh: Extra Shot, Oat Milk', 'irama-santri' ); ?>"
							>
						</div>
						<div>
							<label class="sr-only" for="irama_santri_addon_price_<?php echo (int) $index; ?>"><?php esc_html_e( 'Harga', 'irama-santri' ); ?></label>
							<input
								type="number"
								id="irama_santri_addon_price_<?php echo (int) $index; ?>"
								name="irama_santri_addons[<?php echo (int) $index; ?>][price]"
								value="<?php echo esc_attr( (string) $addon['price'] ); ?>"
								min="0"
								step="1"
								class="widefat"
								placeholder="<?php esc_attr_e( '0', 'irama-santri' ); ?>"
							>
						</div>
					</div>
					<button type="button" class="irama-santri-admin-remove-btn ml-2 text-sm text-coffee-700 underline">
						<?php esc_html_e( 'Hapus add-on', 'irama-santri' ); ?>
					</button>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>


/**
 * Mendaftarkan meta box untuk produk.
 */
function irama_santri_add_product_admin_meta_boxes(): void {
	add_meta_box(
		'irama_santri_product_details',
		__( 'Detail Produk', 'irama-santri' ),
		'irama_santri_render_product_meta_box',
		'product',
		'side',
		'high'
	);

	add_meta_box(
		'irama_santri_product_variants',
		__( 'Varian Produk', 'irama-santri' ),
		'irama_santri_render_variants',
		'product',
		'side',
		'standard'
	);

	add_meta_box(
		'irama_santri_product_addons',
		__( 'Add-On Produk', 'irama-santri' ),
		'irama_santri_render_addons',
		'product',
		'side',
		'standard'
	);
}
add_action( 'add_meta_boxes_product', 'irama_santri_add_product_admin_meta_boxes' );

/**
 * Menyimpan meta produk dari admin.
 */
function irama_santri_save_product_admin_meta( int $post_id ): void {
	if ( ! isset( $_POST['irama_santri_product_nonce'] ) ) {
		return;
	}

	$nonce = sanitize_text_field( wp_unslash( $_POST['irama_santri_product_nonce'] ) );

	if ( ! wp_verify_nonce( $nonce, 'irama_santri_product_meta' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Harga dasar.
	if ( isset( $_POST['irama_santri_base_price'] ) ) {
		$price = irama_santri_sanitize_price( wp_unslash( $_POST['irama_santri_base_price'] ) );
		update_post_meta( $post_id, '_is_base_price', $price );
	}

	// Ketersediaan.
	update_post_meta(
		$post_id,
		'_is_available',
		isset( $_POST['irama_santri_available'] ) ? 1 : 0
	);

	// Featured.
	update_post_meta(
		$post_id,
		'_is_featured',
		isset( $_POST['irama_santri_featured'] ) ? 1 : 0
	);

	// Varian.
	if ( isset( $_POST['irama_santri_variants'] ) && is_array( $_POST['irama_santri_variants'] ) ) {
		$variants = array();
		foreach ( $_POST['irama_santri_variants'] as $key => $variant ) {
			if ( ! isset( $variant['label'] ) || '' === trim( (string) $variant['label'] ) ) {
				continue;
			}
			$variants[] = array(
				'label' => sanitize_text_field( (string) $variant['label'] ),
				'price' => irama_santri_sanitize_price( $variant['price'] ?? 0 ),
			);
		}
		update_post_meta( $post_id, '_is_variants', irama_santri_sanitize_json_items( $variants, 20 ) );
	}

	// Add-on.
	if ( isset( $_POST['irama_santri_addons'] ) && is_array( $_POST['irama_santri_addons'] ) ) {
		$addons = array();
		foreach ( $_POST['irama_santri_addons'] as $key => $addon ) {
			if ( ! isset( $addon['label'] ) || '' === trim( (string) $addon['label'] ) ) {
				continue;
			}
			$addons[] = array(
				'label' => sanitize_text_field( (string) $addon['label'] ),
				'price' => irama_santri_sanitize_price( $addon['price'] ?? 0 ),
			);
		}
		update_post_meta( $post_id, '_is_addons', irama_santri_sanitize_json_items( $addons, 20 ) );
	}
}
add_action( 'save_post_product', 'irama_santri_save_product_admin_meta' );

		<button
			type="button"
			class="irama-santri-admin-add-btn mt-2 text-sm text-accent-600 underline"
			data-target="addons"
		>
			<?php esc_html_e( 'Tambah add-on', 'irama-santri' ); ?>
		</button>
	</div>
	<?php
}

			<?php endforeach; ?>
		<?php endif; ?>

		<button
			type="button"
			class="irama-santri-admin-add-btn mt-2 text-sm text-accent-600 underline"
			data-target="variants"
		>
			<?php esc_html_e( 'Tambah varian', 'irama-santri' ); ?>
		</button>
	</div>
	<?php
}

add_action( 'save_post_product', 'irama_santri_save_product_meta' );
