# -*- coding: utf-8 -*-
import os

target = os.path.join(
    'D:', 'Learn Coding', 'kopisantrie',
    'wp-content', 'plugins', 'irama-santri-core',
    'includes', 'admin', 'product-fields.php'
)

lines = []
lines.append('<?php')
lines.append('/**')
lines.append(' * Meta box produk: variasi, add-on, dan pengaturan lanjutan.')
lines.append(' *')
lines.append(' * @package IramaSantriCore')
lines.append(' */')
lines.append('')
lines.append('defined( \'ABSPATH\' ) || exit;')
lines.append('')
lines.append('/**')
lines.append(' * Menampilkan input varian untuk produk.')
lines.append(' */')
lines.append('function irama_santri_render_variants( int $post_id ): void {')
lines.append('\t$variants = irama_santri_get_variants( $post_id );')
lines.append('\t$index    = 0;')
lines.append('?>')
lines.append('<div class="irama-santri-admin-repeaters" data-target="variants">')
lines.append('<?php if ( ! empty( $variants ) ) : ?>')
lines.append('<?php foreach ( $variants as $index => $variant ) : ?>')
lines.append('<div class="irama-santri-admin-repeater-item mb-3 rounded border border-cream-100 p-3">')
lines.append('<div class="grid gap-2 sm:grid-cols-2">')
lines.append('<div>')
lines.append('<label class="sr-only" for="irama_santri_variant_label_' . $index . '"><?php esc_html_e( \'Label varian\', \'irama-santri\' ); ?></label>')
lines.append('<input type="text" id="irama_santri_variant_label_' . $index . '" name="irama_santri_variants[' . $index . '][label]" value="' . esc_attr( $variant['label'] ) . '" class="widefat" placeholder="' . esc_attr_e( 'Contoh: Regular, Large, Cappuccino', 'irama-santri' ) . '">')
lines.append('</div>')
lines.append('<div>')
lines.append('<label class="sr-only" for="irama_santri_variant_price_' . $index . '"><?php esc_html_e( \'Harga\', \'irama-santri\' ); ?></label>')
lines.append('<input type="number" id="irama_santri_variant_price_' . $index . '" name="irama_santri_variants[' . $index . '][price]" value="' . esc_attr( (string) $variant['price'] ) . '" min="0" step="1" class="widefat" placeholder="0">')
lines.append('</div>')
lines.append('</div>')
lines.append('<button type="button" class="irama-santri-admin-remove-btn ml-2 text-sm text-coffee-700 underline">')
lines.append('<?php esc_html_e( \'Hapus varian\', \'irama-santri\' ); ?>')
lines.append('</button>')
lines.append('</div>')
lines.append('<?php endforeach; ?>')
lines.append('<?php endif; ?>')
lines.append('<button type="button" class="irama-santri-admin-add-btn mt-2 text-sm text-accent-600 underline" data-target="variants">')
lines.append('<?php esc_html_e( \'Tambah varian\', \'irama-santri\' ); ?>')
lines.append('</button>')
lines.append('</div>')
lines.append('<?php')
lines.append('}')
lines.append('')
content = "\n".join(lines)

with open(target, 'w', encoding='utf-8') as f:
    f.write(content)

print('Part 1 written successfully')
