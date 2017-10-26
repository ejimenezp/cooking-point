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

<div class="visible-xs wide">
	       <img class="cp-slideshow" src="/images/cliffs.jpg" >
</div>

<div class="visible-sm visible-md visible-lg">
	       <img class="cp-slideshow" src="/images/cliffs.jpg" >
</div>


<h1 class="header1">Tapas Cooking Class</h1>

<div class="row">
	<div class="cp-class-details col-xs-offset-1 col-xs-10 col-md-offset-2 col-md-8">
		<strong>When:</strong> Monday to Saturday<br/>
		<strong>Time:</strong> 5:30 pm - 9:30 pm<br/>
		<strong>Price: </strong>€70 adult / €35 children (5-12 yo)<br/>
		<strong>Includes: </strong>cooking class, ingredients, recipes, dinner and drinks<br/>
	</div>	
</div>


<div class="no-gutter">
	<div class="col-md-6">
		<p>In this practical lesson you’ll prepare your own dinner with <strong>7 traditional recipes</strong>: 5 tapas, one dessert and sangría.</p>

		<p>Traditional tapas like the popular tortilla de patatas (Spanish potato omelet), chorizos a la sidra (sausage in cider sauce), gambas al ajillo (garlic shrimp), patatas bravas (potatoes with spicy sauce) and pa amb tomàquet (tomato bread with cured ham), all rounded by a crema catalana (crème brûleé).</p>
	</div>

	<div class="col-md-6">

		<p>Our Tapas class are <strong>4 hours long</strong>; 3 hours to prepare your tapas, 1 hour to enjoy your creations with the sangría you made during the class.</p>

		<p>Tapas are <strong>prepared in pairs</strong> under the guidance of our experienced chef. All lessons are <strong>in English</strong> and no cooking experience is required.</p>

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
						echo '<td><a href="booking?class=TAPAS&date=' . $event->date . '" class="btn btn-primary">Book</a></td>';
						echo '</tr>';
						$i++;
					}				
	   			}
	   			echo '<tr><td>More dates</td><td><a href="booking?class=TAPAS" class="btn btn-primary">Book</a></td></tr>';
			@endphp			
	</table>
</div>

<div class="divider"></div>

<p>Originally from Seville, tapas started out almost by accident. In order to keep the flies off a glass of fino, a tapa (meaning lid) of cheese or ham was used to cover the glass. Since then, tapas has embarked on a remarkable journey of social mobility and is now centre stage and among the most popular and fashionable cuisines in the world. Tapas is now an art in itself. Of course the classic tapas remain and if you’ve ever wondered how to make traditional Spanish tapas, this is the class for you.</p>

@stop