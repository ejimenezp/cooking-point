@extends('masterlayout')

@section('title', 'Tapas Cooking Class in English at Cooking Point, Madrid')
@section('description', 'Tapas cooking classes in English every evening in Madrid. Hands-on class of 6 traditional tapas. Two people per cooktop.')


@section('google-structured-data')

<script type="application/ld+json">
[
	@foreach ($events as $event)
		@if ($event->registered < $event->capacity) 
			{
            "@context" : "http://schema.org",
            "@type" : "Event",
            "name" : "Tapas Cooking Class",
            "url" : "https://cookingpoint.es/classes-spanish-tapas-madrid-spain",
			"description" : "Hands-on cooking class to make traditional Spanish tapas and sangria",
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
				    "url": "http://test.cookingpoint.es/classes-spanish-tapas-madrid-spain"
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
		<img class="img-fluid lazyload" data-src="/images/tapas-banner-sm.jpg" alt="tapas cooking class madrid" >		
	</div>
	<div class="d-none d-md-block">
		<img class="img-fluid lazyload" data-src="/images/tapas-banner.jpg" alt="tapas cooking class madrid" >		
	</div>	
</div>
@stop

@section('content')


<h1>Tapas Cooking Class</h1>

<div class="row justify-content-center">

	<div class="col-sm-6 ">
		<div class="pill">
		    <h4>Highlights</h4>
		    <ul>
		    	<li>Cook your own dinner of tapas and sangria.</li>
		    	<li>Get inmersed in the tapas culture by hand of local chefs.</li>
		    	<li>Class in English.</li>
		    	<li>€75 adult / €37.50 children (5-12 year old). Includes ingredients, recipes, lunch and drinks.</li>
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
	                    <td>5:30 PM</td>
	                    <td>4 hours</td>
	              </tr>
	            </table>  
		</div>
	</div>
</div>


<div class="row justify-content-right">
	<div class="col-12">
		<p>Originally from Seville, tapas started out almost by accident. In order to keep the flies off a glass of wine, a tapa (meaning lid) of cheese or ham was used to cover the glass. Since then, tapas have embarked on a remarkable journey of social mobility and are among the most popular and fashionable cuisines in the world. Of course the classic tapas remain and if you’ve ever wondered how to make traditional Spanish tapas, this is the class for you.</p>

		<p>In this practical lesson you’ll prepare your own dinner with <strong>7 recipes</strong>: 5 traditional tapas, one dessert and sangría.</p>

		<p>Along the preparation, our chef will tell stories about the origin and customs around this way of enjoying food. There will be also time to talk about cured ham, olive oil and other produce paradigm of Spanish food culture.</p>

		<div class="row justify-content-center">
			<div class="col-lg-10 col-xl-6">
				<figure class="text-center">
					<img data-src="/images/tapas-details-04.jpg" class="lazyload img-fluid mx-auto d-block" alt="what an experience!">
					<figcaption class="figure-caption">Prepare your own tapas dinner</figcaption>
				</figure>
			</div>
			<div class="col-lg-10 col-xl-6">
				<figure class="text-center">
				<img data-src="/images/tapas-details-03.jpg" class="lazyload img-fluid mx-auto d-block" alt="chef stories">
					<figcaption class="figure-caption">Born and raised in Madrid, we have many stories to tell</figcaption>
				</figure>
			</div>
		</div>


		<p>You will prepare traditional tapas such as the popular Spanish potato omelet and other with chorizo, shrimp and cured ham, all washed down with sangria and ended up with a dessert, all made by you.</p>

		<p>Note: there are alternative ingredients or recipes for people with special dietary requirements.</p>

		<p>After cooking you will sit down to enjoy your creations as <strong>your dinner</strong>, and to share your experience with your fellow cooks. The best way to round up a memorable evening.</p>

		<div class="row justify-content-center">
			<div class="col-md-8 col-lg-6 col-xl-4">
				<figure class="text-center">
					<img data-src="/images/tapas-details-01.jpg" class="lazyload img-fluid mx-auto d-block" alt="flipping the omelet">
					<figcaption class="figure-caption">Master the famous Spanish potato omelet</figcaption>
				</figure>
			</div>
			<div class="col-lg-10 col-xl-6">
				<figure class="text-center">
					<img data-src="/images/tapas-details-05.jpg" class="lazyload img-fluid mx-auto d-block" alt="eating time">
					<figcaption class="figure-caption">Born and raised in Madrid, we have many stories to tell</figcaption>
				</figure>
			</div>
		</div>

		<p>All lessons are <strong>in English</strong> and no cooking experience is required. Recipes are <strong>prepared in pairs</strong>. If you come alone or you are an odd number we will match you with a cooking partner.</p>

	<div class="row justify-content-center">

		<div class="col-10 col-sm-8">
			<div class="pill">
			    <h4 class="text-center"><span class="bkg-status bkg-status-confirmed">COVID-19 Update</span></h4>
			    <p>We maintain the social distance between the different parties, so if you come alone, you will do everything on your own.</p>			
			    <div class="text-center mt-2">
			    	<div class="btn btn-primary"><a href="/blog/covid-free-classes">COVID-19 Measures</a></div>
			    </div>		
			</div>
		</div>
	</div>

		<p>Besides, you get a <strong>recipe booklet</strong> with all the recipes you prepare.</p>

		<p>Check out our <a href="/faq">FAQ</a> for more questions.</p>

		<div class="d-block d-md-none">
			<div style="height: 5rem;"></div>
			<div class="book-now-bottom all-clickable"><a href="/booking?class=TAPAS">Book Now</a></div>
		</div>
		<div class="d-none d-md-block">
			<div class="book-now-right all-clickable"><a href="/booking?class=TAPAS">Book Now</a></div>
		</div>
	</div>
</div>	

<div class="divider"></div>

<h2>Upcoming Classes</h2>


<div class="row justify-content-center">
	<div class="col-sm-6">
		<table class="table">
				@php 
					$i = 0;
					foreach ($events as $event) {
						if ($event->registered < $event->capacity && $i < 3) {
							$date = new DateTime($event->startdateatom);
							echo '<tr><td>';
							echo $date->format("l, d M");
							// echo '</td><td>';
							// echo $date->format("g:i a");
							echo '</td>';	
							echo '<td><a href="booking?class=TAPAS&date=' . $event->date . '" class="btn btn-primary">Book</a></td>';
							echo '</tr>';
							$i++;
						}				
		   			}
				@endphp			
		</table>
		<div class="xxl-button all-clickable"><a href="/booking?class=TAPAS">More Dates</a></div>
	</div>
</div>

<div class="divider"></div>

<h2>Not Decided Yet?</h2>

<p>Perhaps you prefer the morning class...</p>

<div class="row justify-content-center">

    <div class="col-lg-4">
        <div class="bottom-gutter">
            <div class="box all-clickable orange-on-hover">
                <a href="classes-paella-cooking-madrid-spain"></a>             
                <img class="lazyload card-img-top" data-src="/images/home-paella.jpg" alt="paella class" />
                <h4 style="margin-top: 0.5rem;">Paella Cooking Class</h4>
                <p>Enjoy an unforgettable morning visiting a food market and cooking a delicious paella</p>
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
