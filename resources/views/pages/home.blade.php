@extends('masterlayout')

@section('title', 'Spanish Cooking Classes in Madrid - Cooking Point')
@section('description', 'Spanish cooking classes every day. Hands-on classes of paella and tapas in English at top rated Spanish culinary school. Two people per cooktop. Instant confirmation.')

@section('google-structured-data')

<script type="application/ld+json">
[
{
  "@context": "http://schema.org",
  "@type": "WebSite",
  "name": "Cooking Point",
  "alternateName": "Spanish Cooking Classes in Madrid",
  "url": "https://cookingpoint.es"
},
{
  "@context": "http://schema.org",
  "@type": "Organization",
  "name": "Cooking Point",
  "url": "https://cookingpoint.es",
  "logo": "https://cookingpoint.es/images/cookingpoint_logox75.png",
  "address" : "Calle de Moratin, 11, 28014 Madrid",
  "sameAs": [
    "https://www.facebook.com/CookingPointSpain",
    "http://instagram.com/cookingpoint",
    "https://google.com/+CookingPointMadrid"
  ]
}
]
</script>


@stop

@section('banner')

<div class="wide">
  <h1 class="home-preheadline">Spanish Cooking Classes in Madrid</h1>
  <div class="home-headline">Make Cooking Your Highlight of Madrid</div>
  <div class="home-youtube-button"><i class="fa fa-lg fa-youtube-play"></i> Full-size Video</div>
  <div id="banner"></div>
</div>

@stop

@section('modals')

<!-- MODAL -->
<div class="modal fade" id="modal-video" tabindex="-1" role="dialog" aria-labelledby="modal-video-label">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="yt-video"></div>
            </div>
        </div>
    </div>
</div>

@stop

@section('content')

<div class="row">
    <div class="home-notice col-xs-offset-1 col-xs-10 col-md-offset-2 col-md-8">
        <strong>Welcome Gift</strong><br/>
        Book any class by Jan.&nbsp31,&nbsp2018 and get free a<br/>
        Premium Spanish Product<br/>
{{--         Book any class before Jan.&nbsp31,&nbsp2018 and get a<br/>
        Free Bottle of Premium Spanish Olive Oil<br/>
 --}}    </div>  
</div>

<div class="col-md-12">
<div class="divider"></div>
<div class="header3">Our Classes<br><br></div>

<div class="row">
    <div class="col-md-4 home-column">
        <a href="classes-paella-cooking-madrid-spain"><img class="img-responsive center-block" alt="paella cooking class in Madrid" src="/images/home-paella.jpg" /></a>
        <h2 class="header2"><a href="classes-paella-cooking-madrid-spain">Paella Cooking Class</a></h2>
        <p>Learn in our cooking classes how to cook the most famous Spanish dish: Paella (a rice based dish with seafood. meat and vegetables). Following the instructions of our chef, you will prepare your own full menu consisting of paella, gazpacho (cold tomato soup) and sangria.</p>
        <div class="text-center">
            <a href="classes-paella-cooking-madrid-spain" class="btn btn-primary">Paella Class</a>
        </div>
    </div>

    <div class="divider visible-xs"></div>

    <div class="col-md-4 home-column">
            <a href="classes-spanish-tapas-madrid-spain"><img class="img-responsive center-block" title="spanish cooking school in madrid" alt="tapas cooking class in madrid" src="/images/home-tapas.jpg" /></a>
        <h2 class="header2"><a href="classes-spanish-tapas-madrid-spain">Tapas Cooking Class</a></h2>
        <p>The Spanish word "tapas" refers to nearly any food in bite-size pieces, served in small plates to share by a group of friends or family. In our Spanish tapas cooking class you will learn to prepare up to 6 traditional tapas, ranging from Spanish potato omelet to shrimps with garlic, all of them typical from different regions of Spain.</p>
        <div class="text-center">
            <a href="classes-spanish-tapas-madrid-spain" class="btn btn-primary">Tapas Class</a>
        </div>
    </div>

    <div class="col-md-4 home-column">
           <a href="private-cooking-events-madrid-spain"><img class="img-responsive center-block" title="cooking events" alt="private cooking events in Madrid" src="/images/events-banner-sm.jpg" /></a>
        <h2 class="header2"><a href="private-cooking-events-madrid-spain">Private Events</a></h2>
        <p>We can customize our classes as private events for corporate groups, team buildings, hen or stag parties, school trips or just group of friend that want to have a different lunch or dinner in Madrid.<p>
        <div class="text-center">
            <a href="private-cooking-events-madrid-spain" class="btn btn-primary">Private Events</a>
        </div>
    </div>
</div>

<div class="divider"></div>

<div class="header3">Why to choose us</div>

<div class="row">
    <div class="col-md-4">
        <h4 class="header4">Fun &amp; Memorable</h4>
        <p>Get off the beaten tours and attractions, and have a great time cooking and enjoying your Spanish meal in a nice setup. Know through practice more about Spain’s food, culture and traditions.</p>
    </div>

    <div class="col-md-4">
        <h4 class="header4">Truly Hands-on</h4>
        <p>Two people per cooktop, maximum twelve per class. Follow our local chef instructions to get your meal done. No worries, no cooking experience is required. Also, take home your learnings with our recipe booklet.</p>
    </div>

    <div class="col-md-4">
        <h4 class="header4">TripAdvisor's #1 Cooking School in Madrid</h4>
        <p>For 3 years we have been ranked in <a href="https://www.tripadvisor.com/Attraction_Review-g187514-d4888426-Reviews-Cooking_Point-Madrid.html">TripAdvisor</a> #1 Classes &amp; Workshops in Madrid, backed by +400 reviews from real clients.</p>
    </div>
    
</div>

<div class="divider"></div>

<div class="header3">Our Location<br><br></div>

<div id="map"></div>

<div class="divider"></div>

<div class="row">
    <div class="col-md-6">
        <p>Like in any other big city, you will find many things to do in Madrid: museums, monuments, markets, restaurants, bars, parks,... the number of Madrid attractions is countless. But, when it comes to what to do, you shouldn't miss the opportunity to take an active role in your Madrid experience and participate on attractions where five senses are involved.</p>
        <p>Because of its central location, Madrid receives influences from every corner of Spain, what has made of it the best city to learn Spanish cuisine. The Madridian open and conciliatory character will let you discover Spanish wine and food excellences no matter their region of origin.</p>   
    </div>
    <div class="col-md-6">
        <p>In our cooking classes you will learn not just about the Spanish food but also how to make it, what offers the perfect 'take-home' experience that will stay with you forever. So, you will get a broad knowledge of paella and tapas and other typical Spanish food like cured ham, olive oil, saffron, paprika,... and how important they are in the Spanish culinary culture.</p>
        <p>If you are looking for different things to do in Madrid for your holiday, an alternative to sightseeing attractions, whether you are a travelling alone, as a couple or in a corporate event, then consider Cooking Point's cooking classes to get to the very heart of the local culture.</p>
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
