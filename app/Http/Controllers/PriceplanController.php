<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Source;
use App\Priceplan;

class PriceplanController extends Controller
{

    function get(Request $request)
    {
        $source = Source::find($request->source_id);
        $priceplan = Priceplan::where('plan', $source->plan)->where('event_type', $request->type)->first();

        return response()->json([	'adult' => $priceplan->adult_rate,
        											'child' => $priceplan->child_rate,
                									'iva' => $source->iva]);
    }


    function exchangeratesapiid() {
    	return env('OPEN_EXCHANGE_RATES_API_ID', 'basurilla');
    }
}
