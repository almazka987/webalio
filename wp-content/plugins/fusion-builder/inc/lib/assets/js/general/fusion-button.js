jQuery( window ).load( function() {
	var iosVersion;

	if ( cssua.ua.ios ) {
		iosVersion = parseInt( cssua.ua.ios );
		if ( 7 == iosVersion ) {
			jQuery( '.button-icon-divider-left, .button-icon-divider-right' ).each( function() {
				var height = jQuery( this ).parent().outerHeight();
				jQuery( this ).css( 'height', height );

			});
		}
	}
});
