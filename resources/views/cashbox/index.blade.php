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
            <th>Efectivo Inicial</th>
            <th>Ventas</th>
            <th>Compras</th>
            <!-- <th>Ajustes</th> -->
            <th>Efectivo Final</th>
            <th>Descuadre</th>
            <th>Descuadre Acumulado</th>
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
    @include('cashbox.modals')
@stop

@section('js')
    <script async src="{{ mix('/js/cashbox.js') }}"></script>
@stop
