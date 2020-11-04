@extends('masterlayout')

@section('title', 'Spanish Cooking Classes in Madrid - Cooking Point')
@section('description', 'Hands-on paella and tapas cooking classes in English at top rated Madrid culinary school. Family friendly immersion in Spain’s food culture.')



@section('content')

<h1>In-person Classes</h1>


    <div class="row justify-content-center">

        <div class="col-10 col-sm-8">
            <div class="pill">
                <h4 class="text-center"><span class="bkg-status bkg-status-confirmed">COVID-19 Update</span></h4>
                <p>We have reduced our class capacity to 6 people to maintain a social distancing of 2 meters. Face mask is mandatory throughout the activity, except for eating.</p>           
                <div class="text-center mt-2">
                    <div class="btn btn-primary"><a href="/blog/covid-free-classes">COVID-19 Measures</a></div>
                </div>      
            </div>
        </div>
    </div>



    <div class="row justify-content-right">

 
    <div class="col-lg-4">
        <div class="bottom-gutter">        
            <div class="box all-clickable orange-on-hover">
                <a href="/classes-paella-cooking-madrid-spain"></a>
                <img class="img-fluid lazyload" alt="paella cooking class in Madrid" data-src="/images/home-paella.jpg" />
                <h2>Paella Cooking Class</h2>
                <p>Enjoy an unforgettable morning visiting a food market and cooking a delicious paella with the instructions of our local chef. Great start to know more about Spanish food while you make one of our most representative dishes.</p>
                <table class="infogram">
                    <tr>
                        <td><div class="icon"><img src="/images/icons/calendar.png"></div></td>
                        <td><div class="icon"><img src="/images/icons/clock.png"></div></td>
                        <td><div class="icon"><img src="/images/icons/euro.png"></div></td>
                  </tr>
                     <tr>
                        <td>Monday - Saturday</td>
                        <td>10 AM - 2&nbsp;PM</td>
                        <td>€70 (adult)<br>€35 (child)</td>
                  </tr>
                </table>                                  
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="bottom-gutter">
            <div class="box all-clickable orange-on-hover">
                <a href="/classes-spanish-tapas-madrid-spain"></a>             
                <img class="img-fluid lazyload" title="spanish cooking school in madrid" alt="tapas cooking class in madrid" data-src="/images/home-tapas.jpg" />
                <h2>Tapas Cooking Class</h2>
                <p>Spend a fun evening making tapas and sangria. Ranging from Spanish potato omelet to shrimps with garlic, all of them typical from different regions of Spain. The perfect introduction to Spanish food and culture!</p>
                <table class="infogram">
                    <tr>
                        <td><div class="icon"><img src="/images/icons/calendar.png"></div></td>
                        <td><div class="icon"><img src="/images/icons/clock.png"></div></td>
                        <td><div class="icon"><img src="/images/icons/euro.png"></div></td>
                 </tr>
                     <tr>
                        <td>Monday - Saturday</td>
                        <td>5:30 PM - 9:30 PM</td>
                        <td>€70 (adult)<br>€35 (child)</td>
                  </tr>
                </table>  
            </div>            
        </div>
    </div>

    <div class="col-lg-4">
        <div class="bottom-gutter">
            <div class="box all-clickable orange-on-hover">
                <a href="/private-cooking-events-madrid-spain"></a>
                <img class="img-fluid lazyload" title="cooking events" alt="private cooking events in Madrid" data-src="/images/events-banner-sm.jpg" />    
                <h2>Private Events</h2>
                <p>We can customize our classes as private events for corporate groups, team buildings, hen or stag parties, school trips or just group of friend that want to have a different lunch or dinner in Madrid.</p>
            </div>            
        </div>
    </div>
</div> 

@stop





