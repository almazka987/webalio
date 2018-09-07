( function( jQuery ) {

	'use strict';

	// Max height for columns and content boxes
	jQuery.fn.equalHeights = function( $minHeight, $maxHeight ) {

		var $tallest;

		if ( Modernizr.mq( 'only screen and (min-width: ' + fusionEqualHeightVars.content_break_point + 'px)' ) || Modernizr.mq( 'only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: portrait)' ) ) {
			$tallest = ( $minHeight ) ? $minHeight : 0;

			this.each( function() {
				jQuery( this ).css( 'min-height', '0' );
				jQuery( this ).css( 'height', 'auto' );
				jQuery( this ).find( '.fusion-column-content-centered' ).css( 'min-height', '0' );
				jQuery( this ).find( '.fusion-column-content-centered' ).css( 'height', 'auto' );

				if ( jQuery( this ).outerHeight() > $tallest ) {
					$tallest = jQuery( this ).outerHeight();
				}
			});

			if ( ( $maxHeight ) && $tallest > $maxHeight ) {
				$tallest = $maxHeight;
			}

			return this.each( function() {
				var $newHeight = $tallest;

				// If $newHeight is 0, then there is no content in any of the columns. Set the empty column param, so that bg images can be scaled correctly
				if ( '0' == $newHeight ) {
					jQuery( this ).attr( 'data-empty-column', 'true' );
				}

				// Needed for vertically centered columns
				if ( jQuery( this ).children( '.fusion-column-content-centered' ).length ) {
					$newHeight = $tallest - ( jQuery( this ).outerHeight() - jQuery( this ).height() );
				}

				jQuery( this ).css( 'min-height', $newHeight );
				jQuery( this ).find( '.fusion-column-content-centered' ).css( 'min-height', $newHeight );
			});
		} else {
			return this.each( function() {
				jQuery( this ).css( 'min-height', '0' );
				jQuery( this ).find( '.fusion-column-content-centered' ).css( 'min-height', '0' );
			});
		}
	};
})( jQuery );
