<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class BookingControllerApi extends BookingController
{
    function add(Request $request)
    {
        return response()->json(parent::add($request));
    }

    function delete($id)
    {
        return response()->json(['status'=> parent::delete($id)]);
    }

    function findByLocator(Request $request)
    {
        return response()->json(['status'=>'ok', 'data' => parent::findBy($request->locator)]);
    }

    function index($ce_id)
    {
        return response()->json(['status'=>'ok', 'data' => parent::index($ce_id)]);
    }

    function update(Request $request)
    {
        return response()->json(parent::update($request));
    }

    function emailIt(Request $request)
    {
        return response()->json(parent::email(parent::findBy($request->locator)));
    }
}
