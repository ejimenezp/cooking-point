@extends('tienda.masterlayout') 
 
@section('title', 'Sales')
@section('description', 'Cooking Point Shop Sales')

@section('content')

<div class="container">

<h1 class="header1">Sales</h1>

<table id="ticket_table" class="table table-hover ">
	<thead>
		<tr>
			<th>#</th>
			<th>Date</th>
			<th>Total</th>
			<th>Pay</th>
			<th>Who</th>
			<th>Item 1</th>
			<th>Item 2</th>
			<th>Item 3</th>
			<th>Item 4</th>
			<th>More?</th>
		</tr>
	</thead>
		<tbody>
		</tbody>
</table>
<p></p>

<div class="btn btn-sm btn-primary cambio-pagina" data-pagina="/tienda">back</div>

</div>
@stop


