jQuery(document).ready(function($){
	if ( $( '#acf-group_57380c1a6623c' ) ) {
		$( '.acf-input textarea' ).each(function() {
			var regexpData = new RegExp( 'copy_paste$');
			if ( regexpData.test( $( this ).closest( '.acf-field' ).data('name') ) ) {
				$(this).attr('disabled', 'disabled').css({
					color: '#000',
					borderColor: '#3415B0',
					background: '#FFFF99',
				}).addClass('copypaste-field').closest( '.acf-field' ).addClass( 'copypaste-parent' );
			}
		});

		// Attrs and Content for shortcode
		$( '#acf-group_57380c1a6623c' ).on('change', 'input, select, textarea', function( event ) {
			event.preventDefault();
			if ( ! $(this).hasClass('copypaste-field') ) {
				var changingInput = $( this ).closest( '.acf-field' ).siblings( '.copypaste-parent' ).not( '.hidden-by-tab' ).find( '.copypaste-field' );
				var inputVal = changingInput.val();
				var attrName = $( this ).closest( '.acf-field' ).data('name');
				var newData = attrName + '="' + $( this ).val() + '"';
				var newInc = changingInput.val();
				var regexpNm;
				if ( $( this ).is( 'textarea' ) ) {
					regexpNm = new RegExp( '(^\\[.*\\])(.*)(\\[\/.*\\]$)');
					var matching = inputVal.match( regexpNm );
					var start = matching[1];
					var finish = matching[3];
					newInc = start + $( this ).val() + finish;
				} else {
					if ( $( this ).val() != '' ) {
						regexpNm = new RegExp( attrName + '=".*?"','g');
						newInc = inputVal.replace( regexpNm, newData );

						if ( newInc == changingInput.val() ) {
							regexpNm = new RegExp( ']');
							newInc = inputVal.replace( regexpNm, ' ' + newData + ']' );
						}
					} else {
						regexpNm = new RegExp( ' ' + attrName + '=".*?"','g');
						newInc = inputVal.replace( regexpNm, '' );
					}
				}
				changingInput.val( newInc );
			}
		});
	}
	
}); /* document ready end */