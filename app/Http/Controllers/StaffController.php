<?php

namespace App\Http\Controllers;

use App\Staff;

class StaffController extends Controller
{
    static function getCooks()
    {    	
		return Staff::where('role', 'cook')->where('active', true)->get();
    }
}
