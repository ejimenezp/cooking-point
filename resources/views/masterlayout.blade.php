<!DOCTYPE html>
<html lang="en">
  <head>
      <title>@yield('title')</title>
      <meta name="description" content="@yield('description')" >
      <meta name="page" content="@yield('banner-name')" caption="@yield('banner-caption', 'cooking point')">
      
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="icon" href="{{ config('cookingpoint.favicon') }}">
      <link rel="canonical" href="{{ strtok(url()->current(), '?') }}">
      <style type="text/css">
          #map {
                height: 50vh;
                width: 100%;
              }
      </style>  
      <link href="{{ mix('/css/app.css') }}" rel="stylesheet" type="text/css">     
      <script  type='text/javascript' src='{{ mix('/js/app.js') }}'></script>
      <script  type='text/javascript' src="https://use.fontawesome.com/c502308363.js"></script>

      @if (App::environment() == 'production')
        <!-- Google Analytics -->
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-43676257-1', 'auto');
          @yield('analytics-ecommerce-tracking')
          ga('send', 'pageview');
        </script>
        <!-- End Google Analytics -->

        <!-- Global site tag (gtag.js) - Google AdWords: 985592263 -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-985592263"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', 'AW-985592263');
        </script>
        <!-- End Global site tag -->

        @yield('adwords-event-snippet')

      @else
        <!-- no analytics or crawling here. Testing environment -->
        <meta name="robots" content="noindex,nofollow">
      @endif

      @yield('google-structured-data')
      
  </head>
    
  <body>

  <div class="loading loading-backdrop" style="display:none">
    <div class="progress-box">
      <div class="progress"><div>Loading…</div></div>       
    </div>
  </div>

@section('footer')

    <div class="primary-color">
      <div class="pull-left" style="padding-top:1.6em;">© Cooking Point, SL</div>
      <div class="pull-right">Follow us on:
        <a href="https://www.facebook.com/CookingPointSpain" title="facebook" target="_blank"><i class="fa fa-3x fa-facebook-official"></i></a>
        &nbsp;
        <a href="https://google.com/+CookingPointMadrid" title="google plus" target="_blank"><i class="fa fa-3x fa-google-plus-square"></i></a>
        &nbsp;
        <a href="https://www.instagram.com/cookingpoint/" title="instagram" target="_blank"><i class="fa fa-3x fa-instagram"></i></a>        
      </div>      
    </div>
@endsection


<div class="d-block d-lg-none">
<div id="cabecera">
  <nav class="navbar fixed-top">
      <div class="navbar-brand">
        <a href="/"><img class="home-logo" alt="Cooking Point" src="/images/cookingpoint_MIC.svg" onerror="this.onerror=null; this.src='/images/cookingpoint_logox50.png'"></a>
      </div>
      <a class="menu-header-xs" data-toggle="collapse" data-target="#myNavbar" href="#">
          Menu <i class="fa fa-bars" aria-hidden="true"></i>
      </a>
      <div id="myNavbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li>
            <a href="/classes-paella-cooking-madrid-spain">Paella Class</a>
          </li>
          <li>
            <a href="/classes-spanish-tapas-madrid-spain">Tapas Class</a>
          </li>
          <li>
            <a href="/private-cooking-events-madrid-spain">Private Events</a>
          </li>
          <li>
            <a href="/location">Location</a>
          </li>
          <li>
            <a href="/about-us">About Us</a>
          </li>
          <li>
            <a class="cp-class-details cp-class-details" href="/booking">Booking</a>
          </li>
          <li>
            <a href="/gallery">Gallery</a>
          </li>
          <li>
            <a href="/blog">Blog</a>
          </li>
          <li>
            <a href="/faq">FAQ</a>
          </li>
        </ul> 
      </div>
  </nav>
</div>
</div>


<div class="d-none d-lg-block d-xl-none">
  <nav class="navbar navbar-expand-md nav-fill"> 
      <div class="navbar-brand">
        <a href="/"><img class="home-logo" alt="Cooking Point" src="/images/cookingpoint_MIC.svg" onerror="this.onerror=null; this.src='/images/cookingpoint_logox75.png'"></a>
      </div> 

      <ul class="navbar-nav justify-content-center w-100">
        <li class="nav-item">
          <a class="nav-link" href="/classes-paella-cooking-madrid-spain">Paella Class</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/classes-spanish-tapas-madrid-spain">Tapas Class</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/private-cooking-events-madrid-spain">Private Events</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/location">Location</a>
        </li>            
        <li class="nav-item">
          <a class="nav-link" href="/about-us">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link cp-class-details" href="/booking">Booking</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" id="themes" href="#">More <span class="caret"></span></a>
            <div class="dropdown-menu" aria-labelledby="themes">
              <a class="dropdown-item" href="/gallery">Gallery</a>
              <a class="dropdown-item" href="/blog">Blog</a>
              <a class="dropdown-item" href="/faq">FAQ</a>
            </div>
        </li>
      </ul>      
  </nav>
</div>

<div class="d-none d-xl-block">
  <nav class="navbar navbar-expand-xl">
      <a class="navbar-brand"href="/"><img class="home-logo" alt="Cooking Point" src="/images/cookingpoint_MIC.svg" onerror="this.onerror=null; this.src='/images/cookingpoint_logox75.png'"></a>
      <ul class="navbar-nav nav-fill justify-content-center w-100">
        <li class="nav-item">
          <a class="nav-link" href="/classes-paella-cooking-madrid-spain">Paella Class</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/classes-spanish-tapas-madrid-spain">Tapas Class</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/private-cooking-events-madrid-spain">Private Events</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/location">Location</a>
        </li>            
        <li class="nav-item">
          <a class="nav-link" href="/about-us">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link cp-class-details" href="/booking">Booking</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/gallery">Gallery</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/blog">Blog</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/faq">FAQ</a>
       </li>
      </ul>            
  </nav>
</div>

@if (isset($page) && ($page == 'home' || $page == 'booking' ))
<div class="container-fluid">
  @if ($page == 'home')
    @yield('banner')
  @else
    <div class="header-offset"></div>
  @endif
  <div class="row justify-content-center">
    <div class="col col-xl-10">
      @yield('content')                  
    </div>  
  </div>
  <div class="row">
    <div class="divider"></div>
    <div class="col">
      @yield('footer')
    </div> 
  </div>
</div>

@else

<div class="container-fluid">
  <div class="header-offset"></div>
  <div class="row">
    <div id="section-banner"></div>
  </div>
  <div class="row justify-content-center">
    <div class="col-lg-9 col-xl-8">
        @yield('content')           
    </div>      
    <div class="col-lg-3 col-xl-2">
        @yield('sidebar')
    </div>    
  </div>
  <div class="row">
    <div class="divider"></div>
    <div class="col-12">
      @yield('footer')
    </div> 
  </div>
</div>


@endif

<!-- modals specific for this page  -->
@yield('modals')

<!-- javascripts specific for this page  -->
@yield('js')

</body>

</html>
