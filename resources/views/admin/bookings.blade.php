@extends('admin.adminmasterlayout')
@section('title', 'Main - Admin Cooking Point')
@section('description', 'Cooking Point Admin Main Page')
@section('content')
<div class="admin row justify-content-center">
	<div class="col-md-6 col-xl-4">
		<div id="admindatepicker"></div>
	</div>
	<div class="col-md-6">
		<div id="main-section">
			<div id="calendarevent_index" style="display:none;">
				<div class="text-center">
					<form>
						<button class="button_day_selector btn btn-primary" data-d="prev">
							<<</button> <button class="button_day_selector btn btn-primary" data-d="today">Hoy
						</button>
						<button class="button_day_selector btn btn-primary" data-d="next">>></button>
					</form>
				</div>
				<h1>
					<div class="dateshown"></div>
				</h1>
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
					</tbody>
				</table>
				@if (app('request')->input('user_role') >= 3)
				<button class="btn btn-primary button_calendarevent_edit" data-i="-1">Nuevo Evento</button>
				@endif
				<div class="gutter"></div>
			</div>
			@if (app('request')->input('user_role') >= 3)
			<div id="calendarevent_edit" style="display:none;">
				<h1>Editar Evento</h1>
				<form id="form_calendarevent" class="form-horizontal" role="form" onsubmit="return false;">
					{{ csrf_field() }}
					<input name="id" type="hidden" value="9999">
					<table id="ce" class="table">
						<tr>
							<td>
								Fecha:
							</td>
							<td>
								<input type="text" id="eventdatepicker">
								<input type="hidden" name="date" id="realDate">
							</td>
						</tr>
						<tr>
							<td>
								Tipo:
							</td>
							<td>
								<select name="type" id="eventtypelist">
								</select>
							</td>
						</tr>
						<tr>
							<td>
								Cocinero/a:
							</td>
							<td>
								<select name="staff_id" class="cooklist">
								</select>
							</td>
						</tr>
						<tr>
							<td>
								Ayudante:
							</td>
							<td>
								<select name="secondstaff_id" class="cooklist">
								</select>
							</td>
						</tr>
						<tr>
							<td>
								Descripción:
							</td>
							<td>
								<input name="short_description" type="text" value="">
							</td>
						</tr>
						<tr>
							<td>
								Hora:
							</td>
							<td>
								<select name="time">
									<option value="07:00:00">7:00am</option>
									<option value="07:30:00">7:30am</option>
									<option value="08:00:00">8:00am</option>
									<option value="08:30:00">8:30am</option>
									<option value="09:00:00">9:00am</option>
									<option value="09:30:00">9:30am</option>
									<option value="10:00:00">10:00am</option>
									<option value="10:30:00">10:30am</option>
									<option value="11:00:00">11:00am</option>
									<option value="11:30:00">11:30am</option>
									<option value="12:00:00">12:00pm</option>
									<option value="12:30:00">12:30pm</option>
									<option value="13:00:00">1:00pm</option>
									<option value="13:30:00">1:30pm</option>
									<option value="14:00:00">2:00pm</option>
									<option value="14:30:00">2:30pm</option>
									<option value="15:00:00">3:00pm</option>
									<option value="15:30:00">3:30pm</option>
									<option value="16:00:00">4:00pm</option>
									<option value="16:30:00">4:30pm</option>
									<option value="17:00:00">5:00pm</option>
									<option value="17:30:00">5:30pm</option>
									<option value="18:00:00">6:00pm</option>
									<option value="18:30:00">6:30pm</option>
									<option value="19:00:00">7:00pm</option>
									<option value="19:30:00">7:30pm</option>
									<option value="20:00:00">8:00pm</option>
									<option value="20:30:00">8:30pm</option>
									<option value="21:00:00">9:00pm</option>
									<option value="21:30:00">9:30pm</option>
									<option value="22:00:00">10:00pm</option>
									<option value="22:30:00">10:30pm</option>
									<option value="23:00:00">11:00pm</option>
									<option value="23:30:00">11:30pm</option>
									<option value="00:00:00">12:00am</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								Duración:
							</td>
							<td>
								<select name="duration">
									<option value="01:00:00">1 hora</option>
									<option value="01:30:00">1,5 horas</option>
									<option value="02:00:00">2 horas</option>
									<option value="02:30:00">2,5 horas</option>
									<option value="03:00:00">3 horas</option>
									<option value="03:30:00">3,5 horas</option>
									<option value="04:00:00">4 horas</option>
									<option value="05:00:00">5 horas</option>
									<option value="00:00:00">día completo</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								Capacidad:
							</td>
							<td>
								<input name="capacity" type="text" value="12">
							</td>
						</tr>
						<tr>
							<td>
								Invitación:
							</td>
							<td>
								<input name="invitation_link" type="text">
							</td>
						</tr>
						<tr>
							<td>
								+ info:
							</td>
							<td>
								<textarea name="info"></textarea>
							</td>
						</tr>
					</table>
					<button id="button_calendarevent_close" class="btn btn-secondary">Cerrar</button>
					<button id="button_calendarevent_delete" class="btn btn-secondary">Eliminar</button>
					<button id="button_calendarevent_save" class="btn btn-primary">Guardar</button>
				</form>
				<div class="gutter"></div>
			</div>
			@endif
			@if (app('request')->input('user_role') >= 2)
			<div id="booking_index" style="display:none;">
				<div class=" text-center">
					<form>
						<button class="button_calendarevent_selector btn btn-primary" data-d="prev">
							<<</button> <button class="button_calendarevent_selector btn btn-primary" data-d="now">Ahora
						</button>
						<button class="button_calendarevent_selector btn btn-primary" data-d="next">>></button>
					</form>
				</div>
				<h1>
					<div class="dateshown"></div>
				</h1>
				<h4>
					<div class="classshown"></div>
				</h4>
				<table class="table table-hover" id="booking_table">
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
					</tbody>
				</table>
				<button class="btn btn-primary button_booking_edit" data-j="-1">Nueva Reserva</button>
				<button class="btn btn-secondary toggle_datepicker">Ver Calendario</button>
