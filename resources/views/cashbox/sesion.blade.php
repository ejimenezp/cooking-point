@extends('admin.adminmasterlayout')

@section('title', 'Sesion Caja')
@section('description', 'Sesion de caja')

@section('content')

<style>
	.header1 {margin-top: 0.5rem;}
	ul, .indent { margin-left: 20px;
		list-style-type: square; }
</style>

<div class="admin" >
	<h1 class="header1"><span id="cabecera"></span></h1>
	<div id="sesion-page" class="row justify-content-center">
		<input type="hidden" name="sesion_id" value="{{ $id }}">

		<div class="col-md-3">
	    <div class="list-group">
				<div class="list-group-item enlace" section="resumen">Resumen</div>
				<div class="list-group-item enlace" section="anadir-compras">Añadir compras</div>
				<div class="list-group-item enlace" section="anadir-ventas">Añadir ventas</div>
<!-- 				<div class="list-group-item enlace" section="green">Añadir ajuste</div>
 -->				<div class="list-group-item enlace" section="contar-efectivo-inicial">Contar efectivo (apertura)</div>
				<div class="list-group-item enlace" section="contar-efectivo-final">Contar efectivo (cierre)</div>
				<div class="list-group-item enlace" section="cerrar-sesion">Cerrar sesión</div>
				<div class="list-group-item enlace" section="eliminar-sesion">Eliminar sesión</div>
