<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Staff;

class StaffController extends Controller
{
    static function getCooks(Request $request)
    {    	
    	try {

		    return response()->json(['status'=>'ok', 'data' =>Staff::where('role', 'cook')->where('active', true)->get()]);

    	} catch(Exception $e) {
  			return response()->json(['status'=>'fail', 'data' => 'Exception: ' .$e->getMessage()]);
		}
    }
}
