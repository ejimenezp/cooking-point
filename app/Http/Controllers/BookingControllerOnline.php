<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Cookie;

use Log;

class BookingControllerOnline extends BookingController
{

    function thirdpartypaymentget(Request $request)
    {
        $bkg = self::findBy($request->locator);
        if (!$bkg) {    
            return view('errors.wrongLocator');          
        } else {
            $tpv_result = isset($request->tpv_result) ? $request->tpv_result : '';
            return response()->view('pages.paymentrequest', ['bkg' => $bkg, 'tpv_result' => $tpv_result]);
        }
    }

}
