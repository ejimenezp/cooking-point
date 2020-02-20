@extends('masterlayout')

@section('title', 'Spanish Cooking Classes in Madrid - Cooking Point')
@section('description', 'Hands-on paella and tapas cooking classes in English at top rated Madrid culinary school. Family friendly immersion in Spain’s food culture.')

@section('banner-name', 'home')
@section('banner-caption', 'cooking point home banner')



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
},
    @foreach ($events as $event)
        @if ($event->registered < $event->capacity) 
            {
            "@context" : "http://schema.org",
            "@type" : "Event",
            @if ($event->type == 'PAELLA')                
            "name" : "Paella Cooking Class",
            "url" : "http://cookingpoint.es/classes-paella-cooking-madrid-spain",
            "description" : "Hands-on cooking class with market tour to make paella, gazpacho and sangria",
            @else
            "name" : "Tapas Cooking Class",
            "url" : "https://cookingpoint.es/classes-spanish-tapas-madrid-spain",
            "description" : "Hands-on cooking class to make traditional Spanish tapas and sangria",
            @endif            
            "startDate" : "{{ $event->startdateatom }}",
            "endDate" : "{{ $event->enddateatom }}",
            "location" : {
                "@type" : "Place",
                "name" : "Cooking Point",
                "address" : "Calle de Moratin, 11, 28014 Madrid",
                "sameAs": "http://cookingpoint.es" },
            "offers": {
                    "@type": "Offer",
                    "name": "Adult",
                    "availability": "http://schema.org/InStock",
                    "price": "70.00",
                    "priceCurrency": "EUR",
                    @if ($event->type == 'PAELLA')                
                    "url": "http://cookingpoint.es/classes-paella-cooking-madrid-spain"
                    @else
                    "url" : "https://cookingpoint.es/classes-spanish-tapas-madrid-spain"
                    @endif
                  }
            },
        @endif
    @endforeach
    {}
]
</script>


@stop

@section('banner')

<div class="row justify-content-center">
    <h1 class="home-preheadline">Spanish Cooking Classes in Madrid </h1>
    <div class="home-headline"><a href="/best-cooking-classes-madrid">Best Classes in Madrid</a></div>
    <a href="/best-cooking-classes-madrid" class="home-more-info-button">More Info</a>
</div>
<div class="home-pause-button"><i class="fa fa-pause"></i></div>

<div class="row justify-content-center">
    <div id="section-banner"></div>        
</div>

@stop


@section('content')

<div class="col-md-12">
<div class="divider"></div>
<div class="header3">Our Classes<br/><br/></div>

<div class="row">
    <div class="col-lg-4 home-column">
        <a href="classes-paella-cooking-madrid-spain"><img class="img-fluid lazyload" alt="paella cooking class in Madrid" data-src="/images/home-paella.jpg" /></a>
        <h2 class="header2"><a href="classes-paella-cooking-madrid-spain">Paella Cooking Class</a></h2>
        <p>Enjoy an unforgettable morning visiting a food market and cooking a delicious paella with the instructions of our local chef. Great start to know more about Spanish food while you make one of our most representative dishes.</p>
        <div class="text-center">
            <a href="classes-paella-cooking-madrid-spain" class="btn btn-primary">Paella Class</a>
        </div>
    </div>

    <div class="d-block d-sm-none divider"></div>

    <div class="col-lg-4 home-column">
            <a href="classes-spanish-tapas-madrid-spain"><img class="img-fluid lazyload" title="spanish cooking school in madrid" alt="tapas cooking class in madrid" data-src="/images/home-tapas.jpg" /></a>
        <h2 class="header2"><a href="classes-spanish-tapas-madrid-spain">Tapas Cooking Class</a></h2>
        <p>Spend a fun evening making tapas and sangria. Ranging from Spanish potato omelet to shrimps with garlic, all of them typical from different regions of Spain. The perfect introduction to Spanish food and culture!</p>
        <div class="text-center">
            <a href="classes-spanish-tapas-madrid-spain" class="btn btn-primary">Tapas Class</a>
        </div>
    </div>

    <div class="col-lg-4 home-column">
           <a href="private-cooking-events-madrid-spain"><img class="img-fluid lazyload" title="cooking events" alt="private cooking events in Madrid" data-src="/images/events-banner-sm.jpg" /></a>
        <h2 class="header2"><a href="private-cooking-events-madrid-spain">Private Events</a></h2>
        <p>We can customize our classes as private events for corporate groups, team buildings, hen or stag parties, school trips or just group of friend that want to have a different lunch or dinner in Madrid.<p>
        <div class="text-center">
            <a href="private-cooking-events-madrid-spain" class="btn btn-primary">Private Events</a>
        </div>
    </div>
