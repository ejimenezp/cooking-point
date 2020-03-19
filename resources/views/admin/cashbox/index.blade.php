@extends('admin.adminmasterlayout') 
 
@section('title', 'Cashbox')
@section('description', 'Gestión de caja de Cooking Point')

@section('content')

<style>
    .header1 {margin-top: 0.5rem;}
    ul, .indent { margin-left: 20px;
        list-style-type: square; }
</style>

<div id="cashbox-index-page" class="admin justify-content-center">
    <div class="class-md-12">
        <h1 class="header1">Sesiones de caja</h1>
        <ul>
            <li>Las celdas resaltadas significan que no se contó el dinero en el momento de apertura o cierre de la caja.</li>
            <li>Puede haber varias sesiones por día.</li>
            <li>Si se te olvidó incluir una operación y la sesión está cerrada, crea otra sesión.</li>
        </ul>
        <p></p>
        <table id="sesiones" class="table table-hover table-sm">
        <thead>
          <tr>
            <th>#</th>
            <th>Fecha</th>
            <th>Usuario</th>
            <th>Estado</th>
            <th style="text-align:right">Efectivo Inicial</th>
            <th style="text-align:right">Ventas</th>
            <th style="text-align:right">Compras</th>
            <!-- <th style="text-align:right">Ajustes</th> -->
            <th style="text-align:right">Efectivo Final</th>
            <th style="text-align:right" data-toggle="tooltip" title="Diferencia entre el efectivo inicial y el efectivo final de la sesión anterior">Descuadre con sesión anterior <i class="far fa-question-circle"></i></th>
            <th style="text-align:right" data-toggle="tooltip" title="Diferencia entre el efectivo final y el saldo teórico (efectivo inicial + ventas - compras)">Descuadre en esta sesión <i class="far fa-question-circle"></i></th>
            <th style="text-align:right" data-toggle="tooltip" title="Descuadre acumulado desde el último ajuste. Negativo (-) si hay menos dinero en caja que el saldo teórico">Descuadre acumulado <i class="far fa-question-circle"></i></th>
            <th style="text-align:right" data-toggle="tooltip" title="Para eliminar descuadres manualmente (solo admin)">Ajustes <i class="far fa-question-circle"></i></th>
            <th></th>
          </tr>
        </thead>
          <tbody>
        </tbody>
        </table>
    </div>
</div>

<div class="row justify-content-center">
  <button id="boton-nueva-sesion" class="btn btn-primary">Nueva</button>
  &nbsp;&nbsp;&nbsp;
  <button id="boton-pagina-mas" class="btn btn-primary">Página +</button>
  &nbsp;&nbsp;&nbsp;
  <button id="boton-pagina-menos" class="btn btn-primary">Página -</button>
</div>

@stop

@section('modals')
    @include('admin.cashbox.modals')
@stop

@section('js')
    <script async src="{{ mix('/js/admin/cashbox.js') }}"></script>
@stop
