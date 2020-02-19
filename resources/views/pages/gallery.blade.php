@extends('masterlayout')

@section('title', 'Photo Gallery')
@section('description', 'Photos from our clients.')

@section('content')

<div class="row">
	<div class="col-sm-12">
		<h1 class="header1">Gallery</h1>
		<p>We always encourage our clients to share their experiences on the internet. See their pictures posted on social media.<br/><br/></p>
	</div>
</div>


<div class="row justify-content-center">
	<div class="col-md-12 col-lg-10">
		<div class="card-deck">
		  <div class="card">
			<a href="https://instagram.com/explore/tags/cookingpoint/"  target="_blank"><img data-src="/images/instagram-icon.png" class="lazyload img-fluid mx-auto d-block" alt="Instagram #cookingpoint" /></a>
		    <div class="card-body">
		      <h5 class="card-title">instagram</h5>
		      <p class="card-text">Tag #cookingpoint.</p>
		    </div>
		    <div class="card-footer">
    	        <div class="text-center">
	            <a href="https://instagram.com/explore/tags/cookingpoint/"  target="_blank">Go</a>
	        </div>
		    </div>
		  </div>		  
		  <div class="card">
		  	<a href="https://instagram.com/explore/locations/261749268/"  target="_blank"><img data-src="/images/instagram-icon.png" class="lazyload img-fluid mx-auto d-block" alt="Instagram location cooking point" /></a>
		    <div class="card-body">
		      <h5 class="card-title">instagram</h5>
		      <p class="card-text">Location Cooking Point.</p>
		    </div>
		    <div class="card-footer">
		        <div class="text-center">
		            <a href="https://instagram.com/explore/locations/261749268/"  target="_blank">Go</a>
		        </div>
		    </div>
		  </div>
		  <div class="card">
			<a href="http://www.tripadvisor.com/Attraction_Review-g187514-d4888426-Reviews-Cooking_Point-Madrid.html#photos"  target="_blank"><img data-src="/images/tripadvisor-2018-certificate-of-excellence.jpg" class="lazyload img-fluid mx-auto d-block" alt="tripadvisor cooking point photos" /></a>

		    <div class="card-body">
		      <h5 class="card-title">TripAdvisor</h5>
		      <p class="card-text">Client's photos.</p>
		    </div>
		    <div class="card-footer">
		        <div class="text-center">
		            <a href="http://www.tripadvisor.com/Attraction_Review-g187514-d4888426-Reviews-Cooking_Point-Madrid.html#photos"  target="_blank">Go</a>
		        </div>
		    </div>
		  </div>
		</div>		
	</div>
</div>

@stop

