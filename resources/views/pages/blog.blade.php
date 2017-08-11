@extends('masterlayout')

@section('title', 'Blog')
@section('description', 'Blog about Spanish food, recipes, traditions and more')

@section('content')

<div class="row blog">
	<div class="col-sm-12">
		<h1 class="header1">Blog</h1>

<div class="row">

    <div class="col-sm-6">
        <h4 class="header4"></h4>
		<a href="/iberico-ham"><img class="img-responsive center-block" alt="iberico pig" src="/images/blog/iberico-pig.jpg" /></a>
		<h2 class="header2"><a href="/iberico-ham">What Is iberico Ham?</a></h2>
		<p>What makes so special the Iberico Ham? This particular breed, only found in Spain and Portugal has unexpected benefits for your health.</p>
		<div class="text-center">
			<a href="/iberico-ham" class="btn btn-primary">Read More</a>
        </div>
    </div>

    <div class="col-sm-6">
        <h4 class="header4"></h4>
		<a href="/paella-fish-stock"><img class="img-responsive center-block" alt="paella fish stock" src="/images/blog/fish-stock.jpg" /></a>
		<h2 class="header2"><a href="/paella-fish-stock">How to Make Fish Stock</a></h2>
		<p>Finally, we publish our recipe of fish stock, key ingredient in an excellent mixed paella.</p>
		<div class="text-center">
			<a href="/paella-fish-stock" class="btn btn-primary">Read More</a>
        </div>
    </div>

</div>



	</div>
</div>


@stop