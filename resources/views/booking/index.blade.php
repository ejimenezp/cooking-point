@extends('masterlayout')

@section('title', 'Booking')
@section('description', 'Cooking Point booking form. Pay online and get instant confirmation.')

@section('analytics-ecommerce-tracking')
	@php 
		$bkg = json_decode($param)
	@endphp
	@if (isset($bkg->tpv_result) && $bkg->tpv_result === 'OK' && $bkg->calendarevent->bookable_by_clients)
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

@if (App::environment() == 'production')
	<script type="text/javascript">
		if (typeof window.__REACT_DEVTOOLS_GLOBAL_HOOK__ === 'object') {
		  console.log('en produccion')
		   __REACT_DEVTOOLS_GLOBAL_HOOK__.inject = function() {}
		}
	</script>
@endif

@stop
