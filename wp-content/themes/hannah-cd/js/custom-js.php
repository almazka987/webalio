( function($) {
  'use strict';
	
  	<?php // STICKY MENY

	$sticky_menu = ACF_GF('sticky_menu', 'option'); // --> disable the sticky menu

	if( $sticky_menu ) { ?>

		/*****************************************************************/
		/* DISABLE STICKY MENU */
		/*****************************************************************/

		var navbar = $('.navbar');
		
		navbar.on('affix.bs.affix', function() {
			if (!navbar.hasClass('affix')) {
			
				navbar.removeClass('animated slideInDown');
				$('body').css( "padding-top", 0 );
				$( '.full-page .header-post-teaser-box-spacer' ).css( "padding-top", 0 ); 
				$( '.full-page .header' ).css( 'padding-top' , 0 );
					
			}
		});
	
	<?php } ?>

	<?php  // EXIT POPUP
	
	$exit_popup_delay = ACF_GF('add_exit_popup_delay', 'option');
	$exit_popup_delay_show = ACF_GF('add_exit_popup_delay_show', 'option');
	$exit_popup_cookie = ACF_GF('add_exit_popup_cookie', 'option');
	$exit_popup_mobile = ACF_GF('exit_popup_mobile', 'option');

	if( ACF_HR('add_exit_popup', 'option') ) { ?>
	
		/*****************************************************************/
		/* EXIT POPUP */
		/*****************************************************************/

		var exitDelay = <?php if( $exit_popup_delay ) { echo esc_html( $exit_popup_delay ); } else { echo '5'; } ?>;
		var exitDelayShow = <?php if( $exit_popup_delay_show ) { echo 'true'; } else { echo 'false'; } ?>;
		var exitCookie = <?php if( $exit_popup_cookie == '0' ) { echo '0'; } elseif( $exit_popup_cookie >= '0' ) { echo esc_html( $exit_popup_cookie ); } else { echo '30'; } ?>;

		<?php if( $exit_popup_mobile ) { ?>
			var exitDelayShowMobile = true;
		<?php } else { ?>
			var exitDelayShowMobile = false;
		<?php } ?>

		if ( isMobile.any() ) {

			// add specific class for mobile

			$('.exit-popup').addClass('exit-mobile');

			// exit popup options for mobile

			function detectMobileUserScroll() {

				if (typeof bioEp === 'undefined') {
					// nothing
				} else {
					bioEp.init({
						delay: 0,
						showOnDelay: exitDelayShowMobile,
						cookieExp: exitCookie,
					});

					// set the currently top position while scrolling on mobile devices

					var lastScrollTop = 0;
					var st = 0;
					$(window).scroll(function(event){
						var st = $(this).scrollTop();
						if ( st > lastScrollTop ){
							// --> scrolling down check
							// nothing
						} else if( st <= 0 ) {
							// --> scrolling is null
							$('.exit-popup').css('top', 40);
						} else {
							// --> scrolling up check
							$('.exit-popup').css('top', $(window).scrollTop() + 40);
						}
						lastScrollTop = st;
					});			

				}

			}

			// detect user scroll down by 50%, then up by 10% (dialog-trigger.min.js)

			var dtPercentDown = new DialogTrigger(
				function() {
					var dtPercentUp = new DialogTrigger(detectMobileUserScroll, { 
						trigger: 'scrollUp', percentUp: 10 
					});

				}, { 
					trigger: 'scrollDown', 
					percentDown: 40 
				}
			);

		} else {

			// exit popup options for desktop

			if (typeof bioEp === 'undefined') {
				// nothing
			} else {
				bioEp.init({
					delay: exitDelay,
					showOnDelay: exitDelayShow,
					cookieExp: exitCookie,
				});
			}

		}

		// stoping disable the exit popup if clicked inside of itself

		$(document).on("click touchstart", ".exit-popup", function(e) {
			e.stopPropagation();
		});

		// hide exit popup on clicking outside of itself

		$(document).on("click", function() {

			$("#bio_ep_bg, .exit-popup").hide();
			$("body").removeAttr("style"); // remove body overflow:hidden from bioep.min.js

		});
						
	<?php } ?>

	<?php // DROPCAPS FOR SINGLE POSTS

	$dropcap = ACF_GF('dropcap_show', 'option');

	if( ! $dropcap ) { ?>	
							
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
			
	<?php }
                            
    // DROPCAPS FOR POST LISTING

	$dropcap_post_list = ACF_GF('dropcap_post_list', 'option');

	if( ! $dropcap_post_list ) { ?>	
							
		/*****************************************************************/
		/* DROPCAP FOR POSTLISTING */
		/*****************************************************************/

        // --> add dropcap class to all post listings paragraph

        $( '.post-listing .post-content p, .grid-item .post-content p, .magazine-item .post-content p' ).each(function() {                           
            $(this).addClass( 'paragraph-with-dropcap' );		
        });
			
	<?php }
                            
    // ADD DROPCAP CLASS
                                      
    if( ! $dropcap_post_list || ! $dropcap ) { ?>

        // --> wrap first letter of paragraph in span

        $( 'p.paragraph-with-dropcap' ).each(function() {

            $(this).html(function (i, html) {
                return html.replace(/^[^a-zA-Z'"<]*([a-zA-Z])/g, '<span class="dropcap">$1</span>');
            });
                            
        });
                                      
    <?php } ?>

})(jQuery);