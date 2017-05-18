@extends('masterlayout')

@section('title', 'Paella cooking in Madrid: Spanish cooking classes in English')
@section('description', 'Cooking School in Madrid, Spain: learn how to cook paella in English. Spanish Cooking for tourists on paella, gazpacho and tapas')

@section('google-structured-data')

<script type="application/ld+json">
[
	@foreach ($events as $event)
		@if ($event->registered < $event->capacity) 
			{
            "@context" : "http://schema.org",
            "@type" : "Event",
            "name" : "Paella Cooking Class",
            "url" : "http://cookingpoint.es/classes-paella-cooking-madrid-spain",
			"description" : "Hands-on cooking class with market tour to make paella, gazpacho and sangria",
			"startDate" : "{{ $event->startdateatom }}",
			"endDate" : "{{ $event->enddateatom }}",
			"location" : {
       			"@type" : "Place",
        		"name" : "Cooking Point",
        		"address" : "Calle de Moratin, 11, 28014 Madrid",
        		"sameAs": "http://cookingpoint.es" },
        	"offers": {
				    "@type": "Offer",
				    "name": "Adult",
				    "availability": "http://schema.org/InStock",
				    "price": "70.00",
				    "priceCurrency": "EUR",
				    "url": "http://cookingpoint.es/classes-paella-cooking-madrid-spain"
				  }
			},
		@endif
	@endforeach
	{}
]
</script>

@stop

@section('content')

<div class="row">
    <div class="cp-slideshow">
            <div style="display: inline-block;"><img src="/images/slider-paella-02.jpg" ></div>
            <div><img src="/images/slider-paella-01.jpg" ></div>
            <div><img src="/images/slider-paella-03.jpg" ></div>
            <div><img src="/images/slider-paella-04.jpg" ></div>
            <div><img src="/images/slider-paella-05.jpg" ></div>
	</div>
</div>


<div class="row">
	<div class="col-sm-12">
		<h1 class="header1">Paella Cooking Class</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-6">
		<p>Which dish says Spain more than the Paella? From humble beginnings, paella evolved from a simple rice dish into a feast of rice with mixed meat and seafood. Traditionally it is cooked and eaten in the open air and is served directly from the paella to a large group at family gatherings or fiestas. But it is not exclusive to experienced Spanish cooks or to Spanish restaurants, you can make paella at home and this class will show you how.</p>

		<p>Our class starts visiting the <strong>Antón Martín market</strong> (200 m away, open all days except Sundays and holidays) to buy the groceries we will need to cook our menu. We’ll buy vegetables, seafood and perhaps ham, cold cuts, cheese, olives, pastry&#8230; the offering and colouring of this traditional way of shopping daily supplies is endless.</p>

		<p>Back in the school, you’ll have to apply yourself to prepare your <strong>sangría</strong> (yes, finally you will know the way to make it), and your the starter: <strong>gazpacho</strong>, that is a refreshing tomato-based chilled soup. Another taste of Spain worth mastering.</p>

	</div>

	<div class="col-sm-6">
		<p>And then, we will start cooking the <strong>paella</strong>. Along the preparation, our chef will tell the story of this typical Spanish dish including its origins and its place in Spanish culture as well as handy tips that help you make a paella to be proud of.</p>

		<p>Our Paella classes are <strong>4 hours long</strong>; 3 hours to go shopping, prepare your gazpacho and cook the paella, and 1 hour to enjoy your creations with the sangría you made at the beginning of the class. Note: on holidays, we&#8217;ll prepare one additional tapa, as market is closed.</p>

		<p>Dishes are prepared in couples under the guidance of our experienced chef. All lessons are <strong>in English</strong> and no cooking experience is required.</p>

		<p>Class is subject to a minimum attendance of 2 people.</p>

	</div>
	<div class="divider"></div>

</div>

<div class="row call-to-action">
	<div class="col-xs-12 col-sm-1 text-center">
 		<i class="brand-red fa fa-4x fa-info-circle"></i><br/>
	</div>
	<div class="col-xs-3 col-sm-2 what">
		When:<br/>
		Time:<br/>
		Price:<br/>
		Includes:<br/><br/>
		Upcoming classes:<br/>
	</div>
	<div class="col-xs-9">
		Monday to Saturday<br/>
		10 am - 2 pm<br/>
		€70 adult / €35 children (5-12 yo)<br/>
		market tour, ingredients, cooking class, recipes, lunch and drinks<br/><br/>
		<table class="table">
				@php 
					foreach ($events as $event) {
						if ($event->registered < $event->capacity) {
							$date = new DateTime($event->startdateatom);
							echo '<tr><td>';
							echo $date->format("l, d M");
							// echo '</td><td>';
							// echo $date->format("g:i a");
							echo '</td>';	
							echo '<td><a href="booking?class=PAELLA&date=' . $event->date . '" class="btn btn-primary">Book</a></td>';
							echo '</tr>';
						}				
		   			}
		   			echo '<tr><td>More dates</td><td><a href="booking?class=PAELLA" class="btn btn-default">Book</a></td></tr>';
				@endphp			
		</table>
	</div>
</div>

@stop