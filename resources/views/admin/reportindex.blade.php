@extends('admin.adminmasterlayout')

@section('title', 'Reports - Admin Cooking Point')
@section('description', 'Cooking Point Reports')

@section('content')

<div class="row">
	<div class="col-sm-offset-2 col-sm-6">
		<form id="report_form" method='post'>
			{{ csrf_field() }}
			<table class='table'>
				<tr class="booking_date_input">
					<td>
						Inicio:
					</td>
					<td>
						<input type="text" id="startdatepicker">
						<input type="hidden" name="start_date" id="start" >

					</td>
				</tr>
				<tr class="booking_date_input">
					<td>
						Fin:
					</td>
					<td>
						<input type="text" id="enddatepicker">
						<input type="hidden" name="end_date" id="end" >

					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						@if (app('request')->input('user_role') >= 3)
						<ul>
							<li>Clientes
							<ol>
								<li><div class='report' report_id='vclientes'>Detalle Ventas</div></li>
								<li><div class='report' report_id='kpiclientes'>KPI</div></li>
							</ol></li>
							<li>Tienda
							<ol>
								<li><div class='report' report_id='vtienda'>Ventas</div></li>
							</ol></li>
						</ul>
						@endif						
						@if (app('request')->input('user_role') >= 2)
						<ul>
							<li>Turnos
							<ol>
								<li><div class='report' report_id='turnos'>Detalle</div></li>
							</ol>
							</li>
						</ul>
						@endif						

					</td>
				</tr>
			</table>
		</form>


	</div>

</div>

@stop
{{-- @section('modals')
	@include('admin.modals')
@stop --}}

@section('js')
	<script async src="/js/report.js"></script>
@stop

