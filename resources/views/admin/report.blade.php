@extends('admin.adminmasterlayout')

@section('title',  $title )

@section('content')

<div class="row">
	<div class="col-sm-offset-1 col-sm-10">
		<h1 class="header1">{{ $title }}</h1>
		<form id="csv_form" method="post" action="{{ app('request')->input('id') }}">
			{{ csrf_field() }}
			<input type="hidden" name="start_date" value="{{ app('request')->input('start_date') }}" >
			<input type="hidden" name="end_date" value="{{ app('request')->input('end_date') }}" >
			<input type="hidden" name="output" value="csv" >
		    <button class="ir btn btn-default" href="javascript:history.back()">Atrás</button>
		    <button type="submit" class='btn btn-primary'>Descargar</button>

			<table class='table'>
			    <thead>
			      <tr>
					@foreach($headers as $header)
						<th> {{$header}} </th>
					@endforeach		
			      </tr>
			    </thead>
				<tbody>
					@foreach($lines as $line)
						<tr>
							@php
								 $line_array = get_object_vars($line);
							@endphp

							@if (isset($line_array))
								<td>{{ current($line_array) }}</td>					
							@endif

							@while(array_shift($line_array) )
								<td>{{ current($line_array) }}</td>
							@endwhile
						</tr>
					@endforeach				
				</tbody>
			</table>
			
		    <button class="ir btn btn-default" href="javascript:history.back()">Atrás</button>
		    <button type="submit" class='btn btn-primary'>Descargar</button>
		</form>
	</div>

</div>

@stop
{{-- @section('modals')
	@include('admin.modals')
@stop --}}

@section('js')
	<script async src="/js/report.js"></script>
@stop

