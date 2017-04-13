<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Staff;
use Log;
use Cookie;

class AuthController extends Controller
{
    public function login(Request $request) 
    {
    	return view('admin.login')->with('redir', $request->redir);
    }

    public function checklogin(Request $request) 
    {
    	if ($request->name == '' || $request->password == '') {
            return redirect()->route('login', ['redir' => $request->redir]);
    	}

    	$user = Staff::where('auth_name', $request->name)->first();
    	if (!$user) {
            return redirect()->route('login', ['redir'=> $request->redir]);
    	} else {
    		if ($user->auth_password != $request->password) {
            return redirect()->route('login', ['redir'=> $request->redir]);
    		}
     		// aquí generar la cookie

    		return redirect($request->redir)->withCookie(cookie('cpuser', $user->id, 525600));
    	}
    }

    public function logout() 
    {
    	Cookie::queue(cookie('cpuser', 'removecookie', -3600));
    	return redirect()->route('login');
    }

}
