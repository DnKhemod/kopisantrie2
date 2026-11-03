/**
 * Admin repeaters untuk manajemen varian dan add-on.
 *
 * @package IramaSantriCore
 *
 * @since 0.1.0
 */

jQuery( function( $ ) {
	$( document ).on( 'click', '.irama-santri-admin-add-btn', function( e ) {
		e.preventDefault();

		const target = $( this ).data( 'target' );
		if ( ! target ) {
			return;
		}

		let container = $( '[data-target="' + target + '"]' );
		const itemIndex = container.find( '.irama-santri-admin-repeater-item' ).length;

		const item = $( '#irama-santri-admin-item-template-' + target ).clone().removeClass( 'hidden' );

		// Update IDs dan names.
		item.find( 'input' ).each( function() {
			const $input = $( this );
			let name  = $input.attr( 'name' ) || '';
			let id    = $input.attr( 'id' ) || '';

			name = name.replace( /\[\d+\]/, '[' + itemIndex + ']' );
			id   = id.replace( /_(\d+)/, '_' + itemIndex );

			$input.attr( 'name', name ).attr( 'id', id );
			$input.val( '' );
		});

		container.append( item );
		itemIndex++;
	} );

	$( document ).on( 'click', '.irama-santri-admin-remove-btn', function( e ) {
		e.preventDefault();
		const $btn = $( this );
		const item = $btn.closest( '.irama-santri-admin-repeater-item' );

		if ( item.length === 0 ) {
			return;
		}

		// Warn if only one item.
		const container = item.closest( '[data-target]' );
		const items     = container.find( '.irama-santri-admin-repeater-item' );
		if ( items.length <= 1 ) {
			alert( 'Minimal satu item harus tetap ada.' );
			return;
		}

		item.remove();
	} );

	// Hidden template for cloning.
	$( 'body' ).append(
		'<div id="irama-santri-admin-item-template-variants" class="hidden">' +
			'<div class="irama-santri-admin-repeater-item" data-item-id="variant-0">' +
				'<div class="grid gap-2 sm:grid-cols-2">' +
					'<div>' +
						'<label class="sr-only" for="irama_santri_variant_label_0">Label varian</label>' +
						'<input type="text" id="irama_santri_variant_label_0" name="irama_santri_variants[0][label]" value="" class="widefat">' +
					'</div>' +
					'<div>' +
						'<label class="sr-only" for="irama_santri_variant_price_0">Harga</label>' +
						'<input type="number" id="irama_santri_variant_price_0" name="irama_santri_variants[0][price]" value="0" min="0" step="1" class="widefat">' +
					'</div>' +
				'</div>' +
				'<button type="button" class="irama-santri-admin-remove-btn ml-2 text-sm text-coffee-700 underline">Hapus</button>' +
			'</div>' +
		'</div>'
	);

	$( 'body' ).append(
		'<div id="irama-santri-admin-item-template-addons" class="hidden">' +
			'<div class="irama-santri-admin-repeater-item" data-item-id="addon-0">' +
				'<div class="grid gap-2 sm:grid-cols-2">' +
					'<div>' +
						'<label class="sr-only" for="irama_santri_addon_label_0">Nama add-on</label>' +
						'<input type="text" id="irama_santri_addon_label_0" name="irama_santri_addons[0][label]" value="" class="widefat">' +
					'</div>' +
					'<div>' +
						'<label class="sr-only" for="irama_santri_addon_price_0">Harga</label>' +
						'<input type="number" id="irama_santri_addon_price_0" name="irama_santri_addons[0][price]" value="0" min="0" step="1" class="widefat">' +
					'</div>' +
				'</div>' +
				'<button type="button" class="irama-santri-admin-remove-btn ml-2 text-sm text-coffee-700 underline">Hapus</button>' +
			'</div>' +
		'</div>'
	);

	// Auto-focus after adding.
	$( document ).on( 'click', '.irama-santri-admin-add-btn', function() {
		setTimeout( function() {
			const $input = $( '[data-target="' + $( this ).data( 'target' ) + '"] .irama-santri-admin-repeater-item:last input[type="text"]' );
			if ( $input.length ) {
				$input.focus();
			}
		}, 50 );
	} );
} );
