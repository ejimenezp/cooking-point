@extends('admin.adminmasterlayout')
@section('title', 'Booking Edit')
@section('description', 'Booking Edit')
@php
@endphp
@section('content')
<div class="admin row justify-content-center">
	<div class="col-md-6 col-xl-4">
		<div id="admindatepicker"></div>
	</div>
	<div class="col-md-6">
		<h1>
			{{ date_format(date_create($bkg->calendarevent->date), 'l, j F') }}
		</h1>
		<h4>
			{{ substr($bkg->calendarevent->time, 0, 5) . ' ' . $bkg->calendarevent->type . ' (' . $bkg->calendarevent->staff->name . ') Conf ' . $bkg->calendarevent->registered . ' Disp ' . $bkg->calendarevent->availablecovid }}
		</h4>

				<form id="form_booking" class="form-horizontal" method="post">
					@csrf
					<input name="id" type="hidden" value="{{ $bkg->id }}">
					<input name="status_filter" type="hidden" value="{{ $bkg->status_filter }}">
					<input name="calendarevent_id" type="hidden" value="{{ $bkg->calendarevent_id }}">
					<input name="onlineclass" type="hidden" value="{{ $bkg->onlineclass }}">
					<input name="tz" type="hidden" value="{{ $bkg->tz }}">					
					<table id="booking" class="table">
						<tr>
							<td>
								Nombre:
							</td>
							<td>
								<input name="name" type="text" value="{{ $bkg->name }}">
							</td>
						</tr>
						<tr>
							<td>
								Fuente:
							</td>
							<td>
								<select id="sourcelist" name="source_id">
								@foreach($sources as $source)
									@if($bkg->source_id == $source->id)
        						<option value="{{ $source->id }}" selected> {{ $source->name }}</option>
        					@else 
        						<option value="{{ $source->id }}"> {{ $source->name }}</option>
        					@endif
        				@endforeach
								</select>
							</td>
						</tr>
						<tr>
							<td>
								Estado:
							</td>
							<td>
								<select name="status" value="{{ $bkg->status }}" > 
									<option value="PAID" selected>PAID</option>
									<option value="CONFIRMED">CONFIRMED</option>
									<option value="PAY-ON-ARRIVAL">PAY-ON-ARRIVAL</option>
									<option value="PENDING">PENDING</option>
									<option value="CANCELED">CANCELED</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								Teléfono:
							</td>
							<td>
								<input name="phone" type="text" value="{{ $bkg->phone }}">
							</td>
						</tr>
						<tr>
							<td>
								Email:
							</td>
							<td>
								<input name="email" type="text" value="{{ $bkg->email }}">
							</td>
						</tr>
						<tr>
							<td>
								Adultos:
							</td>
							<td>
								<select name="adult">
									@for ($i = 1; $i <= 24; $i++) <option value="{{ $i }}">{{ $i }}</option>
										@endfor
										<option value="0">0</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								Niños:
							</td>
							<td>
								<select name="child">
									@for ($i = 0; $i <= 24; $i++) <option value="{{ $i }}">{{ $i }}</option>
										@endfor
								</select>
							</td>
						</tr>
						<tr>
							<td>
								Alergias:
							</td>
							<td>
								<textarea name="food_requirements"></textarea>
							</td>
						</tr>
						<tr>
							<td>
								Comentarios:
							</td>
							<td>
								<textarea name="comments"></textarea>
							</td>
						</tr>
						<tr class='details'>
							<td>
								Referencia:
							</td>
							<td>
								<input name="locator" style="width:50%;" type="text" value="{{ $bkg->locator }}">&nbsp
								<button id="button_booking_copy" class="btn btn-primary btn-sm">Copiar</button>
							</td>
						</tr>
						<tr class='details'>
							<td>
								Seguimiento:
							</td>
							<td>
								<select name="crm">
									<option value="YES">SÍ</option>
									<option value="NO">NO MOLESTAR</option>
									<option value="PAYMENT_KO">FALLO PAGO TARJETA</option>
									<option value="REMINDED">ENVIADO RECORDATORIO</option>
									<option value="REVIEW_ASKED">SOLICITADA REVIEW</option>
								</select>
							</td>
						</tr>
						<tr class='details'>
							<td>
								Forma de pago:
							</td>
							<td>
								<select name="pay_method">
									<option value="ONLINE">ONLINE</option>
									<option value="CARD">TARJETA</option>
									<option value="CASH">EFECTIVO</option>
									<option value="TRANSFER">TRANSFERENCIA</option>
									<option value="PAYPAL">PAYPAL</option>
									<option value="N/A">(no aplica)</option>
								</select>
							</td>
						</tr>
						<tr class='details'>
							<td>
								Fecha pago:
							</td>
							<td>
								<input name="payment_date" type="text" value="{{ $bkg->payment_date }}">
							</td>
						</tr>
						<tr class="price details">
							<td>
								Precio:
							</td>
							<td>
								<input type="text" name="price" value="{{ $bkg->price }}">
							</td>
						</tr>
						<tr class='details'>
							<td>
								IVA:
							</td>
							<td>
								<input type="checkbox" name="iva" value="{{ $bkg->iva }}">
							</td>
						</tr>
						<tr class='details'>
							<td>
								Ocultar precio:
							</td>
							<td>
								<input type="checkbox" name="hide_price" value="{{ $bkg->hide_price }}">
							</td>
						</tr>
						<tr class='details'>
							<td>
								Fecha fija:
							</td>
							<td>
								<input type="checkbox" name="fixed_date" value="{{ $bkg->hide_date }}">
							</td>
						</tr>
						<tr class='details'>
							<td>
								Factura:
							</td>
							<td>
								<input type="text" name="invoice" value="{{ $bkg->invoice }}">
							</td>
						</tr>
						<tr class="booking_date_input details ">
							<td>
								Fecha:
							</td>
							<td>
								<input type="text" id="booking_date_edit">
								<input type="hidden" name="date" id="bookingNewDate">
							</td>
						</tr>
						<tr class="booking_date_input details ">
							<td>
								Evento:
							</td>
							<td>
								<select id="dayeventlist" name="type">
								</select>
							</td>
						</tr>
					</table>
					<button class="btn btn-secondary" method="get" formaction="{{ '/admin/adminbookings/calendarevent/' . $bkg->calendarevent->id }}";>Cerrar</button>
					<button id="button_booking_delete" class="btn btn-secondary">Eliminar</button>
					<button class="btn btn-primary" type="submit" formaction="{{ '/admin/adminbookings/booking/' . $bkg->id }}">Guardar</button>
					<button id="button_booking_emailit" class="btn btn-secondary">Enviar email</button>
					<button id="button_booking_details" class="btn btn-secondary">+Details</button>
				</form>

	</div>
</div>
@stop
@section('js')
@stop
