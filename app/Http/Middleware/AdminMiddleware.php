<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Api\TokenApiController;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle( $request, Closure $next )
    {   
        if( count(Session::all()) == 0){
            
            Session::flush();
//            if ( isset($_SERVER['CONTENT_TYPE']) ) {
//                    #return response('Token expiro, favor de iniciar sesion.', 419);
//                }
                return response()->json('Token expiro, favor de iniciar sesion.', 419);
                //return redirect()->route('/');
        }
//        echo "llego";
        #debuger(Session::all());
//        debuger(count(Session::all()));
        if ( Session::has( 'email') ) {
            $datos = [ 'email'=> Session::get('email'),'api_token' => Session::get('api_token') ];
            $token = new TokenApiController;
            $response =  array_to_object($token->token( new Request($datos) )->original);
            if ($response->success == true ) {
                return $next($request);
            }else{
                Session::flush();
                if ( isset($_SERVER['CONTENT_TYPE']) ) {
                    return response('Token expiro, favor de iniciar sesion.', 419);
                }

                return redirect()->route('/');

            }


        }else{
            Session::flush();
            if ( isset($_SERVER['CONTENT_TYPE']) ) {
                return response('Token expiro, favor de iniciar sesion.', 419);
            }
            return redirect()->route('/');

        }
    }
}
