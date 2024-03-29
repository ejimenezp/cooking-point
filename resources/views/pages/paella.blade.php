@extends('masterlayout')

@section('title', 'Paella Cooking Class and Market Tour at Cooking Point, Madrid')
@section('description', 'Paella cooking classes in English every morning in Madrid. Hands-on class of paella includes market tour. Two people per cooktop.')

@section('google-structured-data')

<script type="application/ld+json">
[
	@foreach ($events as $event)
		@if ($event->registered < $event->capacity) 
			{
            "@context" : "http://schema.org",
            "@type" : "Event",
            "name" : "Paella Cooking Class",
            "url" : "https://cookingpoint.es/classes-paella-cooking-madrid-spain",
			"description" : "Hands-on cooking class with market tour to make paella, gazpacho and sangria",
			"startDate" : "{{ $event->startdateatom }}",
			"endDate" : "{{ $event->enddateatom }}",
      "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
      "eventStatus": "https://schema.org/EventScheduled",
			"location" : {
       			"@type" : "Place",
        		"name" : "Cooking Point",
        		"address" : "Calle de Moratin, 11, 28014 Madrid",
        		"sameAs": "https://cookingpoint.es" },
        	"offers": {
				    "@type": "Offer",
				    "name": "Adult",
				    "availability": "http://schema.org/InStock",
            "validFrom": "{{ $event->validfromdateatom }}",
				    "price": "75.00",
				    "priceCurrency": "EUR",
				    "url": "https://cookingpoint.es/classes-paella-cooking-madrid-spain"
				  }
			},
		@endif
	@endforeach
	{}
]
</script>

@stop


@section('banner')
<div class="section-banner">
	<div class="d-block d-md-none">
		<img class="img-fluid lazyload" data-src="/images/paella-banner-sm.jpg" alt="paella cooking class madrid" >		
	</div>
	<div class="d-none d-md-block">
		<img class="img-fluid lazyload" data-src="/images/paella-banner.jpg" alt="paella cooking class madrid" >		
	</div>	
</div>
@stop

@section('content')

<h1>Paella Cooking Class</h1>


<div class="row justify-content-center">

	<div class="col-sm-6 ">
		<div class="pill">
		    <h4>Highlights</h4>
		    <ul>
		    	<li>Make your own paella, gazpacho and sangria.</li>
		    	<li>Buy ingredients at local market nearby.</li>
		    	<li>Class in English.</li>
		    	<li>€75 adult / €37.50 children (5-12 year old). Includes market tour, ingredients, recipes, lunch and drinks.</li>
		    </ul>				
		</div>
	</div>
	<div class="col-sm-6">
		<div class="pill">
		    <h4>Schedule</h4>
	            <table class="infogram">
	                <tr>
                <td><div class="icon"><img title="Operating days" src="/images/icons/calendar.png"></div></td>
                <td><div class="icon"><img title="Start time" src="/images/icons/clock.png"></div></td>
                <td><div class="icon"><img title="Duration" src="/images/icons/duration.png"></div></td>
	              </tr>
	                 <tr>
	                    <td>Monday - Saturday</td>
	                    <td>10 AM</td>
	                    <td>4 hours</td>
	              </tr>
	            </table>  
		</div>
	</div>
</div>


<div class="row justify-content-right">
	<div class="col-12">
		<h3>Description</h3>

		<p>Our class starts visiting the <strong>Antón Martín market</strong> (200 m from the school) to buy the groceries we will need to cook our menu. We’ll buy vegetables, seafood, and perhaps ham, olives, cheese, pastry&#8230; the offering and colouring of this traditional way of shopping daily supplies is endless.</p>

		<p>Back in the school, you’ll have to apply yourself to prepare your <strong>sangría</strong> and your starter: <strong>gazpacho</strong>, that is a refreshing tomato-based chilled soup. Another taste of Spain worth mastering.</p>

		<div class="row justify-content-center">
			<div class="col-lg-10 col-xl-6">
				<figure class="text-center">
					<img data-src="/images/paella-details-02.jpg" class="lazyload img-fluid mx-auto d-block" alt="anton martin market">		
					<figcaption class="figure-caption">Shopping the ingredients at the local market</figcaption>
				</figure>
			</div>
			<div class="col-lg-10 col-xl-6">
				<figure class="text-center">
				<img data-src="/images/paella-details-01.jpg" class="lazyload img-fluid mx-auto d-block" alt="making gazpacho">		
					<figcaption class="figure-caption">Making gazpacho, a refreshing cold tomato soap</figcaption>
				</figure>
			</div>
		</div>


		<p>Later, you will get down to work to make your own <strong>paella</strong>, the most international Spanish dish, based on rice, seafood and chicken. </p>

		<p>Along the preparation, our chef will tell its story including its origins and its place in Spanish culture as well as handy tips that help you make a paella to be proud of.</p>

		<div class="row justify-content-center">
			<div class="col-lg-10 col-xl-6">
				<figure class="text-center">
					<img data-src="/images/paella-details-03.jpg" class="lazyload img-fluid mx-auto d-block" alt="making paella">
					<figcaption class="figure-caption">Every two of you make your own paella</figcaption>
				</figure>
			</div>
			<div class="col-lg-10 col-xl-6">
				<figure class="text-center">
					<img data-src="/images/paella-banner-sm.jpg" class="lazyload img-fluid mx-auto d-block" alt="making paella">
					<figcaption class="figure-caption">Born and raised in Madrid, we have many stories to tell</figcaption>
				</figure>
			</div>
		</div>

		<p>After cooking you will sit down to enjoy your creations as <strong>your lunch</strong>, and to share your experience with your fellow cooks. The best way to round up a memorable morning.</p>

		<div class="row justify-content-center">
			<div class="col-lg-10 col-xl-6">
				<figure class="text-center">
					<img data-src="/images/paella-details-04.jpg" class="lazyload img-fluid mx-auto d-block" alt="eating paella after class">
					<figcaption class="figure-caption">Time to eat while sharing experiences with your new friends</figcaption>
				</figure>
			</div>
		</div>

		<p>All lessons are <strong>in English</strong> and no cooking experience is required. Recipes are <strong>prepared in pairs</strong>. If you come alone or you are an odd number we will match you with a cooking partner.</p>

