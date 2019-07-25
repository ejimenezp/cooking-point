<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Staff;

class StaffController extends Controller
{
    static function getCooks(Request $request)
    {    	
		return Staff::where('role', 'cook')->where('active', true)->get();
    }
}
