<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Requests;

use App\TiendaArticulo;
use App\TiendaVentas;
use Log;

class TicketsController extends Controller
{
    public function front()
    {
    	$articulos = TiendaArticulo::where('visible', true)->orderBy('display_order')->get();
    	return view('tienda.frontend')->with('articulos', $articulos);
    }

    public function getTickets (Request $request)
    {
        return TiendaVentas::where('fecha', $request->date)->where('anulado', false)->get();
    }

    public function deleteticket (Request $request)
    {
    	TiendaVentas::where('id', $request->id)->update(['anulado' => true]);
    	return view('tienda.sales')->with('date', $request->date);
    }

    public function addticket (Request $request)
    {

    	$h = new TiendaVentas;

    	$h->fecha = $request->date;
    	$h->total = $request->total;
        $h->staff_id = $request->cpuser;
	    $h->base4 = $request->base4;
	    $h->iva4 = $request->iva4;
        $h->base10 = $request->base10;
        $h->iva10 = $request->iva10;
        $h->base21 = $request->base21;
        $h->iva21 = $request->iva21;
    	$h->pago = $request->pago;
    	$h->anulado = false;

    	$i = 0;
    	while (isset($request->articulos[$i])) {
    		$h->{"linea".$i} = $request->articulos[$i];
    		$i++;
    	}

    	$h->save();

    	return $h->id;
    }
}