</div>

<div class="divider"></div>

<div class="header3">Watch Video<br/><br/></div>

<div class="row justify-content-center">
    <div class="col-sm-10 col-lg-8">
        <div class="embed-responsive embed-responsive-16by9"> 
            <iframe class="lazyload" data-src="https://www.youtube.com/embed/qsQVbrSjBow?rel=0" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</div>

<div class="divider"></div>

<div class="header3">Why to Choose Us<br/><br/></div>

<div class="row">
    <div class="col-lg-4">
        <a href="/best-cooking-classes-madrid"><img class="img-fluid lazyload" alt="best class in Madrid" data-src="/images/home-bestclassintown.jpg" /></a>
        <h4 class="header4">Top Rated School</h4>
        <p>Five years of excellent reviews in all major travel and business rating sites (TripAdvisor, Yelp, Google,...) back us as #1 in our category.</p>
    </div>

    <div class="col-lg-4">
        <a href="/best-cooking-classes-madrid"><img class="img-fluid lazyload" alt="best class in Madrid" data-src="/images/bestclasses-banner-sm.jpg" /></a>
        <h4 class="header4">Fun &amp; Memorable</h4>
        <p>Have a fun immersion in Spain’s food culture and know insights and tips to get the most of Spanish food during your trip and back home.</p>
    </div>

    <div class="col-lg-4">
        <a href="/best-cooking-classes-madrid"><img class="img-fluid lazyload" alt="best class in Madrid" data-src="/images/home-trullyhandson.jpg" /></a>
        <h4 class="header4">Truly Hands-on</h4>
        <p>Two people per cooktop, maximum twelve per class. Follow our chef instructions to get your meal done. No worries, no cooking experience is required.</p>
    </div>
</div>
<div class="row justify-content-center">
    <a href="/best-cooking-classes-madrid" class="btn btn-primary">10 Reasons to Choose Us</a>
</div>


<div class="divider"></div>

<div class="header3">Upcoming Classes<br><br></div>
    <div class="row justify-content-center">
        <div class="col col-sm-10 col-lg-8">
            <table class="table">
                    @php 
                        $i = 0;
                        foreach ($events as $event) {
                            if ($event->registered < $event->capacity && $i < 5) {
                                $date = new DateTime($event->startdateatom);
                                echo '<tr>';
                                echo '<td>' . $date->format("D, d M") . '</td>';
                                switch ($event->type) {
                                    case 'PAELLA' :
                                        echo '<td>10:00 AM</td><td> Paella Cooking Class</td>';
                                        echo '<td><a href="classes-paella-cooking-madrid-spain" class="btn btn-primary">Details</a></td>';
                                        break;
                                    case 'TAPAS' :
                                        echo '<td>5:30 PM</td><td>Tapas Cooking Class</td>';
                                        echo '<td><a href="classes-spanish-tapas-madrid-spain" class="btn btn-primary">Details</a></td>';
                                        break;
                                    default :
                                        continue;
                                }
                                echo '</tr>';
                                $i++;
                            }               
                        }
                    @endphp         
            </table>
        </div>
</div>

<div class="divider"></div>

<div class="header3">Our Location<br/><br/></div>

<div id="map" style="height: 50vh;width: 100%;"></div>

<div class="divider"></div>

<div class="row">
    <p>Like in any other big city, you will find many things to do in Madrid: museums, monuments, markets, restaurants, bars, parks,... the number of Madrid attractions is countless. But, when it comes to what to do, you shouldn't miss the opportunity to take an active role in your Madrid experience and participate on attractions where five senses are involved.</p>
    <p>Because of its central location, Madrid receives influences from every corner of Spain, what has made of it the best city to learn Spanish cuisine. The Madridian open and conciliatory character will let you discover Spanish wine and food excellences no matter their region of origin.</p>   
    <p>In our cooking classes you will learn not just about the Spanish food but also how to make it, what offers the perfect 'take-home' experience that will stay with you forever. So, you will get a broad knowledge of paella and tapas and other typical Spanish food like cured ham, olive oil, saffron, paprika,... and how important they are in the Spanish culinary culture.</p>
    <p>If you are looking for different things to do in Madrid for your holiday, an alternative to sightseeing attractions, whether you are a travelling alone, with your family or in a corporate event, then consider Cooking Point's cooking classes to get to the very heart of the local culture.</p>
</div>

</div>

@stop


@section('js')

<script async src="{{ mix('/js/home.js') }}"></script>

<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBlkvAcWJQOK3Vp1s2XQVJTKs4ZblKTbzI&callback=initMap&libraries=places" ></script>


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
