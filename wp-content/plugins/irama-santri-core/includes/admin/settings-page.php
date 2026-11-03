<?php
/**
 * Halaman pengaturan plugin.
 *
 * @package IramaSantriCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Mendaftarkan menu admin.
 *
 * @return void
 */
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
}

/**
 * Menampilkan halaman Info Kedai.
 *
 * @return void
 */
function irama_santri_render_settings_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$info = irama_santri_get_business_info();
	$map  = irama_santri_get_page_map();
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

		<form method="post" action="options.php">
			<?php settings_fields( 'irama_santri_settings' ); ?>

			<h2><?php esc_html_e( 'Info Kedai', 'irama-santri' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row">
						<label for="irama_santri_address"><?php esc_html_e( 'Alamat', 'irama-santri' ); ?></label>
					</th>
					<td>
						<textarea
							id="irama_santri_address"
							name="irama_santri_business_info[address]"
							rows="3"
							class="large-text"
						><?php echo esc_textarea( $info['address'] ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="irama_santri_hours"><?php esc_html_e( 'Jam operasional', 'irama-santri' ); ?></label>
					</th>
					<td>
						<input
							type="text"
							id="irama_santri_hours"
							name="irama_santri_business_info[hours]"
							value="<?php echo esc_attr( $info['hours'] ); ?>"
							class="regular-text"
						>
					</td>
				</tr>
			</table>

			<h2><?php esc_html_e( 'Pemetaan Halaman', 'irama-santri' ); ?></h2>
			<p class="description">
				<?php esc_html_e( 'Pilih halaman yang menjadi tujuan tombol Menu dan Contact.', 'irama-santri' ); ?>
			</p>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row">
						<label for="irama_santri_menu_page_id"><?php esc_html_e( 'Halaman Menu', 'irama-santri' ); ?></label>
					</th>
					<td>
						<?php
						wp_dropdown_pages(
							array(
								'name'             => 'irama_santri_page_map[menu_page_id]',
								'id'               => 'irama_santri_menu_page_id',
								'selected'         => $map['menu_page_id'],
								'show_option_none' => __( '— Pilih halaman —', 'irama-santri' ),
								'option_none_value' => 0,
							)
						);
						?>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="irama_santri_contact_page_id"><?php esc_html_e( 'Halaman Contact', 'irama-santri' ); ?></label>
					</th>
					<td>
						<?php
						wp_dropdown_pages(
							array(
								'name'             => 'irama_santri_page_map[contact_page_id]',
								'id'               => 'irama_santri_contact_page_id',
								'selected'         => $map['contact_page_id'],
								'show_option_none' => __( '— Pilih halaman —', 'irama-santri' ),
								'option_none_value' => 0,
							)
						);
						?>
					</td>
				</tr>
			</table>

			<?php submit_button(); ?>
		</form>

		<h2 class="mt-8"><?php esc_html_e( 'Galeri', 'irama-santri' ); ?></h2>
		<p class="description">
			<?php esc_html_e( 'Pilih foto dari Media Library yang akan ditampilkan di halaman Gallery.', 'irama-santri' ); ?>
		</p>
		<table class="form-table" role="presentation">
			<tr>
				<th scope="row">
					<label for="irama_santri_gallery_ids"><?php esc_html_e( 'Foto Galeri', 'irama-santri' ); ?></label>
				</th>
				<td>
					<?php
					wp_dropdown_pages(
						array(
							'name'             => 'irama_santri_gallery_ids',
							'id'               => 'irama_santri_gallery_ids',
							'show_option_none' => __( '— Pilih foto —', 'irama-santri' ),
							'option_none_value' => '',
							'show_option_no_header' => true,
							'walker' => new Walker_Page_List(),
						)
					);
					?>
					<p class="description"><?php esc_html_e( 'Klik untuk pilih banyak (Ctrl/Cmd + klik).', 'irama-santri' ); ?></p>
				</td>
			</tr>
		</table>
	</div>
	<?php
}