<!-- 				<form style="display: inline;" id="layout" method="post" action="layout">
					@csrf
					<input type="hidden" type="text" name="calendarevent_id">
					<button type="submit" class="btn btn-primary">Colocación</button>
				</form> -->
				<div class="gutter"></div>
			</div>
			<div id="booking_edit" style="display:none;">
				<h1>Editar Reserva</h1>
				<h4>
					<div class="dateshown"></div>
					<div class="classshown"></div>
				</h4>
				<form id="form_booking" class="form-horizontal" role="form" onsubmit="return false;">
					{{ csrf_field() }}
					<input name="id" type="hidden" value="9999">
					<input name="locator" type="hidden" value="AAA000">
					<input name="status_filter" type="hidden" value="">
					<input name="calendarevent_id" type="hidden" value="9999">
					<input name="onlineclass" type="hidden" value="0">
					<input name="tz" type="hidden" value="">
					<table id="booking" class="table">
						<tr>
							<td>
								Nombre:
							</td>
							<td>
								<input name="name" type="text" value="">
							</td>
						</tr>
						<tr>
							<td>
								Fuente:
							</td>
							<td>
								<select id="sourcelist" name="source_id">
								</select>
							</td>
						</tr>
						<tr>
							<td>
								Estado:
							</td>
							<td>
								<select name="status">
									<option value="PAID">PAID</option>
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
								<input name="phone" type="text" value="">
							</td>
						</tr>
						<tr>
							<td>
								Email:
							</td>
							<td>
								<input name="email" type="text" value="">
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
						<tr class='details d-none'>
							<td>
								Referencia:
							</td>
							<td>
								<input name="locator" style="width:50%;" type="text" value="">&nbsp
								<button id="button_booking_copy" class="btn btn-primary btn-sm">Copiar</button>
							</td>
						</tr>
						<tr class='details d-none'>
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
						<tr class='details d-none'>
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
						<tr class='details d-none'>
							<td>
								Fecha pago:
							</td>
							<td>
								<input name="payment_date" type="text" value="">
							</td>
						</tr>
						<tr class="price details d-none">
							<td>
								Precio:
							</td>
							<td>
								<input type="text" name="price">
							</td>
						</tr>
						@if (app('request')->input('user_role') >= 3)
						<tr class='details d-none'>
							<td>
								IVA:
							</td>
							<td>
								<input type="checkbox" name="iva">
							</td>
						</tr>
						<tr class='details d-none'>
							<td>
								Ocultar precio:
							</td>
							<td>
								<input type="checkbox" name="hide_price" value="1">
							</td>
						</tr>
						<tr class='details d-none'>
							<td>
								Fecha fija:
							</td>
							<td>
								<input type="checkbox" name="fixed_date">
							</td>
						</tr>
						<tr class='details d-none'>
							<td>
								Factura:
							</td>
							<td>
								<input type="text" name="invoice" value="">
							</td>
						</tr>
						@else
						<input type="hidden" name="iva">
						<input type="hidden" name="hide_price">
						<input type="hidden" name="fixed_date">
						<input type="hidden" name="invoice">
						@endif
						<tr class="booking_date_input details d-none">
							<td>
								Fecha:
							</td>
							<td>
								<input type="text" id="booking_date_edit">
								<input type="hidden" name="date" id="bookingNewDate">
							</td>
						</tr>
						<tr class="booking_date_input details d-none">
							<td>
								Evento:
							</td>
							<td>
								<select id="dayeventlist" name="type">
								</select>
							</td>
						</tr>
					</table>
					<button id="button_booking_close" class="btn btn-secondary">Cerrar</button>
					<button id="button_booking_delete" class="btn btn-secondary">Eliminar</button>
					<button id="button_booking_save" class="btn btn-primary">Guardar</button>
					<button id="button_booking_emailit" class="btn btn-secondary">Enviar email</button>
					<button id="button_booking_details" class="btn btn-secondary">+Details</button>
				</form>
				<div class="gutter"></div>
			</div>
			@endif
		</div>
	</div>
</div>

@stop

@section('js')
<script defer type='text/javascript' src="/js/admin/bookings.js"></script>
@stop
