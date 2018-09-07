jQuery( window ).load( function() {

	var pageSmoothHeight,
	    flexSmoothHeight;

	if ( jQuery().flexslider ) {

		if ( Number( fusionFlexSliderVars.status_vimeo ) ) {

			jQuery( '.flexslider' ).find( 'iframe' ).each( function() {
				var id =  jQuery( this ).attr( 'id' ),
					src = jQuery( this ).attr( 'src' );

				if ( id && -1 !== src.indexOf( 'vimeo' ) ) {
					$f( id ).addEvent( 'ready', function( playerID ) {
						var froogaloop = $f( playerID ),
						    slide      = jQuery( '#' + playerID ).parents( 'li' );

						froogaloop.addEvent( 'play', function( data ) {
							jQuery( '#' + playerID ).parents( 'li' ).parent().parent().flexslider( 'pause' );
						});

						froogaloop.addEvent( 'pause', function( data ) {
							if ( 'yes' === jQuery( slide ).attr( 'data-loop' ) ) {
								jQuery( '#' + playerID ).parents( 'li' ).parent().parent().flexslider( 'pause' );
							} else {
								jQuery( '#' + playerID ).parents( 'li' ).parent().parent().flexslider( 'play' );
							}
						});
					});
				}
			});
		}

		if ( 'false' === fusionFlexSliderVars.page_smoothHeight ) {
			pageSmoothHeight = false;
		} else {
			pageSmoothHeight = true;
		}

		jQuery( '.fusion-blog-layout-grid .flexslider' ).flexslider({
			slideshow: Boolean( Number( fusionFlexSliderVars.slideshow_autoplay ) ),
			slideshowSpeed: Number( fusionFlexSliderVars.slideshow_speed ),
			video: true,
			smoothHeight: pageSmoothHeight,
			pauseOnHover: false,
			useCSS: false,
			prevText: '&#xf104;',
			nextText: '&#xf105;',
			start: function( slider ) {
				jQuery( slider ).removeClass( 'fusion-flexslider-loading' );

				if ( 'undefined' !== typeof( slider.slides ) && 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
					if ( Number( fusionFlexSliderVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '-20px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).hide();
					}
					if ( Number( fusionFlexSliderVars.status_yt ) && true === window.yt_vid_exists ) {
						window.YTReady( function() {
							new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
								events: {
									'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
								}
							});
						});
					}
				} else {
					if ( Number( fusionFlexSliderVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '0px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).show();
					}
				}

				// Reinitialize waypoints
				jQuery.waypoints( 'viewportHeight' );
				jQuery.waypoints( 'refresh' );
			},
			before: function( slider ) {
				if ( 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
					if ( Number( fusionFlexSliderVars.status_vimeo ) ) {
						$f( slider.slides.eq( slider.currentSlide ).find( 'iframe' )[0] ).api( 'pause' );
					}

					if ( Number( fusionFlexSliderVars.status_yt ) && true === window.yt_vid_exists ) {
						window.YTReady( function() {
							new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
								events: {
									'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
								}
							});
						});
					}

					/* ------------------  YOUTUBE FOR AUTOSLIDER ------------------ */
					playVideoAndPauseOthers( slider );
				}
			},
			after: function( slider ) {
				if ( 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
					if ( Number( fusionFlexSliderVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '-20px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).hide();
					}

					if ( Number( fusionFlexSliderVars.status_yt ) && true === window.yt_vid_exists ) {
						window.YTReady( function() {
							new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
								events: {
									'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
								}
							});
						});
					}
				} else {
					if ( Number( fusionFlexSliderVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '0px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).show();
					}
				}
				jQuery( '[data-spy="scroll"]' ).each( function() {
				  var $spy = jQuery( this ).scrollspy( 'refresh' );
				});
			}
		});

		if ( 'false' === fusionFlexSliderVars.flex_smoothHeight ) {
			flexSmoothHeight = false;
		} else {
			flexSmoothHeight = true;
		}

		jQuery( '.fusion-flexslider' ).not( '.woocommerce .images #slider' ).flexslider({
			slideshow: Boolean( Number( fusionFlexSliderVars.slideshow_autoplay ) ),
			slideshowSpeed: fusionFlexSliderVars.slideshow_speed,
			video: true,
			smoothHeight: flexSmoothHeight,
			pauseOnHover: false,
			useCSS: false,
			prevText: '&#xf104;',
			nextText: '&#xf105;',
			start: function( slider ) {

				// Remove Loading
				slider.removeClass( 'fusion-flexslider-loading' );

				// For dynamic content, like equalHeights
				jQuery( window ).trigger( 'resize' );

				if ( 'undefined' !== typeof( slider.slides ) && 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
					if ( Number( fusionFlexSliderVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '-20px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).hide();
					}
					if ( Number( fusionFlexSliderVars.status_yt ) && true === window.yt_vid_exists ) {
						window.YTReady( function() {
							new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
								events: {
									'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
								}
							});
						});
					}
				} else {
					if ( Number( fusionFlexSliderVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '0px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).show();
					}
				}

				// Reinitialize waypoint
				jQuery.waypoints( 'viewportHeight' );
				jQuery.waypoints( 'refresh' );
			},
			before: function( slider ) {
				if ( 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
					if ( Number( fusionFlexSliderVars.status_vimeo ) ) {
						$f( slider.slides.eq( slider.currentSlide ).find( 'iframe' )[0] ).api( 'pause' );
					}

					if ( Number( fusionFlexSliderVars.status_yt ) && true === window.yt_vid_exists ) {
						window.YTReady( function() {
							new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
								events: {
									'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
								}
							});
						});
					}

					/* ------------------  YOUTUBE FOR AUTOSLIDER ------------------ */
					playVideoAndPauseOthers( slider );
				}
			},
			after: function( slider ) {
				if ( 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
					if ( Number( fusionFlexSliderVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '-20px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).hide();
					}

					if ( Number( fusionFlexSliderVars.status_yt ) && true === window.yt_vid_exists ) {
						window.YTReady( function() {
							new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
								events: {
									'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
								}
							});
						});
					}
				} else {
					if ( Number( fusionFlexSliderVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '0px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).show();
					}
				}
				jQuery( '[data-spy="scroll"]' ).each( function() {
				  var $spy = jQuery( this ).scrollspy( 'refresh' );
				});
			}
		});

		jQuery( '.flexslider:not(.tfs-slider)' ).flexslider({
			slideshow: Boolean( Number( fusionFlexSliderVars.slideshow_autoplay ) ),
			slideshowSpeed: fusionFlexSliderVars.slideshow_speed,
			video: true,
			smoothHeight: flexSmoothHeight,
			pauseOnHover: false,
			useCSS: false,
			prevText: '&#xf104;',
			nextText: '&#xf105;',
			start: function( slider ) {

				// Remove Loading
				slider.removeClass( 'fusion-flexslider-loading' );

				if ( 'undefined' !== typeof( slider.slides ) && 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
					if ( Number( fusionFlexSliderVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '-20px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).hide();
					}
					if ( Number( fusionFlexSliderVars.status_yt ) && true === window.yt_vid_exists ) {
						window.YTReady( function() {
							new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
								events: {
									'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
								}
							});
						});
					}
				} else {
					if ( Number( fusionFlexSliderVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '0px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).show();
					}
				}

				// Reinitialize waypoint
				jQuery.waypoints( 'viewportHeight' );
				jQuery.waypoints( 'refresh' );
			},
			before: function( slider ) {
				if ( 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
					if ( Number( fusionFlexSliderVars.status_vimeo ) ) {
						$f( slider.slides.eq( slider.currentSlide ).find( 'iframe' )[0] ).api( 'pause' );
					}
					if ( Number( fusionFlexSliderVars.status_yt ) && true === window.yt_vid_exists ) {
						window.YTReady( function() {
							new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
								events: {
									'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
								}
							});
						});
					}

					/* ------------------  YOUTUBE FOR AUTOSLIDER ------------------ */
					playVideoAndPauseOthers( slider );
				}
			},
			after: function( slider ) {
				if ( 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
					if ( Number( fusionFlexSliderVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '-20px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).hide();
					}
					if ( Number( fusionFlexSliderVars.status_yt ) && true === window.yt_vid_exists ) {
						window.YTReady( function() {
							new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
								events: {
									'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
								}
							});
						});
					}
				} else {
					if ( Number( fusionFlexSliderVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '0px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).show();
					}
				}
				jQuery( '[data-spy="scroll"]' ).each( function() {
				  var $spy = jQuery( this ).scrollspy( 'refresh' );
				});
			}
		});

		if ( 1 <= jQuery( '.flexslider-attachments' ).length ) {
			if ( 'undefined' !== typeof jQuery( '.flexslider-attachments' ).data( 'flexslider' ) ) {
				jQuery( '.flexslider-attachments' ).flexslider( 'destroy' );
			}

			jQuery( '.flexslider-attachments' ).flexslider({
				slideshow: Boolean( Number( fusionFlexSliderVars.slideshow_autoplay ) ),
				slideshowSpeed: fusionFlexSliderVars.slideshow_speed,
				video: false,
				smoothHeight: false,
				pauseOnHover: false,
				useCSS: false,
				prevText: '&#xf104;',
				nextText: '&#xf105;',
				controlNav: 'thumbnails',
				start: function( slider ) {
					jQuery( slider ).find( '.fusion-slider-loading' ).remove();

					// Remove Loading
					slider.removeClass( 'fusion-flexslider-loading' );
				}
			});
		}
	}
});
