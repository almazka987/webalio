jQuery( document ).ready( function( $ ) {
	jQuery( '.fusion-alert .close' ).click( function( e ) {
		e.preventDefault();

		jQuery( this ).parent().slideUp();
	});
});
