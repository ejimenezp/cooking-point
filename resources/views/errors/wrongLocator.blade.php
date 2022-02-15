@extends('masterlayout')

@section('title', 'Spanish Cooking Classes in Madrid, Spain')
@section('description', 'Spanish cooking classes everyday in Madrid. Cooking classes on paella and tapas in English in select culinary school in Spain')

@section('content')

<h1>Booking Not Found</h1>
<p>Sorry, that number does not correspond to any booking. Please enter a valid one : </p>

<div class="row justify-content-center">
	<div class="col-sm-8">
		<form id="retrieve-form" action="/booking">
        <p class='font-weight-bold mb-0'>Booking # :</p>
		    <input name="locator" type="text" value="" >
		    <div class="text-center mt-3">
					<button type="submit" class="btn btn-primary">Send</button>	
		    </div>
		</form>
	</div>
</div>
@stop