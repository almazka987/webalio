( function($) {
  'use strict';
	
  	
	
		
							
		/*****************************************************************/
		/* DROPCAP */
		/*****************************************************************/

        // --> add dropcap class to the first post paragraph

        $('.post-main-content .post-content p').each( function(i, el) {

            // find all paragraphs with text

            if ( $(this).text().trim().length ) {

                $(this).addClass( 'paragraph-with-dropcap' );

                // break after the first match

                return false;					

            }

        });
			
		
							
		/*****************************************************************/
		/* DROPCAP FOR POSTLISTING */
		/*****************************************************************/

        // --> add dropcap class to all post listings paragraph

        $( '.post-listing .post-content p, .grid-item .post-content p, .magazine-item .post-content p' ).each(function() {                           
            $(this).addClass( 'paragraph-with-dropcap' );		
        });
			
	
        // --> wrap first letter of paragraph in span

        $( 'p.paragraph-with-dropcap' ).each(function() {

            $(this).html(function (i, html) {
                return html.replace(/^[^a-zA-Z'"<]*([a-zA-Z])/g, '<span class="dropcap">$1</span>');
            });
                            
        });
                                      
    
})(jQuery);