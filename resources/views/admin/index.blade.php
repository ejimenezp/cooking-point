@extends('admin.adminmasterlayout')

@section('title', 'Main - Admin Cooking Point')
@section('description', 'Cooking Point Admin Main Page')

@section('content')

<div class="row">
	<div class="col-sm-4">
		<div class="admin" id="admindatepicker"></div>
	</div>

	<div class="col-sm-8">
		<div id="calendarevent_index">
			<div class="text-center">
	            <form >
	                <button class="button_day_selector btn btn-primary" data-d="prev"><<</button>
					<button class="button_day_selector btn btn-primary" data-d="today">Hoy</button>				
	                <button class="button_day_selector btn btn-primary" data-d="next">>></button>
	            </form>
	       </div>
			<h1><div class="dateshown"></div></h1>

			<table class="table table-hover" id="calendarevent_table">
			    <thead>
			    	<tr>
			    		<th>Hora</th>
			    		<th>Tipo</th>
			    		<th>Cocinero/a</th>
			    		<th>Pax</th>
@if (app('request')->input('user_role') >= 3)
			    		<th></th>
@endif
		    		</tr>
				</thead>
			    <tbody>
			    </tbody>                        
			</table>

@if (app('request')->input('user_role') >= 3)
			<button class="btn btn-primary button_calendarevent_edit" data-i="-1">Nuevo Evento</button>	
@endif
		</div>

@if (app('request')->input('user_role') >= 3)
		<div id="calendarevent_edit">
			<h1>Editar Evento</h1>
			<form id="form_calendarevent" class="form-horizontal" role="form" onsubmit="return false;">
   				{{ csrf_field() }}
   				<input name="id" type="hidden" value="9999">
				<table id="ce" class="table">
					<tr>
						<td class="">
							Fecha:
						</td>
						<td class="value">
							<input type="text" id="eventdatepicker" >
							<input type="hidden" name="date" id="realDate" >
						</td>
					</tr>
					<tr>
						<td class="">
							Tipo:
						</td>
						<td class="value">
							<select name="type">
								<option value="PAELLA">PAELLA</option>
								<option value="TAPAS">TAPAS</option>
								<option value="GROUP">GROUP</option>
								<option value="HOLIDAY">HOLIDAY</option>
								<option value="FILLER">FILLER</option>
							</select>				
						</td>
					</tr>
					<tr>
						<td class="">
							Cocinero/a:
						</td>
						<td class="value">
							<select name="staff_id" id="cooklist">
							</select>				
						</td>
					</tr>
					<tr>
						<td class="">
							Detalles:
						</td>
						<td class="value">
							<input name="short_description" type="text" value="" >
						</td>
					</tr>
					<tr>
						<td class="">
							Confirmado:
						</td>
						<td class="value">
							<input type="checkbox" name="confirmed">
						</td>
					</tr>
					<tr>
						<td class="">
							Hora:
						</td>
						<td class="value">
							<select name="time">
								<option value="09:00:00">9:00am</option>
								<option value="09:30:00">9:30am</option>
								<option value="10:00:00">10:00am</option>
								<option value="10:30:00">10:30am</option>
								<option value="11:00:00">11:00am</option>
								<option value="11:30:00">11:30am</option>
								<option value="12:00:00">12:00pm</option>
								<option value="12:30:00">11:30pm</option>
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
							</select>
						</td>
					</tr>			
					<tr>					
						<td class="">
							Duración:
						</td>
						<td class="value">
							<select name="duration">
								<option value="01:00:00">1 hora</option>
								<option value="02:00:00">2 horas</option>
								<option value="03:00:00">3 horas</option>
								<option value="04:00:00">4 horas</option>
								<option value="05:00:00">5 horas</option>
								<option value="00:00:00">día completo</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="">
							Capacidad:
						</td>
						<td class="value">
							<input name="capacity" type="text" value="12" >
						</td>
					</tr>
				</table>

				<button id="button_calendarevent_close" class="btn btn-primary">Cerrar</button>
				<button id="button_calendarevent_delete" class="btn btn-primary">Eliminar</button>
				<button id="button_calendarevent_save" class="btn btn-primary">Guardar</button>
			</form>
		</div>
@endif

