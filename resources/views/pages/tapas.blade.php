@extends('masterlayout')

@section('title', 'Tapas Cooking Class in English at Cooking Point, Madrid')
@section('description', 'Tapas cooking classes in English every evening in Madrid. Hands-on class of 6 traditional tapas. Two people per cooktop.')

@section('banner-name', 'tapas')
@section('banner-caption', 'tapas cooking class madrid')

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


<h1 class="header1">Tapas Cooking Class</h1>

<div class="row justify-content-center">
	<div class="cp-class-details col-10 col-sm-8">
		<strong>When:</strong> Monday to Saturday<br/>
		<strong>Time:</strong> 5:30 pm - 9:30 pm<br/>
		<strong>Price: </strong>€70 adult / €35 children (5-12 year old)<br/>
		<strong>Includes: </strong>cooking class, ingredients, recipes, dinner and drinks<br/>
	</div>	
</div>


<div class="row justify-content-right">
	<div class="col-12">
		<p>In this practical lesson you’ll prepare your own dinner with <strong>7 traditional recipes</strong>: 5 tapas, one dessert and sangría.</p>

		<img src="/images/tapas-details-02.jpg" class="img-fluid mx-auto d-block" alt="cooking shrimp">

		<p><br>Along the preparation, our chef will tell the story of typical Spanish dish including its origins and its place in Spanish culture. A nice inmersion to Spain's food culture.</p>

		<img src="/images/tapas-details-03.jpg" class="img-fluid mx-auto d-block" alt="chef stories">

		<p><br>Traditional tapas like the popular tortilla de patatas (Spanish potato omelet), chorizos a la sidra (sausage in cider sauce), gambas al ajillo (garlic shrimp), patatas bravas (potatoes with spicy sauce) and pa amb tomàquet (tomato bread with cured ham), all rounded by a crema catalana (crème brûleé).</p>

		<img src="/images/tapas-details-01.jpg" class="img-fluid mx-auto d-block" alt="flipping the omelet">

		<p><br></p>

		<img src="/images/tapas-details-04.jpg" class="img-fluid mx-auto d-block" alt="all an experience">

		<p><br>Our Tapas class are <strong>4 hours long</strong>; 3 hours to prepare your tapas, 1 hour to enjoy your creations with the sangría you made during the class.</p>

		<img src="/images/tapas-details-05.jpg" class="img-fluid mx-auto d-block" alt="eating time">

		<p><br>Tapas are <strong>prepared in pairs</strong> under the guidance of our experienced chef. All lessons are <strong>in English</strong> and no cooking experience is required.</p>

		<div class="text-center">
			<p></p>
			<a href="/booking?class=TAPAS" class="btn btn-primary">Book Now</a>
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
							echo '<td><a href="booking?class=TAPAS&date=' . $event->date . '" class="btn btn-primary">Book</a></td>';
							echo '</tr>';
							$i++;
						}				
		   			}
		   			echo '<tr><td>More dates</td><td><a href="booking?class=TAPAS" class="btn btn-primary">Book</a></td></tr>';
				@endphp			
		</table>
	</div>
</div>

<div class="divider"></div>

<div class="header2">Not Decided Yet?</div>
<p>Perhaps you prefer the morning class...</p>
<div class="row justify-content-center">
	<div class="col-md-12 col-lg-12">
		<div class="card-deck">
		  <div class="card">
		    <a href="classes-paella-cooking-madrid-spain"><img class="card-img-top" src="/images/home-paella.jpg" alt="paella class"></a>		    
		    <div class="card-body">
		      <h5 class="card-title">Paella Class</h5>
		      <p class="card-text">Enjoy an unforgettable morning visiting a food market and cooking a delicious paella.</p>
		    </div>
		    <div class="card-footer">
		        <div class="text-center">
		            <a href="classes-paella-cooking-madrid-spain" class="btn btn-primary">Paella Class</a>
		        </div>
		    </div>
		  </div>		  
		  <div class="card">
		    <a href="/best-cooking-classes-madrid"><img class="card-img-top" src="/images/home-bestclassintown.jpg" alt="best classes in town"></a>
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
		    <a href="/gallery"><img class="card-img-top" src="/images/tripadvisor-photo.jpg" alt="photo gallery"></a>
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

<div class="divider"></div>

<p>Originally from Seville, tapas started out almost by accident. In order to keep the flies off a glass of fino, a tapa (meaning lid) of cheese or ham was used to cover the glass. Since then, tapas has embarked on a remarkable journey of social mobility and is now centre stage and among the most popular and fashionable cuisines in the world. Tapas is now an art in itself. Of course the classic tapas remain and if you’ve ever wondered how to make traditional Spanish tapas, this is the class for you.</p>

@stop
