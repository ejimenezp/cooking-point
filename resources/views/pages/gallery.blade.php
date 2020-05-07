@extends('masterlayout')

@section('title', 'Photo Gallery')
@section('description', 'Photos from our clients.')

@section('content')

<div class="row">
	<div class="col-sm-12">
		<h1>Gallery</h1>
		<p>See other clients' pictures posted on social media.<br/><br/></p>
	</div>
</div>



<div class="row justify-content-center">
    <div class="col-6 col-md-3">
        <div class="bottom-gutter">
            <div class="box all-clickable orange-on-hover">
				<a href="https://instagram.com/explore/tags/cookingpoint/"  target="_blank"></a>
				<img data-src="/images/instagram-icon.png" class="lazyload img-fluid mx-auto d-block" alt="Instagram #cookingpoint" />
                <h4 style="margin-top: 0.5rem;">Instagram</h4>
            </div>            
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="bottom-gutter">        
            <div class="box all-clickable orange-on-hover">
                <a href="http://www.tripadvisor.com/Attraction_Review-g187514-d4888426-Reviews-Cooking_Point-Madrid.html#photos"  target="_blank"></a>
                <img data-src="/images/tripadvisor-logo.png" class="lazyload img-fluid mx-auto d-block" alt="tripadvisor cooking point photos" />
                <h4 style="margin-top: 0.5rem;">TripAdvisor </h4>
            </div>
        </div>
    </div>
</div>

@stop