@if (app('request')->input('user_role') >= 2)
		<div id="booking_index">
			<div class=" text-center">
	            <form >
	                <button class="button_calendarevent_selector btn btn-primary" data-d="prev"><<</button>
					<button class="button_calendarevent_selector btn btn-primary" data-d="now">Ahora</button>				
	                <button class="button_calendarevent_selector btn btn-primary" data-d="next">>></button>
	            </form>
	       </div>
			<h1><div class="dateshown"></div></h1>
			<h4><div class="classshown"></div></h4>
			<table class="table table-hover" id="booking_table">
			    <thead>
			    	<tr>
			    		<th>Pax</th>
			    		<th>Nombre</th>
			    		<th>Status</th>
			    		<th>Alergias</th>
			    		<th>Comentarios</th>
		    		</tr>
				</thead>
			    <tbody>
			    </tbody>                        
			</table>

			<button class="btn btn-primary button_booking_edit" data-j="-1">Nueva Reserva</button>	
		</div>

		<div id="booking_edit">
			<h1>Editar Reserva</h1>
			<h4><div class="dateshown"></div>
			<div class="classshown"></div></h4>
			<form id="form_booking" class="form-horizontal" role="form" onsubmit="return false;">
   				{{ csrf_field() }}
   				<input name="id" type="hidden" value="9999">
   				<input name="locator" type="hidden" value="AAA000">
   				<input name="status_filter" type="hidden" value="">
   				<input name="calendarevent_id" type="hidden" value="9999">
				<table id="booking" class="table">
					<tr>
						<td class="">
							Nombre:
						</td>
						<td class="value">
							<input name="name" type="text" value="" >
						</td>
					</tr>
					<tr>
						<td class="">
							Fuente:
						</td>
						<td class="value">
							<select id="sourcelist" name="source_id">
							</select>
						</td>
					</tr>
					<tr>					
						<td class="">
							Estado:
						</td>
						<td class="value">
							<select name="status">
								<option value="PAID">PAGADA</option>
								<option value="DEPOSIT">DEPÓSITO</option>
								<option value="CONFIRMED">CONFIRMADA</option>
								<option value="GUARANTEE">GARANTÍA</option>
								<option value="PENDING">PENDIENTE PAGO</option>
								<option value="CANCELLED">CANCELADA</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="">
							Teléfono:
						</td>
						<td class="value">
							<input name="phone" type="text" value="" >
						</td>
					</tr>
					<tr>
						<td class="">
							Email:
						</td>
						<td class="value">
							<input name="email" type="text" value="" >
						</td>
					</tr>
					<tr>					
						<td class="">
							Adultos:
						</td>
						<td class="value">
							<select name="adult">
								@for ($i = 1; $i <= 24; $i++)
								<option value="{{ $i }}">{{ $i }}</option>
								@endfor
								<option value="0">0</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="">
							Niños:
						</td>
						<td class="value">
							<select name="child">
								@for ($i = 0; $i <= 24; $i++)
								<option value="{{ $i }}">{{ $i }}</option>
								@endfor
							</select>
						</td>
					</tr>
					<tr>
						<td class="">
							Alergias:
						</td>
						<td class="value">
							<textarea name="food_requirements"></textarea>
						</td>
					</tr>
					<tr>
						<td class="">
							Comentarios:
						</td>
						<td class="value">
							<textarea name="comments"></textarea>
						</td>
					</tr>
					<tr>
						<td class="">
							Referencia:
						</td>
						<td class="value">
							<input name="locator" type="text" value="" >
						</td>
					</tr>
					<tr>
						<td class="">
							Seguimiento:
						</td>
						<td class="value">
							<select name="crm">
								<option value="YES">SÍ</option>
								<option value="NO">NO MOLESTAR</option>
								<option value="REMINDED">RECORDATORIO</option>
								<option value="REVIEW_ASKED">REVIEW SOLICITADA</option>
								<option value="CLICKED_THROUGH">POSIBLE REVIEW</option>
							</select>				
						</td>
					</tr>
					<tr>
						<td class="">
							Forma de pago:
						</td>
						<td class="value">
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
					<tr>
						<td class="">
							Fecha pago (online):
						</td>
						<td class="value">
							<input name="payment_date" type="text" value="" >
						</td>			
					</tr>
					<tr class="price">
						<td class="">
							Precio:
						</td>
						<td>
							<input type="text" name="price" >
						</td>
					</tr>
					<tr class="price">
						<td class="">
							IVA:
						</td>
						<td class="value">
							<input type="checkbox" name="iva" value="1">
						</td>
					</tr>
					<tr class="price">
						<td class="">
							Ocultar precio:
						</td>
						<td class="value">
							<input type="checkbox" name="hide_price" value="1">
						</td>
					</tr>
					<tr class="booking_date_input">
						<td class="">
							Fecha:
						</td>
						<td class="value">
							<input type="text" id="booking_date_edit">
							<input type="hidden" name="date" id="bookingNewDate" >

						</td>
					</tr>
					<tr class="booking_date_input">
						<td class="">
							Evento:
						</td>
						<td class="value">
							<select id="dayeventlist" name="type">
							</select>
						</td>
					</tr>
				</table>

				<button id="button_booking_close" class="btn btn-primary">Cerrar</button>
				<button id="button_booking_delete" class="btn btn-primary">Eliminar</button>
				<button id="button_booking_save" class="btn btn-primary">Guardar</button>
			</form>
		</div>
	</div>
@endif

</div>

@section('modals')
	@include('admin.modals')
@stop

@section('js')
	{{-- <script async src="/js/calendarevent.js"></script> --}}
@stop
@stop