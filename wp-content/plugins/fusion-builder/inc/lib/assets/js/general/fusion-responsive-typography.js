// Calculate the responsive type values for font size and line height for all heading tags
var fusionCalculateResponsiveTypeValues = function( $customSensitivity, $customMinimumFontSizeFactor, $customMobileBreakPoint, $elements ) {

	// Setup options
	var $sensitivity           = $customSensitivity || 1,
	    $minimumFontSizeFactor = $customMinimumFontSizeFactor || 1.5,
	    $bodyFontSize          = parseInt( jQuery( 'body' ).css( 'font-size' ) ),
	    $minimumFontSize       = $bodyFontSize * $minimumFontSizeFactor,
	    $mobileBreakPoint      = ( $customMobileBreakPoint || 0 === $customMobileBreakPoint ) ? $customMobileBreakPoint : 800,
	    $windowSiteWidthRatio,
	    $resizeFactor;

	var calculateValues = function() {
		var $siteWidth;

		// Get the site width for responsive type
		if ( jQuery( window ).width() >= $mobileBreakPoint ) {

			// Get px based site width from Theme Options
			if ( fusionTypographyVars.site_width.indexOf( 'px' ) ) {
				$siteWidth = parseInt( fusionTypographyVars.site_width );

			// If site width is percentage based, use default site width
			} else {
				$siteWidth = 1100;
			}

		// If we are below $mobileBreakPoint of viewport width, set $mobileBreakPoint as site width
		} else {
			$siteWidth = $mobileBreakPoint;
		}

		// The resizing factor can be finetuned through a custom sensitivity; values below 1 decrease resizing speed
		$windowSiteWidthRatio = jQuery( window ).width() / $siteWidth;
		$resizeFactor         = 1 - ( ( 1 - $windowSiteWidthRatio ) * $sensitivity );

		// If window width is smaller than site width then let's adjust the headings
		if ( jQuery( window ).width() <= $siteWidth ) {

			// Loop over all heading tegs
			jQuery( $elements ).each( function() {

				// Only decrease font-size if the we stay above $minimumFontSize
				if ( jQuery( this ).data( 'fontsize' ) * $resizeFactor > $minimumFontSize ) {
					jQuery( this ).css( {
						'font-size': Math.round( jQuery( this ).data( 'fontsize' ) * $resizeFactor * 1000 ) / 1000,
						'line-height': ( Math.round( jQuery( this ).data( 'lineheight' ) * $resizeFactor * 1000 ) / 1000 ) + 'px'
					});

				// If decreased font size would become too small, natural font size is above $minimumFontSize, set font size to $minimumFontSize
				} else if ( jQuery( this ).data( 'fontsize' ) > $minimumFontSize ) {
					jQuery( this ).css( {
						'font-size': $minimumFontSize,
						'line-height': ( Math.round( jQuery( this ).data( 'lineheight' ) * $minimumFontSize / jQuery( this ).data( 'fontsize' ) * 1000 ) / 1000 ) + 'px'
					});
				}

			});

		// If window width is larger than site width, delete any resizing styles
		} else {
			jQuery( $elements ).each( function() {

				// If initially an inline font size was set, restore it
				if ( jQuery( this ).data( 'inline-fontsize' ) ) {
					jQuery( this ).css( 'font-size', jQuery( this ).data( 'fontsize' ) );

				// Otherwise remove inline font size
				} else {
					jQuery( this ).css( 'font-size', '' );
				}

				// If initially an inline line height was set, restore it
				if ( jQuery( this ).data( 'inline-lineheight' ) ) {
					jQuery( this ).css( 'line-height', jQuery( this ).data( 'lineheight' ) + 'px' );

				// Otherwise remove inline line height
				} else {
					jQuery( this ).css( 'line-height', '' );
				}

			});
		}
	};

	calculateValues();

	jQuery( window ).on( 'resize orientationchange', calculateValues );
};

function fusionSetOriginalTypographyData() {

	// Loop through all headings
	jQuery( 'h1, h2, h3, h4, h5, h6' ).each(
		function() {

			// If there are inline styles on the element initially, store information about it in data attribute
			if ( jQuery( this ).prop( 'style' )['font-size'] ) {
				jQuery( this ).attr( 'data-inline-fontsize', true );
			}

			if ( jQuery( this ).prop( 'style' )['font-size'] ) {
				jQuery( this ).attr( 'data-inline-lineheight', true );
			}

			// Set the original font size and line height to every heading as data attribute
			jQuery( this ).attr( 'data-fontsize', parseInt( jQuery( this ).css( 'font-size' ) ) );
			jQuery( this ).attr( 'data-lineheight', parseInt( jQuery( this ).css( 'line-height' ) ) );
		}
	);
}

jQuery( document ).ready( function( $ ) {

		fusionSetOriginalTypographyData();
		fusionCalculateResponsiveTypeValues( fusionTypographyVars.typography_sensitivity, fusionTypographyVars.typography_factor, 800, 'h1, h2, h3, h4, h5, h6' );

});

jQuery( document ).ajaxComplete( function() {

	fusionSetOriginalTypographyData();

});
