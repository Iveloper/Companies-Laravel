<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Session;
/**
 * Description of Locale
 *
 * @author ivelin
 */
class Locale {
    
    
    public function handle($request, Closure $next)
    {
        app()->setLocale(session()->get('language'));
        
        return $next($request);
    }
    
}
