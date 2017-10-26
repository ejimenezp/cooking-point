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
}
]
</script>

<script type="text/javascript">
function goFullscreen(id) {
  var element = document.getElementById(id);       
  if (element.mozRequestFullScreen) {
    element.mozRequestFullScreen();
  } else if (element.webkitRequestFullScreen) {
    element.webkitRequestFullScreen();
  }  
}

function toggleAudio() {
  var audioElm = document.getElementById('video-home');
  var muteIcon = document.getElementById('mute');
  if (!audioElm.muted)  { 
    audioElm.muted = true; 
    muteIcon.classList.remove('fa-volume-up')
    muteIcon.classList.add('fa-volume-off')
  } else { 
    audioElm.muted = false; 
    muteIcon.classList.remove('fa-volume-off')
    muteIcon.classList.add('fa-volume-up')
  }
}

function toggleVideo() {
  var audioElm = document.getElementById('video-home');
  var muteIcon = document.getElementById('pause');
  if (!audioElm.paused)  { 
    audioElm.pause(); 
    muteIcon.classList.remove('fa-pause')
    muteIcon.classList.add('fa-play')
  } else { 
    audioElm.play(); 
    muteIcon.classList.remove('fa-play')
    muteIcon.classList.add('fa-pause')
  }
}
</script>

@stop

@section('banner')

<div id="wide-video">
    {{-- <img class="cp-slideshow" src="/images/cliffs.jpg" >         --}}
  <div id="featured">
    <video id="video-home" autoplay="true" controls="controls" onclick="toggleVideo(); return false" >
      <source src="/images/Cooking_point.mp4" type="video/mp4" />
    </video>
</div>


<h1 class="home-headline">Spanish Cooking Classes in Madrid</h1>

<div class="video-control">
  <i id="pause" class="fa fa-pause" aria-hidden="true" onclick="toggleVideo(); return false"></i>
  <i id="mute" class="fa fa-volume-up" aria-hidden="true" onclick="toggleAudio(); return false"></i>
  <i class="fa fa-arrows-alt" aria-hidden="true" onclick="goFullscreen('featured'); return false"></i>
</div>

</div>

@stop

@section('content')

<div class="divider"></div>
<div class="header3">Our Classes<br><br></div>

<div class="row">
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

<div class="header3">Why to choose us</div>

<div class="row">
    <div class="col-sm-4">
        <h4 class="header4">Fun &amp; Memorable</h4>
        <p>Get off the beaten tours and attractions, and have a great time cooking and enjoying your Spanish meal in a nice setup. Know through practice more about Spain’s food, culture and traditions.</p>
    </div>

    <div class="col-sm-4">
        <h4 class="header4">Truly Hands-on</h4>
        <p>Two people per cooktop, maximum twelve per class. Follow our local chef instructions to get your meal done. No worries, no cooking experience is required. Also, take home your learnings with our recipe booklet.</p>
    </div>

    <div class="col-sm-4">
        <h4 class="header4">TripAdvisor's #1 Cooking School in Madrid</h4>
        <p>For 3 years we have been ranked in <a href="https://www.tripadvisor.com/Attraction_Review-g187514-d4888426-Reviews-Cooking_Point-Madrid.html">TripAdvisor</a> #1 Classes &amp; Workshops in Madrid, backed by +400 reviews from real clients.</p>
    </div>
    
</div>

<div class="divider"></div>

<div class="header3">Our Location<br><br></div>

<a href="https://www.google.com/maps/place/Cooking+Point/@40.412387,-3.697495,15z/data=!4m5!3m4!1s0x0:0xbfa70f0e9ca1618!8m2!3d40.4123866!4d-3.6974954?hl=en" target="_blank"><img class="img-responsive center-block" src="/images/plano-web.png" alt="Cooking Point School Location" /></a>

<div class="divider"></div>

<div class="row">
    <div class="col-sm-6">
        <p>Like in any other big city, you will find many things to do in Madrid: museums, monuments, markets, restaurants, bars, parks,... the number of Madrid attractions is countless. But, when it comes to what to do, you shouldn't miss the opportunity to take an active role in your Madrid experience and participate on attractions where five senses are involved.</p>
        <p>Because of its central location, Madrid receives influences from every corner of Spain, what has made of it the best city to learn Spanish cuisine. The Madridian open and conciliatory character will let you discover Spanish wine and food excellences no matter their region of origin.</p>   
    </div>
    <div class="col-sm-6">
        <p>In our cooking classes you will learn not just about the Spanish food but also how to make it, what offers the perfect 'take-home' experience that will stay with you forever. So, you will get a broad knowledge of paella and tapas and other typical Spanish food like cured ham, olive oil, saffron, paprika,... and how important they are in the Spanish culinary culture.</p>
        <p>If you are looking for different things to do in Madrid for your holiday, an alternative to sightseeing attractions, whether you are a travelling alone, as a couple or in a corporate event, then consider Cooking Point's cooking classes to get to the very heart of the local culture.</p>
    </div>
</div>

@stop