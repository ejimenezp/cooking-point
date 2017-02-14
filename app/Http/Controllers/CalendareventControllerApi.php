<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Log;

class CalendareventControllerApi extends CalendareventController
{
    function add(Request $request)
    {
        return response()->json(['status'=> parent::add($request)]);
    }


    function delete($id)
    {
        return response()->json(['status'=> parent::delete($id)]);
    }

    function find($id)
    {
        return response()->json(['status'=>'ok', 'data' => parent::find($id)]);
    }

    function update(Request $request)
    {
        return response()->json(['status'=> parent::update($request)]);
    }


    function getSchedule(Request $request)
    {
	    return response()->json(['status'=>'ok', 'data' => $this->getIntervalSchedule($request->start, $request->end, $request->bookable_only)]);
    }

    function getAvailability(Request $request)
    {
        return response()->json(['status'=>'ok', 'data' => $this->getIntervalSchedule($request->start, $request->end, $request->bookable_only, $request->ce_type)]);
    }
}
