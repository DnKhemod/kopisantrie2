<?php
/**
 * Footer.
 *
 * Struktur dasar; styling final menunggu design system.
 *
 * @package IramaSantriTheme
 */

defined( 'ABSPATH' ) || exit;

$irama_santri_info = irama_santri_theme_business_info();
?>
<footer class="border-t border-cream-100">
	<div class="mx-auto flex max-w-6xl flex-col gap-2 px-4 py-8 text-sm text-coffee-700">
		<p>
			&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?>
			<?php bloginfo( 'name' ); ?>
		</p>
		<?php if ( ! empty( $irama_santri_info['address'] ) ) : ?>
			<p><?php echo esc_html( $irama_santri_info['address'] ); ?></p>
		<?php endif; ?>
		<?php if ( ! empty( $irama_santri_info['hours'] ) ) : ?>
			<p><?php echo esc_html( $irama_santri_info['hours'] ); ?></p>
		<?php endif; ?>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
