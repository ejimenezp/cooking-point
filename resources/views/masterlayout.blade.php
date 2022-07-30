<!DOCTYPE html>
<html lang="@yield('page-lang','en')">
  <head>
      <title>@yield('title')</title>
      <meta name="description" content="@yield('description')" >
      <meta name="csrf-token" content="{{ csrf_token() }}">
      
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <meta property="og:title" content="@yield('title')">
      <meta property="og:description" content="@yield('description')">
      <meta property="og:image" content="/images/blog/@yield('page-thumbnail')">
      <meta property="og:url" content="{{ strtok(url()->current(), '?') }}">

      <link rel="icon" href="{{ config('cookingpoint.favicon') }}">
      <link rel="canonical" href="{{ strtok(url()->current(), '?') }}">

      <link defer href="{{ mix('/css/app.css') }}" rel="stylesheet" type="text/css">     

      @if (App::environment() == 'production')

        @yield('analytics-ecommerce-tracking')

        <!-- Google Tag Manager -->
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

    @if (App::environment() == 'production')
      <!-- Google Tag Manager (noscript) -->
      <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K5H7TCB"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
      <!-- End Google Tag Manager (noscript) -->
    @endif

<!-- smartphone -->
<div class="d-block d-xl-none">
  <div class="cp-smartphone-navbar clearfix">
      <div class="logo">
        <a href="/"><img alt="Cooking Point" src="/images/icons/cookingpoint-logo-landscape.png"></a>        
      </div>
      <div class=" float-right">
        <a class='menu-strips' href='javascript:void(0);' ><img src="/images/icons/menu-strips.png" />
        </a>        
      </div>

      <div id="dropdown-content" class="dropdown-content-slide-out">
        <ul>
          <li>
            <a href="/">Home</a>
          </li>
          <li>
            <a href="/classes-paella-cooking-madrid-spain">Paella Class</a>
          </li>
          <li>
            <a href="/classes-spanish-tapas-madrid-spain">Tapas Class</a>
          </li>
          <li>
            <a href="/private-events">Private Events</a>
          </li>
          <li>
            <a href="/location">Location</a>
          </li>            
<!--           <li>
            <a href="/about-us">About Us</a>
          </li> -->
          <li>
            <a href="/booking"><span class="font-weight-bold">Booking</span></a>
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

<div lang="en" class="d-none d-xl-block">
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
            <a href="/private-events">Private Events</a>
          </li>

          <li>
            <a href="/location">Location</a>
          </li>            
<!--           <li>
            <a href="/about-us">About Us</a>
          </li> -->
          <li>
            <a href="/booking"><span class="font-weight-bold">Booking</span></a>
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
    <div class="col col-sm-7">
      <div class="d-flex flex-row">
        <div class="d-flex flex-column mr-2">
            <a href="mailto:info@cookingpoint.es"><img class="d-flex justify-content-center icon" title="Email" src="/images/icons/email.png"></a>
            <a class="text-dark" href="mailto:info@cookingpoint.es">info@cookingpoint.es</a>
        </div>
        <div class="ml-2" id="here" data-toggle="modal" data-target="#contactPhone">
          <div class="d-flex flex-column">
            <a class="d-flex flex-row align-items-start" href="#here">
              <img class="d-flex justify-content-around icon" title="phone" src="/images/icons/phone.png">
              <img class="d-flex justify-content-around icon" title="whatsapp" src="/images/icons/whatsapp.png">
            </a>
            <a class="text-dark" href="#here">(+34) 910 115 154</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col mt-3 col-sm-5 mt-sm-0">
      <div class="d-flex flex-row justify-content-center justify-content-sm-end">      
      <div class="d-flex justify-content-center justify-content-sm-end">      
        <div class="d-flex align-self-center">Follow us on:</div>
          <div class="icon">
            <a href="https://www.facebook.com/CookingPointSpain" title="facebook" target="_blank"><img title="facebook" src="/images/icons/facebook.png"></a>
          </div>
          <div class="icon">
            <a href="https://www.instagram.com/cookingpoint/" title="instagram" target="_blank"><img title="instagram" src="/images/icons/instagram.png"></a>
          </div>
        </div>
        </div>      
    </div>
    <!-- only for pages paella & tapas, with a "Pay Now" button -->
    @yield('bottom-filler') 
  </div>
  
</div>

<div class="modal fade" tabindex="-1" id="contactPhone" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="h3">Call or Chat?</div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>        
      </div>
      <div class="modal-body">
        <div class="d-flex flex-row justify-content-around">
          <div class="d-flex flex-column mr-2">
              <a href="tel:+34910115154"><img class="d-flex justify-content-center icon" title="phone" src="/images/icons/phone.png"></a>
              <a class="text-dark" href="tel:+34910115154">Phone Call</a>
          </div>
          <div class="d-flex flex-column ml-2">
              <a href="https://wa.me/message/OZF6UKVAAR6GB1"><img class="d-flex justify-content-center icon" title="whatsapp" src="/images/icons/whatsapp.png"></a>
              <a class="text-dark" href="https://wa.me/message/OZF6UKVAAR6GB1">WhatsApp Chat</a>
          </div> 
        </div>
      </div>
    </div>
  </div>
</div>
<!-- modals specific for this page  -->
@yield('modals')

<!-- javascripts specific for this page  -->
<script defer type='text/javascript' src="{{ mix('/js/app.js') }}"></script>

@yield('js')

</body>

</html>
