<!DOCTYPE html>
<html lang="en">
  <head>
      <title>@yield('title')</title>
      <meta name="description" content="@yield('description')" >
      <meta name="csrf-token" content="{{ csrf_token() }}">
      
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
            <a href="/private-cooking-events-madrid-spain">Private Events</a>
          </li>
          <li>
            <a href="/location">Location</a>
          </li>            
          <li>
            <a href="/about-us">About Us</a>
          </li>
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
    <div class="col-12">
        <div class="float-left">
          <table>
            <tr><td>
                  <div class="icon" style="padding-bottom:0;">
                    <a href="mailto:info@cookingpoint.es"><img title="Email" src="/images/icons/email.png"></a>
                  </div>
            </td></tr>
            <tr><td>
                   <a class="unstyled" href="mailto:info@cookingpoint.es">info@cookingpoint.es</a>
            </td></tr>
          </table>
        

        </div>
        <div class="float-right">
          <table>
            <tr><td colspan="2">Follow us on:</td></tr>
            <tr><td>
                  <div class="icon">
                    <a href="https://www.facebook.com/CookingPointSpain" title="facebook" target="_blank"><img title="facebook" src="/images/icons/facebook.png"></a>
                  </div>
            </td><td>
                  <div class="icon">
                    <a href="https://www.instagram.com/cookingpoint/" title="instagram" target="_blank"><img title="instagram" src="/images/icons/instagram.png"></a>
                  </div>
            </td></tr>
          </table>
        </div>      
    </div>
    <!-- only for pages paella & tapas, with a "Pay Now" button -->
    @yield('bottom-filler') 
  </div>
  
</div>

<!-- modals specific for this page  -->
@yield('modals')

<!-- javascripts specific for this page  -->
<script defer type='text/javascript' src="{{ mix('/js/app.js') }}"></script>

@yield('js')

</body>

</html>
