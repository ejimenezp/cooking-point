<!DOCTYPE html>
<html lang="en">
  <head>
      <title>@yield('title')</title>
      <meta name="description" content="@yield('description')" >
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="page" content="@yield('banner-name')" caption="@yield('banner-caption', 'cooking point')">
      
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="icon" href="{{ config('cookingpoint.favicon') }}">
      <link rel="canonical" href="{{ strtok(url()->current(), '?') }}">

      <link href="{{ mix('/css/app.css') }}" rel="stylesheet" type="text/css">     
      <script defer type='text/javascript' src="{{ mix('/js/app.js') }}"></script>
      <!-- <script  type='text/javascript' src="https://use.fontawesome.com/c502308363.js"></script> -->
      <link defer rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

      @if (App::environment() == 'production')

        <!-- Google Tag Manager -->
        @yield('analytics-ecommerce-tracking')

        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-K5H7TCB');</script>
        <!-- End Google Tag Manager -->

      @else
        <!-- no analytics or crawling here. Testing environment -->
        <meta name="robots" content="noindex,nofollow">
      @endif

      @yield('google-structured-data')
      
  </head>
    
  <body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K5H7TCB"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

@section('footer')

    <div class="primary-color">
      <div class="float-left">© Cooking Point, SL</div>
      <div class="float-right">Follow us on:
        <a href="https://www.facebook.com/CookingPointSpain" title="facebook" target="_blank"><i class="fab fa-2x fa-facebook-square"></i></a>
        &nbsp;
        <a href="https://www.instagram.com/cookingpoint/" title="instagram" target="_blank"><i class="fab fa-2x fa-instagram"></i></a>        
      </div>      
    </div>
@endsection


<div class="d-block d-lg-none">
<div id="cabecera">
  <nav class="navbar fixed-top">
      <div class="navbar-brand">
        <a href="/"><img class="home-logo lazyload" alt="Cooking Point" data-src="/images/cookingpoint_MIC.svg" onerror="this.onerror=null; this.src='/images/cookingpoint_logox50.png'"></a>
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
            <a class="cp-class-details" href="/booking">Booking</a>
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
        <a href="/"><img class="home-logo lazyload" alt="Cooking Point" data-src="/images/cookingpoint_MIC.svg" onerror="this.onerror=null; this.src='/images/cookingpoint_logox75.png'"></a>
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
      <a class="navbar-brand"href="/"><img class="home-logo lazyload" alt="Cooking Point" data-src="/images/cookingpoint_MIC.svg" onerror="this.onerror=null; this.src='/images/cookingpoint_logox75.png'"></a>
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

<div class="container-fluid">
  @if (isset($page) && ($page == 'home'))
    @yield('banner')
  @else
    <div class="header-offset"></div>
    <div class="row justify-content-center">
      <div id="section-banner"></div>
    </div>
  @endif
  <div class="row justify-content-center">
    <div class="col col-md-11 col-lg-10">
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

<!-- modals specific for this page  -->
@yield('modals')

<!-- javascripts specific for this page  -->
@yield('js')

</body>

</html>
