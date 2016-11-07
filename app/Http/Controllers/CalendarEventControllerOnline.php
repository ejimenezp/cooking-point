<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Log;

class CalendareventControllerOnline extends CalendareventController
{
    function add(Request $request)
    {
        return response()->json(['status'=> parent::add($request)]);
    }


    function delete($id)
    {
        return response()->json(['status'=> parent::delete($id)]);
    }


    function update(Request $request)
    {
        return response()->json(['status'=> parent::update($request)]);
    }


    function getSchedule(Request $request)
    {
	    return response()->json(['status'=>'ok', 'data' => $this->getIntervalSchedule($request->start, $request->end, $request->bookable_only)]);
    }
    // el resto de metodos, ya definidos en la clase padre
}
