<?php
/**
 * Manajemen fasilitas (Our Space).
 *
 * @package IramaSantriCore
 */

defined( 'ABSPATH' ) || exit;

/** Menampilkan daftar fasilitas di admin. */
function irama_santri_render_facilities_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$page     = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';
	$message  = '';
	$message_type = '';

	if ( 'facility' === $page && isset( $_GET['settings-updated'] ) ) {
		$message  = __( 'Fasilitas berhasil disimpan.', 'irama-santri' );
		$message_type = 'updated';
	}

	$facilities_query = irama_santri_get_facilities();
	$facilities       = array();
	if ( $facilities_query->have_posts() ) {
		while ( $facilities_query->have_posts() ) {
			$facilities_query->the_post();
			$facilities[ get_the_ID() ] = array(
				'title' => get_the_title(),
			);
		}
		wp_reset_postdata();
	}
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<?php if ( $message ) : ?>
			<div class="notice notice-<?php echo esc_attr( $message_type ); ?>">
				<p><?php echo wp_kses_post( $message ); ?></p>
			</div>
		<?php endif; ?>

		<h2><?php esc_html_e( 'Fasilitas', 'irama-santri' ); ?></h2>
		<p class="description"><?php esc_html_e( 'Kelola daftar fasilitas yang ditampilkan di halaman Our Space.', 'irama-santri' ); ?></p>

		<table class="widefat fixed striped">
			<thead>
				<tr>
					<th scope="col"><?php esc_html_e( 'Nama', 'irama-santri' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Urutan', 'irama-santri' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Aksi', 'irama-santri' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if ( ! empty( $facilities ) ) : ?>
					<?php ksort( $facilities ); ?>
					<?php foreach ( $facilities as $id => $item ) : ?>
						<tr>
							<th scope="row"><?php echo esc_html( $item['title'] ); ?></th>
							<td class="center"><?php echo (int) get_post_meta( $id, '_irama_santri_order', true ); ?></td>
							<td class="center">
								<a href="<?php echo esc_url( admin_url( 'post.php?action=edit&post=' . (int) $id . '&page=facility' ) ); ?>">
									<?php esc_html_e( 'Sunting', 'irama-santri' ); ?>
								</a>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php else : ?>
					<tr>
						<td colspan="3"><?php esc_html_e( 'Belum ada fasilitas. Tambahkan fasilitas di bawah.', 'irama-santri' ); ?></td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>

		<h2><?php esc_html_e( 'Tambah Fasilitas', 'irama-santri' ); ?></h2>
		<a
			href="<?php echo esc_url( admin_url( 'post-new.php?post_type=facility' ) ); ?>"
			class="button button-primary"
		>
			<?php esc_html_e( 'Tambah Fasilitas Baru', 'irama-santri' ); ?>
		</a>
	</div>
	<?php
}

/** Mendaftarkan menu admin. */
function irama_santri_register_admin_pages(): void {
	add_menu_page(
		__( 'Irama Santri', 'irama-santri' ),
		__( 'Irama Santri', 'irama-santri' ),
		'manage_options',
		'irama-santri',
		'irama_santri_render_settings_page',
		'dashicons-store',
		3
	);

	add_submenu_page(
		'irama-santri',
		__( 'Info Kedai', 'irama-santri' ),
		__( 'Info Kedai', 'irama-santri' ),
		'manage_options',
		'irama-santri',
		'irama_santri_render_settings_page'
	);

	add_submenu_page(
		'irama-santri',
		__( 'Fasilitas', 'irama-santri' ),
		__( 'Fasilitas', 'irama-santri' ),
		'manage_options',
		'facility',
		'irama_santri_render_facilities_page'
	);
}
add_action( 'admin_menu', 'irama_santri_register_admin_pages' );
