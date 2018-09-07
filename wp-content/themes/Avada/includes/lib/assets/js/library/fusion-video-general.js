function insertParam( url, parameterName, parameterValue, atStart ) {

	var replaceDuplicates = true,
	    cl,
	    urlhash,
	    sourceUrl,
	    urlParts,
	    newQueryString,
	    parameters,
	    i,
	    parameterParts;

	if ( 0 < url.indexOf( '#' ) ) {
		cl      = url.indexOf( '#' );
		urlhash = url.substring( url.indexOf( '#' ), url.length );
	} else {
		urlhash = '';
		cl      = url.length;
	}
	sourceUrl = url.substring( 0, cl );

	urlParts = sourceUrl.split( '?' );
	newQueryString = '';

	if ( 1 < urlParts.length ) {
		parameters = urlParts[1].split( '&' );
		for ( i = 0; ( i < parameters.length ); i++ ) {
			parameterParts = parameters[ i ].split( '=' );
			if ( ! ( replaceDuplicates && parameterParts[0] == parameterName ) ) {
				if ( '' === newQueryString ) {
					newQueryString = '?' + parameterParts[0] + '=' + ( parameterParts[1] ? parameterParts[1] : '' );
				} else {
					newQueryString += '&';
					newQueryString += parameterParts[0] + '=' + ( parameterParts[1] ? parameterParts[1] : '' );
				}
			}
		}
	}
	if ( '' === newQueryString ) {
		newQueryString = '?';
	}

	if ( atStart ) {
		newQueryString = '?' + parameterName + '=' + parameterValue + ( newQueryString.length > 1 ? '&' + newQueryString.substring( 1 ) : '' );
	} else {
		if ( '' !== newQueryString && '?' != newQueryString ) {
			newQueryString += '&';
		}
		newQueryString += parameterName + '=' + ( parameterValue ? parameterValue : '' );
	}
	return urlParts[0] + newQueryString + urlhash;
}

// Define YTReady function.
window.YTReady = ( function() {
	var onReadyFuncs = [],
	    apiIsReady   = false;

	/* @param func function	 Function to execute on ready
	 * @param func Boolean	  If true, all qeued functions are executed
	 * @param bBefore Boolean  If true, the func will added to the first
	 position in the queue*/
	return function( func, bBefore ) {
		if ( true === func ) {
			apiIsReady = true;
			while ( onReadyFuncs.length ) {

				// Removes the first func from the array, and execute func
				onReadyFuncs.shift()();
			}
		} else if ( 'function' === typeof func ) {
			if ( apiIsReady ) {
				func();
			} else {
				onReadyFuncs[ bBefore ? 'unshift' : 'push' ]( func );
			}
		}
	};
})();

function registerYoutubePlayers() {
	if ( Number( fusionVideoGeneralVars.status_yt ) && true === window.yt_vid_exists ) {
		window.$youtube_players = [];

		jQuery( '.tfs-slider' ).each( function() {
			var $slider = jQuery( this );

			$slider.find( '[data-youtube-video-id]' ).find( 'iframe' ).each( function() {
				var $iframe = jQuery( this );

				window.YTReady( function() {
					window.$youtube_players[$iframe.attr( 'id' )] = new YT.Player( $iframe.attr( 'id' ), {
						events: {
							'onReady': onPlayerReady( $iframe.parents( 'li' ) ),
							'onStateChange': onPlayerStateChange( $iframe.attr( 'id' ), $slider )
						}
					});
				});
			});
		});
	}
}

// Load the YouTube iFrame API
function loadYoutubeIframeAPI() {

	var tag,
	    firstScriptTag;

	if ( Number( fusionVideoGeneralVars.status_yt ) && true === window.yt_vid_exists ) {
		tag = document.createElement( 'script' );
		tag.src = 'https://www.youtube.com/iframe_api';
		firstScriptTag = document.getElementsByTagName( 'script' )[0];
		firstScriptTag.parentNode.insertBefore( tag, firstScriptTag );
	}
}

// This function will be called when the API is fully loaded
function onYouTubePlayerAPIReady() {
	window.YTReady( true );
}

function onPlayerStateChange( $frame, $slider ) {
	return function( $event ) {
		if ( $event.data == YT.PlayerState.PLAYING ) {
			jQuery( $slider ).flexslider( 'pause' );
		}

		if ( $event.data == YT.PlayerState.PAUSED ) {
			jQuery( $slider ).flexslider( 'play' );
		}

		if ( $event.data == YT.PlayerState.BUFFERING ) {
			jQuery( $slider ).flexslider( 'pause' );
		}

		if ( $event.data == YT.PlayerState.ENDED ) {
			if ( '1' == jQuery( $slider ).data( 'autoplay' ) ) {
				jQuery( $slider ).flexslider( 'play' );
			}
		}
	};
}

