<?php

namespace App\Http\Controllers\Cashbox;

use Illuminate\Http\Request;
use Log;
use Carbon\Carbon;
use App\Http\Controllers\Controller;


// use App\Http\Requests;

use App\Cashbox\Sesion;
use App\Cashbox\Movimiento;
use App\Cashbox\Concepto;
use App\TiendaVentas;

class MovimientoController extends Controller 
{

    //
    //
    // añade un movimiento a sesion
    //      datos del movimiento
    //
    function crear(Request $request)
    {
        $sesion = Sesion::find($request->sesion_id);
        $sesion->movimientos()->create([
            'tipo' => $request->tipo,
            'descripcion' => $request->descripcion,
            'importe' => $request->importe,
            'ticket_tienda' => $request->ticket_tienda ? $request->ticket_tienda : 0,
            'ticket' => $request->ticket === 'true' 
        ]);
        $sesion->push();
        $sesion->recalcular();
    }




    //
    //
    // borrar un movimiento
    // 
    //
    function eliminar ($id)
    {
        $mov = Movimiento::find($id);
        $sesion = $mov->sesion;
        $mov->delete();
        $sesion->recalcular();
    }




    //
    //
    // devuelve los tickets (ids) de los últimos meses que todavía no aparezcan en ninguna 
    // sesión
    // 
    //
    function getTickets ($id)
    {
        $sesion = Sesion::find($id);
    	$fecha_sesion = new Carbon($sesion->fecha);
    	$meses_atras = Carbon::now()->addWeeks(-40);
    	$tickets_usados = Movimiento::where('ticket_tienda', '!=', 0)->pluck('ticket_tienda')->toArray();
        return TiendaVentas::whereBetween('fecha', [$meses_atras->toDateString(), $fecha_sesion->toDateString()])->where('anulado', false)->where('pago', 'cash')->whereNotIn('id', $tickets_usados)->get();
    }


    //
    //
    // devuelve la lista de conceptos para mostrarlos en los <select>
    // 
    //
	function getConceptos()
	{
		return Concepto::orderBy('orden', 'asc')->get();
	}


}

