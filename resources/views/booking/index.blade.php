@extends('masterlayout')

@section('title', 'Booking')
@section('description', 'Cooking Point booking form. Pay online and get instant confirmation.')
@section('sidebar', 'no')

@section('analytics-ecommerce-tracking')
	@if ($tpv_result === 'OK' && ($bkg->calendarevent->type === 'PAELLA' || $bkg->calendarevent->type === 'TAPAS'))
	<!-- ecommerce tracking snippet -->
	ga('require', 'ec')
	@if ($bkg->adult)
	ga('ec:addProduct', {
	  'id': "{{ $bkg->calendarevent->type }}" ,
	  'name': "{{ $bkg->calendarevent->type }}",
	  'variant': 'adult',
	  'quantity': {{ $bkg->adult }}
	})
	@endif
	@if ($bkg->child)
	ga('ec:addProduct', {
	  'id': "{{ $bkg->calendarevent->type }}" ,
	  'name': "{{ $bkg->calendarevent->type }}",
	  'variant': 'child',
	  'quantity': {{ $bkg->child }}
	})
	@endif
	ga('ec:setAction', 'purchase', {
			id: "{{$bkg->locator}}",
			revenue: "{{ round($bkg->price/1.21 , 2) }}"
	})
	<!-- End ecommerce snippet -->
	@endif
@stop

@section('adwords-event-snippet')
	@if ($tpv_result === 'OK')
	<!-- Event snippet for reservar conversion page -->
	<script>
	  gtag('event', 'conversion', {
	      'send_to': 'AW-985592263/mDIBCN3enHcQx-P71QM',
	      'value': {{ round($bkg->price/1.21 , 2) }},
	      'currency': 'EUR',
	      'transaction_id': "{{$bkg->locator}}"
	  });
	</script>
	<!-- End event snippet -->
	@endif
@stop

@section('content')

