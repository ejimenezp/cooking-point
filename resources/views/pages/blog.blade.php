@extends('masterlayout')

@section('title', 'Blog')
@section('description', 'Blog about Spanish food, recipes, traditions and more')

@section('content')


<h1 class="header1">Blog</h1>

	@foreach ($postindex as $post)
	<div class="blog-thumbnail">
		<a href="/blog/{{ $post['friendly_url'] }}">
			<div class="row">
				<div class="col-lg-4 col-sm-6">
					<img class="lazyload img-fluid" data-src="{{ $post['thumbnail_image'] }}" alt="">
				</div>
				<div class="col-lg-8 col-sm-6">
					<h3>{{ $post['title'] }}</h3>
					<p>{{ $post['thumbnail_description'] }}</p>
					<button class="btn btn-primary">Read</button>
				</div>
			</div>
		</a>		
	</div>
	<div class="divider"></div>
	@endforeach


@stop