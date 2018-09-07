// Get WP admin bar height
function getAdminbarHeight() {
	var $adminbarHeight = 0;

	if ( jQuery( '#wpadminbar' ).length ) {
		$adminbarHeight = parseInt( jQuery( '#wpadminbar' ).outerHeight() );
	}

	return $adminbarHeight;
}

function getWaypointOffset( $object ) {
	var $offset = $object.data( 'animationoffset' ),
	    $adminbarHeight,
	    $stickyHeaderHeight;

	if ( undefined === $offset ) {
		$offset = 'bottom-in-view';
	}

	if ( 'top-out-of-view' === $offset ) {
		$adminbarHeight     = getAdminbarHeight();
		$stickyHeaderHeight = ( 'function' === getWaypointTopOffset ) ? getWaypointTopOffset() : 0;

		$offset = $adminbarHeight + $stickyHeaderHeight;
	}

	return $offset;
}
jQuery( window ).load( function() {

	// Initialize Waypoint
	setTimeout( function() {
		jQuery.waypoints( 'viewportHeight' );
	}, 300 );
});
