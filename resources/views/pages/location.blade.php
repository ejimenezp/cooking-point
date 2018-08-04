@extends('masterlayout')

@section('title', 'Address and Directions')
@section('description', 'Located in Barrio de Huertas, within walking distance of major hotel areas and museums. Metro Anton Martin, Line 1.')

@section('banner-name', 'location')
@section('banner-caption', 'cooking point front-door')

@section('content')

<h1 class="header1">Location</h1>

<div class="row justify-content-center">
	<div class="cp-class-details col-10 col-sm-8">
		<i class="fa fa-lg fa-map-marker"></i>&nbsp;&nbsp;Calle de Moratin, 11  28014 Madrid (Spain)<br/>
 		<i class="fa fa-lg fa-subway"></i> Metro Anton Martin (Line 1), exit Amor de Dios St.<br/>
 		<i class="fa fa-lg fa-clock-o"></i> Monday to Saturday, 9:30 am - 9:30 pm<br/>
 		<i class="fa fa-lg fa-envelope-o"></i> <a href="mailto:info@cookingpoint.es">info@cookingpoint.es</a><br/>
 		<i class="fa fa-lg fa-phone"></i> <a href="tel:(+34)910115154">(+34) 910 115 154</a><br/>		
	</div>

<div class="col-12">
      <p>Cooking Point is located in the Barrio de Huertas (or Barrio de las Letras, Letter's Quarter). An important place in history especially during the 16th-century Golden Age of Spanish Literature, Miguel de Cervantes and Lope de Vega both lived here. </p>

	<p>This quarter is in the heart of Madrid and our school is within walking distance of Madrid landmarks like Museo del Prado or Puerta del Sol. The closest metro station is Anton Martin (line 1, light blue), exit Amor de Dios St.</p>

      <div id="map" style="width: 100%; height: 80vh"></div>

      <p><br>Inside Cooking Point, we have designed our large kitchen to feel like home. The state-of-the-art appliances will ensure nothing can go wrong while all the tools are exactly as you would have in your own kitchen. There is no reason why you won’t be able to take this new-found skill home with you.</p>

      <p>A unique feature of our school is the size, we can host a group of up to 24 people. Large enough for a great atmosphere, small enough to get the right guidance and support from the chef. All cooking is done in pairs, each couple has their own stove to work on.</p>
</div>

<div class="cp-class-details col-10 col-sm-8">
      <strong>Location:</strong> Barrio de Huertas, In the heart of Madrid<br/>
      <strong>Capacity:</strong> 24 people<br/>
      <strong>Usage:</strong> Cooking classes, private events, TV set,...<br/><br/>
      <div class="text-center">
            <a href="http://tour.cookingpoint.es/CP_tour.html" class="btn btn-primary" target="_blank">Virtual Tour</a>
      </div>
</div> 
     
</div>

@stop

@section('js')

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBlkvAcWJQOK3Vp1s2XQVJTKs4ZblKTbzI&callback=initMap&libraries=places" async defer></script>

<script>
  function initMap() {
  var sansebastian = {lat:40.41353, lng:-3.7036784}
  var map = new google.maps.Map(document.getElementById('map'), {
          center: sansebastian,
          zoom: 15,
          styles: [
            {
            "elementType": "geometry",
            "stylers": [
            {
            "color": "#ebe3cd"
            }
            ]
            },
            {
            "elementType": "labels.text.fill",
            "stylers": [
            {
            "color": "#523735"
            }
            ]
            },
            {
            "elementType": "labels.text.stroke",
            "stylers": [
            {
            "color": "#f5f1e6"
            }
            ]
            },
            {
            "featureType": "administrative",
            "elementType": "geometry.stroke",
            "stylers": [
            {
            "color": "#c9b2a6"
            }
            ]
            },
            {
            "featureType": "administrative.land_parcel",
            "elementType": "geometry.stroke",
            "stylers": [
            {
            "color": "#dcd2be"
            }
            ]
            },
            {
            "featureType": "administrative.land_parcel",
            "elementType": "labels.text.fill",
            "stylers": [
            {
            "color": "#ae9e90"
            }
            ]
            },
            {
            "featureType": "landscape.natural",
            "elementType": "geometry",
            "stylers": [
            {
            "color": "#dfd2ae"
            }
            ]
            },
            {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [
            {
            "color": "#dfd2ae"
            }
            ]
            },
            {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [
            {
            "color": "#93817c"
            }
            ]
            },
            {
            "featureType": "poi.business",
            "stylers": [
            {
            "visibility": "off"
            }
            ]
            },
            {
            "featureType": "poi.park",
            "elementType": "geometry.fill",
            "stylers": [
            {
            "color": "#a5b076"
            }
            ]
            },
            {
            "featureType": "poi.park",
            "elementType": "labels.text",
            "stylers": [
            {
            "visibility": "off"
            }
            ]
            },
            {
            "featureType": "poi.park",
            "elementType": "labels.text.fill",
            "stylers": [
            {
            "color": "#447530"
            }
            ]
            },
            {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [
            {
            "color": "#f5f1e6"
            }
            ]
            },
            {
            "featureType": "road.arterial",
            "elementType": "geometry",
            "stylers": [
            {
            "color": "#fdfcf8"
            }
            ]
            },
            {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [
            {
            "color": "#f8c967"
            }
            ]
            },
            {
            "featureType": "road.highway",
            "elementType": "geometry.stroke",
            "stylers": [
            {
            "color": "#e9bc62"
            }
            ]
            },
            {
            "featureType": "road.highway.controlled_access",
            "elementType": "geometry",
            "stylers": [
            {
            "color": "#e98d58"
            }
            ]
            },
            {
            "featureType": "road.highway.controlled_access",
            "elementType": "geometry.stroke",
            "stylers": [
            {
            "color": "#db8555"
            }
            ]
            },
            {
            "featureType": "road.local",
            "elementType": "labels.text.fill",
            "stylers": [
            {
            "color": "#806b63"
            }
            ]
            },
            {
            "featureType": "transit.line",
            "elementType": "geometry",
            "stylers": [
            {
            "color": "#dfd2ae"
            }
            ]
            },
            {
            "featureType": "transit.line",
            "elementType": "labels.text.fill",
            "stylers": [
            {
            "color": "#8f7d77"
            }
            ]
            },
            {
            "featureType": "transit.line",
            "elementType": "labels.text.stroke",
            "stylers": [
            {
            "color": "#ebe3cd"
            }
            ]
            },
            {
            "featureType": "transit.station",
            "elementType": "geometry",
            "stylers": [
            {
            "color": "#dfd2ae"
            }
            ]
            },
            {
            "featureType": "water",
            "elementType": "geometry.fill",
            "stylers": [
            {
            "color": "#b9d3c2"
            }
            ]
            },
            {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [
            {
            "color": "#92998d"
            }
            ]
            }
          ]
        })
  var service = new google.maps.places.PlacesService(map)
  var contentString = '<div><strong>Cooking Point</strong><br>\
      Calle de Moratin, 11 <br>\
      28014 Madrid<br>\
      <a href="https://www.google.com/maps/place/Cooking+Point/@40.412387,-3.697495,15z/data=!4m5!3m4!1s0x0:0xbfa70f0e9ca1618!8m2!3d40.4123866!4d-3.6974954?hl=en" target="_blank">See on Google Maps</a></div>'
  var infowindow = new google.maps.InfoWindow({ content: contentString })
  service.getDetails({
  placeId: 'ChIJFZKt8CkmQg0RGBbK6fBw-gs'
  }, function(place, status) {
      if (status === google.maps.places.PlacesServiceStatus.OK) {
        var marker = new google.maps.Marker({
          map: map,
          position: place.geometry.location
        });
        marker.addListener('click', function() { infowindow.open(map, marker);})
      }
  })

}
</script>

@stop


