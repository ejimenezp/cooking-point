@extends('masterlayout')

@section('title', 'Booking')
@section('description', 'Cooking Point booking form. Pay online and get instant confirmation.')

@section('analytics-ecommerce-tracking')

@stop




@section('content')

<div class="row">
	<div id="BookingRoot" data="{{ $param }}"></div>
	
</div>


@stop

@section('js')
	<link rel="stylesheet" type="text/css" href="{{ mix('/css/booking.css') }}">
	<script defer src="{{ mix('/js/booking.js') }}"></script>
@stop
