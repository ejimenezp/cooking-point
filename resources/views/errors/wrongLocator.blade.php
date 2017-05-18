@extends('masterlayout')

@section('title', 'Spanish Cooking Classes &amp; Wine Tastings in Madrid, Spain')
@section('description', 'Spanish cooking classes and wine tastings everyday in Madrid. Cooking classes on paella and tapas in English in select culinary school in Spain')

@section('content')


<div class="row">
 

<div class="col-sm-12">
	<h1 class="header1">Locator Not Found</h1>
	<p>Sorry, but that locator does not correspond to any booking. Please enter a valid locator: </p>
</div>

<div class="col-sm-6">
	<form id="retrieve-form" action="/booking">
	    <table class="availability-table">
	      <tbody>
	        <tr>
	          <td class="bold availability-row">
	            Locator:
	          </td>
	          <td>
	            <input name="locator" type="text" value="" >
	          </td>
	        </tr>
	      </tbody>
	    </table>
	    <div class="text-center">
			<button type="submit" class="btn btn-primary">Send</button>	
	    </div>
	</form>
</div>

</div>
@stop