// Flexslider is handled separately in fusion-flexslider.js with other slider code.
jQuery( window ).load( function() {
	var lastTimelineDate,
	    collapseMonthVisible,
	    $infiniteScrollContainer;

	if ( jQuery().isotope ) {

		jQuery( '.fusion-blog-layout-grid' ).each( function() {
			var columns = 2,
			    gridWidth,
			    $gridContainer = jQuery( this ),
			    i;

			for ( i = 1; i < 7; i++ ) {
				if ( jQuery( this ).hasClass( 'fusion-blog-layout-grid-' + i ) ) {
					columns = i;
				}
			}

			gridWidth = Math.floor( 100 / columns * 100 ) / 100  + '%';
			$gridContainer.find( '.fusion-post-grid' ).css( 'width', gridWidth );
			$gridContainer.isotope({
				layoutMode: 'masonry',
				itemSelector: '.fusion-post-grid',
				transformsEnabled: false,
				isOriginLeft: jQuery( 'body.rtl' ).length ? false : true,
				resizable: true
			});

			if ( ( $gridContainer.hasClass( 'fusion-blog-layout-grid-4' ) || $gridContainer.hasClass( 'fusion-blog-layout-grid-5' ) || $gridContainer.hasClass( 'fusion-blog-layout-grid-6' ) ) && Modernizr.mq( 'only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: portrait)' ) ) {
				gridWidth = Math.floor( 100 / 3 * 100 ) / 100  + '%';
				$gridContainer.find( '.fusion-post-grid' ).css( 'width', gridWidth );
				$gridContainer.isotope({
					layoutMode: 'masonry',
					itemSelector: '.fusion-post-grid',
					transformsEnabled: false,
					isOriginLeft: jQuery( 'body.rtl' ).length ? false : true,
					resizable: true
				});
			}

			setTimeout(
				function() {
					jQuery( window ).trigger( 'resize' );
					$gridContainer.isotope();
				}, 250
			);
		});
	}

	// Timeline vars and click events for infinite scroll
	lastTimelineDate = jQuery( '.fusion-blog-layout-timeline' ).find( '.fusion-timeline-date' ).last().text();
	collapseMonthVisible = true;

	jQuery( '.fusion-blog-layout-timeline' ).find( '.fusion-timeline-date' ).click( function() {
		jQuery( this ).next( '.fusion-collapse-month' ).slideToggle();
	});

	jQuery( '.fusion-timeline-icon' ).find( '.fusion-icon-bubbles' ).click( function() {
		if ( collapseMonthVisible ) {
			jQuery( this ).parent().next( '.fusion-blog-layout-timeline' ).find( '.fusion-collapse-month' ).slideUp();
			collapseMonthVisible = false;
		} else {
			jQuery( this ).parent().next( '.fusion-blog-layout-timeline' ).find( '.fusion-collapse-month' ).slideDown();
			collapseMonthVisible = true;
		}
	});

	// Setup infinite scroll for each blog instance; main blog page and blog shortcodes
	jQuery( '.fusion-posts-container-infinite' ).each( function() {

		// Set the correct container for blog shortcode infinite scroll
		var $blogInfiniteContainer = jQuery( this ),
		    $originalPosts         = jQuery( this ).find( '.post' ),
		    $parentWrapperClasses,
		    $fusionPostsContainer,
		    $currentPage,
		    $loadMoreButton;

		if ( jQuery( this ).find( '.fusion-blog-layout-timeline' ).length ) {
			$blogInfiniteContainer = jQuery( this ).find( '.fusion-blog-layout-timeline' );
		}

		// If more than one blog shortcode is on the page, make sure the infinite scroll selectors are correct
		$parentWrapperClasses = '';
		if ( $blogInfiniteContainer.parents( '.fusion-blog-shortcode' ).length ) {
			$parentWrapperClasses = '.' + $blogInfiniteContainer.parents( '.fusion-blog-shortcode' ).attr( 'class' ).replace( /\ /g, '.' ) + ' ';
		}

		// Infite scroll for main blog page and blog shortcode
		jQuery( $blogInfiniteContainer ).infinitescroll({

			navSelector: $parentWrapperClasses + 'div.pagination',

			// Selector for the paged navigation (it will be hidden)
			nextSelector: $parentWrapperClasses + 'a.pagination-next',

			// Selector for the NEXT link (to page 2)
			itemSelector: $parentWrapperClasses + 'div.pagination .current, ' + $parentWrapperClasses + 'article.post:not( .fusion-archive-description ), ' + $parentWrapperClasses + '.fusion-collapse-month, ' + $parentWrapperClasses + '.fusion-timeline-date',

			// Selector for all items you'll retrieve
			loading: {
				finishedMsg: fusionBlogVars.infinite_finished_msg,
				msg: jQuery( '<div class="fusion-loading-container fusion-clearfix"><div class="fusion-loading-spinner"><div class="fusion-spinner-1"></div><div class="fusion-spinner-2"></div><div class="fusion-spinner-3"></div></div><div class="fusion-loading-msg">' + fusionBlogVars.infinite_blog_text + '</div>' )
			},

			maxPage: ( $blogInfiniteContainer.data( 'pages' ) ) ? $blogInfiniteContainer.data( 'pages' ) : undefined,

			errorCallback: function() {
				if ( jQuery( $blogInfiniteContainer ).hasClass( 'isotope' ) ) {
					jQuery( $blogInfiniteContainer ).isotope();
				}
			}
		}, function( posts ) {

			var columns,
			    gridWidth,
			    i;

			// Timeline layout specific actions
			if ( jQuery( $blogInfiniteContainer ).hasClass( 'fusion-blog-layout-timeline' ) ) {

				// Check if the last already displayed moth is the same as the first newly loaded; if so, delete one label
				if ( jQuery( posts ).first( '.fusion-timeline-date' ).text() == lastTimelineDate ) {
					jQuery( posts ).first( '.fusion-timeline-date' ).remove();
				}

				// Set the last timeline date to lat of the currently loaded
				lastTimelineDate = jQuery( $blogInfiniteContainer ).find( '.fusion-timeline-date' ).last().text();

				// Append newly loaded items of the same month to the container that is already there
				jQuery( $blogInfiniteContainer ).find( '.fusion-timeline-date' ).each( function() {
					jQuery( this ).next( '.fusion-collapse-month' ).append( jQuery( this ).nextUntil( '.fusion-timeline-date', '.fusion-post-timeline' ) );
				});

				// If all month containers are collapsed, also collapse the new ones
				if ( ! collapseMonthVisible ) {
					setTimeout( function() {
						jQuery( $blogInfiniteContainer ).find( '.fusion-collapse-month' ).hide();
					}, 200 );
				}

				// Delete empty collapse-month containers
				setTimeout( function() {
					jQuery( $blogInfiniteContainer ).find( '.fusion-collapse-month' ).each( function() {
						if ( ! jQuery( this ).children().length ) {
							jQuery( this ).remove();
						}
					});
				}, 10 );

				// Reset the click event for the collapse-month toggle
				jQuery( $blogInfiniteContainer ).find( '.fusion-timeline-date' ).unbind( 'click' );
				jQuery( $blogInfiniteContainer ).find( '.fusion-timeline-date' ).click( function() {
					jQuery( this ).next( '.fusion-collapse-month' ).slideToggle();
				});
			}

			// Grid layout specific actions
			if ( jQuery( $blogInfiniteContainer ).hasClass( 'fusion-blog-layout-grid' ) &&
				 jQuery().isotope
			) {
				jQuery( posts ).hide();

				// Get the amount of columns
				columns = 2;
				for ( i = 1; i < 7; i++ ) {
					if ( jQuery( $blogInfiniteContainer ).hasClass( 'fusion-blog-layout-grid-' + i ) ) {
						columns = i;
					}
				}

				// Calculate grid with
				gridWidth = Math.floor( 100 / columns * 100 ) / 100  + '%';
				jQuery( $blogInfiniteContainer ).find( '.post' ).css( 'width', gridWidth );

				// Add and fade in new posts when all images are loaded
				imagesLoaded( posts, function() {
					jQuery( posts ).fadeIn();

					// Relayout isotope
					if ( jQuery( $blogInfiniteContainer ).hasClass( 'isotope' ) ) {
						jQuery( $blogInfiniteContainer ).isotope( 'appended', jQuery( posts ) );
						jQuery( $blogInfiniteContainer ).isotope();
					}

					// Refresh the scrollspy script for one page layouts
					jQuery( '[data-spy="scroll"]' ).each( function() {
						var $spy = jQuery( this ).scrollspy( 'refresh' );
					});
				});
			}

			// Initialize flexslider for post slideshows
			jQuery( $blogInfiniteContainer ).find( '.flexslider' ).flexslider({
				slideshow: Boolean( Number( fusionBlogVars.slideshow_autoplay ) ),
				slideshowSpeed: fusionBlogVars.slideshow_speed,
				video: true,
				pauseOnHover: false,
				useCSS: false,
				prevText: '&#xf104;',
				nextText: '&#xf105;',
				start: function( slider ) {

					// Remove Loading
					slider.removeClass( 'fusion-flexslider-loading' );

					if ( 'undefined' !== typeof( slider.slides ) && 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
						if ( Number( fusionBlogVars.pagination_video_slide ) ) {
							jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '-20px' );
						} else {
							jQuery( slider ).find( '.flex-control-nav' ).hide();
						}
						if ( Number( fusionBlogVars.status_yt ) && true === window.yt_vid_exists ) {
							window.YTReady( function() {
								new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
									events: {
										'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
									}
								});
							});
						}
					} else {
						if ( Number( fusionBlogVars.pagination_video_slide ) ) {
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
						if ( Number( fusionBlogVars.status_vimeo ) ) {
							$f( slider.slides.eq( slider.currentSlide ).find( 'iframe' )[0] ).api( 'pause' );
						}

						if ( Number( fusionBlogVars.status_yt ) && true === window.yt_vid_exists ) {
							window.YTReady( function() {
								new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
									events: {
										'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
									}
								});
							});
						}

						/* ------------------  YOUTUBE FOR AUTOSLIDER ------------------ */
						/* WIP
						playVideoAndPauseOthers( slider );
						*/
					}
				},
				after: function( slider ) {
					if ( 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
						if ( Number( fusionBlogVars.pagination_video_slide ) ) {
							jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '-20px' );
						} else {
							jQuery( slider ).find( '.flex-control-nav' ).hide();
						}

						if ( Number( fusionBlogVars.status_yt ) && true === window.yt_vid_exists ) {
							window.YTReady( function() {
								new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
									events: {
										'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
									}
								});
							});
						}
					} else {
						if ( Number( fusionBlogVars.pagination_video_slide ) ) {
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

			// Trigger fitvids
			jQuery( posts ).each( function() {
				jQuery( this ).find( '.full-video, .video-shortcode, .wooslider .slide-content' ).fitVids();
			});

			// Hide the load more button, if the currently loaded page is already the last page
			$fusionPostsContainer = $blogInfiniteContainer;
			if ( jQuery( $blogInfiniteContainer ).hasClass( 'fusion-blog-layout-timeline' ) ) {
				$fusionPostsContainer = jQuery( $blogInfiniteContainer ).parents( '.fusion-posts-container-infinite' );
			}

			$currentPage = $fusionPostsContainer.find( '.current' ).html();
			$fusionPostsContainer.find( '.current' ).remove();

			if ( $fusionPostsContainer.data( 'pages' ) == $currentPage ) {
				$fusionPostsContainer.parent().find( '.fusion-loading-container' ).hide();
				$fusionPostsContainer.parent().find( '.fusion-load-more-button' ).hide();
			}

			// Activate lightbox for the newly added posts
			if ( 'individual' === fusionBlogVars.lightbox_behavior || ! $originalPosts.find( '.fusion-post-slideshow' ).length ) {
				window.avadaLightBox.activate_lightbox( jQuery( posts ) );

				$originalPosts = $blogInfiniteContainer.find( '.post' );
			}

			// Refresh the lightbox, needed in any case
			window.avadaLightBox.refresh_lightbox();
			jQuery( window ).trigger( 'resize' );

			// Trigger resize so that any parallax sections below get recalculated.
			setTimeout( function() {
				jQuery( window ).trigger( 'resize' );
			}, 500 );

			// Reinitialize waypoints
			jQuery( window ).init_waypoint();

		});

		// Setup infinite scroll manual loading
		if ( ( jQuery( $blogInfiniteContainer ).hasClass( 'fusion-blog-archive' ) && 'load_more_button' === fusionBlogVars.blog_pagination_type ) ||
			 jQuery( $blogInfiniteContainer ).hasClass( 'fusion-posts-container-load-more' ) ||
			 ( jQuery( $blogInfiniteContainer ).hasClass( 'fusion-blog-layout-timeline' ) && jQuery( $blogInfiniteContainer ).parent().hasClass( 'fusion-posts-container-load-more' ) )
		) {
			jQuery( $blogInfiniteContainer ).infinitescroll( 'unbind' );

			// Load more posts button click
			if ( jQuery( $blogInfiniteContainer ).hasClass( 'fusion-blog-archive' ) ) {
				$loadMoreButton = jQuery( $blogInfiniteContainer ).parent().find( '.fusion-load-more-button' );
			} else {
				$loadMoreButton = jQuery( $blogInfiniteContainer ).parents( '.fusion-blog-archive' ).find( '.fusion-load-more-button' );
			}

			$loadMoreButton.on( 'click', function( e ) {
				e.preventDefault();

				// Use the retrieve method to get the next set of posts
				jQuery( $blogInfiniteContainer ).infinitescroll( 'retrieve' );

				// Trigger isotope for correct positioning
				if ( jQuery( $blogInfiniteContainer ).hasClass( 'fusion-blog-layout-grid' ) ) {
					jQuery( $blogInfiniteContainer ).isotope();
				}
			});
		}

		// Hide the load more button, if there is only one page
		$fusionPostsContainer = $blogInfiniteContainer;
		if ( jQuery( $blogInfiniteContainer ).hasClass( 'fusion-blog-layout-timeline' ) && jQuery( $blogInfiniteContainer ).parents( '.fusion-blog-layout-timeline-wrapper' ).length ) {
			$fusionPostsContainer = jQuery( $blogInfiniteContainer ).parents( '.fusion-posts-container-infinite' );
		}

		if ( 1 == $fusionPostsContainer.data( 'pages' ) ) {
			$fusionPostsContainer.parent().find( '.fusion-loading-container' ).hide();
			$fusionPostsContainer.parent().find( '.fusion-load-more-button' ).hide();
		}
	});
});
