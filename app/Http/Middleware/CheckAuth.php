<?php

namespace App\Http\Middleware;

use Closure;
use Log;
use App\Staff;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->hasCookie('cpuser')) {
            $user_id = $request->cookie('cpuser');
            $user = Staff::find($user_id);
            if ($user) {
                // Log::debug('usuario: ' . $user->name . ' role: ' . $user->auth_role);            
                $request->merge(['user_name' => $user->name, 'user_role' => $user->auth_role, 'cpuser' => $user_id]);
                return $next($request);
            } else {
               return redirect()->route('login', ['redir' => $request->fullUrl()]);
            }
        } else {
            return redirect()->route('login', ['redir' => $request->fullUrl()]);
        }
    }
}