function onPlayerReady( $slide ) {
	return function( $event ) {
		if ( 'yes' === jQuery( $slide ).data( 'mute' ) ) {
			$event.target.mute();
		}
	};
}

function ytVidId( url ) {
	var p = /^(?:https?:)?(\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
	return ( url.match( p ) ) ? RegExp.$1 : false;
}

function playVideoAndPauseOthers( slider ) {

	// Play the youtube video inside the current slide
	var $currentSliderIframes = jQuery( slider ).find( '[data-youtube-video-id]' ).find( 'iframe' ),
	    $currentSlide         = jQuery( slider ).data( 'flexslider' ).slides.eq( jQuery( slider ).data( 'flexslider' ).currentSlide ),
	    $currentSlideIframe   = $currentSlide.find( '[data-youtube-video-id]' ).find( 'iframe' );

	// Stop all youtube videos
	$currentSliderIframes.each( function( i ) {

		// Don't stop current video, but all others
		if ( jQuery( this ).attr( 'id' ) != $currentSlideIframe.attr( 'id' ) ) {
			window.$youtube_players[jQuery( this ).attr( 'id' )].stopVideo(); // Stop instead of pause for preview images
		}
	});

	if ( $currentSlideIframe.length ) {
		if ( ! $currentSlideIframe.parents( 'li' ).hasClass( 'clone' ) && $currentSlideIframe.parents( 'li' ).hasClass( 'flex-active-slide' ) && 'yes' === $currentSlideIframe.parents( 'li' ).attr( 'data-autoplay' ) ) { // Play only if autoplay is setup

			window.$youtube_players[$currentSlideIframe.attr( 'id' )].playVideo();
		}

		if ( 'yes' === $currentSlide.attr( 'data-mute' ) ) {
			window.$youtube_players[$currentSlideIframe.attr( 'id' )].mute();
		}
	}

	jQuery( slider ).find( 'video' ).each( function( i ) {
		if ( 'function' === typeof jQuery( this )[0].pause ) {
			jQuery( this )[0].pause();
		}
		if ( ! jQuery( this ).parents( 'li' ).hasClass( 'clone' ) && jQuery( this ).parents( 'li' ).hasClass( 'flex-active-slide' ) && 'yes' === jQuery( this ).parents( 'li' ).attr( 'data-autoplay' ) ) {
			if ( 'function' === typeof jQuery( this )[0].play ) {
				jQuery( this )[0].play();
			}
		}
	});
}
jQuery( document ).ready( function() {

	var iframes;

	jQuery( '.fusion-fullwidth.video-background' ).each( function() {
		if ( jQuery( this ).find( '[data-youtube-video-id]' ) ) {
			window.yt_vid_exists = true;
		}
	});

	iframes = jQuery( 'iframe' );
	jQuery.each( iframes, function( i, v ) {
		var src = jQuery( this ).attr( 'src' ),
		    newSrc,
		    newSrc2,
		    newSrc3;

		if ( src ) {
			if ( Number( fusionVideoGeneralVars.status_vimeo ) && 1 <= src.indexOf( 'vimeo' ) ) {
				jQuery( this ).attr( 'id', 'player_' + ( i + 1 ) );
				newSrc  = insertParam( src, 'api', '1', false );
				newSrc2 = insertParam( newSrc, 'player_id', 'player_' + ( i + 1 ), false );
				newSrc3 = insertParam( newSrc2, 'wmode', 'opaque', false );

				jQuery( this ).attr( 'src', newSrc3 );
			}

			if ( Number( fusionVideoGeneralVars.status_yt ) && ytVidId( src ) ) {
				jQuery( this ).attr( 'id', 'player_' + ( i + 1 ) );

				newSrc = insertParam( src, 'enablejsapi', '1', false );
				newSrc2 = insertParam( newSrc, 'wmode', 'opaque', false );

				jQuery( this ).attr( 'src', newSrc2 );

				window.yt_vid_exists = true;
			}
		}
	});

	jQuery( '.full-video, .video-shortcode, .wooslider .slide-content, .fusion-portfolio-carousel .fusion-video' ).not( '#bbpress-forums .full-video, #bbpress-forums .video-shortcode, #bbpress-forums .wooslider .slide-content, #bbpress-forums .fusion-portfolio-carousel .fusion-video' ).fitVids();
	jQuery( '#bbpress-forums' ).fitVids();

	registerYoutubePlayers();

	loadYoutubeIframeAPI();
});
