<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Requests;

use App\ProductMaster;
use App\Sales;
use Log;

use App\Http\Controllers\WalletController;

class ShopController extends Controller
{

    public function create (Request $request)
    {
        $h = new Sales;
        $description = '';

        $h->fecha = $request->fecha;
        $h->total = $request->total;
        $h->staff = $request->staff;
        $h->pago = $request->pago;
        $h->anulado = false;

        $i = 0;
        $h->base4 = $h->base10 = $h->base21 = $h->base0 = 0;
        $h->iva4 = $h->iva10 = $h->iva21 = $h->iva0 = 0;


        foreach($request->articulos as $articulo) {
            $item = ProductMaster::find($articulo['id']);
            $itemBase = $item->price / (1 + $item->iva / 100);
            $itemIva = $item->price - $itemBase;
            switch ($item['iva']) {
                case 4:
                    $h->base4 += $itemBase;
                    $h->iva4 += $itemIva;
                    break;
                
                case 10:
                    $h->base10 += $itemBase;
                    $h->iva10 += $itemIva;
                    break;

                case 0: // para tips
                    $h->base0 += $itemBase;
                    $h->iva0 += $itemIva;
                    break;

                default:
                    $h->base4 += $itemBase;
                    $h->iva4 += $itemIva;
                    break;
                }
            $h->{"linea".$i} = $item->description;
            $description .= $item->description . ', ';
            $i++;
        }
        $description = substr($description, 0, -2); // remove last comma
        $h->save();

        if ($request->pago == 'cash') {
            WalletController::createFromSale($h, $description);            
        }
    }

    public function retrieve ($id) {
        return Sales::find($id);
    }

    public function retrieveTicketList ($date)
    {
        return Sales::where('fecha', $date)->where('anulado', false)->orderBy('id', 'desc')->get();
    }

    public function update (Request $request)
    {
        return 'in progress';
    }

    public function destroy (Request $request)
    {
        Sales::where('id', $request->id)->update(['anulado' => true]);
        WalletController::destroySale($request->id);
    }

    public function retrieveMaster () {
        return ProductMaster::where('visible', 1)->get();
    }

}
