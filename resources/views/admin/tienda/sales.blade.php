@extends('admin.adminmasterlayout') 
 
@section('title', 'Sales')
@section('description', 'Cooking Point Shop Sales')

@section('content')

<div class="admin row justify-content-center">
    <div class="col-sm-6">
        <input type="hidden" name="date" id="realDate">
        <input type="text" name="pretty_date" id="admindatepicker">
    </div>
    <div class="col-sm-6">
		<div class="btn btn-sm btn-secondary cambio-pagina" data-pagina="/admin/tienda">back</div>
    </div>
</div>

<div class="admin row justify-content-center">
	<div class="col-12">
		<h1>Sales</h1>

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

		<div class="btn btn-sm btn-secondary cambio-pagina" data-pagina="/admin/tienda">back</div>

	</div>
</div>
@stop

@section('js')
<script defer type='text/javascript' src="/js/admin/tienda.js"></script>
@stop
