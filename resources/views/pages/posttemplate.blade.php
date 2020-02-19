@extends('masterlayout')

@section('title', $post->title )
@section('description', "cualquier descripción" )

@section('content')

<div id="post-page" data-postid="{{ $post->id }}">

	<h1 id="header" class="header1">{{ $post->title }}</h1>
	<address class="header6">Madrid | <time datetime="{{ $post->publishing_date }}">{{ $post->publishing_date }}</time></address>

	<div id="text">{!! $post->body !!}</div>
	<div class="divider"></div>
	<h2 class="header2">Related posts:</h2>

	<div class="row justify-content-center">
		<div class="col-md-12 col-lg-10">

			<div class="card-deck">

			@foreach ($related as $rel)
			<div class="card">
			  	<a href="{{ $rel['friendly_url'] }}">
			  		<img class="lazyload card-img-top" data-src="{{ $rel['thumbnail_image'] }}" alt="">
				    <div class="card-body">
						<h5 class="card-title">{{ $rel['title'] }}</h5>
						<p class="card-text">{{ $rel['thumbnail_description'] }}</p>
					</div>
			  	</a>
				<div class="card-footer">
			  		<a href="{{ $rel['friendly_url'] }}">
				        <div class="text-center">
						    <button class="btn btn-primary">Read</button>
				        </div>
				    </a>
				</div>

			</div>
			@endforeach

			</div>
		</div>
	</div>

</div>


@stop
