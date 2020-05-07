<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Requests;

use App\Booking;
use App\Http\Controllers\TPVControllerStub;
use Cookie;
use Log;

use \DateTimeZone;
use \DateTime;

class TPVStub extends Controller
{

 	public function main (Request $request)
  {
  	return view('tpv.tpv-stub', ['Ds_MerchantParameters' => $request->Ds_MerchantParameters]);
  }

 	public function reply (Request $request)
 	{
 		Log::info('en reply el request es:');
 		Log::info($request);

 		$d = new DateTime();
 		$req = Request::create($request->callback, 'POST', [
	    'Ds_Response' => $request->DS_Response,
	    'Ds_MerchantData' => $request->Ds_MerchantData,
	    'Ds_Date' => $d->format('d/m/Y'),
	    'Ds_Hour' => $d->format('H:i')
			]);
 		$controller = new TPVControllerStub;
 		$controller->callback($req);

 		return redirect($request->action);
 	}

}
