<?php
/**
 * Manajemen galeri.
 *
 * @package IramaSantriCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Menampilkan daftar galeri (attachment) di admin.
 */
function irama_santri_render_gallery_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$message  = '';
	$message_type = '';

	if ( isset( $_POST['irama_santri_gallery_save'] ) ) {
		check_admin_referer( 'irama_santri_gallery_save' );

		$ids = isset( $_POST['irama_santri_gallery_ids'] ) ? array_map( 'absint', (array) $_POST['irama_santri_gallery_ids'] ) : array();
		$ids = array_values( array_unique( array_filter( $ids ) ) );
		$ids = array_slice( $ids, 0, 60 );

		$valid = array();
		foreach ( $ids as $id ) {
			if ( 'attachment' === get_post_type( $id ) ) {
				$valid[] = $id;
			}
		}

		update_option( 'irama_santri_gallery_ids', $valid );

		$message  = __( 'Galeri berhasil disimpan.', 'irama-santri' );
		$message_type = 'updated';
	}

	$current_ids = irama_santri_get_gallery_ids();
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<?php if ( $message ) : ?>
			<div class="notice notice-<?php echo esc_attr( $message_type ); ?>">
				<p><?php echo wp_kses_post( $message ); ?></p>
			</div>
		<?php endif; ?>

		<h2><?php esc_html_e( 'Galeri', 'irama-santri' ); ?></h2>
		<p class="description"><?php esc_html_e( 'Pilih foto dari Media Library untuk ditampilkan di halaman Gallery.', 'irama-santri' ); ?></p>

		<form method="post">
			<?php wp_nonce_field( 'irama_santri_gallery_save', 'irama_santri_gallery_nonce' ); ?>

			<table class="widefat fixed striped" id="irama-santri-gallery-table">
				<thead>
					<tr>
						<th scope="col" class="check-column">
							<input type="checkbox" id="irama-santri-gallery-select-all">
						</th>
						<th scope="col"><?php esc_html_e( 'Foto', 'irama-santri' ); ?></th>
						<th scope="col"><?php esc_html_e( 'Judul', 'irama-santri' ); ?></th>
						<th scope="col"><?php esc_html_e( 'Urutan', 'irama-santri' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$args = array(
						'post_type'      => 'attachment',
						'post_mime_type' => 'image',
						'posts_per_page' => -1,
						'orderby'        => 'menu_order',
						'order'          => 'ASC',
					);
					$query = new WP_Query( $args );
					if ( $query->have_posts() ) :
						while ( $query->have_posts() ) {
							$query->the_post();
							$attachment_id = get_the_ID();
							$is_checked    = in_array( $attachment_id, $current_ids, true ) ? 'checked' : '';
							$order         = (int) get_post_meta( $attachment_id, '_irama_santri_gallery_order', true );
							?>
							<tr>
								<td class="check-column">
									<input type="checkbox" name="irama_santri_gallery_ids[]" value="<?php echo (int) $attachment_id; ?>" <?php echo $is_checked; ?>>
								</td>
								<td>
									<?php
									$preview = wp_get_attachment_image( $attachment_id, 'thumbnail', false, array( 'class' => 'max-w-32' ) );
									if ( $preview ) {
										echo wp_kses_post( $preview );
									}
									?>
								</td>
								<th scope="row">
									<p class="has-medium-editor-size"><?php echo esc_html( get_the_title() ); ?></p>
								</th>
								<td class="center">
									<input
										type="number"
										name="irama_santri_gallery_order[<?php echo (int) $attachment_id; ?>]"
										value="<?php echo (int) $order; ?>"
										min="0"
										step="1"
										class="small-text"
									>
								</td>
							</tr>
							<?php
						}
						wp_reset_postdata();
					else :
						?>
						<tr>
							<td colspan="4"><?php esc_html_e( 'Tidak ada gambar dalam Media Library.', 'irama-santri' ); ?></td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>

			<p class="submit">
				<input type="submit" name="irama_santri_gallery_save" class="button button-primary" value="<?php esc_attr_e( 'Simpan Urutan Galeri', 'irama-santri' ); ?>">
			</p>
		</form>
	</div>
	<?php
}

/**
 * Mendaftarkan menu admin untuk galeri.
 */
function irama_santri_register_gallery_admin_page(): void {
	add_submenu_page(
		'irama-santri',
		__( 'Galeri', 'irama-santri' ),
		__( 'Galeri', 'irama-santri' ),
		'manage_options',
		'irama-santri-gallery',
		'irama_santri_render_gallery_page'
	);
}
add_action( 'admin_menu', 'irama_santri_register_gallery_admin_page' );
