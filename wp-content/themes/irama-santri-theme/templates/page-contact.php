<?php
/**
 * Template Name: Contact & Location
 *
 * @package IramaSantriTheme
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main id="primary" class="mx-auto max-w-6xl px-4 py-10">
	<header class="mb-8">
		<h1 class="mb-2 text-3xl font-semibold"><?php esc_html_e( 'Contact & Location', 'irama-santri' ); ?></h1>
		<p class="text-coffee-700"><?php esc_html_e( 'Kunjungi kami atau hubungi informasi kami.', 'irama-santri' ); ?></p>
	</header>

	<div class="grid gap-8 lg:grid-cols-2">
		<section>
			<h2 class="mb-4 text-2xl font-semibold"><?php esc_html_e( 'Alamat', 'irama-santri' ); ?></h2>
			<address class="not-italic text-coffee-700">
				<?php
				$business_info = irama_santri_get_business_info();
				if ( ! empty( $business_info['address'] ) ) :
					echo esc_html( $business_info['address'] );
				else :
					esc_html_e( 'Alamat akan ditambahkan.', 'irama-santri' );
				endif;
				?>
			</address>
		</section>

		<section>
			<h2 class="mb-4 text-2xl font-semibold"><?php esc_html_e( 'Jam Operasional', 'irama-santri' ); ?></h2>
			<p class="text-coffee-700">
				<?php
				if ( ! empty( $business_info['hours'] ) ) :
					echo esc_html( $business_info['hours'] );
				else :
					esc_html_e( 'Jam operasional akan ditambahkan.', 'irama-santri' );
				endif;
				?>
			</p>
		</section>
	</div>

	<div class="mt-8 rounded border border-cream-100 bg-cream-100 p-6">
		<?php
		$page_map = irama_santri_get_page_map();
		$page_urls = array(
			'menu'    => isset( $page_map['menu_page_id'] ) ? $page_map['menu_page_id'] : 0,
			'contact' => isset( $page_map['contact_page_id'] ) ? $page_map['contact_page_id'] : 0,
		);

		if ( isset( $page_urls['menu'] ) && $page_urls['menu'] ) :
			$menu_url = get_permalink( $page_urls['menu'] );
			if ( $menu_url ) :
				?>
				<a
					href="<?php echo esc_url( $menu_url ); ?>"
					class="inline-flex items-center rounded border border-accent-600 px-6 py-3 text-sm font-medium text-accent-600 hover:bg-accent-600 hover:text-white"
				>
					<?php esc_html_e( 'Lihat Menu', 'irama-santri' ); ?>
				</a>
				<?php
			endif;
		endif;

		if ( isset( $page_urls['contact'] ) && $page_urls['contact'] ) :
			$contact_url = get_permalink( $page_urls['contact'] );
			if ( $contact_url ) :
				?>
				<a
					href="<?php echo esc_url( $contact_url ); ?>"
					class="ml-4 inline-flex items-center rounded border border-coffee-900 px-6 py-3 text-sm font-medium text-coffee-900 hover:bg-coffee-900 hover:text-white"
				>
					<?php esc_html_e( 'Kunjungi Kedai', 'irama-santri' ); ?>
				</a>
				<?php
			endif;
		endif;
		?>
	</div>
</main>

<?php get_footer(); ?>
