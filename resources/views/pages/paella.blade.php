@extends('masterlayout')

@section('title', 'Paella Cooking Class and Market Tour at Cooking Point, Madrid')
@section('description', 'Paella cooking classes in English every morning in Madrid. Hands-on class of paella includes market tour. Two people per cooktop.')

@section('banner-name', 'paella')
@section('banner-caption', 'paella cooking class madrid')

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
			"location" : {
       			"@type" : "Place",
        		"name" : "Cooking Point",
        		"address" : "Calle de Moratin, 11, 28014 Madrid",
        		"sameAs": "https://cookingpoint.es" },
        	"offers": {
				    "@type": "Offer",
				    "name": "Adult",
				    "availability": "http://schema.org/InStock",
				    "price": "70.00",
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

@section('content')

<h1 class="header1">Paella Cooking Class</h1>

<div class="row justify-content-center">
	<div class="cp-class-details col-10 col-sm-8">
		<strong>When:</strong> Monday to Saturday<br/>
		<strong>Time:</strong> 10:00 am - 2:00 pm<br/>
		<strong>Price: </strong>€70 adult / €35 children (5-12 year old)<br/>
		<strong>Includes: </strong>market tour, cooking class, ingredients, recipes, lunch and drinks<br/>
	</div>	
</div>

<div class="row justify-content-right">
	<div class="col-12">
		<p>Our class starts visiting the <strong>Antón Martín market</strong> (200 m from the school) to buy the groceries we will need to cook our menu. We’ll buy vegetables, seafood, and perhaps ham, olives, cheese, pastry&#8230; the offering and colouring of this traditional way of shopping daily supplies is endless.</p>

		<img data-src="/images/paella-details-02.jpg" class="lazyload img-fluid mx-auto d-block" alt="anton martin market">

		<p><br>Back in the school, you’ll have to apply yourself to prepare your <strong>sangría</strong> and your starter: <strong>gazpacho</strong>, that is a refreshing tomato-based chilled soup. Another taste of Spain worth mastering.</p>

		<img data-src="/images/paella-details-01.jpg" class="lazyload img-fluid mx-auto d-block" alt="making gazpacho">

		<p><br>And then, you will get down to work to make your own <strong>paella</strong>, the most international Spanish dish, based on rice, seafood and chicken. Along the preparation, our chef will tell its story including its origins and its place in Spanish culture as well as handy tips that help you make a paella to be proud of.</p>

		<img data-src="/images/paella-details-03.jpg" class="lazyload img-fluid mx-auto d-block" alt="making paella">
		<p><br></p>
		<img data-src="/images/paella-banner-sm.jpg" class="lazyload img-fluid mx-auto d-block" alt="making paella">

		<p><br>After cooking you will sit down to enjoy your creations as <strong>your lunch</strong>, and to share your experience with your fellow cooks. The best way to round up a memorable morning.</p>

		<img data-src="/images/paella-details-04.jpg" class="lazyload img-fluid mx-auto d-block" alt="eating paella after class">

		<p><br>All lessons are <strong>in English</strong> and no cooking experience is required. Recipes are <strong>prepared in pairs</strong>. If you come alone or you are an odd number we will match you with a cooking partner.</p>

		<p>Besides, you get a <strong>recipe booklet</strong> with all the recipes you prepare.</p>

		<p>Check out our <a href="/faq">FAQ</a> for more questions.</p>



		<div class="text-center">
			<p></p>
			<a href="/booking?class=PAELLA" class="btn btn-primary">Book Now</a>
			<p></p>
		</div>

	</div>
</div>

<div class="divider"></div>

<h2 class="header2">Upcoming Classes</h2>


<div class="row justify-content-center">
	<div class="col-10 col-sm-8">
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
						echo '<td><a href="booking?class=PAELLA&date=' . $event->date . '" class="btn btn-primary">Book</a></td>';
						echo '</tr>';
						$i++;
					}				
	   			}
	   			echo '<tr><td>More dates</td><td><a href="booking?class=PAELLA" class="btn btn-primary">Book</a></td></tr>';
			@endphp			
		</table>
	</div>
</div>

<div class="header2">Not Decided Yet?</div>
<p>Perhaps you prefer the evening class...</p>
<div class="row justify-content-center">
	<div class="col-md-12 col-lg-10">
		<div class="card-deck">
		  <div class="card">
		    <a href="classes-spanish-tapas-madrid-spain"><img class="lazyload card-img-top" data-src="/images/home-tapas.jpg" alt="tapas class"></a>
		    <div class="card-body">
		      <h5 class="card-title">Tapas Class</h5>
		      <p class="card-text">Have a great evening making tapas and sangria.</p>
		    </div>
		    <div class="card-footer">
    	        <div class="text-center">
	            <a href="classes-spanish-tapas-madrid-spain" class="btn btn-primary">Tapas Class</a>
	        </div>
		    </div>
		  </div>		  
		  <div class="card">
		    <a href="/best-cooking-classes-madrid"><img class="lazyload card-img-top" data-src="/images/home-bestclassintown.jpg" alt="best classes in town"></a>
		    <div class="card-body">
		      <h5 class="card-title">10 Reasons Why</h5>
		      <p class="card-text">Find out why we think we are the best classes in town.</p>
		    </div>
		    <div class="card-footer">
		        <div class="text-center">
		            <a href="/best-cooking-classes-madrid" class="btn btn-primary">10 Reasons Why</a>
		        </div>
		    </div>
		  </div>
		  <div class="card">
		    <a href="/gallery"><img class="lazyload card-img-top" data-src="/images/tripadvisor-photo.jpg" alt="photo gallery"></a>
		    <div class="card-body">
		      <h5 class="card-title">Photo Gallery</h5>
		      <p class="card-text">Check out client photos on social media.</p>
		    </div>
		    <div class="card-footer">
		        <div class="text-center">
		            <a href="/gallery" class="btn btn-primary">Gallery</a>
		        </div>
		    </div>
		  </div>
		</div>		
	</div>
</div>

@stop

