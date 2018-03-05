@extends('masterlayout')

@section('title', 'Paella Cooking Class and Market Tour at Cooking Point, Madrid')
@section('description', 'Paella cooking classes in English every morning in Madrid. Hands-on class of paella includes market tour. Two people per cooktop.')

@section('page', 'paella')
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

<div class="row">
	<div class="cp-class-details col-xs-offset-1 col-xs-10 col-md-offset-2 col-md-8">
		<strong>When:</strong> Monday to Saturday<br/>
		<strong>Time:</strong> 10:00 am - 2:00 pm<br/>
		<strong>Price: </strong>€70 adult / €35 children (5-12 year old)<br/>
		<strong>Includes: </strong>market tour, cooking class, ingredients, recipes, lunch and drinks<br/>
	</div>	
</div>

<div class="no-gutter">
	
	<div class="col-md-6" >
		<p>Our class starts visiting the <strong>Antón Martín market</strong> (200 m away, open all days except Sundays and holidays) to buy the groceries we will need to cook our menu. We’ll buy vegetables, seafood and perhaps ham, cold cuts, cheese, olives, pastry&#8230; the offering and colouring of this traditional way of shopping daily supplies is endless.</p>

		<p>Back in the school, you’ll have to apply yourself to prepare your <strong>sangría</strong> and your the starter: <strong>gazpacho</strong>, that is a refreshing tomato-based chilled soup. Another taste of Spain worth mastering.</p>

		<p>And then, we will start cooking the <strong>paella</strong>. Along the preparation, our chef will tell the story of this typical Spanish dish including its origins and its place in Spanish culture as well as handy tips that help you make a paella to be proud of.</p>
	</div>

	<div class="col-md-6">

		<p>Our Paella classes are <strong>4 hours long</strong>; 3 hours to go shopping, prepare your gazpacho and cook the paella, and 1 hour to enjoy your creations with the sangría you made at the beginning of the class. Note: on holidays, we&#8217;ll prepare one additional tapa, as market is closed.</p>

		<p>Dishes are prepared in couples under the guidance of our experienced chef. All lessons are <strong>in English</strong> and no cooking experience is required.</p>

		<p>Class is subject to a minimum attendance of 2 people.</p>

	</div>
</div>

<div class="divider"></div>

<h2 class="header2">Upcoming Classes</h2>


<div class="col-sm-offset-3 col-sm-6">
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
<div class="divider"></div>

<p>Which dish says Spain more than the Paella? From humble beginnings, paella evolved from a simple rice dish into a feast of rice with mixed meat and seafood. Traditionally it is cooked and eaten in the open air and is served directly from the paella to a large group at family gatherings or fiestas. But it is not exclusive to experienced Spanish cooks or to Spanish restaurants, you can make paella at home and this class will show you how.</p>


@stop