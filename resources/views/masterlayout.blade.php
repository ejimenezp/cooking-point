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
      <style type="text/css">
        /*body {display:none;}*/
      </style>
      <link defer href="{{ mix('/css/app.css') }}" rel="stylesheet" type="text/css">     

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

<svg style="position: absolute; width: 0; height: 0; overflow: hidden" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
  <defs>
  
    <symbol id="3strips" viewBox="0 0 1024 1024">
      <path class="path1" d="M512 96l-512 512 96 96 96-96v416h256v-192h128v192h256v-416l96 96 96-96-512-512zM512 512c-35.346 0-64-28.654-64-64s28.654-64 64-64c35.346 0 64 28.654 64 64s-28.654 64-64 64z"></path>
    </symbol>


  </defs>
</svg>


<!-- smartphone -->
<div class="d-block d-lg-none">
  <div class="cp-smartphone-navbar clearfix">
      <div class="logo">
        <a href="/"><img class="home-logo lazyload" alt="Cooking Point" data-src="/images/cookingpoint_MIC.svg" onerror="this.onerror=null; this.src='/images/cookingpoint_logox75.png'"></a>        
      </div>
      <a class='icon' href='javascript:void(0);' >
        <div class="icon-2 icon-clock"></div>
      </a>
      <div id="dropdown-content">
        <ul>
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
            <a href="/booking">Booking</a>
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
  </div>

</div>

<!-- <div class="d-block d-lg-none"> -->
<div class="d-none">
<div id="cabecera">
  <nav class="navbar fixed-top">
      <div class="navbar-brand">
        <a href="/"><img class="home-logo lazyload" alt="Cooking Point" data-src="/images/cookingpoint_MIC.svg" onerror="this.onerror=null; this.src='/images/cookingpoint_logox50.png'"></a>
      </div>
      <a class="menu-header-xs" data-toggle="collapse" data-target="#myNavbar" href="#">
        <div class="icon-2 icon-clock"></div>
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

<!-- ipad landscape -->

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

<!-- desktop -->

<div class="d-none d-xl-block">
  <div class="cp-navbar">
      <div class="logo">
        <a href="/"><img class="home-logo lazyload" alt="Cooking Point" data-src="/images/cookingpoint_MIC.svg" onerror="this.onerror=null; this.src='/images/cookingpoint_logox75.png'"></a>        
      </div>
      <div class="menu clearfix">
        <ul>
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
            <a href="/booking">Booking</a>
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
  </div>
</div>



@section('footer')

    <div class="primary-color">
      <div class="float-left">© Cooking Point, SL</div>
      <div class="float-right">Follow us on:
        <a href="https://www.facebook.com/CookingPointSpain" title="facebook" target="_blank"><i class="fab fa-2x fa-facebook-square"></i></a>
        &nbsp;
        <a href="https://www.instagram.com/cookingpoint/" title="instagram" target="_blank"><i class="fab fa-2x fa-instagram"></i></a>        
      </div>      
      <div style="height: 6rem;"> </div>
    </div>
@endsection


<!-- <div class="header-offset"></div> -->

<div class="container-fluid">

  <!-- banner -->
  @if (isset($page) && ($page == 'home'))
    <div class="row justify-content-center">
      <div id="section-banner"></div>
    </div>
  @else
    <div class="row justify-content-center">
      <div id="section-banner"></div>
    </div>
  @endif

  <!-- contents -->
  <div class="row justify-content-center">
    <div class="col-md-11 col-lg-10">
      @yield('content')                  
    </div>  
  </div>

  <!-- footer -->
  <div class="row">
    <div class="divider"></div>
    <div class="col-12">
      @yield('footer')
    </div> 
  </div>

</div>

<!-- modals specific for this page  -->
@yield('modals')

<!--       <link defer rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
 -->
<!-- javascripts specific for this page  -->
<script defer type='text/javascript' src="{{ mix('/js/app.js') }}"></script>

@yield('js')

</body>

</html>
