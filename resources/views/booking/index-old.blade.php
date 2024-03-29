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
	<div id="booking_steps" class="col-12">

		<div id="step1" class="d-none">
			<h1>Booking</h1>

			<p>Select number of guests and class to check availability</p>
			<div class="row justify-content-center">
				<div class="col-md-4">
					<form id="booking_form_1">
					<input type="hidden" name="source_id" value="2">
					@if (isset($bkg))
						<input type="hidden" name="status" value="{{ $bkg->status }}">
						<input type="hidden" name="locator" value="{{ $bkg->locator }}">
					@else
						<input type="hidden" name="status" value="PENDING">
						<input type="hidden" name="locator" value="">
					@endif				
					@if (isset($class) && $class == 'TAPAS') 
						<input type="hidden" name="type" value="TAPAS">
						<input type="hidden" name="type_shown" value="Tapas Cooking Class">
					@else 
						<input type="hidden" name="type" value="PAELLA">
						<input type="hidden" name="type_shown" value="Paella Cooking Class">
					@endif
					<input type="hidden" name="adult" value="0">
					<input type="hidden" name="child" value="0">
					<input type="hidden" name="status_filter" value="DO_NOT_COUNT">
					<input type="hidden" name="pay_method" value="N/A">
					<input type="hidden" name="calendarevent_id" value="">
					<input type="hidden" name="id" value="">
					<input type="hidden" name="price" value="0">
					<input type="hidden" name="iva" value="1">
					<input type="hidden" name="hide_price" value="">
					<input type="hidden" name="payment_date" value="">
					<input type="hidden" name="fixed_date" value="">
					<input type="hidden" name="crm" value="YES">
					<input type="hidden" name="invoice" value="">
					<table class="availability-table">

						<tr>
							<td class="fw-bold">
								Date:
							</td>
							<td>
								<div class="dateshown"></div>
							</td>
						</tr>
						<tr>					
							<td class="fw-bold">
								Adults:
							</td>
							<td>
								<table>
									<tbody>
										<tr>
											<td></td>
											<td style='width: 40%;text-align: right;'><div id="adult-down" class="icon"><img src="/images/icons/minus.png"></div></td>
											<td style='width: 20%;text-align: center;'><div class="fake-input text-center" data="adult">0</div></td>
											<td style='width: 40%;text-align: left;'><div id="adult-up" class="icon"><img src="/images/icons/add.png"></div></td>
										</tr>
									</tbody>

								</table>

										
							</td>
						</tr>
						<tr>
							<td class="fw-bold">
								Children:&nbsp;
							</td>
							<td>
								<table>
									<tbody>
										<tr>
											<td></td>
											<td style='width: 40%;text-align: right;'><div id="child-down" class="icon"><img src="/images/icons/minus.png"></div></td>
											<td style='width: 20%;text-align: center;'><div class="fake-input text-center" data="child">0</div></td>
											<td style='width: 40%;text-align: left;'><div id="child-up" class="icon"><img src="/images/icons/add.png"></div></td>
										</tr>
									</tbody>

								</table>							
							</td>
						</tr>
						<tr>
							<td class="fw-bold">
								Class:
							</td>
							<td>
								<div class="type-dropdown-input">
									@if (isset($class) && $class == 'TAPAS') 
										<div class="fake-input" data="type">Tapas Cooking Class</div>
									@else
										<div class="fake-input" data="type">Paella Cooking Class</div>
									@endif
								  <ul id="myDropdown" class="type-dropdown-content">
								    <li id="li_paella">Paella Cooking Class</li>
								    <li id="li_tapas">Tapas Cooking Class</li>
								  </ul>
								</div>
							</td>
						</tr>
						<tr>
							<td class="fw-bold">
								Price:
							</td>
							<td>
								€<span class="priceshown"></span>
							</td>
						</tr>
					</table>
					</form>
				</div>
				<div class="col-md-4">
					<div class="online" id="bookingdatepicker"></div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="text-center">
						@if (isset($bkg) && $bkg->status != 'PENDING') 
							<button id="button_booking_help" class="btn btn-light">Help</button>
							<!-- <a href="#step4" class="step cancel btn btn-light">Cancel</a> -->
							<a href="#step4" class="update_class btn btn-primary">Update Booking</a>
						@else
							<button id="button_booking_help" class="btn btn-light">Help</button>
							<a href="#step2" class="update_class btn btn-primary" checkout="checkout">Continue</a>
						@endif
						<p></p>
					</div>
				</div>
			</div>
		</div>

		<div id="step2" class="d-none">
			<div class="row justify-content-left">
				<div class="col-12">		
					<h1>Booking</h1>
					<p>You are about to book the following class:</p>
					<div class="row ">
						<div class="col-md-5">
							<table class="voucher-table">
								<tbody>
									<tr>
										<td class="fw-bold">
											Class:
										</td>
										<td>
											<div class="typeshown"></div>
										</td>
									</tr>
									<tr>
										<td class="fw-bold">
											Date:
										</td>
										<td>
											<div class="dateshown"></div>
										</td>
									</tr>

									<tr>
										<td class="fw-bold">
											Time:
										</td>
										<td>
											<div class="timeshown"></div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-md-2">
							<table class="voucher-table">
								<tbody>
									<tr>					
										<td class="fw-bold">
											Adults:
										</td>
										<td>
											<div class="adultshown"></div>
										</td>
									</tr>
									<tr>
										<td class="fw-bold">
											Children:&nbsp;
										</td>
										<td>
											<div class="childshown"></div>

										</td>
									</tr>
									<tr>
										<td class="fw-bold">
											Price:
										</td>
										<td>
											€<span class="priceshown"></span>
										</td>
									</tr>
								</tbody>
							</table>				
						</div>						
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">		
					<br/>
					<p>Please, enter your contact info:   <small>(<span style="color:red">*</span> = mandatory)</small></p>
					<div class="row justify-content-center">
						<div class="col-md-5">
							<form id="booking_form_2">
							<table class="availability-table">
								<tbody>
									<tr>
										<td class="fw-bold">
											Name <span class="text-danger">*</span> :
										</td>
										<td>
											<input name="name" type="text" value="" >
										</td>
									</tr>
									<tr>
										<td class="fw-bold">
											E-mail <span class="text-danger">*</span> :
										</td>
										<td>
											<input name="email" type="text" value="" >
										</td>
									</tr>
									<tr>
										<td class="fw-bold">
											Phone:
										</td>
										<td>
											<input name="phone" type="text" value="" >
										</td>
									</tr>
								</tbody>
							</table>
							</form>	
						</div>				
						<div class="col-12 col-md-7">
							<form id="booking_form_3">				
							<table class="availability-table">
								<tbody>
									<tr>
										<td class="fw-bold" style="width: 30%">
											Food Restrictions:
										</td>
										<td>
											<textarea name="food_requirements"></textarea>
										</td>
									</tr>
									<tr>
										<td class="fw-bold">
											Comments:
										</td>
										<td>
											<textarea name="comments"></textarea>
										</td>
									</tr>
								</tbody>
							</table>
							</form>
							<br/>	
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="text-center">
						@if (isset($bkg) && $bkg->status != 'PENDING')
							<!-- <a href="#step4" class="step cancel btn btn-light" >Cancel</a> -->
							<a href="#step4" class="step update_contact btn btn-primary">Update Booking</a>
						@elseif (isset($bkg) && $bkg->fixed_date)
							<button class="btn btn-primary" id="button_purchase" >Checkout</button>
						@else
							<a href="#step1" class="step btn btn-light">Change Class/Date</a>
							<button class="btn btn-primary" id="button_purchase" >Checkout</button>			
						@endif
						<p></p>
					</div>
				</div>
			</div>
		</div>

		<div id="step4" class="d-none" data-tpv_result="{{ $tpv_result }}">
			<h1>Booking: Voucher</h1>
			<div class='step4_voucher'>
				<div class="row">
					<div class="col-md-5">
						<table class="voucher-table">
							<tbody>
								<tr>
									<td class="fw-bold">
										Class:
									</td>
									<td>
										<div class="typeshown"></div>
									</td>
								</tr>
								<tr>
									<td class="fw-bold">
										Date:
									</td>
									<td>
										<div class="dateshown"></div>
									</td>
								</tr>

								<tr>
									<td class="fw-bold">
										Time:
									</td>
									<td>
										<div class="timeshown"></div>
									</td>
								</tr>
								<tr>
									<td class="fw-bold">
										Booking #:
									</td>
									<td>
										<div class="locatorshown"></div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-md-7">
						<table class="voucher-table">
							<tbody>
								<tr>					
									<td class="fw-bold">
										Adults:
									</td>
									<td>
										<div class="adultshown"></div>
									</td>
								</tr>
								<tr>
									<td class="fw-bold">
										Children:
									</td>
									<td>
										<div class="childshown"></div>

									</td>
								</tr>
								<tr>
									<td class="fw-bold">
										Price:
									</td>
									<td>
										€<span class="priceshown"></span>
									</td>
								</tr>
								<tr>
									<td class="fw-bold">
										Status:
									</td>
									<td>
										<span class="statusshown"></span>
									</td>
								</tr>
							</tbody>
						</table>				
					</div>
				</div>
				<div class="row">
					<div class="divider"></div>
					<div class="col-md-5">
						<table class="voucher-table">
							<tbody>
								<tr>
									<td class="fw-bold">
										Name:
									</td>
									<td>
										<div class="nameshown"></div>
									</td>
								</tr>
								<tr>
									<td class="fw-bold">
										E-mail:
									</td>
									<td>
										<div class="emailshown"></div>
									</td>
								</tr>
								<tr>
									<td class="fw-bold">
										Phone:
									</td>
									<td>
										<div class="phoneshown"></div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>				
					<div class="col-md-7">
						<table class="voucher-table">
							<tbody>
								<tr>
									<td class="fw-bold align-top">
										Food Restrictions:
									</td>
									<td>
										<div class="foodshown"></div>
									</td>
								</tr>
								<tr>
									<td class="fw-bold align-top">
										Comments:
									</td>
									<td>
										<div class="commentsshown"></div>
									</td>
								</tr>
							</tbody>
						</table>
						<br/>	
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="text-center">
						<button id="button_booking_forget" class="btn btn-light">New Booking</button>
						<button id="button_booking_edit" class="btn btn-primary">Edit Booking</button>
						<button id="button_print_voucher" class="btn btn-primary">Print Voucher</button>
						<button id="button_email_voucher" class="btn btn-primary">E-mail Voucher</button>
						<p></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="d-none">
	<div id="printer" class="d-print-block row justify-content-center">
		<div class="col-md-10 d-print-block">
			<div class="divider"></div>
			<div class="divider"></div>
			<div class="text-center">
				<img class="lazyload" alt="Cooking Point logo" data-src="/images/cookingpoint_logox75.png" />				
				<div class="divider"></div>
				<p class="header1 text-center">Cooking Point Voucher</p>
			</div>
			<div id="printer_voucher"></div>

			<div class="divider"></div>

			<div>Meeting Point</div>
			Cooking Point<br/>
			Calle de Moratin, 11 28014 Madrid<br/>
			tel. (+34) 910 115 154<br />
			Metro Anton Martin (Line 1), exit Calle de Amor de Dios<br /><br /></p>
			<img class="rounded mx-auto d-block" alt="Cooking Point location" src="/images/plano-email.png" />
			<div class="divider"></div>
			
			@if (isset($bkg))
				<p>Access/Edit this booking anytime at: cookingpoint.es/booking/{{ $bkg->locator }}</p>
			@endif
		</div>
	</div>
</div>

@stop

@section('modals')
	@include('booking.modals')
@stop

@section('js')
	<link rel="stylesheet" type="text/css" href="{{ mix('/css/booking.css') }}">
	<script defer src="{{ mix('/js/booking.js') }}"></script>
	<script defer src="{{ mix('/js/booking-step1.js') }}"></script>
@stop
