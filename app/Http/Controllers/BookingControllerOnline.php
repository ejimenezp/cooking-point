<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Cookie;

use Log;

class BookingControllerOnline extends BookingController
{
    function get(Request $request)
    {
        if (!$request->locator){
            $class = isset($request->class) ? $request->class : '';
            return view('booking.index', ['page' => 'booking', 'tpv_result' => '', 'class' => $class]);
        } else {
            // $request = new Request;
            // $request->locator = $locator;
            $bkg = self::findByLocator($request);
            if (!$bkg) {    
                return view('errors.wrongLocator');          
            } else {
                $tpv_result = ($request->tpv_result) ? $request->tpv_result : '';
                return response()->view('booking.index', ['page' => 'booking', 'bkg' => $bkg, 'tpv_result' => $tpv_result])->cookie('cplocator', $bkg->locator);
            }
        }
    }
}