<div class="row">
	<div id="booking_steps" class="col-12">

		<div id="step1" class="d-none">
			<h1 class="header1">Booking: Availability</h1>

			<p>Select number of guests and desired class to check availability</p>
			<div class="row justify-content-center">
				<div class="col" style="padding-left: 0px;">
					<div class="online" id="bookingdatepicker"></div>
				</div>
				<div class="col" style="padding-left: 0px;">
					<form id="booking_form_1">
					<input type="hidden" name="source_id" value="2">
					@if (isset($bkg))
						<input type="hidden" name="status" value="{{ $bkg->status }}">
						<input type="hidden" name="locator" value="{{ $bkg->locator }}">
					@else
						<input type="hidden" name="status" value="PENDING">
						<input type="hidden" name="locator" value="">
					@endif				
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
							<td class="bold">
								Date:
							</td>
							<td>
								<div class="dateshown"></div>
							</td>
						</tr>
						<tr>					
							<td class="bold">
								Adults:
							</td>
							<td>
							@if (isset($bkg) && $bkg->fixed_date)
								<select name="adult">
									<option value="{{ $bkg->adult }}">{{ $bkg->adult }}</option>
								</select>
							@else
								<select name="adult">
									<option value="0" selected="selected">0</option>
									@for ($i = 1; $i <= 8; $i++)
									<option value="{{ $i }}">{{ $i }}</option>
									@endfor
									<option value="-1" disabled>9+ please contact</option>
								</select>
							@endif											
							</td>
						</tr>
						<tr>
							<td class="bold">
								Children:&nbsp;
							</td>
							<td>
							@if (isset($bkg) && $bkg->fixed_date)
								<select name="child">
									<option value="{{ $bkg->child }}">{{ $bkg->child }}</option>
								</select>
							@else
								<select name="child">
									@for ($i = 0; $i <= 4; $i++)
									<option value="{{ $i }}">{{ $i }}</option>
									@endfor
									<option value="-1" disabled>5+ please contact</option>
								</select>
							@endif
							</td>
						</tr>
						<tr>
							<td class="bold">
								Class:
							</td>
							<td>
								<select name="type">
								@if (isset($class) && $class == 'PAELLA') 
									<option value="PAELLA" selected="selected">Paella Cooking Class</option>
								@else
									<option value="PAELLA">Paella Cooking Class</option>
								@endif
								@if (isset($class) && $class == 'TAPAS') 
									<option value="TAPAS" selected="selected">Tapas Cooking Class</option>
								@else
									<option value="TAPAS">Tapas Cooking Class</option>
								@endif
								</select>				
							</td>
						</tr>
						<tr>
							<td class="bold">
								Price:
							</td>
							<td>
								€<span class="priceshown"></span>
							</td>
						</tr>
					</table>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="text-center">
						@if (isset($bkg) && $bkg->status != 'PENDING') 
							<a id="button_booking_help" class="btn btn-link">Help</a>
							<a href="#step4" class="step cancel btn btn-default">Cancel</a>
							<a href="#step4" class="update_class btn btn-primary">Update Booking</a>
						@else
							<a id="button_booking_help" class="btn btn-link">Help</a>
							<a class="booking_retrieve btn btn-default">Use Booking #</a>
							<a href="#step2" class="update_class btn btn-primary" checkout="checkout">Checkout</a>
						@endif
						<p></p>
					</div>
				</div>
			</div>
		</div>

		<div id="step2" class="d-none">
			<div class="row justify-content-left">
				<div class="col-sm-12">		
					<h1 class="header1">Booking: Checkout</h1>
					<p>You are about to book the following class:</p>
					<div class="row ">
						<div class="col-sm-5">
							<table class="voucher-table">
								<tbody>
									<tr>
										<td class="bold">
											Class:
										</td>
										<td>
											<div class="typeshown"></div>
										</td>
									</tr>
									<tr>
										<td class="bold">
											Date:
										</td>
										<td>
											<div class="dateshown"></div>
										</td>
									</tr>

									<tr>
										<td class="bold">
											Time:
										</td>
										<td>
											<div class="timeshown"></div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-sm-2">
							<table class="voucher-table">
								<tbody>
									<tr>					
										<td class="bold">
											Adults:
										</td>
										<td>
											<div class="adultshown"></div>
										</td>
									</tr>
									<tr>
										<td class="bold">
											Children:&nbsp;
										</td>
										<td>
											<div class="childshown"></div>

										</td>
									</tr>
									<tr>
										<td class="bold">
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
				<div class="col-sm-12">		
					<br/>
					<p>Please, enter your contact info:   <small>(<span style="color:red">*</span> = mandatory)</small></p>
					<div class="row justify-content-center">
						<div class="col">
							<form id="booking_form_2">
							<table class="availability-table">
								<tbody>
									<tr>
										<td class="bold availability-row">
											Name <span class="mandatory">*</span> :
										</td>
										<td>
											<input name="name" type="text" value="" >
										</td>
									</tr>
									<tr>
										<td class="bold availability-row">
											E-mail <span class="mandatory">*</span> :
										</td>
										<td>
											<input name="email" type="text" value="" >
										</td>
									</tr>
									<tr>
										<td class="bold availability-row">
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
						<div class="col">
							<form id="booking_form_3">				
							<table class="availability-table">
								<tbody>
									<tr>
										<td class="bold" style="width: 30%">
											Food Restrictions:
										</td>
										<td>
											<textarea name="food_requirements"></textarea>
										</td>
									</tr>
									<tr>
										<td class="bold">
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
				<div class="col-sm-12">
					<div class="text-center">
						@if (isset($bkg) && $bkg->status != 'PENDING')
							<a href="#step4" class="step cancel btn btn-default" >Cancel</a>
							<a href="#step4" class="step update_contact btn btn-primary">Update Booking</a>
						@elseif (isset($bkg) && $bkg->fixed_date)
							<a class="btn btn-primary" id="button_purchase" >Purchase</a>
						@else
							<a href="#step1" class="step btn btn-default">Change Class/Date</a>
							<a class="btn btn-primary" id="button_purchase" >Purchase</a>			
						@endif
						<p></p>
					</div>
				</div>
			</div>
		</div>

		<div id="step4" class="d-none" data-tpv_result="{{ $tpv_result }}">
			<h1 class="header1">Booking: Voucher</h1>
			<div class='step4_voucher'>
				<div class="row">
					<div class="col-sm-5">
						<table class="voucher-table">
							<tbody>
								<tr>
									<td class="bold">
										Class:
									</td>
									<td>
										<div class="typeshown"></div>
									</td>
								</tr>
								<tr>
									<td class="bold">
										Date:
									</td>
									<td>
										<div class="dateshown"></div>
									</td>
								</tr>

								<tr>
									<td class="bold">
										Time:
									</td>
									<td>
										<div class="timeshown"></div>
									</td>
								</tr>
								<tr>
									<td class="bold">
										Booking #:
									</td>
									<td>
										<div class="locatorshown"></div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-sm-7">
						<table class="voucher-table">
							<tbody>
								<tr>					
									<td class="bold">
										Adults:
									</td>
									<td>
										<div class="adultshown"></div>
									</td>
								</tr>
								<tr>
									<td class="bold">
										Children:
									</td>
									<td>
										<div class="childshown"></div>

									</td>
								</tr>
								<tr>
									<td class="bold">
										Price:
									</td>
									<td>
										€<span class="priceshown"></span>
									</td>
								</tr>
								<tr>
									<td class="bold">
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
					<div class="col-sm-5">
						<table class="voucher-table">
							<tbody>
								<tr>
									<td class="bold">
										Name:
									</td>
									<td>
										<div class="nameshown"></div>
									</td>
								</tr>
								<tr>
									<td class="bold">
										E-mail:
									</td>
									<td>
										<div class="emailshown"></div>
									</td>
								</tr>
								<tr>
									<td class="bold">
										Phone:
									</td>
									<td>
										<div class="phoneshown"></div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>				
					<div class="col-sm-7">
						<table class="voucher-table">
							<tbody>
								<tr>
									<td class="bold align-top">
										Food Restrictions:
									</td>
									<td>
										<div class="foodshown"></div>
									</td>
								</tr>
								<tr>
									<td class="bold align-top">
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
				<div class="col-sm-12">
					<div class="text-center">
						<a id="button_booking_forget" class="btn btn-link">New Booking</a>
						<a id="button_booking_edit" class="btn btn-primary">Edit Booking</a>
						<a id="button_print_voucher" class="btn btn-primary">Print Voucher</a>
						<a id="button_email_voucher" class="btn btn-primary">E-mail Voucher</a>
						<p></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="d-none">
	<div id="printer" class="col-sm-12">
		<div class="row justify-content-center">
			<div class="divider"></div>
			<div class="divider"></div>
			<div class="text-center">
				<img alt="Cooking Point logo" src="/images/cookingpoint_logox75.png" />				
				<div class="divider"></div>
				<p class="header1 text-center">Cooking Point Voucher</p>
			</div>
			<div id="printer_voucher"></div>

			<div class="divider"></div>

			<p><span class="header2">Meeting Point</span><br/>
			Cooking Point<br/>
			Calle de Moratin, 11 28014 Madrid<br/>
			tel. (+34) 910 115 154<br /><br /></p>
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
	<script async src="{{ mix('/js/booking.js') }}"></script>
@stop