<!-- 				<div class="list-group-item" id="boton-recalcular-caja">Recalcular caja</div>
 -->	    </div>      		
		</div>

		<div id="main-section" class="col-md-9">
			<div id="resumen">
				<h1 class="header1">Resumen</h1>
				<p>Operaciones de caja registradas en esta sesión:</p>
		    <table id="tabla-movimientos" class="table" style="display:none;">
			    <thead>
			      <tr>
			        <th>Descripción</th>
			        <th>Importe</th>
			        <th>Saldo</th>
			        <th>Descuadre</th>
			        <th>Desc. acumulado</th>
			        <th></th>
			      </tr>
			    </thead>
			      <tbody>
			      </tbody>
		    </table>
		    <p>
		    </p>
		    <button class="btn btn-primary boton-vuelta-caja">Vuelta a Sesiones de caja</button>

			</div>
			<div id="anadir-compras" style="display:none;">
				<h1 class="header1">Añadir Compras</h1>
				<p>Aquí se añaden todas las salidas de efectivo de la caja. Eso incluye las compras o pagos de los que no tengamos ticket.</p> 
					<ul>
						<li>Selecciona el comercio de la lista y importe pagado en efectivo.</li>
						<li>Si no hay ticket, desmarca la casilla correspondiente.</li>
					</ul>
					<p></p>

				<table id="tabla-compras"><tr>
					<td>
						<select id="select-compras"></select>
					</td>
					<td>
						<input name="descripcion" value="texto alternativo">
					</td>
					<td>
						<input name="importe" value="0">
					</td>
					<td>
						Ticket? <input type="checkbox" name="ticket_id" checked="checked" value="1">
					</td>					
					<td>
						<button class="btn btn-primary" id="boton-anadir-compras">Añadir</button>
					</td>	
					</tr></table>
			    <p>
			    </p>
			    <button class="btn btn-default mostrar-resumen" >Cancelar</button>

			</div>	

			<div id="anadir-ventas" style="display:none;">
				<h1 class="header1">Añadir ventas</h1>
				<p>Aquí se añaden todas las ventas en efectivo, de la tienda, clases, eventos,...</p>
				<p>Desde aquí, las ventas de la tienda pagadas en efectivo:</p>
				<table class="indent" id="tabla-ventas-tienda">
					<tr>
					<td>
						<select id="select-ventas-tienda"></select>
					</td>				
					<td>
						<button class="btn btn-primary" id="boton-anadir-ventas-tienda">Añadir</button>
					</td>	
					</tr>
				</table>
				<p></p>
				<p>Desde aquí, otras entradas de dinero (clases, garantías,...):</p>
				<table class="indent" id="tabla-ventas">
					<tr>
					<td>
						<select id="select-ventas"></select>
					</td>
					<td>
						<input name="descripcion" value="texto alternativo">
					</td>
					<td>
						<input name="importe" value="0">
					</td>			
					<td>
						<button class="btn btn-primary" id="boton-anadir-ventas">Añadir</button>
					</td>	
					</tr>
				</table>
			    <p>
			    </p>
			    <button class="btn btn-default mostrar-resumen" >Cancelar</button>	
			</div>	

			<div id="contar-efectivo-inicial" style="display:none;">
				<h1 class="header1">Efectivo en la apertura de caja</h1>
				<p>Cuenta bien el efectivo que hay en la caja antes de hacer cualquier operación.</p>
				<ul style="list-style-type: square;"><li>Si hay desfase con el saldo de la sesión anterior, será responsabilidad de la persona que hizo caja antes que tú.</li>
				</ul>
				<p></p>

				<div class="col-md-10">
					<table id="tabla-efectivo-inicial">
						<tr>
							<td style="width: 10%;text-align: center;">
								200 € 
							</td>
							<td style="width: 10%;">
								<input data-val="200" value="">	
							</td>
							<td style="width: 10%;text-align: center;">
								100 € 
							</td>
							<td style="width: 10%;">
								<input data-val="100" value="">	
							</td>
							<td style="width: 10%;text-align: center;">
								50 € 
							</td>
							<td style="width: 10%;">
								<input data-val="50" value="">	
							</td>
						</tr>
						<tr>
							<td style="width: 10%;text-align: center;">
								20 € 
							</td>
							<td style="width: 10%;">
								<input data-val="20" value="">	
							</td>
							<td style="width: 10%;text-align: center;">
								10 € 
							</td>
							<td style="width: 10%;">
								<input data-val="10" value="">	
							</td>
							<td style="width: 10%;text-align: center;">
								5 € 
							</td>
							<td style="width: 10%;">
								<input data-val="5" value="">	
							</td>
						</tr>
						<tr>
							<td style="width: 10%;text-align: center;">
								2 € 
							</td>
							<td style="width: 10%;">
								<input data-val="2" value="">	
							</td>
							<td style="width: 10%;text-align: center;">
								1 € 
							</td>
							<td style="width: 10%;">
								<input data-val="1" value="">	
							</td>
						</tr>
						<tr>
							<td style="width: 10%;text-align: center;">
								50 cent. 
							</td>
							<td style="width: 10%;">
								<input data-val="0.5" value="">	
							</td>
							<td style="width: 10%;text-align: center;">
								20 cent.
							</td>
							<td style="width: 10%;">
								<input data-val="0.2" value="">	
							</td>
							<td style="width: 10%;text-align: center;">
								10 cent.
							</td>
							<td style="width: 10%;">
								<input data-val="0.1" value="">	
							</td>
						</tr>
						<tr>
							<td style="width: 10%;text-align: center;">
								5 cent. 
							</td>
							<td style="width: 10%;">
								<input data-val="0.05" value="">	
							</td>
							<td style="width: 10%;text-align: center;">
								2 cent.
							</td>
							<td style="width: 10%;">
								<input data-val="0.02" value="">	
							</td>
							<td style="width: 10%;text-align: center;">
								1 cent.
							</td>
							<td style="width: 10%;">
								<input data-val="0.1" value="">	
							</td>
						</tr>
					</table>
					<p></p>
					<table>
						<tr>
						<td>
							Resultado (puedes cambiarlo a mano):
						</td>
						<td>
							<input name="importe" value="0">
						</td>				
						<td>
							<button class="btn btn-primary" id="boton-contar-efectivo-inicial">Añadir</button>
						</td>	
						</tr>
					</table>
				</div>
					
				
			    <p></p>
			    <button class="btn btn-default mostrar-resumen" >Cancelar</button>
			</div>


			<div id="contar-efectivo-final" style="display:none;">
				<h1 class="header1">Efectivo al cierre caja</h1>
				<p>Cuenta bien el efectivo e introduce el importe aquí antes de cerrar la sesión.</p>
				<ul>
					<li>Si en la columna <strong>Descuadre</strong> aparece un importe, por favor chequea dónde puede estar las diferencias (importes incorrectos, faltan operaciones por anotar...).</li>
					<li>Puedes añadir o borrar operaciones en cualquier momento, así como cambiar el importe que has contado (si hubiera algún error).</li>
				</ul>
				<p></p>

				<p></p>

				<div class="col-md-10">
					<table id="tabla-efectivo-final">
						<tr>
							<td style="width: 10%;text-align: center;">
								200 € 
							</td>
							<td style="width: 10%;">
								<input data-val="200" value="">	
							</td>
							<td style="width: 10%;text-align: center;">
								100 € 
							</td>
							<td style="width: 10%;">
								<input data-val="100" value="">	
							</td>
							<td style="width: 10%;text-align: center;">
								50 € 
							</td>
							<td style="width: 10%;">
								<input data-val="50" value="">	
							</td>
						</tr>
						<tr>
							<td style="width: 10%;text-align: center;">
								20 € 
							</td>
							<td style="width: 10%;">
								<input data-val="20" value="">	
							</td>
							<td style="width: 10%;text-align: center;">
								10 € 
							</td>
							<td style="width: 10%;">
								<input data-val="10" value="">	
							</td>
							<td style="width: 10%;text-align: center;">
								5 € 
							</td>
							<td style="width: 10%;">
								<input data-val="5" value="">	
							</td>
						</tr>
						<tr>
							<td style="width: 10%;text-align: center;">
								2 € 
							</td>
							<td style="width: 10%;">
								<input data-val="2" value="">	
							</td>
							<td style="width: 10%;text-align: center;">
								1 € 
							</td>
							<td style="width: 10%;">
								<input data-val="1" value="">	
							</td>
						</tr>
						<tr>
							<td style="width: 10%;text-align: center;">
								50 cent. 
							</td>
							<td style="width: 10%;">
								<input data-val="0.5" value="">	
							</td>
							<td style="width: 10%;text-align: center;">
								20 cent.
							</td>
							<td style="width: 10%;">
								<input data-val="0.2" value="">	
							</td>
							<td style="width: 10%;text-align: center;">
								10 cent.
							</td>
							<td style="width: 10%;">
								<input data-val="0.1" value="">	
							</td>
						</tr>
						<tr>
							<td style="width: 10%;text-align: center;">
								5 cent. 
							</td>
							<td style="width: 10%;">
								<input data-val="0.05" value="">	
							</td>
							<td style="width: 10%;text-align: center;">
								2 cent.
							</td>
							<td style="width: 10%;">
								<input data-val="0.02" value="">	
							</td>
							<td style="width: 10%;text-align: center;">
								1 cent.
							</td>
							<td style="width: 10%;">
								<input data-val="0.1" value="">	
							</td>
						</tr>
					</table>
					<p></p>
					<table>
						<tr>
						<td>
							Resultado (puedes cambiarlo a mano):
						</td>
						<td>
							<input name="importe" value="0">
						</td>				
						<td>
							<button class="btn btn-primary" id="boton-contar-efectivo-final">Añadir</button>
						</td>	
						</tr>
					</table>
				</div>
			</div>

			<div id="cerrar-sesion" style="display:none;">
				<h1 class="header1">Cerrar sesión</h1>
				<p>Si no has contado el efectivo antes del cierre, por favor, hazlo ahora.</p>
				<p>Si ya está todo contado y anotado, confirma la acción pulsando "Cerrar Sesión"</p>

			    </p>
			    <button class="btn btn-default mostrar-resumen" >Cancelar</button>&nbsp;<button class="btn btn-primary" id="boton-cerrar-sesion" >Cerrar sesión</button>
			</div>

			<div id="eliminar-sesion" style="display:none;">
				<h1 class="header1">Eliminar sesión</h1>
				<p></p>
				<p>Solo se pueden eliminar sesiones abiertas. Si estás segura/o de ello, confirma la acción pulsando "Eliminar Sesión"</p>

			    </p>
			    <button class="btn btn-default mostrar-resumen" >Cancelar</button>&nbsp;<button class="btn btn-primary" id="boton-eliminar-sesion" >Eliminar sesión</button>
			</div>
				
		</div>
	</div>
</div>

@section('modals')
	@include('cashbox.modals')
@stop

@section('js')
<script async src="/js/cashbox.js"></script>
@stop

@stop
