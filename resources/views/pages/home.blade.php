@extends('masterlayout')

@section('title', 'Madrid Cooking Classes - Cooking Point School')
@section('description', 'Madrid cooking classes every day. Hands-on classes of paella and tapas in English at top rated Spanish culinary school. Two people per cooktop. Instant confirmation.')

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
            "url" : "https://cookingpoint.es/classes-paella-cooking-madrid-spain",
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
                "sameAs": "https://cookingpoint.es" },
            "offers": {
                    "@type": "Offer",
                    "name": "Adult",
                    "availability": "http://schema.org/InStock",
                    "price": "70.00",
                    "priceCurrency": "EUR",
                    @if ($event->type == 'PAELLA')                
                    "url": "https://cookingpoint.es/classes-paella-cooking-madrid-spain"
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

@section('content')

<div class="row">
    <div class="cp-slideshow">
            <div style="display: inline-block;"><img src="/images/slider-home-05.jpg" ></div>
            <div><img src="/images/slider-home-031.jpg" ></div>
            <div><img src="/images/slider-home-021.jpg" ></div>
            <div><img src="/images/slider-home-042.jpg" ></div>
            <div><img src="/images/slider-home-01.jpg" ></div>
    </div>


    <div style="position:relative;">
        {{-- <img alt="paella cooking class in Madrid, Spain" src="/images/cooking-point-class.png" height="150" /> --}}
        <h1 class="home-headline">#1 Cooking Classes in Madrid</h1>
    </div>
  


</div>

{{-- <div class="row text-center">
          <a href="https://www.tripadvisor.com/Attraction_Review-g187514-d4888426-Reviews-Cooking_Point-Madrid.html"><img alt="tripadvisor certificate of excellence" src="/images/tripadvisorCE.png" /></a>
</div> --}}


<div class="row">
    <div class="col-sm-offset-1 col-sm-10">
        <p></p>
        <p class="header5 text-center">Cooking Point is a cooking school downtown Madrid designed for either individual travelers or groups that want to get immersed in the Spanish gastronomy culture</p>
    </div>
</div>

<div class="divider"></div>

<div class="row">
    <div class="col-sm-12 header3">Why to choose us</div>

    <div class="col-sm-4">
        <h4 class="header4">Fun &amp; Memorable</h4>
        <p>Get off the beaten tours and attractions, and have a great time cooking and enjoying your Spanish meal in a nice setup. Know through practice more about Spain’s food, culture and traditions.</p>
    </div>

    <div class="col-sm-4">
        <h4 class="header4">Truly Hands-on</h4>
        <p>Two people per cooktop, twelve per class. Follow our local chef instructions to get your meal done. No worries, no cooking experience is required. Also, take home your learnings with our recipe booklet.</p>
    </div>

    <div class="col-sm-4">
        <h4 class="header4">TripAdvisor's #1 Cooking School in Madrid</h4>
        <p>For third year in a row our school is <a href="https://www.tripadvisor.com/Attraction_Review-g187514-d4888426-Reviews-Cooking_Point-Madrid.html">1st on TripAdvisor</a> ranking of Classes &amp; Workshops in Madrid, backed by +300 reviews from real clients.</p>
    </div>
</div>

<div class="divider"></div>

<div class="row">
    <div class="col-sm-12 header3">Our Activities<br><br></div>
    <div class="col-sm-4 home-column">
        <a href="classes-paella-cooking-madrid-spain"><img class="img-responsive center-block" alt="paella cooking class in Madrid, Spain" src="/images/home-en-paella.jpg" /></a>
        <h2 class="header2"><a href="classes-paella-cooking-madrid-spain">Paella Cooking Class</a></h2>
        <p>Learn in our cooking classes how to cook the most famous Spanish dish: Paella (a rice based dish with seafood. meat and vegetables). Following the instructions of our chef, you will prepare your own full menu consisting of paella, gazpacho (cold tomato soup) and sangria.</p>
        <div class="text-center">
            <a href="classes-paella-cooking-madrid-spain" class="btn btn-primary">Paella Class</a>
        </div>
    </div>

    <div class="divider visible-xs"></div>

    <div class="col-sm-4 home-column">
            <a href="classes-spanish-tapas-madrid-spain"><img class="img-responsive center-block" title="spanish cooking school in madrid" alt="cooking school madrid spain" src="/images/home-en-tapas.jpg" /></a>
        <h2 class="header2"><a href="classes-spanish-tapas-madrid-spain">Tapas Cooking Class</a></h2>
        <p>The Spanish word "tapas" refers to nearly any food in bite-size pieces, served in small plates to share by a group of friends or family. In our Spanish tapas cooking class you will learn to prepare up to 6 traditional tapas, ranging from Spanish potato omelet to shrimps with garlic, all of them typical from different regions of Spain.</p>
        <div class="text-center">
            <a href="classes-spanish-tapas-madrid-spain" class="btn btn-primary">Tapas Class</a>
        </div>
    </div>

    <div class="col-sm-4 home-column">
           <a href="private-cooking-events-madrid-spain"><img class="img-responsive center-block" title="cooking events" alt="private cooking events in Madrid" src="/images/home-en-cata.jpg" /></a>
        <h2 class="header2"><a href="private-cooking-events-madrid-spain">Private Events</a></h2>
        <p>We can customize our classes as private events for corporate groups, team buildings, hen or stag parties, school trips or just group of friend that want to have a different lunch or dinner in Madrid.<p>
        <div class="text-center">
            <a href="private-cooking-events-madrid-spain" class="btn btn-primary">Private Events</a>
        </div>
    </div>

</div>

<div class="divider"></div>

<div class="row">
    <div class="col-sm-12 header3">Upcoming Classes<br><br></div>
    <div class="col-sm-offset-2 col-sm-6 col-xs-12">
        <table class="table">
                @php 
                    $i = 0;
                    foreach ($events as $event) {
                        if ($event->registered < $event->capacity && $i < 5) {
                            $date = new DateTime($event->startdateatom);
                            echo '<tr>';
                            switch ($event->type) {
                                case 'PAELLA' :
                                    echo '<td><div class="header4">' . $date->format("l, d M") . '</div>';
                                    echo '<small>Paella Cooking Class</small>';
                                    echo '</td><td><a href="classes-paella-cooking-madrid-spain" class="btn btn-primary">See Details</a></td>';
                                    break;
                                case 'TAPAS' :
                                    echo '<td><div class="header4">' . $date->format("l, d M") . '</div>';
                                    echo '<small>Tapas Cooking Class</small>';
                                    echo '</td><td><a href="classes-spanish-tapas-madrid-spain" class="btn btn-primary">See Details</a></td>';
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

<div class="row">
    <div class="col-sm-12 header3">Our Location<br><br></div>
    <div class="cp-slideshow">
        <a href="https://www.google.com/maps/place/Cooking+Point/@40.412387,-3.697495,15z/data=!4m5!3m4!1s0x0:0xbfa70f0e9ca1618!8m2!3d40.4123866!4d-3.6974954?hl=en" target="_blank"><img src="/images/plano-web.png" alt="Cooking Point School Location" /></a>
    </div>
</div>

<div class="divider"></div>

<div class="row">
    <div class="col-sm-6">
        <p><span class="dropcap home-headline">L</span>ike in any other big city, you will find many things to do in Madrid: museums, monuments, markets, restaurants, bars, parks,... the number of Madrid attractions is countless. But, when it comes to what to do, you shouldn't miss the opportunity to take an active role in your Madrid experience and participate on attractions where five senses are involved.</p>
        <p>Because of its central location, Madrid receives influences from every corner of Spain, what has made of it the best city to learn Spanish cuisine. The Madridian open and conciliatory character will let you discover Spanish wine and food excellences no matter their region of origin.</p>   
    </div>
    <div class="col-sm-6">
        <p>In our cooking classes you will learn not just about the Spanish food but also how to make it, what offers the perfect 'take-home' experience that will stay with you forever. So, you will get a broad knowledge of paella and tapas and other typical Spanish food like cured ham, olive oil, saffron, paprika,... and how important they are in the Spanish culinary culture.</p>
        <p>If you are looking for different things to do in Madrid for your holiday, an alternative to sightseeing attractions, whether you are a travelling alone, as a couple or in a corporate event, then consider Cooking Point's cooking classes to get to the very heart of the local culture.</p>
    </div>
</div>

@stop