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
            $bkg = self::findBy($request->locator);
            if (!$bkg) {    
                return view('errors.wrongLocator');          
            } else {
                $tpv_result = isset($request->tpv_result) ? $request->tpv_result : '';
                return response()->view('booking.index', ['page' => 'booking', 'bkg' => $bkg, 'tpv_result' => $tpv_result])->cookie('cplocator', $bkg->locator, 525600);
            }
        }
    }


    function legacyget(Request $request)
    {
        if (!$request->hash){
            return redirect('/booking')->withCookie(Cookie::forget('cplocator'));
        } else {
            $bkg = self::findByHash($request->hash);
            if (!$bkg) {    
                return redirect('/booking')->withCookie(Cookie::forget('cplocator'));          
            } else {
                return redirect('/booking/'. $bkg->locator);
            }
        }
    }


    function thirdpartypaymentget(Request $request)
    {
        $bkg = self::findBy($request->locator);
        if (!$bkg) {    
            return view('errors.wrongLocator');          
        } else {
            $tpv_result = isset($request->tpv_result) ? $request->tpv_result : '';
            return response()->view('pages.3rdpartypayment', ['bkg' => $bkg, 'tpv_result' => $tpv_result]);
        }
    }


    function forget(Request $request)
    {
        return redirect('/booking')->withCookie(Cookie::forget('cplocator'));
    }
}
