<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class BookingControllerOnline extends BookingController
{
    function add(Request $request)
    {
        return response()->json(['status'=> parent::add($request)]);
    }

    function delete($id)
    {
        return response()->json(['status'=> parent::delete($id)]);
    }

    function index($ce_id)
    {
        return response()->json(['status'=>'ok', 'data' => parent::index($ce_id)]);
    }

    function update(Request $request)
    {
        return response()->json(['status'=> parent::update($request)]);
    }
}
