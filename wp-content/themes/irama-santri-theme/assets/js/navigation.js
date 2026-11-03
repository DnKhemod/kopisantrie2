/** Toggle navigasi pada layar kecil. */
( () => {
	const toggle = document.querySelector( '[data-nav-toggle]' );
	const menu = document.querySelector( '[data-nav-menu]' );

	if ( ! toggle || ! menu ) {
		return;
	}

	toggle.addEventListener( 'click', () => {
		const isOpen = toggle.getAttribute( 'aria-expanded' ) === 'true';
		toggle.setAttribute( 'aria-expanded', String( ! isOpen ) );
		menu.classList.toggle( 'is-open', ! isOpen );
	} );
} )();
