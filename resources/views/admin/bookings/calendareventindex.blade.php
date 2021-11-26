@extends('admin.adminmasterlayout')
@section('title', 'Main - Admin Cooking Point')
@section('description', 'Calendar Event Index')
@php
$ddate =date_create($date);
$prev_date = date_format(date_modify($ddate,"-1 day"), "Y-m-d");
$next_date = date_format(date_modify($ddate,"+2 days"), "Y-m-d");
$today = date_format(date_create(), "Y-m-d");
@endphp
@section('content')
<div class="admin row justify-content-center">
	<div class="col-md-6 col-xl-4">
		<div id="admindatepicker"></div>
	</div>
	<div class="col-md-6">
		<h1>{{ date_format(date_create($date), 'l, j F') }}</h1>
		<form class="text-center" method="get">
			<button class="btn btn-primary" type="submit" formaction="{{ $prev_date }}">
				<<</button> <button class="btn btn-primary" type="submit" formaction="{{ $today }}">Hoy
			</button>
			<button class="btn btn-primary" type="submit" formaction="{{ $next_date }}">>></button>
		</form>
		<table class="table table-hover" id="calendarevent_table">
			<thead>
				<tr>
					<th>Hora</th>
					<th>Tipo</th>
					<th>Chef</th>
					<th>Pax</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($calendarevents as $ce)
				<tr onclick='window.location.href="{{ '/admin/adminbookings/calendarevent/' . $ce->id }}";'>
					<td>{{ $ce->time }}</td>
					<td>{{ $ce->type }}</td>
					<td>{{ $ce->staff->name }}</td>
					<td>{{ $ce->registered }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@if (app('request')->input('user_role') >= 3)
		<button class="btn btn-primary button_calendarevent_edit" data-i="-1">Nuevo Evento</button>
		@endif
	</div>
</div>
@stop
@section('js')
@stop
