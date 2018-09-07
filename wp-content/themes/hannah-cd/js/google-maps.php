( function($) {
  'use strict';

	<?php 
		$map_zoom = ACF_GF('map_zoom', 'option');
		$map_color = ACF_GF('map_color', 'option'); 
		$map_info = ACF_GF('map_info', 'option'); 
	?>
    
    /*
	*  new_map
	*
	*  This function will render a Google Map onto the selected jQuery element
	*
	*  @type	function
	*  @date	8/11/2013
	*  @since	4.3.0
	*
	*  @param	$el (jQuery element)
	*  @return	n/a
	*/

	function new_map( $el ) {

		// var
		var $markers = $el.find('.marker');

		// vars
		var args = {
			zoom		: <?php if($map_zoom){ ?><?php echo esc_html( $map_zoom ); ?><?php } else { ?>12<?php } ?>,
			center		: new google.maps.LatLng(0, 0),
			mapTypeId	: google.maps.MapTypeId.ROADMAP,
            scrollwheel : false,
            <?php if($map_color){ ?>
				styles: [
					{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#333333"}]},
					{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},
					{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},
					{"featureType":"poi","elementType":"labels.text","stylers":[{"visibility":"off"}]},
					{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":50}]},
					{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},
					{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},
					{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},
					{"featureType":"water","elementType":"all","stylers":[{"color":"#dbdbdb"},{"visibility":"on"}]}]
            <?php } ?>
		};

		// create map	        	
		var map = new google.maps.Map( $el[0], args);

		// add a markers reference
		map.markers = [];

		// add markers
		$markers.each(function() {
			add_marker( $(this), map );
		});

		// center map
		center_map( map );
		
		// return
		return map;

	}

	/*
	*  add_marker
	*
	*  This function will add a marker to the selected Google Map
	*
	*  @type	function
	*  @date	8/11/2013
	*  @since	4.3.0
	*
	*  @param	$marker (jQuery element)
	*  @param	map (Google Map object)
	*  @return	n/a
	*/

	function add_marker( $marker, map ) {

		// var
		var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

		// create marker
		var marker = new google.maps.Marker({
			position	: latlng,
			map			: map
		});

		// add to array
		map.markers.push( marker );

		// if marker contains HTML, add it to an infoWindow
		if( $marker.html() ) {
		
			// create info window
			var infowindow = new google.maps.InfoWindow({
				content	: $marker.html()
			});
		
			// show info window when marker is clicked
			<?php if( $map_info ) { ?>
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open( map, marker );
				});
			<?php } else { ?>
				infowindow.open( map, marker );
			<?php } ?>
			
		}

	}

	/*
	*  center_map
	*
	*  This function will center the map, showing all markers attached to this map
	*
	*  @type	function
	*  @date	8/11/2013
	*  @since	4.3.0
	*
	*  @param	map (Google Map object)
	*  @return	n/a
	*/

	function center_map( map ) {

		// vars
		var bounds = new google.maps.LatLngBounds();

		// loop through all markers and create bounds
		$.each( map.markers, function( i, marker ) {
			var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
			bounds.extend( latlng );
		});

		// only 1 marker?
		if( map.markers.length == 1 ) {
		
			// set center of map
			map.setCenter( bounds.getCenter() );
			map.setZoom( <?php if($map_zoom){ ?><?php echo esc_html( $map_zoom ); ?><?php } else { ?>12<?php } ?> );
			
		} else {
		
			// fit to bounds
			map.fitBounds( bounds );
			
		}

	}

	/*
	*  document ready
	*
	*  This function will render each map when the document is ready (page has loaded)
	*
	*  @type	function
	*  @date	8/11/2013
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	// global var
	var map = null;

	$(document).ready(function() {

		$('.google-map').each(function() {

			// create map
			map = new_map( $(this) );

		});

	});

})(jQuery);