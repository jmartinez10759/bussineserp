<?php

namespace App\Http\Controllers\Api;

use GuzzleHttp\Client;
use App\Model\MasterModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

abstract class MasterApiController extends Controller
{

    public $_client;
	  protected $_api; #propiedad
    protected $_permission; #propiedad
    protected $_url;
    protected $tipo = "application/json";
    protected $master;

    public function __construct(){
        $this->_client = new Client();
        $this->master = new MasterModel();
        $this->middleware('cors');
    }
  /**
   *Metodo para la validacion del token
   *@access public
   *@param array
   *@return
   */
    public function validate_permisson( $indice = false ,$parametros = array(),$request=false ){
        #indice = id_de la tabla
        try {
          $datos = self::parser_string();
          #dd($datos,$request->all());
          $server         = $_SERVER['REQUEST_METHOD'];
          $http_usuario   = isset( $_SERVER['HTTP_USUARIO'] )? $_SERVER['HTTP_USUARIO']:null;
          $http_token     = isset( $_SERVER['HTTP_TOKEN'] )? $_SERVER['HTTP_TOKEN']:null;
          #debuger( $_SERVER );
          $token = ( $http_token && $http_usuario )? self::token_validate( [ 'email' => $http_usuario,'api_token' => $http_token] ) : false;
          #ddebuger($token);
          if ( isset( $token->success ) && $token->success == true ) {
            #$permisson = self::permisson_validate( [ 'id_users' => $token->result[0]->id ] )->result;
            $permisson = ['CON','INS','UPD','DEL'];
            #debuger($permisson);
            switch ($server) {
              case 'GET':
              #debuger( in_array($datos,$request->all()) );
                if ( in_array( 'CON', $permisson )  ) {
                  if ( isset($parametros[$indice]) ) {
                    return $this->show( $parametros );
                  }
                  if ( isset($datos) && count($datos) > 0 ) {
                    return $this->show( new Request($datos) );
                  }
                  return $this->all();
                }
                return $this->show_error(0);
              break;

              case 'POST':
                if ( in_array( 'INS' ,$permisson  ) ){
                  $registros = [];
                  foreach ($request->all() as $key => $value) {
                      if( !array_key_exists($key, $datos)){
                          $registros[$key] = $value;
                      }
                  }
                  #debuger($registros);
                  return $this->store( new Request( $registros ) );
                }
                return $this->show_error(0);
              break;

              case 'PUT':
                $id = isset($request->$indice)? $request->$indice :false;
                if(!$id){
                  return $this->show_error(3,['id' => $id]);
                }
                if ( in_array( 'UPD' ,$permisson  ) ) {
                  $register = [];
                  $keys = ['id'];
                  foreach ( $request->all() as $key => $value) {
                    if( !in_array($key,$keys)){
                      $register[$key] = $value;
                    }
                  }
                  return $this->update(new Request( $register ), $id);
                }
                return $this->show_error(0);
              break;

              case 'DELETE':
                #$id = isset($request->$indice)? $request->$indice :false;
                $id = isset( $request->$indice )? $request->$indice : false;
                #dump($id);
                if ( in_array( 'DEL' ,$permisson  ) ){
                  return $this->destroy( $id );
                }
                return $this->show_error(0);
              break;

            }

          }
          $errors = isset($token->success)? $token->success : $http_token;
          return $this->show_error(1,$errors);
        } catch (\Exception $e) {
            $errors = $e->getMessage();
            return $this->show_error(1,$errors);
        }

    }
   /**
   *Metodo para la validacion del token
   *@access protected
   *@param array
   *@return
   */
    protected  function token_validate( $datos ){
        $this->_api = new TokenApiController();
        return array_to_object($this->_api->token( new Request( $datos ) )->original );
    }
  /**
   *Metodo para la validacion de los permisos por cada usuario
   *@access protected
   *@param array data [description]
   *@return integer [regresa el numero de permiso solicitdo]
   */
    protected function permisson_validate( $data = [] ){
      $this->_permission = new PermisosApiController();
      return array_to_object( $this->_permission->permisson( $data ) );
      return 1;
  }
  /**
   *Metodo donde muestra el mensaje de success
   *@access protected
   *@param integer $code [Envia la clave de codigo.]
   *@param array $data [envia la informacion correcta ]
   *@return json
   */
    protected function _message_success( $code = false, $data = array() ){

        $code = ( $code )? $code : 200 ;
        $datos = [
            "success"   => true,
            "message"   => "Transacción exitosa",
            "code"		  => "SYS-".$code."-".$this->setCabecera($code),
            "result"    => $data
        ];
        return response()->json($datos,$code);
    }
  /**
   *Metodo para establecer si se realizo con exito la peticion
   *@access private
   *@param $codigo [description]
   *@return string [description]
   */
   private function get_status_message( $codigo = false ) {
	    $estado = array(
	       200 => 'OK',
	       201 => 'Created',
	       202 => 'Accepted',
	       204 => 'No Content',
	       301 => 'Moved Permanently',
	       302 => 'Found',
	       303 => 'See Other',
	       304 => 'Not Modified',
	       400 => 'Bad Request',
	       401 => 'Unauthorized',
	       403 => 'Forbidden',
	       404 => 'Not Found',
	       405 => 'Method Not Allowed',
	       409 => 'Conflict',
         412 => 'Precondition Failed',
	       500 => 'Internal Server Error'
	   	);

	   return ($estado[$codigo]) ? $estado[$codigo] : $estado[500];
 	 }
   	/**
	 *Se crea un metodo para mostrar los errores dependinedo la accion a realizar
	 *@access protected
	 *@param integer $id [ Coloca el indice para mandar el error que corresponde. ]
	 *@param array $datos [ Envia la informacion para pintar el error. ]
	 *@return string $errores
	 */
	protected function show_error( $id = false ,$datos = [] ) {

    switch ($id) {
      case 0:
        $codigo = 401;
        break;
        case 1:
            $codigo = 409;
          break;
          case 2:
            $codigo = 500;
            break;
            case 3:
              $codigo = 412;
              break;
              case 4:
                $codigo = 400;
                break;
                case 5:
                    $codigo = 400;
                    break;
                    case 6:
                        #$codigo = 304;
                        $codigo = 400;
                        break;
    }

		$errors = [
			#0
			[
				'success' => false,
				'message' => "Acceso Denegado",
        'code' 	  => "SYS-".$codigo."-".$this->setCabecera($codigo),
        'error'	  => ['description' => "No tiene permisos para realizar esta acción" ],
        'result' 	=> $datos
			],
			#1
			[
				'success' => false,
				'message' => "Error en la transacción",
        'code' 	  => "SYS-".$codigo."-".$this->setCabecera($codigo),
        'error'	  => [ 'description'   => "Token expiro, favor de verificar" ],
        'result'  => $datos

			],
			#2
			[
				'success' => false,
				'message' => "Petición Incorrecta",
        'code' 	  => "SYS-".$codigo."-".$this->setCabecera($codigo),
        'error'	  => [ 'description' => "El Servicio de Internet es Incorrecto" ],
        'result' 	=> $datos
			],
			#3
			[
				'success' => false,
				'message' => "Registros ingresados incorrectos",
        'code' 	  => "SYS-".$codigo."-".$this->setCabecera($codigo),
        'error'	  => [ 'description' => "Verificar los campos solicitados." ],
        'result' 	=> $datos

			],
			#4
			[
				'success' => false,
				'message' => "Sin Registros",
        'code' 	  => "SYS-".$codigo."-".$this->setCabecera($codigo),
				'error'	  => [ 'description'  => "No se encontro ningún registro"],
        'result' 	=> $datos
			],
			#5
			[
				'success' => false,
				'message' => "Sin Registros",
        'code' 	  => "SYS-".$codigo."-".$this->setCabecera($codigo),
        'error'	  => [ 'description' => "Ingrese datos para poder realizar la acción" ],
        'result' 	=> $datos
			],
      #6
      [
				'success' => false,
				'message' => "Error en la Transacción",
        'code' 	  => "SYS-".$codigo."-".$this->setCabecera($codigo),
				'error'	  => [ 'description' => "Ocurrio un error en el registro solicitado" ],
        'result' 	=> $datos
			]

		];
      return response()->json($errors[$id],$codigo);

	}
  /**
  * Se crea un metodo en el cual se establece el formato en el que se enviara la informacion del REST
  * @access protected
  * @param $codigo int [description]
  * @return void
  */
    protected function setCabecera( $codigo ) {
        header("HTTP/1.0 " . $codigo . " " . $this->get_status_message($codigo));
        header("Content-Type:" . $this->tipo);
        header("status:" . $codigo);
        return $this->get_status_message($codigo);

    }
  /**
   *Metodo donde parsea la cadena
   *@access public
   *@return array $datos [description]
   */
    public function parser_string(){
        $datos = [];
        if ($_SERVER['QUERY_STRING']) {
            $params = explode("&", $_SERVER['QUERY_STRING']);
            $params = implode("=", $params);
            $params = explode("=", $params);
            $i = 1;
            foreach ($params as $key => $value) {
                if ($key%2 == 0 ) {
                   $datos[$value] = $params[$i];
                }
                $i++;
            }
        }
        return $datos;

    }
  /**
   *Metodo para verificar si estan correctamete los valores ingresados
   *@access public
   *@param $data array  [description]
   *@param $class object [description]
   *@return array
   */
    public function parse_register( $data = array(), $clase, $claves_date = []){

        $datos = [];
        #verifica que no vayan nulos los campos y si no estan nulos los regresa en un arreglo
        if ( count($data) > 0 ) {

            for ($i=0; $i < count($data); $i++) {

                foreach ($data[$i] as $key => $value) {

                    if ($data[$i][$key] == null) {
                        return ['success' => false,'result' => $data[$i] ];
                    }
                    if ($value != false) {
                        $datos[$key] = $value;
                    }
                }
                #se valida la fecha
                if ( $claves_date ) {

                    for ($j=0; $j < count($claves_date); $j++) {
                        $validate_fecha = isset( $data[$i][$claves_date[$j]] )? $data[$i][$claves_date[$j]] : false;
                        $fecha = schema_fecha( $validate_fecha );
                        if ( isset($fecha['success']) && $fecha['success'] == false ) {
                            return ['success' => false,'result' => $claves_date[$j] ];
                         }

                    }

                }

            }

        }
        #validaciones de datos diferentes.
        if ( array_diff( array_keys($datos), $clase->fillable) ) {
            return ['success' => false,'result' => array_values(array_diff( array_keys($datos), $clase->fillable))  ];
        }

        return $datos;

    }


}
