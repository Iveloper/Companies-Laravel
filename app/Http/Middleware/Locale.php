<?php

namespace App\Http\Middleware;
use Closure;

class Locale {
    
    /*Middleware function that puts user's preferred language to the session
     * right after logging into the system, this way a user does not need to 
     * change their language every time,because the preferred language stays 
     * saved from last time.
     */
    public function handle($request, Closure $next)
    {
        app()->setLocale(session()->get('language'));
        
        return $next($request);
    }
    
}
