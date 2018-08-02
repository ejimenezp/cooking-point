@extends('masterlayout')

@section('title', 'Photo Gallery')
@section('description', 'Photos from our clients.')

@section('content')

<div class="row">
	<div class="col-sm-12">
		<h1 class="header1">Gallery</h1>
		<p>We always encourage our clients to share their experiences on the internet. See their pictures posted to some social networks.<br/><br/></p>
	</div>
</div>

<div class="row text-center">
	<div class="col-xs-4">
		<a href="https://instagram.com/explore/tags/cookingpoint/"  target="_blank"><img src="/images/gallery-Instagram-hashtag-150x150.jpg" class="img-fluid" alt="Instagram #cookingpoint" /></a>
	</div>
	<div class="col-xs-4">
		<a href="https://instagram.com/explore/locations/261749268/"  target="_blank"><img src="/images/gallery-Instagram-local-150x150.jpg" class="img-fluid" alt="Instagram location cooking point" /></a>
	</div>
	<div class="col-xs-4">
		<a href="http://www.tripadvisor.com/Attraction_Review-g187514-d4888426-Reviews-Cooking_Point-Madrid.html#photos"  target="_blank"><img src="/images/gallery-TripAdvisor-logo-150x150.jpg" class="img-fluid" alt="tripadvisor cooking point photos" /></a>
	</div>
</div>

@stop

