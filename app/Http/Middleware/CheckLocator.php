<?php

namespace App\Http\Middleware;

use Closure;
use Log;

class CheckLocator
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
        // Log::info('pasa por chjecklocator handle isset($request->locator) es '. isset($request->locator));
        if ($request->hasCookie('cplocator') && !isset($request->locator)) {
            // Log::debug('middleware detecto el locator '. $request->cookie('cplocator'));            
            $request->merge(['locator'=> $request->cookie('cplocator')]);
        }
        return $next($request);
    }
}
