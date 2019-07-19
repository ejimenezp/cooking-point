<?php

namespace App\Http\Controllers\Cashbox;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Log;
use Carbon\Carbon;


// use App\Http\Requests;

use App\Cashbox\Sesion;
use App\Cashbox\Movimiento;

class SesionController extends Controller
{

	//
	//
	// función crear sesion,la fecha marcará el orden de las sesiones y 
	// se usará para los saldos iniciales, etc
	//		fecha
	//		usuario
	// 
	//
	function crear(Request $request)
	{
		$nueva = new Sesion();
		$nueva->fecha = $request->fecha;
        $nueva->usuario = $request->usuario;
        $siguiente = Sesion::whereDate('fecha' , '>=', $request->fecha)->orderBy('fecha', 'asc')->first();
        if ($siguiente) {
            $nueva->sesion_siguiente = $siguiente->id;
        } else {
            $nueva->sesion_siguiente = 0;
        }
        $anterior = Sesion::whereDate('fecha' , '<=', $request->fecha)->orderBy('fecha', 'desc')->first();
        $nueva->sesion_anterior = $anterior->id;

        if ($anterior->estado == 'ABIERTA') {
            $anterior->estado = 'CERRADA';
        }
		$nueva->estado = 'ABIERTA';
        $nueva->saldo_sesion = $anterior->saldo_sesion;
        $nueva->efectivo_sesion = $nueva->efectivo_sesion_al_inicio = $anterior->efectivo_sesion;
        $nueva->descuadre_acumulado = $anterior->descuadre_acumulado;

		$nueva->save();
        $anterior->sesion_siguiente = $nueva->id;
        $anterior->save();

        return $nueva->id;

	}



    //
    //
    // devuelve tabla con detalles de las operaciones para mostrarse en pantalla
    // 
    //
    function detalles($id)
    {
        $sesion = Sesion::find($id);
        return $sesion->detalles(); 
    }

	//
	//
	// función recalcular la caja por haber modificado alguna sesión
	//		sesion_id - la sesión desde la que se empieza a calcular
	// 
	//
	function recalcularCaja($id)
	{
		$sesion = Sesion::find($id);
		do {
			$sesion->recalcular();
            $id = $sesion->sesion_siguiente;
            $sesion = Sesion::find($id);
		}
		while ($sesion);
	}

    //
    //
    // devuelve una sesión completa, con sus movimientos
    // 	 session_id 
    //
    function get($id)
    {
    	return Sesion::find($id)->load('movimientos');
    }

    //
    //
    // devuelve la tabla resumen de las sesiones
    // (más adelante, añadiremos intervalos)
    //
    function getLista(Request $request)
    {
        $tabla = [];
        $contador_sesiones = 9; // +1 sesiones a devolver en la tabla

        $sesion = Sesion::find($request->comienzo);
        if (!$sesion) {
            $sesion = Sesion::orderBy('fecha', 'desc')->first();
        }

        if ($request->direccion == 'asc') {
            do {
                array_push($tabla, $sesion->toArray());
                $id = $sesion->sesion_siguiente;
                $sesion = Sesion::find($id);
            } while ($sesion && $contador_sesiones--);             
        } else {  // descending
            do {
                array_unshift($tabla, $sesion->toArray());
                $id = $sesion->sesion_anterior;
                $sesion = Sesion::find($id);
            } while ($sesion && $contador_sesiones--);
        }
        return $tabla;
    }

    //
    //
    // actualiza el valor del efectivo inicial después de contarlo 
    //
    //
    function setEfectivoInicial(Request $request)
    {
        $sesion = Sesion::find($request->sesion_id);
        $sesion->efectivo_inicial = $request->importe;
        $sesion->recalcular();
    }

    //
    //
    // actualiza el valor del efectivo final después de contarlo 
    //
    //
    function setEfectivoFinal(Request $request)
    {
        $sesion = Sesion::find($request->sesion_id);
        $sesion->efectivo_final = $request->importe;
        $sesion->recalcular();
    }

    //
    //
    // cerrar sesión 
    //
    //
    function cerrar($id)
    {
        $sesion = Sesion::find($id);
        $sesion->estado = 'CERRADA';
        $sesion->save();
    }

    //
    //
    // eliminar sesión. Elimina también los movimientos asociados a la misma
    //
    //
    function eliminar($id)
    {
        $sesion = Sesion::find($id);
        if ($sesion->estado == 'CERRADA') {
            return response()->json('No se pueden eliminar sesiones cerradas', 350);
        }
        $sesion->movimientos()->delete();
        $sesion->delete();
    }

    //
    //
    // devuelve la última sesión creada
    //
    //
    function getUltimaAbierta()
    {
        return Sesion::where('estado', 'ABIERTA')->orderBy('fecha', 'desc')->first();
    }



}

