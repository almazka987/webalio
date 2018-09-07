jQuery( window ).load( function() {
	if ( cssua.ua.mobile || cssua.ua.tablet_pc ) {
		jQuery( '.fusion-popover, .fusion-tooltip' ).each( function() {
			jQuery( this ).attr( 'data-trigger', 'click' );
			jQuery( this ).data( 'trigger', 'click' );
		});
	}

	// Initialize Bootstrap Popovers
	jQuery( '[data-toggle~="popover"]' ).popover({
		container: 'body'
	});
});
