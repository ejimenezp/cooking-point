@extends('masterlayout')

@section('title', 'Booking')
@section('description', 'Cooking Point booking form. Pay online and get instant confirmation.')

@section('analytics-ecommerce-tracking')
	@if ($tpv_result === 'OK' && ($bkg->calendarevent->type === 'PAELLA' || $bkg->calendarevent->type === 'TAPAS'))
		<script>
		window.dataLayer = window.dataLayer || [];
		dataLayer.push({
		 'transactionId': '{{$bkg->locator}}',
		 'transactionTotal': {{ round($bkg->price/1.21 , 2) }}, 
		 'transactionProducts': [{
		   'name': '{{ $bkg->calendarevent->type }}',
		   'sku': '{{ $bkg->calendarevent->type }}',
		   'price': {{ round($bkg->price/1.21 , 2) }},  
		   'quantity':  1
		 }]
		});
		</script>
	@endif
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
