<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Eventtype;

class EventtypeController extends Controller
{
    static function get()
    {    	
		return Eventtype::where('active', true)->get();
    }

    static function bookable_by_clients (Request $request) {
    	$et = Eventtype::where('active', true)
    									->where('bookable_by_clients', true)
    									->where('online', $request->online == 'true')->get();
    	return $et->map->only(['type', 'short_description', 'time']);
    }
}
