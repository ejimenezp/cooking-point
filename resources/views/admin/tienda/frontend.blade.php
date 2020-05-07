@extends('admin.adminmasterlayout') 
 
@section('title', 'Cooking Point Shop')
@section('description', 'Cooking Point Shop Page')

@section('content')

<div class="admin row justify-content-center">
    <div class="col-sm-6">
        <input type="hidden" name="date" id="realDate">
        <input type="text" name="pretty_date" id="admindatepicker">
    </div>
    <div class="col-sm-6">
        <div class="btn btn-sm btn-secondary" id="boton-limpiar">Clean Ticket</div>
        <div class="btn btn-sm btn-primary cambio-pagina" data-pagina="/admin/tienda/tickets">View Sales</div>
    </div>
</div>

<div class="admin row justify-content-center">

 	<div class="col-sm-6">
<?php
$seccion = "";
foreach ($articulos as $articulo) {
    if ($articulo['seccion'] != $seccion) {
        $seccion = $articulo['seccion'];
        echo '<h1>'. $seccion . '</h1>';                
    }
    echo '<div class="btn btn-secondary boton-tienda articulo" data-id="'. $articulo['id'] .
    '" data-nombre="'. htmlspecialchars($articulo['nombre']) .
    '" data-pvp="'. $articulo['pvp'] .
    '" data-iva="'. $articulo['iva'] . '">'. 
    $articulo['nombre'] . '</div>';
}
?>

	</div>
		<div class="col-sm-6">
        <h1>Ticket</h1>
        <div class="screen">
            <table id="screen_table">
                <thead><tr><th>Product</th><th class="text-right">Price</th></tr></thead>
                <tbody><tr><td></td><td></td></tr></tbody>                        
                <tfoot><tr><td>Total (€)</td><td class="text-right"><span class="total">0</span></td></tr></tfoot>
            </table>
        </div>

        <div class="d-none">
            <div id="receipt">
                <table>
                    <tr>
                        <td><img src="/images/cookingpoint_printer.jpg"></td>
                        <td style="padding-left:30px;line-height: 1.1rem;">Cooking Point, S.L.<br/>
                        C/ Moratín, 11<br/>
                        28014 Madrid (SPAIN)<br/>
                        NIF: B86615143<br/>
                        cookingpoint.es</td>
                    </tr>
                </table>
                

                <p style="margin-bottom:0px"><br/><strong>Ticket #: <span id="ticket_id">--</span> &nbsp; Date: <span id="pretty_date"></span></strong></p>
                 
                <table id="items_table">
                    <thead><tr><th>Product</th><th class="text-right">Price</th></tr></thead>
                    <tbody><tr><td></td><td></td></tr></tbody>                        
                    <tfoot><tr><td>Total (€)</td><td class="text-right"><span class="total">0</span></td></tr></tfoot>
                </table>

                <p style="margin-bottom:0px"><br/><strong>Value Added Tax (IVA)</strong></p>
                <table id="tax_table">
                    <thead>
                        <tr><th>Base (€)</th><th>Rate (%)</th><th>Tax (€)</th></tr>
                    </thead>
                    <tbody>
                        <tr><td></td><td></td><td></td></tr>
                    </tbody>
                </table>

                <p class="text-center"><br/>Paid: <span id="forma_pago"></span></p>
                <p class="text-center"><img src="/images/tripadvisor_printer.jpg"></p>
                <p class="text-center">Thank You!!<br/><br/>.</p>
            </div>
        </div>
        <div class="btn btn-lg btn-primary boton-tienda pagar" data-pago="cash">Pay Cash</div>
        <div class="btn btn-lg btn-danger boton-tienda pagar" data-pago="credit card">Pay Card</div>
	</div>   		
    		
</div>

@stop

@section('js')
<script defer type='text/javascript' src="/js/admin/tienda.js"></script>
@stop


