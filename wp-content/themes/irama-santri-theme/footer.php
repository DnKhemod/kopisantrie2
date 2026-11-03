<?php
defined( 'ABSPATH' ) || exit;
$business_info = irama_santri_theme_business_info();
?>
<footer class="site-footer">
	<div class="site-footer__inner">
		<div><a class="site-brand site-brand--footer" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span class="site-brand__mark" aria-hidden="true">IS</span><span class="site-brand__name"><?php bloginfo( 'name' ); ?></span></a><p><?php esc_html_e( 'Ruang untuk terhubung, berkarya, belajar, dan berbagi.', 'irama-santri' ); ?></p></div>
		<div class="site-footer__details"><span><?php echo esc_html( $business_info['address'] ?? '' ); ?></span><span><?php echo esc_html( $business_info['hours'] ?? '' ); ?></span></div>
		<p class="site-footer__copyright">&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
