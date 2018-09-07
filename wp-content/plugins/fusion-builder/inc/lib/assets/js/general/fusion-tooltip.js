jQuery( window ).load( function() {

	// Initialize Bootstrap Tooltip
	jQuery( '[data-toggle="tooltip"]' ).each( function() {

		var $container;

		if ( jQuery( this ).parents( '.fusion-header-wrapper' ).length ) {
			$container = '.fusion-header-wrapper';
		} else if ( jQuery( this ).parents( '#side-header' ).length ) {
			$container = '#side-header';
		} else {
			$container = 'body';
		}

		jQuery( this ).tooltip({
			container: $container
		});
	});

	jQuery( '.fusion-tooltip' ).hover( function() {

		// Get the current title attribute
		var $title = jQuery( this ).attr( 'title' );

			// Store it in a data var
			jQuery( this ).attr( 'data-title', $title );

			// Set the title to nothing so we don't see the tooltips
			jQuery( this ).attr( 'title', '' );

	});

	 jQuery( '.fusion-tooltip' ).click( function() {

		// Retrieve the title from the data attribute
		var $title = jQuery( this ).attr( 'data-title' );

		// Return the title to what it was
		jQuery( this ).attr( 'title', $title );

		jQuery( this ).blur();

	});
});
jQuery( document ).ready( function( $ ) {

	jQuery( '.tooltip-shortcode, .fusion-secondary-header .fusion-social-networks li, .fusion-author-social .fusion-social-networks li, .fusion-footer-copyright-area .fusion-social-networks li, .fusion-footer-widget-area .fusion-social-networks li, .sidebar .fusion-social-networks li, .social_links_shortcode li, .share-box li, .social-icon, .social li' ).mouseenter( function( e ) {
		jQuery( this ).find( '.popup' ).hoverFlow( e.type, {
			'opacity': 'show'
		});
	});

	jQuery( '.tooltip-shortcode, .fusion-secondary-header .fusion-social-networks li, .fusion-author-social .fusion-social-networks li, .fusion-footer-copyright-area .fusion-social-networks li, .fusion-footer-widget-area .fusion-social-networks li, .sidebar .fusion-social-networks li, .social_links_shortcode li, .share-box li, .social-icon, .social li' ).mouseleave( function( e ) {
		jQuery( this ).find( '.popup' ).hoverFlow( e.type, {
			'opacity': 'hide'
		});
	});
});
