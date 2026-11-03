/**
 * Menambah dan menghapus field varian serta add-on produk.
 *
 * @package IramaSantriCore
 */
jQuery( function( $ ) {
	$( document ).on( 'click', '.irama-santri-admin-add-btn', function( event ) {
		event.preventDefault();
		const target = $( this ).data( 'target' );
		if ( ! [ 'variants', 'addons' ].includes( target ) ) {
			return;
		}
		const container = $( '.irama-santri-admin-repeaters[data-target="' + target + '"]' );
		if ( ! container.length ) {
			return;
		}

		let itemIndex = 0;
		container.find( 'input[name]' ).each( function() {
			const match = $( this ).attr( 'name' ).match( /\[(\d+)\]/ );
			if ( match ) {
				itemIndex = Math.max( itemIndex, Number( match[1] ) + 1 );
			}
		} );

		const singular = 'variants' === target ? 'variant' : 'addon';
		const label = 'variants' === target ? 'Label varian' : 'Nama add-on';
		const item = $( '<div class="irama-santri-admin-repeater-item mb-3"><div class="grid gap-2 sm:grid-cols-2"><div><label class="screen-reader-text"></label><input type="text" class="widefat"></div><div><label class="screen-reader-text"></label><input type="number" min="0" step="1" class="widefat"></div></div><button type="button" class="irama-santri-admin-remove-btn button-link">Hapus</button></div>' );
		const inputs = item.find( 'input' );
		inputs.eq( 0 ).attr( 'id', 'irama_santri_' + singular + '_label_' + itemIndex ).attr( 'name', 'irama_santri_' + target + '[' + itemIndex + '][label]' ).attr( 'aria-label', label );
		inputs.eq( 1 ).attr( 'id', 'irama_santri_' + singular + '_price_' + itemIndex ).attr( 'name', 'irama_santri_' + target + '[' + itemIndex + '][price]' ).attr( 'aria-label', 'Harga' ).val( '0' );
		container.find( '.irama-santri-admin-add-btn' ).before( item );
		inputs.eq( 0 ).trigger( 'focus' );
	} );

	$( document ).on( 'click', '.irama-santri-admin-remove-btn', function( event ) {
		event.preventDefault();
		const item = $( this ).closest( '.irama-santri-admin-repeater-item' );
		const container = item.closest( '.irama-santri-admin-repeaters' );
		if ( container.find( '.irama-santri-admin-repeater-item' ).length > 1 ) {
			item.remove();
		}
	} );
} );


