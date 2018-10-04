<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];


    public function handles($request, Closure $next)
    {
        #dd(Session::all(),$request->input('_token'));
        if($request->input('_token')) {
            if ( \Session::get('_token') != $request->input('_token')) {
                return $next($request);
                #return redirect()->guest('/');
            }
        }

    }



}
