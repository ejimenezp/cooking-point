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


<!-- smartphone -->
<div class="d-block d-md-none">
  <div class="cp-smartphone-navbar clearfix">
      <div class="logo">
        <a href="/"><img alt="Cooking Point" src="/images/icons/cookingpoint-logo-landscape.png"></a>        
      </div>
      <div class=" float-right">
        <a class='menu-strips' href='javascript:void(0);' ><img src="/images/icons/menu-strips.png" />
        </a>        
      </div>

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

  <div class="navbar-offset"></div>
</div>

<!-- ipad landscape & desktop -->

<div class="d-none d-md-block">
  <div class="cp-navbar">
      <div class="logo">
        <a href="/"><img alt="Cooking Point" src="/images/cookingpoint_MIC.svg" onerror="this.onerror=null; this.src='/images/cookingpoint_logox75.png'"></a>        
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



<div class="container-fluid">

<!-- banner -->

  <div class="row justify-content-center">
      @yield('banner')
  </div>

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
      <div class="primary-color">
        <div class="float-left">© Cooking Point, SL</div>
        <div class="float-right">Follow us on:
          <a href="https://www.facebook.com/CookingPointSpain" title="facebook" target="_blank"><i class="fab fa-2x fa-facebook-square"></i></a>
          &nbsp;
          <a href="https://www.instagram.com/cookingpoint/" title="instagram" target="_blank"><i class="fab fa-2x fa-instagram"></i></a>        
        </div>      
        <div style="height: 6rem;"> </div>
      </div>
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
