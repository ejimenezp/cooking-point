@extends('masterlayout')

@section('title', 'Blog')
@section('description', 'Blog about Spanish food, recipes, traditions and more')

@section('content')


<h1 class="header1">Blog</h1>

<div class="row justify-content-center">

    <div class="col-sm-6">
        <h4 class="header4"></h4>
		<a href="/iberico-ham"><img class="img-fluid center-block" alt="iberico pig" src="/images/blog/iberico-pig.jpg" /></a>
		<h2 class="header2"><a href="/iberico-ham">What Is Iberico Ham?</a></h2>
		<p>What makes so special the Iberico Ham? This particular breed, only found in Spain and Portugal has unexpected benefits for your health.</p>
		<div class="text-center">
			<a href="/iberico-ham" class="btn btn-primary">Read More</a>
        </div>
    </div>

    <div class="col-sm-6">
        <h4 class="header4"></h4>
		<a href="/paella-fish-stock"><img class="img-fluid center-block" alt="paella fish stock" src="/images/blog/fish-stock.jpg" /></a>
		<h2 class="header2"><a href="/paella-fish-stock">How to Make Fish Stock</a></h2>
		<p>Finally, we publish our recipe of fish stock, key ingredient in an excellent mixed paella.</p>
		<div class="text-center">
			<a href="/paella-fish-stock" class="btn btn-primary">Read More</a>
        </div>
    </div>

</div>

<div class="row justify-content-center">

    <div class="col-sm-6">
        <h4 class="header4"></h4>
		<a href="/protected-designation-of-origin"><img class="img-fluid center-block" alt="protected designation of origin label" src="/images/blog/dop-label.jpg" /></a>
		<h2 class="header2"><a href="/protected-designation-of-origin">Protected Designation of Origin (PDO)</a></h2>
		<p>The Protected Designation of Origin symbol certifies where foodstuff has been grown and/or produced to avoid couterfeits and deliver to customers the excellence of European foodstuff production.</p>
		<div class="text-center">
			<a href="/protected-designation-of-origin" class="btn btn-primary">Read More</a>
        </div>
    </div>

    <div class="col-sm-6">
        <h4 class="header4"></h4>
		<a href="/spanish-potato-omelet"><img class="img-fluid center-block" alt="Spanish Potato Omelet" src="/images/blog/spanish-omelet-at-cooking-point.jpg" /></a>
		<h2 class="header2"><a href="/spanish-potato-omelet">Tortilla de Patatas</a></h2>
		<p>All you should know about Tortilla: recipe, customs, history, best tortillas in Madrid, ...</p>
		<div class="text-center">
			<a href="/spanish-potato-omelet" class="btn btn-primary">Read More</a>
        </div>
    </div>
</div>

@stop