@extends('masterlayout')

@section('title', 'Blog')
@section('description', 'Blog about Spanish food, recipes, traditions and more')

@section('content')


<h1 class="header1">Blog</h1>

	@foreach ($postindex as $post)
	<div class="box all-clickable">
		<a href="/blog/{{ $post['friendly_url'] }}">
			<div class="row">
				<div class="col-lg-4 col-sm-6">
					<img class="lazyload img-fluid" data-src="/images/blog/{{ $post['thumbnail_image'] }}" alt="">
				</div>
				<div class="col-lg-8 col-sm-6">
					<h2>{{ $post['title'] }}</h2>
					<p>{{ $post['thumbnail_description'] }}</p>
				</div>
			</div>
		</a>		
	</div>
	@endforeach


@stop