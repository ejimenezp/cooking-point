@extends('masterlayout')

@section('title', $post->title )
@section('description', "cualquier descripción" )

@section('content')

<div id="post-page" data-postid="{{ $post->id }}">

	<h1 id="header" class="header1">{{ $post->title }}</h1>
	<address class="header6">Madrid | <time datetime="{{ $post->publishing_date }}">{{ $post->publishing_date }}</time></address>

	<div id="text">{!! $post->body !!}</div>

	@if (count($related) > 1) 
		<div class="divider"></div>
		<h2 class="header2">Related posts</h2>

		@foreach ($related as $rel)
		<div class="blog-thumbnail">
			<a href="/blog/{{ $rel['friendly_url'] }}">
				<div class="row">
					<div class="col-lg-4 col-sm-6">
						<img class="img-fluid" src="/images/blog/{{ $rel['thumbnail_image'] }}" alt="">
					</div>
					<div class="col-lg-8 col-sm-6">
						<h3 class="header3">{{ $rel['title'] }}</h3>
						<p>{{ $rel['thumbnail_description'] }}</p>
						<button class="btn btn-primary">Read</button>
					</div>
				</div>
			</a>		
		</div>
		<div class="divider"></div>
		@endforeach
	@endif

</div>


@stop
