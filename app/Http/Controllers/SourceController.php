<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Source;

class SourceController extends Controller
{
    function get()
    {
	    return Source::orderBy('type')->orderBy('name')->get();
    }
}
