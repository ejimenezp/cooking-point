@extends('masterlayout')

@section('title', 'Tapas cooking in Madrid, Spain: Spanish Cooking classes in English')
@section('description', 'Learn to make Spanish tapas in our school in Madrid')

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
				    "url": "http://test.cookingpoint.es/classes-spanish-tapas-madrid-spain"
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
            <div style="display: inline-block;"><img src="/images/slider-tapas-05.jpg" ></div>
            <div><img src="/images/slider-tapas-01.jpg" ></div>
            <div><img src="/images/slider-tapas-03.jpg" ></div>
            <div><img src="/images/slider-tapas-02.jpg" ></div>
            <div><img src="/images/slider-tapas-04.jpg" ></div>
	</div>
</div>


<div class="row">
	<div class="col-sm-12">
		<h1 class="header1">Tapas Cooking Class</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-6">
		<p>Originally from Seville, tapas started out almost by accident. In order to keep the flies off a glass of fino, a tapa (meaning lid) of cheese or ham was used to cover the glass. People got used to it and bartenders would take advantage of the salty, thirst-inducing snacks to sell more drink. It’s also said that it was encouraged to curb drunken behaviour as the food would slow the effects of alcohol.</p>

		<p>Since then, tapas has embarked on a remarkable journey of social mobility. Gone are the saucers of simple olives or boquerones (fresh anchovies) served as a by-product in local bars, tapas is now centre stage and among the most popular and fashionable cuisines in the world with top restaurants to prove it. Tapas is now an art in itself. Of course the classic tapas remain and if you’ve ever wondered how to make traditional Spanish tapas, this is the class for you.</p>
	</div>

	<div class="col-sm-6">

	<p>In this practical lesson you’ll prepare to <strong>5 traditional tapas and 1 dessert</strong>, like the popular tortilla de patatas (Spanish potato omelet), chorizos a la sidra (sausage in cider sauce), gambas al ajillo (garlic shrimp), patatas bravas (potatoes with spicy sauce) and pa amb tomàquet (tomato bread with cured ham), all rounded by a crema catalana (crème brûleé).</p>

	<p>Our Tapas class are <strong>4 hours long</strong>; 3 hours to prepare your tapas, 1 hour to enjoy your creations with the <strong>sangría</strong>, also made during the class.</p>

	<p>Tapas are <strong>prepared in pairs</strong> under the guidance of our experienced chef. All lessons are <strong>in English</strong> and no cooking experience is required.</p>

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
		5:30 pm - 9:30 pm<br/>
		€70 adult / €35 children (5-12 yo)<br/>
		cooking class, ingredients, recipes, dinner and drinks<br/><br/>
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
							echo '<td><a href="booking?class=TAPAS&date=' . $event->date . '" class="btn btn-primary">Book</a></td>';
							echo '</tr>';
						}				
		   			}
		   			echo '<tr><td>More dates</td><td><a href="booking?class=TAPAS" class="btn btn-default">Book</a></td></tr>';
				@endphp			
		</table>
	</div>
</div>

@stop