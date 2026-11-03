<?php
/**
 * Fallback template.
 *
 * Template halaman final dibuat setelah design system disetujui.
 *
 * @package IramaSantriTheme
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="mx-auto max-w-6xl px-4 py-10">
	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article <?php post_class( 'mb-10' ); ?>>
				<h1 class="mb-4 text-3xl font-semibold">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h1>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Belum ada konten.', 'irama-santri' ); ?></p>
	<?php endif; ?>
</main>
<?php
get_footer();
