@extends('masterlayout')

@section('title', $post->title )
@section('description', $post->description )
@section('page-thumbnail', $post->thumbnail_image)

@section('content')

<div id="post-page" data-postid="{{ $post->id }}">

	<h1 id="header">{{ $post->title }}</h1>
	<address>Madrid | <time datetime="{{ $post->publishing_date }}">{{ $post->publishing_date }}</time></address>

	<div id="text">{!! $post->body !!}</div>

	@if (count($related) > 0) 
		<div class="divider"></div>
		<h1>Related posts</h1>

		@foreach ($related as $rel)
			<div class="box all-clickable orange-on-hover">
				<a href="/blog/{{ $rel['friendly_url'] }}">
					<div class="row">
						<div class="col-lg-4 col-sm-6">
							<img class="lazyload img-fluid" data-src="/images/blog/{{ $rel['thumbnail_image'] }}" alt="">
						</div>
						<div class="col-lg-8 col-sm-6">
							<h2>{{ $rel['title'] }}</h2>
							<p>{{ $rel['thumbnail_description'] }}</p>
						</div>
					</div>
				</a>		
			</div>
		@endforeach
	@endif

			<div class="box all-clickable orange-on-hover">
				<a href="/blog/">
					<div class="row justify-content-center">
						<h2>All Posts</h2>
					</div>
				</a>
			</div>

</div>


@stop
