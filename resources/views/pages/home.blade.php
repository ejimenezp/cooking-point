@extends('masterlayout')

@section('title', 'Spanish Cooking Classes in Madrid - Cooking Point')
@section('description', 'Hands-on paella and tapas cooking classes in English at top rated Madrid culinary school. Family friendly immersion in Spain’s food culture.')


@section('banner')

<div class="d-block d-md-none">
    <div class="section-banner">
        <img class="lazyload img-fluid" data-src="/images/home-banner-sm.jpg" alt="cooking point madrid" >     
    <div class="home-headline">Spanish Cooking Classes in Madrid</div>
    </div>
</div>
<div class="d-none d-md-block">
    <div class="section-banner">
        <img class="lazyload img-fluid" data-src="/images/home-banner.jpg" alt="cooking point madrid" >        
        <div class="home-headline">Spanish Cooking Classes in Madrid</div>
    </div>  
</div>

@stop


@section('content')

<h3>Our Classes</h3>

<div class="row">
    <div class="col-lg-4">
        <div class="bottom-gutter">        
            <div class="box all-clickable">
                <a href="/classes-paella-cooking-madrid-spain"></a>
                <img class="img-fluid lazyload" alt="paella cooking class in Madrid" data-src="/images/home-paella.jpg" />
                <h2>Paella Cooking Class</h2>
                <p>Enjoy an unforgettable morning visiting a food market and cooking a delicious paella with the instructions of our local chef. Great start to know more about Spanish food while you make one of our most representative dishes.</p>
                <table class="infogram">
                    <tr>
                        <td><div class="icon-2 icon-calendar"></div></td>
                        <td><div class="icon-2 icon-clock"></div></td>
                        <td><div class="icon-2 icon-euro"></div></td>
                  </tr>
                     <tr>
                        <td>Monday - Saturday</td>
                        <td>10 AM - 2 PM</td>
                        <td>€70 (adult)<br>€35 (child)</td>
                  </tr>
                </table>                                  
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="bottom-gutter">
            <div class="box all-clickable">
                <a href="/classes-spanish-tapas-madrid-spain"></a>             
                <img class="img-fluid lazyload" title="spanish cooking school in madrid" alt="tapas cooking class in madrid" data-src="/images/home-tapas.jpg" />
                <h2>Tapas Cooking Class</h2>
                <p>Spend a fun evening making tapas and sangria. Ranging from Spanish potato omelet to shrimps with garlic, all of them typical from different regions of Spain. The perfect introduction to Spanish food and culture!</p>
                <table class="infogram">
                    <tr>
                        <td><div class="icon-2 icon-calendar"></div></td>
                        <td><div class="icon-2 icon-clock"></div></td>
                        <td><div class="icon-2 icon-euro"></div></td>
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
            <div class="box all-clickable">
                <a href="/private-cooking-events-madrid-spain"></a>
                <img class="img-fluid lazyload" title="cooking events" alt="private cooking events in Madrid" data-src="/images/events-banner-sm.jpg" />    
                <h2>Private Events</h2>
                <p>We can customize our classes as private events for corporate groups, team buildings, hen or stag parties, school trips or just group of friend that want to have a different lunch or dinner in Madrid.</p>
            </div>            
        </div>
    </div>
</div> 

<div class="divider"></div>

<h3>Watch Video</h3>

<div class="row justify-content-center">
    <div class="col-sm-10 col-lg-8">
        <div class="embed-responsive embed-responsive-16by9"> 
            <iframe class="lazyload" data-src="https://www.youtube.com/embed/qsQVbrSjBow?rel=0" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</div>

<div class="divider bottom-gutter"></div>

<h3>Why to Choose Us</h3>

<div class="row">
    <div class="col-sm-6">
        <div class="pill all-clickable">
            <img class="img-fluid lazyload" alt="best class in Madrid" data-src="/images/bestintown_logo.png" />
            <h4>10 Reasons to Choose Us</h4>
            <p>We give you 10 reasons why we think ours are the best lessons in town if you want to learn to cook Spanish food. <u>Click to know more</u>.</p>
            <a href="/best-cooking-classes-madrid"></a>        
        </div>  
        <div class="pill">
            <img class="img-fluid lazyload" alt="fun classes" data-src="/images/bestclasses-banner-sm.jpg" />
            <h4>Fun &amp; Memorable</h4>
            <p>Have a fun immersion in Spain’s food culture and know insights and tips to get the most of Spanish food during your trip and back home.</p>        
        </div>

    </div>
    <div class="col-sm-6">
        <div class="pill">
            <img class="img-fluid lazyload" alt="best rated school" data-src="/images/tripadvisorCE_2018.png" />
            <h4>Top Rated School</h4>
            <p>Six years of excellent reviews in all major travel and business rating sites (TripAdvisor, Yelp, Google,...) back us as best in our category.</p>        
            </div>   
        <div class="pill">
            <img class="img-fluid lazyload" alt="hands-on class" data-src="/images/home-trullyhandson.jpg" />
            <h4>Truly Hands-on</h4>
            <p>Two people per cooktop, maximum twelve per class. Follow our chef directions to get your meal done. No worries, no cooking experience is required.</p>           
        </div>
    </div>
</div>

<div class="divider"></div>

<h3>Upcoming Classes</h3>
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

<h3>Our Location</h3>

<iframe class="lazyload" src="https://www.google.com/maps/d/embed?mid=1Z52oFNjEYejtU59SYZuFh3q7EuEIXSxX" style="height: 60vh;width: 100%;"></iframe>

<div class="divider"></div>

<h3>Madrid, food capital<br/><br/></h3>

<div class="row">
    <div class="col-12">
        <p>Like in any other big city, you will find many things to do in Madrid: museums, monuments, markets, restaurants, bars, parks,... the number of Madrid attractions is countless. But, when it comes to what to do, you shouldn't miss the opportunity to take an active role in your Madrid experience and participate on attractions where five senses are involved.</p>
        <p>Because of its central location, Madrid receives influences from every corner of Spain, what has made of it the best city to learn Spanish cuisine. The Madridian open and conciliatory character will let you discover Spanish wine and food excellences no matter their region of origin.</p>   
        <p>In our cooking classes you will learn not just about the Spanish food but also how to make it, what offers the perfect 'take-home' experience that will stay with you forever. So, you will get a broad knowledge of paella and tapas and other typical Spanish food like cured ham, olive oil, saffron, paprika,... and how important they are in the Spanish culinary culture.</p>
        <p>If you are looking for different things to do in Madrid for your holiday, an alternative to sightseeing attractions, whether you are a travelling alone, with your family or in a corporate event, then consider Cooking Point's cooking classes to get to the very heart of the local culture.</p>
    </div>
</div>

@stop


@section('js')

<script defer src="{{ mix('/js/home.js') }}"></script>

@stop
