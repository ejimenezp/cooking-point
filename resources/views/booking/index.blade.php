@extends('masterlayout')

@section('title', 'Booking Form for Cooking School Madrid, Spain: Spanish Cuisine Courses')
@section('description', 'Cooking courses school schedules and contact form: cooking classes calendar in madrid, Spain. Plan your cooking school vacations')

@section('content')

<div class="row">
	<div id="booking_steps" class="col-sm-12">

		<div id="step1" class="hidden">
			<h1>Booking: Availability</h1>
			<p>Select date, desired class and party size to check the availability</p>
			<div class="col-sm-6">
				<div class="online" id="bookingdatepicker"></div>
			</div>
			<div class="col-sm-6">
				<form id="booking_form_1">
				<input type="hidden" name="source_id" value="1">
				@if (isset($bkg))
					<input type="hidden" name="status_major" value="{{ $bkg->status_major }}">
					<input type="hidden" name="locator" value="{{ $bkg->locator }}">
				@else
					<input type="hidden" name="status_major" value="PENDING">
					<input type="hidden" name="locator" value="">
				@endif				
				<input type="hidden" name="status_minor" value="">
				<input type="hidden" name="pay_method" value="N/A">
				<input type="hidden" name="calendarevent_id" value="">
				<input type="hidden" name="id" value="">
				<input type="hidden" name="price" value="70">
				<input type="hidden" name="iva" value="">
				<input type="hidden" name="crm" value="">
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
							Adults:
						</td>
						<td>
							<select name="adult">
								@for ($i = 1; $i <= 8; $i++)
								<option value="{{ $i }}">{{ $i }}</option>
								@endfor
								<option value="0" disabled>+8 please contact</option>
							</select>					
						</td>
					</tr>
					<tr>
						<td class="bold">
							Children:&nbsp;
						</td>
						<td>
							<select name="child">
								@for ($i = 0; $i <= 4; $i++)
								<option value="{{ $i }}">{{ $i }}</option>
								@endfor
								<option value="0" disabled>+4 please contact</option>
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
			<div class="row">
				<div class="col-sm-12">
					<div class="text-center">
						@if (isset($bkg) && $bkg->status_major != 'PENDING') 
							<a id="button_booking_help" class="btn btn-link">Help</a>
							<a href="#step4" class="step cancel btn btn-default">Cancel</a>
							<a href="#step4" class="update_class btn btn-primary">Update Booking</a>
						@else
							<a id="button_booking_help" class="btn btn-link">Help</a>
							<a class="booking_retrieve btn btn-primary">Use Locator</a>
							<a href="#step2" class="update_class btn btn-primary" checkout="checkout">Check-out</a>
						@endif
					</div>
				</div>
			</div>
		</div>

		<div id="step2" class="hidden">
			<div class="row">
				<div class="col-sm-12">		
					<h1>Booking: Check-out</h1>
					<p>You are about to book the following activity:</p>
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
			<div class="row">
				<div class="col-sm-12">		
					<br/>
					<p>Please, enter your contact info:   <small>(<span style="color:red">*</span> = mandatory)</small></p>
					<div class="col-sm-5">
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
					<div class="col-sm-7">
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
			<div class="row">
				<div class="col-sm-12">
					<div class="text-center">
						@if (isset($bkg) && $bkg->status_major != 'PENDING')
							<a href="#step4" class="step cancel btn btn-default" >Cancel</a>
							<a href="#step4" class="step update_contact btn btn-primary">Update Booking</a>
						@else
							<a href="#step1" class="step btn btn-default">Change Class/Date</a>
							<a class="btn btn-primary" id="button_purchase" >Purchase</a>
						@endif
					</div>
				</div>
			</div>
		</div>

		<div id="step4" class="hidden" data-tpv_result="{{ $tpv_result }}">
			<h1>Booking: Voucher</h1>
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
										Locator:
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
						<a id="button_booking_edit" class="btn btn-primary">Edit Booking</a>
						<a id="button_print_voucher" class="btn btn-primary">Print Voucher</a>
						<a id="button_email_voucher" class="btn btn-primary">E-mail Voucher</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="hidden">
	<div id="printer" class="col-sm-12">
		<div class="row">
			<div class="divider"></div>
			<div class="divider"></div>
			<div class="text-center">
				 <img alt="Cooking Point logo" src="/images/cookingpoint_logox113.png" />				
				<h2>Cooking Point Voucher</h2>
			</div>
			<h1>Details</h1>
			<div id="printer_voucher"></div>
		</div>
		<div class="row">
			<h1>Meeting Point</h1>
			<p>Cooking Point<br/>
			Calle de Moratin, 11 28014 Madrid<br/>
			tel. (+34) 910 115 154<br /><br /></p>
			<img alt="Cooking Point location" src="/images/plano-email.png" />
			<div class="divider"></div>
			@if (isset($bkg))
				<p>Access/Edit this booking anytime at: cookingpoint.es/booking/{{ $bkg->locator }}</p>
			@endif
		</div>
	</div>
</div>

@section('modals')
	@include('booking.modals')
@stop

@section('js')
	<script async src="/js/booking.js"></script>
@stop
@stop