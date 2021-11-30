@extends('admin.adminmasterlayout')
@section('title', 'Main - Admin Cooking Point')
@section('description', 'Booking Index')
@php
@endphp
@section('content')
<div class="admin row justify-content-center">
	<div class="col-md-6 col-xl-4">
		<div id="admindatepicker"></div>
	</div>
	<div class="col-md-6">
		<h1>
			{{ date_format(date_create($ce->date), 'l, j F') }}
		</h1>
		<form class="text-center" method="get">
			<button class="button_calendarevent_selector btn btn-primary" data-d="prev">
				<<</button> <button class="button_calendarevent_selector btn btn-primary" data-d="now">Ahora
			</button>
			<button class="button_calendarevent_selector btn btn-primary" data-d="next">>></button>
		</form>


		<h4>
			{{ substr($ce->time, 0, 5) . ' ' . $ce->type . ' (' . $ce->staff->name . ') Conf ' . $ce->registered . ' Disp ' . $ce->availablecovid }}
		</h4>
		<table class="" id="">
			<thead>
				<tr>
					<th>Pax</th>
					<th>Nombre</th>
					<th>Status</th>
					<th>Alergias</th>
					<th>Coment.</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($ce->bookings as $bkg)
				<tr onclick='window.location.href="{{ '/admin/adminbookings/booking/' . $bkg->id }}";'>
					<td>@if ($bkg->children > 0) {{ $bkg->adult . '+' . $bkg->children }} @else {{ $bkg->adult }} @endif </td>
					<td>{{ $bkg->name }}</td>
					<td>{{ $bkg->status }}</td>
					<td>{{ $bkg->food_requirements }}</td>
					<td>{{ $bkg->comments }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<button class="btn btn-primary button_booking_edit" data-j="-1">Nueva Reserva</button>
		<button class="btn btn-secondary toggle_datepicker">Ver Calendario</button>
		<form style="display: inline;" id="layout" method="post" action="layout">
			@csrf
			<input type="hidden" type="text" name="calendarevent_id">
			<button type="submit" class="btn btn-primary">Colocación</button>
		</form>
		<div class="gutter"></div>
	</div>
</div>
@stop
@section('js')
@stop
