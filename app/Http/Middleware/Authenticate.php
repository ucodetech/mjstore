<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if($request->routeIs('superuser.*')){
                return route('superuser.super.login');
            }
            if($request->routeIs('seller.*')){
                return route('seller.vendor.login');
            }
            return route('user.user.login');
        }
        
    }
}
