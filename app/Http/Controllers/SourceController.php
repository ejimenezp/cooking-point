<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Source;

class SourceController extends Controller
{
    function get()
    {
    	try {
	    	return response()->json(['status'=>'ok', 
	    							'data' => Source::orderBy('type')->orderBy('name')->get()]);
    	} catch(Exception $e) {
  			return response()->json(['status'=>'fail', 'data' => 'Exception: ' .$e->getMessage()]);
		}
    }
}
