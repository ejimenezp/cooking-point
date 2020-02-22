@extends('masterlayout')

@section('title', 'About Us')
@section('description', 'We are 100% local, passionate about cooking and Spanish food culture.')

@section('content')

<div class="row">
	<div class="col-sm-12">
		<h1 class="header1">About Us</h1>
		<p>We are 100% local, passionate about cooking and Spanish food culture.<br/><br/></p>
	</div>
</div>

<div class="row">
	<div class="col-sm-6">
		<div class="text-center">
			<img class="lazyload text-center" data-src="/images/eduardo.jpg" alt="eduardo" />
		</div>
		<p class="header2">Eduardo</p>
		<p>Born and raised in Madrid, Eduardo decided to quit his engineering and marketing career to found Cooking Point in 2013 to teach the recipes he learned from his mum when he was a child. He believes gastronomy and the way people enjoy food say a lot about each country, feels like fish in water at the market or cooking something on the stove.
</p>
	</div>
	<div class="col-sm-6">
		<div class="text-center">
			<img class="lazyload text-center" data-src="/images/laura.jpg" alt="laura" />
		</div>
		<p class="header2">Laura</p>
		<p>Also 100% Madridian, Laura has been combining her two passions —translation and cooking—, during her whole life. She loves unveiling the stories and legends behind each recipe and will take you through a historical and gastronomical journey in every class. When she is not teaching, you can find her at the market getting supplies for her recently discovered recipes.</p>

	</div>
</div>

<div class="row">
	<div class="col-sm-6">
		<div class="text-center">
			<img class="lazyload text-center" data-src="/images/angel.jpg" alt="angel" />
		</div>
		<p class="header2">Angel</p>
		<p>Full blooded Spaniard, Angel is passionate about cultures and languages that led him to study and work as a tour guide in different countries. While abroad, he also worked in restaurants where got professional cooking knowledge. But long before that, he's always been a keen home cook and supporter of the Mediterranean diet and Spanish cuisine.</p>

	</div>
	<div class="col-sm-6">
		<div class="text-center">
			<img class="lazyload text-center" data-src="/images/teresa.jpg" alt="teresa" />
		</div>
		<p class="header2">Teresa</p>
		<p>Born in Madrid and raised on her mother’s traditional recipes, is a natural creative talent. She has spent many years inspiring herself and those around her through art, drama and music, while her love to travel has brought her closer to other cultures and cuisines. She has a wealth of experience working in bars and restaurants throughout Spain and is ready to share her passion for artistic Spanish cooking, in her native city. Take this opportunity for a unique, and as we like to say, inTERESAnte experience!</p>
	</div>
</div>

<div class="header2">Our Classes</div>
<p>And these are our classes.</p>
<div class="row justify-content-center">
	<div class="col-md-10 col-lg-8">
		<div class="card-deck">
		  <div class="card">
		    <a href="classes-paella-cooking-madrid-spain"><img class="lazyload card-img-top" data-src="/images/home-paella.jpg" alt="paella class"></a>
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
		</div>		
	</div>
</div>

@stop

