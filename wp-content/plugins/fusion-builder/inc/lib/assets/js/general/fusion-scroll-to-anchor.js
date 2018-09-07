( function( jQuery ) {

	'use strict';

	// Smooth scrolling to anchor target
	jQuery.fn.fusion_scroll_to_anchor_target = function() {
		var $href     = jQuery( this ).attr( 'href' ),
		    $hrefHash = $href.substr( $href.indexOf( '#' ) ).slice( 1 ),
		    $target   = jQuery( '#' + $hrefHash ),
		    $adminbarHeight,
		    $stickyHeaderHeight,
		    $currentScrollPosition,
		    $newScrollPosition,
		    $halfScrollAmount,
		    $halfScrollPosition;

		if ( $target.length && '' !== $hrefHash ) {
			$adminbarHeight        = ( 'function' === typeof getAdminbarHeight ) ? getAdminbarHeight() : 0;
			$stickyHeaderHeight    = ( 'function' === typeof getStickyHeaderHeight ) ? getStickyHeaderHeight() : 0;
			$currentScrollPosition = jQuery( document ).scrollTop();
			$newScrollPosition     = $target.offset().top - $adminbarHeight - $stickyHeaderHeight;
			$halfScrollAmount      = Math.abs( $currentScrollPosition - $newScrollPosition ) / 2;

			if ( $currentScrollPosition > $newScrollPosition ) {
				$halfScrollPosition = $currentScrollPosition - $halfScrollAmount;
			} else {
				$halfScrollPosition = $currentScrollPosition + $halfScrollAmount;
			}

			jQuery( 'html, body' ).animate({
				 scrollTop: $halfScrollPosition
			}, { duration: 400, easing: 'easeInExpo', complete: function() {

					$adminbarHeight = ( 'function' === typeof getAdminbarHeight ) ? getAdminbarHeight() : 0;
					$stickyHeaderHeight = ( 'function' === typeof getStickyHeaderHeight ) ? getStickyHeaderHeight() : 0;

					$newScrollPosition = ( $target.offset().top - $adminbarHeight - $stickyHeaderHeight );

					jQuery( 'html, body' ).animate({
						 scrollTop: $newScrollPosition
					}, 450, 'easeOutExpo' );

				}

			});

			// On page tab link
			if ( $target.hasClass( 'tab-link' ) && 'function' === typeof fusionSwitchTabOnLinkClick ) {
				jQuery( '.fusion-tabs' ).fusionSwitchTabOnLinkClick();
			}

			return false;
		}
	};

})( jQuery );

jQuery( document ).ready( function( $ ) {

	jQuery( '.fusion-menu a:not([href="#"], .fusion-megamenu-widgets-container a, .search-link), .fusion-mobile-nav-item a:not([href="#"], .search-link), .fusion-button:not([href="#"], input, button), .fusion-one-page-text-link:not([href="#"])' ).click( function( e ) {

		var $currentHref,
		    $currentPath,
		    $target,
		    $targetArray,
		    $targetID,
		    $targetIDFirstChar,
		    $targetPath,
		    $targetPathLastChar,
		    $targetWindow;

		if ( jQuery( this ).hasClass( 'avada-noscroll' ) || jQuery( this ).parent().hasClass( 'avada-noscroll' ) ) {
			return true;
		}

		if ( this.hash ) {

			// Current path
			$currentHref = window.location.href.split( '#' );
			$currentPath = ( '/' === $currentHref[0].charAt( $currentHref[0].length - 1 ) ) ? $currentHref[0] : $currentHref[0] + '/';

			// Target path
			$targetWindow       = ( jQuery( this ).attr( 'target' ) ) ? jQuery( this ).attr( 'target' ) : '_self';
			$target             = jQuery( this ).attr( 'href' );
			$targetArray        = $target.split( '#' );
			$targetID           = ( 'undefined' !== typeof $targetArray[1] ) ? $targetArray[1] : '';
			$targetIDFirstChar  = $targetID.substring( 0, 1 );
			$targetPath         = $targetArray[0];
			$targetPathLastChar = $targetPath.substring( $targetPath.length - 1, $targetPath.length );

			if ( '/' !== $targetPathLastChar ) {
				$targetPath = $targetPath + '/';
			}

			if ( '!' === $targetIDFirstChar || '/' === $targetIDFirstChar  ) {
				return;
			}

			e.preventDefault();

			// If the link is outbound add an underscore right after the hash tag to make sure the link isn't present on the loaded page
			if ( ( location.pathname.replace( /^\//, '' ) == this.pathname.replace( /^\//, '' ) || '#' === $target.charAt( 0 ) ) && '' === location.search ) {
				jQuery( this ).fusion_scroll_to_anchor_target();
				if ( jQuery( this ).parents( '.fusion-flyout-menu' ).length ) {
					jQuery( '.fusion-flyout-menu-toggle' ).trigger( 'click' );
				}
			} else {

				// If we are on search page, front page anchors won't work, unless we add full path.
				if ( '/' === $targetPath && '' !== location.search ) {
					$targetPath = location.href.replace( location.search, '' );
				}

				window.open( $targetPath + '#_' + $targetID, $targetWindow );
			}
		}
	});
});

// Prevent anchor jumping on page load
if ( location.hash && '#_' === location.hash.substring( 0, 2 ) ) {

	// Add the anchor link to the hidden a tag
	jQuery( '.fusion-page-load-link' ).attr( 'href', '#' + location.hash.substring( 2 ) );

	// Scroll the page
	jQuery( window ).load( function() {
		if ( jQuery( '.fusion-blog-shortcode' ).length ) {
			setTimeout( function() {
				jQuery( '.fusion-page-load-link' ).fusion_scroll_to_anchor_target();
			}, 300 );
		} else {
			jQuery( '.fusion-page-load-link' ).fusion_scroll_to_anchor_target();
		}
	});
}
