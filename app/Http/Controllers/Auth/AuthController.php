<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysUsersModel;

class AuthController extends MasterController
{
    private static $_data   = [];
    private static $_tabla_model;
    public static $title_page  = "Inicio Sesion";
    public static $desarrollo  = "Desarrollado por ";
    public static $empresa     = "";

    public function __construct(){
        parent::__construct();
        self::$_tabla_model = new SysUsersModel;
    }
    /**
     * Metodo para visuzalizar para iniciar session
     * @access public
     * @return void
     */
    public static function showLogin()
    {
    	$data= [
    		'title_page'	=>  self::$title_page
            ,'desarrollo'   =>  self::$desarrollo
            ,'empresa' 		=>  self::$empresa
    		,'error' 		=>  "Mensaje de error"
    	];
    	$data = array_merge($data,self::$_data);
    	 if ( Session::get('id') !== null ){
	        return redirect()->route('dashboard');
    	 }
	     if( empty($data['logged_in']) && isset($data['msg']) ){
	        $data['error'] = '<div class="alert alert-error login-error-msg">
	        <button type="button" class="close btn-close">&times;</button>
	        '.$data['msg'].'
	        </div>';
	     }else{
	      $data['error'] = "";
	     }
    	return View('auth.auth',$data);

    }

    /**
     *This Method is for login in the dashboard
     * @access public
     * @param Request $request [description]
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function authLogin( Request $request )
    {
        return $this->startSession( $request, new SysUsersModel );
    }
    /**
     * This method is for finish session
     * @access public
     * @return void
     */
    public function logout()
    {
        $this->_binnacleCreate(new SysUsersModel);
    	Session::flush();
    	return redirect()->route('/');
    }
    /**
     *Metodo donde verifica el token generado para validar y redireccionar
     *@access public
     *@param $confirmed_code [description]
     *@return void
     */
    public static function verify_code( $confirmed_code ){

        if ( $confirmed_code ) {
              $condicion = ['confirmed_code' => $confirmed_code ];
              $consulta = self::$_model::show_model([], $condicion, self::$_tabla_model );
              if( $consulta ){
                  $session = [];
                  $datos = [ 'confirmed_code' => null, 'confirmed' => true, 'api_token' => str_random(50) ];
                  $where = ['email' => $consulta[0]->email];
                  $response = self::$_model::update_model( $where,$datos, self::$_tabla_model );
                  #debuger($response[0]);
                  foreach ($response[0] as $key => $value) {
                      $session[$key] = $value;
                  }
                  Session::put( $session );
                  return redirect()->route( self::$_ruta );
              }
              return redirect()->route('/');
        }
        return redirect()->route('/');

    }



}