<!-- 	<div class="row justify-content-center">

		<div class="col-10 col-sm-8">
			<div class="pill">
			    <h4 class="text-center"><span class="bkg-status bkg-status-confirmed">COVID-19 Update</span></h4>
			    <p>We maintain the social distance between the different parties, so if you come alone, you will do everything on your own.</p>
			    <div class="text-center mt-2">
			    	<div class="btn btn-primary"><a href="/blog/covid-free-classes">COVID-19 Measures</a></div>
			    </div>		
			</div>
		</div>
	</div> -->

		<p>Besides, you get a <strong>recipe booklet</strong> with all the recipes you prepare.</p>

		<p>Check out our <a href="/faq">FAQ</a> for more questions.</p>

		<div class="d-block d-md-none">
			<div class="book-now-bottom all-clickable"><a href="/booking?class=PAELLA">Book Now</a></div>
		</div>
		<div class="d-none d-md-block">
			<div class="book-now-right all-clickable"><a href="/booking?class=PAELLA">Book Now</a></div>
		</div>

	</div>
</div>

<div class="divider"></div>

<h3>Upcoming Classes</h3>


<div class="row justify-content-center">
	<div class="col-sm-6">
		<table class="table">
			@php 
				$i = 0;
				foreach ($events as $event) {
					if ($event->registered < $event->capacity && $i < 3) {
						$date = new DateTime($event->startdateatom);
						echo '<tr class="all-clickable orange-on-hover"><td>';
						echo $date->format("D, M d");
						echo '</td><td>';
						echo $date->format("g:i A");
						echo '</td>';	
						echo '<td><a href="booking?class=PAELLA&date=' . $event->date . '" class="btn btn-primary">Book</a></td>';
						echo '</tr>';
						$i++;
					}				
	   			}
			@endphp			
		</table>
		<div class="xxl-button all-clickable"><a href="/booking?class=PAELLA">More Dates</a></div>
	</div>
</div>

<div class="divider"></div>

<h3>Not Decided Yet?</h3>
<p>Perhaps you prefer the evening class...</p>
<div class="row justify-content-center">

    <div class="col-lg-4">
        <div class="bottom-gutter">
            <div class="box all-clickable orange-on-hover">
                <a href="/classes-spanish-tapas-madrid-spain"></a>             
                <img class="img-fluid lazyload" data-src="/images/home-tapas.jpg" alt="tapas cooking class in madrid" />
                <h4 style="margin-top: 0.5rem;">Tapas Cooking Class</h4>
                <p>Have a great evening making tapas and sangria</p>
            </div>            
        </div>
    </div>

    <div class="col-lg-4">
        <div class="bottom-gutter">        
            <div class="box all-clickable orange-on-hover">
                <a href="/best-cooking-classes-madrid"></a>
                <img class="img-fluid lazyload" data-src="/images/bestintown_logo.png" alt="best classes in town" />
                <h4 style="margin-top: 0.5rem;">10 Reasons Why</h4>
                <p>Find out why we think we are the best classes in town</p>                                
            </div>
        </div>
    </div>



    <div class="col-lg-4">
        <div class="bottom-gutter">
            <div class="box all-clickable orange-on-hover">
                <a href="/gallery"></a>
                <img class="img-fluid lazyload" data-src="/images/tripadvisor-photo.jpg" alt="photo gallery" />    
                <h4 style="margin-top: 0.5rem;">Photo Gallery</h4>
                <p>Check out client photos on social media</p>
            </div>            
        </div>
    </div>
</div>
@stop

@section('bottom-filler')
<div class="d-block d-md-none">
	<div style="height: 9rem;"></div>
</div>
@stop


