jQuery( document ).ready( function() {

	_.each( patcherVars.args, function( args ) {

		var topMenuElement,
		    subMenuElement,
			noticeContent;

		// Only process if the number of available patches is > 0.
		if ( 'undefined' !== typeof patcherVars.patches[ args.context ] && 0 < patcherVars.patches[ args.context ] ) {
			topMenuElement = jQuery( '#adminmenu .toplevel_page_' + args.parent_slug + ' .wp-menu-name' );
			subMenuElement = jQuery( '#adminmenu .toplevel_page_' + args.parent_slug + ' ul.wp-submenu li a[href="admin.php?page=' + args.context + '-fusion-patcher"]' );

			noticeContent = '<span class="update-plugins count-' + patcherVars.patches[ args.context ] + '" style="margin-left:5px;"><span class="plugin-count">' + patcherVars.patches[ args.context ] + '</span></span>';

			jQuery( noticeContent ).appendTo( topMenuElement );
			jQuery( noticeContent ).appendTo( subMenuElement );
		}
	});
});
