<?php

namespace App\Http\Controllers\Auth;

#use App\Model\MasterModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysRolMenuModel;
use App\Model\Administracion\Configuracion\SysSesionesModel;

class AuthController extends MasterController
{
    #se crea una propiedad
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
    public static function showLogin(){
      #debuger(Session::get('id'));
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
     *Metodo para visuzalizar para iniciar session
     *@access public
     *@param Request $request [description]
     *@return void
     */
    public function authLogin( Request $request ){
        #debuger($request->all());
      	$where = [];
        $values_sesion = ['_token'];
    		foreach ($request->all() as $key => $value) {
    			if ( !in_array($key,$values_sesion ) ) {
    				$where[$key] = $value;
    			}
    		}
		    #se realiza la consulta para verificar si existen ese candidato en la base de datos
        return self::inicio_session( array_to_object( $where ), self::$_tabla_model );
    }
    /**
     * Metodo para cerrar session
     * @access public
     * @return void
     */
    public static function logout(){
        self::_bitacora(true);
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
