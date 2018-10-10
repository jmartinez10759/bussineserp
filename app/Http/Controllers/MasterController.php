<?php

namespace App\Http\Controllers;

use DOMDocument;
use App\Facades\Menu;
use GuzzleHttp\Client;
use App\Facades\Upload;
use App\Model\MasterModel;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Model\Administracion\Correos\SysCorreosModel;
use App\Model\Administracion\Correos\SysEnviadosModel;
use App\Model\Administracion\Correos\SysCategoriasModel;
use App\Model\Administracion\Configuracion\SysMenuModel;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysEstadosModel;
use App\Model\Administracion\Configuracion\SysRolMenuModel;
use App\Model\Administracion\Configuracion\SysSesionesModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysSucursalesModel;
use App\Model\Administracion\Correos\SysCategoriasCorreosModel;

abstract class MasterController extends Controller
{
  public static $_client;
  public $_tipo_user;
  public static $_domain = "";
  protected $tipo = "application/json";
  public $_http;
  protected static $_titulo = "Buro Laboral Mexico - CRM";
  protected static $_desarrollo = "";
  protected static $_link_desarrollo = "";
  public    static $_model;
  protected static $message_success;
  protected static $message_error;
  protected static $ssl_ruta = [];

  public function __construct(){
      #self::$ssl_ruta = ["verify" => $_SERVER['DOCUMENT_ROOT']. "/cacert.pem"];
      self::$ssl_ruta = ["verify" => false ];
      self::$_client = new Client( self::$ssl_ruta );
      self::$_domain = domain();
      self::$_model = new MasterModel();
      self::$message_success = "¡Transacción Exitosa!";
      self::$message_error = "¡Ocurrio un error, favor de verificar!";
      $this->middleware('permisos.menus',['except' => ['load_lista_sucursal','lista','lista_sucursal', 'portal','showLogin','authLogin','logout','verify_code']]);
      $this->middleware('permisos.rutas',['only' => ['index']]);
  }
/**
 * Metodo general para consumir endpoint utilizando una clase de laravel
 * @access protected
 * @param  url [description]
 * @param  header [description]
 * @param  data [description]
 * @return json [description]
 */
  protected static function endpoint( $url = false, $headers = [], $data = [], $method=false ){
        $response = self::$_client->$method( $url, ['headers'=> $headers, 'body' => json_encode( $data ) ]);
        $zonerStatusCode = $response->getStatusCode();
        return json_decode($response->getBody());
    }
/**
 *Metodo donde muestra el mensaje de success
 *@access protected
 *@param integer $code [Envia la clave de codigo.]
 *@param array $data [envia la informacion correcta ]
 *@return json
 */
	protected function _message_success( $code = false, $data = [], $message = false ){
        $code = ( $code )? $code : 200 ;
        $datos = [
                "success"   => true,
                "message"   => ($message)? $message :"Transacción exitosa",
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
	protected function show_error( $id = false ,$datos = [],$message = false ) {

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
				'message' => ($message)? $message :"Acceso Denegado",
				'code' 	  => "SYS-".$codigo."-".$this->setCabecera($codigo),
				'error'	  => ['description' => "No tiene permisos para realizar esta acción" ],
				'result' 	=> $datos
			],
			#1
			[
				'success' => false,
				'message' => ($message)? $message :"Error en la transacción",
				'code' 	  => "SYS-".$codigo."-".$this->setCabecera($codigo),
				'error'	  => [ 'description'   => "Token expiro, favor de verificar" ],
				'result'  => $datos

			],
			#2
			[
				'success' => false,
				'message' => ($message)? $message :"Petición Incorrecta",
				'code' 	  => "SYS-".$codigo."-".$this->setCabecera($codigo),
				'error'	  => [ 'description' => "El Servicio de Internet es Incorrecto" ],
				'result' 	=> $datos
			],
			#3
			[
				'success' => false,
				'message' => ($message)? $message :"Registros ingresados incorrectos",
				'code' 	  => "SYS-".$codigo."-".$this->setCabecera($codigo),
				'error'	  => [ 'description' => "Verificar los campos solicitados." ],
				'result' 	=> $datos

			],
			#4
			[
				'success' => false,
				'message' => ($message)? $message :"Sin Registros",
				'code' 	  => "SYS-".$codigo."-".$this->setCabecera($codigo),
				'error'	  => [ 'description'  => "No se encontro ningún registro"],
				'result' 	=> $datos
			],
			#5
			[
				'success' => false,
				'message' => ($message)? $message :"Sin Registros",
				'code' 	  => "SYS-".$codigo."-".$this->setCabecera($codigo),
				'error'	  => [ 'description' => "Ingrese datos para poder realizar la acción" ],
				'result' 	=> $datos
			],
			#6
			[
				'success' => false,
				'message' => ($message)? $message :"Error en la Transacción",
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
	 * Metodo para mandar a cargar el menu dependiendo el rol desempeÃ±ado por el usuario
	 * @access public
	 * @param array $data [ Description ]
	 * @return void
	 */
	protected static function menus( $response, $estatus=false ){
        $menus_array = [];
        $permisos = [];
        for ($i=0; $i < count( $response ); $i++) {
            for ($j=0; $j < count( $response[$i]->menus ); $j++) {
                 if($response[$i]->menus[$j]->pivot->estatus == 1){
                     $menus_array[] = ($response[$i]->menus[$j]);
                 }
            }
        }
				
        if( $estatus ){
            return $menus_array;
        }
        return Menu::build_menu_tle( $menus_array );
        #return Menu::build_menu( $menus_array );

	}
 /**
  * Metodo para cargar la vista general de la platilla que se va a utilizar
  * @access protected
  * @param string $view [Description]
  * @param array  $data [Description]
  * @return void
  */
	protected static function _load_view( $view = false, $parse = []){
		$emails = [];
		$notificaciones = [];
		$response = SysUsersModel::with(['menus' => function($query){
			$where = [
                        'sys_rol_menu.estatus'		 => 1
                        ,'sys_rol_menu.id_empresa' => Session::get('id_empresa')
                        ,'sys_rol_menu.id_sucursal'=> Session::get('id_sucursal')
                        ,'sys_rol_menu.id_rol'     => Session::get('id_rol')
				];
	     return $query->where($where)->orderBy('orden','asc')->get();
		},'roles' => function( $query ){
			 return $query->with(['notificaciones' => function($query){
				 		return $query->where(['sys_notificaciones.estatus' => 1])->orderBy('created_at','desc')->get();
			 }])->groupBy('sys_users_roles.id_users','sys_users_roles.id_rol');
		},'details'])->where( ['id' => Session::get('id')] )->get();
        #debuger($response[0]->roles);
		$by_users = SysCategoriasCorreosModel::where(['id_users' => Session::get('id') ])->get();
		foreach ($by_users as $correo) {
				$condicion = [ 'id'=> $correo->id_correo ,'estatus_recibidos' => 1 ,'estatus_vistos'=> 0 ];
				$emails[] = SysCorreosModel::where( $condicion )->get();
		}

		foreach ($response[0]->roles as $roles) {
				foreach ($roles->notificaciones as $notifications) {
					$notificaciones[] = $notifications;
				}
		}
		#debuger($notificaciones	);
		$parse['MENU_DESKTOP'] 			= self::menus( $response );
		$parse['APPTITLE'] 				= utf8_decode( self::$_titulo );
		$parse['IMG_PATH']  			= domain().'images/';
		$parse['anio']					= date('Y');
		$parse['base_url']				= domain();
		$parse['nombre_completo']		= Session::get('name')." ".Session::get('first_surname');
		$parse['desarrollo'] 			= utf8_decode(self::$_desarrollo);
		$parse['link_desarrollo'] 	    = utf8_decode(self::$_link_desarrollo);
		$parse['welcome'] 				= "Bienvenid@";
		$parse['photo_profile'] 		= isset($response[0]->details->foto)? $response[0]->details->foto : asset('img/profile/profile.png');
		$parse['rol'] 					= isset($response[0]->roles[0]->perfil)? $response[0]->roles[0]->perfil : "Perfil No Asignado";
		$parse['empresa'] 				= (isset(SysEmpresasModel::where(['id' => Session::get('id_empresa')])->get()[0]->nombre_comercial) )? SysEmpresasModel::where(['id' => Session::get('id_empresa')])->get()[0]->nombre_comercial: "Empresa No Asignada";
		$parse['sucursal'] 				= (isset(SysSucursalesModel::where(['id' => Session::get('id_sucursal')])->get()[0]->sucursal) )? SysSucursalesModel::where(['id' => Session::get('id_sucursal')])->get()[0]->sucursal: "Sucursal No Asignada";
		$parse['url_previus']           = (Session::get('id_empresa') != 0 && Session::get('id_sucursal') != 0)? route('list.empresas'): route("/");

		$parse['page_title'] 			= isset($parse['page_title'])? $parse['page_title']: " ";
		$parse['title'] 				= isset($parse['title'])? $parse['title'] : "";
		$parse['subtitle'] 				= isset($parse['subtitle'])? $parse['subtitle'] : "";
		$parse['count_correo'] 	        = count( self::_parse_array($emails) );
		$parse['efect_notify_correo']   = (count( $emails ) > 0  )? "notify": "";
		$parse['efect_notify'] 	        = (count( $notificaciones ) > 0 )?"notify": "";
		$parse['count_notify'] 	        = count( $notificaciones );
		$parse['notifications'] 	    = $notificaciones;
		$parse['emails'] 	            = self::_parse_array($emails);
		#$parse['permisos']        = Session::get('permisos');
		$eliminar 	  = (isset(Session::get('permisos')['DEL']) )? Session::get('permisos')['DEL']:  true;
		$insertar 	  = (isset(Session::get('permisos')['INS']) )? Session::get('permisos')['INS']:  true;
		$update 	  = (isset(Session::get('permisos')['UPD']) )? Session::get('permisos')['UPD']:  true;
		$select		  = (isset(Session::get('permisos')['GET']) )? Session::get('permisos')['GET']:  true;
		$upload_files = (isset(Session::get('permisos')['UPLF']) )? Session::get('permisos')['UPLF']: true;
		$correos 	  = (isset(Session::get('permisos')['EMAIL']) )? Session::get('permisos')['EMAIL']: true;
		$reportes 	  = (isset(Session::get('permisos')['PDF']) )? Session::get('permisos')['PDF']: true;
		$excel 		  = (isset(Session::get('permisos')['EXL']) )? Session::get('permisos')['EXL']: true;
		$modal 		  = (isset(Session::get('permisos')['AGR']) )? Session::get('permisos')['AGR']: true;
		$notify       = (isset(Session::get('permisos')['NTF']) )? Session::get('permisos')['NTF']: true;
		$permisos     = (isset(Session::get('permisos')['PER']) )? Session::get('permisos')['PER']: true;

		$parse['eliminar']  		= (!$eliminar)? 		"style=display:block;" : "style=display:none;";
		$parse['insertar']  		= (!$insertar)? 		"style=display:block;" : "style=display:none;";
		$parse['update'] 			= (!$update)? 			"style=display:block;" : "style=display:none;";
		$parse['select'] 			= (!$select)? 			"style=display:block;" : "style=display:none;";
		$parse['correos'] 			= (!$correos)? 			"style=display:block;" : "style=display:none;";
		$parse['reportes'] 			= (!$reportes)? 		"style=display:block;" : "style=display:none;";
		$parse['excel'] 			= (!$excel)? 			"style=display:block;" : "style=display:none;";
		$parse['modal'] 			= (!$modal)? 			"style=display:block;" : "style=display:none;";
		$parse['notify'] 			= (!$notify)? 			"style=display:block;" : "style=display:none;";
		$parse['permisos'] 			= (!$permisos)? 		"style=display:block;" : "style=display:none;";

		$parse['upload_files'] 	= (!$upload_files)? "style=display:block;" : "style=display:none;";

		$parse['agregar'] 	= (isset( $parse['agregar'] ) )? "#".$parse['agregar']: "#modal_add_register";
		$parse['buscador'] 	= (isset( $parse['buscador'] ) )? "#".$parse['buscador']: "#datatable";
		#ddebuger($parse );
		return View( $view , $parse );

	}
	/**
	 * Metodo para realizar la consulta de la session.
	 * @access public
	 * @param $where array [description]
	 * @return void
	 */
	public function inicio_session( $where, $tabla_model ){
        
    $error = null;
    try {
        $condicion = [];
        if ( isset($where->email) && isset($where->password)) {
          $condicion['email'] = $where->email;
          $condicion['password'] = $where->password;
          $condicion['confirmed'] = true;
        }
        $datos = [ 'api_token' => str_random(50) ];
        $where = [ 'email' => $where->email];
        $response = self::$_model::update_model( $where,$datos, $tabla_model );
        $condicion['api_token'] = ( $response )? $response[0]->api_token: null;
        $consulta = $tabla_model::with(['menus' => function($query){
          return $query->where(['sys_rol_menu.estatus' => 1 ])
          ->groupBy('sys_rol_menu.id_users','sys_rol_menu.id_menu','sys_rol_menu.estatus');
        },'roles' => function( $query ){
          return $query->where(['sys_roles.estatus' => 1 ])
          ->groupBy('sys_users_roles.id_users','sys_users_roles.id_rol');
        },'empresas' => function($query) {
          return $query->where(['sys_empresas.estatus' => 1 ])
          ->groupBy('id_users','id','nombre_comercial');
        }])->where( $condicion )->get();
        #debuger($consulta);
        if( count( $consulta ) > 0 ){
          $usuarios = data_march($consulta);
          $session = [];
          $keys = ['password','remember_token','confirmed_code'];
          foreach ($usuarios[0] as $key => $value) {
            if( !in_array($key,$keys) ){
              $session[$key] = $value;
            }
          }
          foreach ($consulta as $response) { $empresas = $response->empresas; }
          #se realiza la consulta a la tabla ralacional.
          if( count( $empresas ) > 0 ){
            Session::put( $session );
            self::_bitacora();
            $session['ruta'] = 'list/empresas';
            return $this->_message_success(200,$session,'¡Usuario inicio Sesion Correctamente!' );
          }
          $where = [
            'id_users'     => $session['id']
            ,'id_empresa'  => 0
            ,'id_sucursal' => 0
          ];
          $sessions['id_empresa'] = 0;
          $sessions['id_sucursal'] = 0;
          $sessions['id_rol'] = isset($consulta[0]->roles[0]->id)? $consulta[0]->roles[0]->id : "";
          $ruta = self::data_session( $consulta[0]->menus );
          $sesiones = array_merge($sessions,$ruta);
          if( count($consulta[0]->menus) < 1 ){
            return $this->show_error(6,$sesiones,'¡No cuenta con permisos necesarios, favor de contactar al administrador!');
          }
          Session::put( array_merge($session,$sesiones) );
          self::_bitacora();
          return $this->_message_success(200,array_merge($session,$sesiones),'¡Usuario inicio Sesion Correctamente!' );
        }
        $success = true;
        return $this->show_error(6,$consulta,'¡Por favor verificar la información ingresada!');
    } catch (\Exception $e) {
        $success = false;
        $error = $e->getMessage()." ".$e->getLine();
        return $this->show_error(6,$error);
        #$error = $e->getFile()." ".$e->getMessage()." ".$e->getLine();
    }

	}
	/**
	 * Metodo Donde se realizan las consultas necesarias para cargar los datos del correo.
	 * @access public
	 * @param $where array [description]
	 * @return void
	 */
	public static function page_mail(){

		$ruta_validate = substr(parse_domain()->uri,1);
		$correos = $papelera = $destacados = $enviados = $borradores = $etiquetas = [];
		$where = [ 'id_users' => Session::get('id') ];
		#$where = [ 'id' => Session::get('id') ];
		$response_correo = SysCategoriasCorreosModel::where( $where )->orderBy('created_at','DESC')->get();
		#$response_correo = SysUsersModel::with('correos','categorias')->where( $where )->orderBy('created_at','DESC')->get();
		#debuger($response_correo);
		#se realiza la consulta a la tabla de categorias
		$categorias = SysCategoriasModel::where(['estatus' => 1,'id_users' => Session::get('id')])->get();
		if ( $response_correo ) {
				foreach($response_correo as $email) {
					#dd( $email->categorias );
					$correos[] = SysCorreosModel::where( [
								'id' => $email->id_correo
								,'estatus_enviados' 		=> 0
								,'estatus_recibidos' 		=> 1
								,'estatus_papelera' 		=> 0
								,'estatus_borradores' 	=> 0
						] )->get();
					$papelera[]    = SysCorreosModel::where( [ 'id' => $email->id_correo, 'estatus_papelera' => 1 ] )->get();
					$destacados[]  = SysCorreosModel::where( [ 'id' => $email->id_correo, 'estatus_destacados' => 1 ] )->get();
					$enviados[]    = SysCorreosModel::where( [
						'id' => $email->id_correo
						,'estatus_enviados'   => 1
						,'estatus_recibidos'  => 0
						,'estatus_papelera'   => 0
						,'estatus_borradores' => 0
						//,'estatus_vistos' 	  => 0
					] )->get();
					$borradores[]    = SysCorreosModel::where( [
						'id' => $email->id_correo,
						'estatus_enviados' => 0
						,'estatus_recibidos' => 0
						,'estatus_papelera' => 0
						,'estatus_destacados' => 0
						,'estatus_borradores' => 1
					] )->get();

					$etiquetas[] = SysCategoriasModel::where(['estatus' => 1, 'id' => $email->id_categorias])->get();

				}
		}
		$tash = [];
		$destacado = [];
		$email = [];
		$datos_correo = [];
		$send = [];
		$drafts = [];
		$titulos = "";
		switch ($ruta_validate) {
			case 'correos/papelera':
						$datos_correo = self::_parse_array($papelera);
						$titulos = "Papelera";
				break;
			 case "correos/destacados":
			 #ddbuger($destacados);
					 $datos_correo = self::_parse_array($destacados);
					 $titulos = "Destacados";
			 break;

			 case "correos/recibidos":
					$datos_correo = self::_parse_array($correos);
					$titulos = "Recibidos";
				break;
				case "correos/envios":
				 		$datos_correo = self::_parse_array($enviados);
	 					$titulos = "Enviados";

 				break;

				case "correos/borradores":
				$datos_correo = self::_parse_array($borradores);
				$titulos = "Borradores";
 				break;
		}
		$tash = self::_parse_array($papelera);
		$destacado = self::_parse_array($destacados);
		$email = self::_parse_array($correos);
		$send = self::_parse_array($enviados);
		$drafts = self::_parse_array($borradores);
		$tags = self::_parse_array($etiquetas);
		$estados = dropdown([
			'data'       => SysEstadosModel::all()
			,'value'     => 'id'
			,'text'      => 'nombre'
			,'name'      => 'cmb_estados'
			,'class'     => 'form-control'
			,'leyenda'   => 'Seleccione Opcion'
			//,'event'     => 'v-change_usuario()'
			,'attr'      => 'v-model="newKeep.id_estate" '
		]);

		 #debuger($tags);
		 $data = [
				'page_title' 	      => "Correos"
				,'title'  		      	=> $titulos
				,'subtitle' 	      	=> $titulos
				,'correo' 	      	  => $email
				,'correos' 	      	  => $datos_correo
				,'papelera' 	      	=> $tash
				,'destacados' 	      => $destacado
				,'categoria' 	        => $tags
				,'categorias' 	      => $categorias
				,'enviados' 	        => $send
				,'borradores' 	      => $drafts
				,'titulo' 	          => $titulos
				,'campo_1' 	          => "Categoria"
				,'campo_2' 	          => "Descripcion"
				,'select_estados' 	  => $estados

			];
			#ddebuger( Session::get('permisos') );
			return $data;

	}
	/**
	 * Metodo para obtener el conteo y la informacion de cada seccion de los correos.
	 * @access public
	 * @param array $data [Description]
	 * @return array
	 */
	 private static function _parse_array( $data = [] ){
		 $datos = [];
		 foreach ($data as $key => $value) {
			 foreach ($value as $key => $values) {
				 $datos[] = $values;
			 }
			}
			return $datos;
	 }
	 /**
		* Metodo para hacer la consulta de la vacante
		* @access public
		* @param string $request [Description]
		* @param boolean $encode_64  [Description]
		* @return void
		*/
	 public static function upload_file( $request, $encode_64 = false ){

			 $files = $request->file('file');
			 $archivo = [];
			 for ($i=0; $i < count($files) ; $i++) {
					 $imagedata      = file_get_contents($files[$i]);
					 $nombre_temp    = $files[$i]->getClientOriginalName();
					 $extension      = strtolower($files[$i]->getClientOriginalExtension());
           if($encode_64){
             $archivo['file'][] = addslashes($imagedata);
           }

			 }
			 	#debuger($archivo);
			 return $archivo;

	 }
 /**
	* Carga y manda a llamar un facades para leer la informacion e insertar la informacion en sus respectivas tablas
	* @access public
	* @param string $request [Description]
	* @param boolean nombre tabla a insertar  [Description]
	* @return void
	*/
   public static function upload_file_catalogos( Request $request, $directorio, $models = false  ){
        try {
          $upload = new Upload;
          $upload->directorio = ( isset($directorio) && $directorio != "")? $directorio : "upload_file/catalogos/";
          $upload->table_model = $models;
          $load_file = $upload->upload_file( new Request( $request->all() ));
          for ($i=0; $i < count( $load_file->result ); $i++) {
             $ruta = ['ruta' => $load_file->result[$i]];
             if(!$models){
                return array_to_object(['success' => false,'message' => "Modelo no encontrado"]);
             }
             $upload->upload_read( new Request($ruta) );
             $response = $upload->store_register();
          }
          return array_to_object($response);
        } catch (Exception $e) {
             $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
             return ['success' => false, 'result' => $error, 'message' => "Ocurrio un error, favor de verificar"];
        }

    }
 /**
	*Metodo para hacer la consulta para los menus
	*@access public
	*@param string $request [Description]
	*@return void
	*/
	 public static function data_session( $request ){
         #debuger($request);
        $session = [];
        if( count($request) > 0 ){
                foreach ($request as $rutas ) {
                        if( isset($rutas->link) && $rutas->link != ""){
                            $session['ruta'] = $rutas->link;
                            break;
                        }
                }

        }else{
            $session['ruta'] = 'failed/error';
        }
        return $session;
	 }
 /**
	*Metodo para hacer la consulta de la vacante
	*@access private
	*@return void
	*/
  	 protected static function _bitacora( $logout = false ){
  		 #se realiza una transaccion
  		 $error = null;
  		 DB::beginTransaction();
  		 try {
  			 $users = SysUsersModel::where(['id' => Session::get('id')])->get();
  			 $where = ['id' => $users[0]->id_bitacora,'id_users' => Session::get('id')];
  			 $sesiones = SysSesionesModel::where($where)->get();
  			 $fecha_inicio = isset($sesiones[0]->created_at)?$sesiones[0]->created_at: timestamp();
  			 $fecha_final  = isset($sesiones[0]->updated_at)?$sesiones[0]->updated_at: timestamp();

  			 if ($logout) {
  				 $data_logout = [
  					    'conect'        => 0
  			           ,'disconect'     => 1
  					   ,'updated_at'    => timestamp()
  					   ,'time_conected' => time_fechas( $fecha_inicio ,timestamp() )
  				 ];
  				 SysSesionesModel::where( $where )->update($data_logout);

  			 }else{
  				 $data = [
  					'id_users'      => Session::get('id')
  					,'ip_address'   => get_client_ip()
  					,'user_agent'   => detect()['user_agent']
  					,'conect'       => 1
  					,'disconect'    => 0
  					];
  				 $bitacora = SysSesionesModel::create($data);
  				 #debuger($bitacora);
  				 SysUsersModel::where(['id' => Session::get('id')])->update(['id_bitacora' => $bitacora->id]);
  			 }

  			 DB::commit();
  			 $success = true;
  		 } catch (\Exception $e) {
  				 $success = false;
  				 $error = $e->getMessage();
  				 DB::rollback();
  		 }

  		 if ($success) {
  			 return $success;
  		 }
  		 return $error;

  	 }
 /**
  * Se crea un metodo estructurar el xml en arreglo
  * @access protected
  * @param $xml_path [Description]
  * @return array [description]
  */
  	protected static function _validateXml( $xml_path = false ){

  		if ( !empty( $xml_path )) {

				$data = self::_load_file_xml($xml_path);
				$texto = $data['texto'];
				$xml = $data['object'];
				#debuger($data);
				#se realiza las validaciones necesarias para identificar el tipo de comprobante que es.
				if (strpos($texto,"cfdi:Comprobante") !== FALSE) { $tipo="cfdi"; } else
				if (strpos($texto,"<Comprobante") !== FALSE) { $tipo="cfd"; } else
				if (strpos($texto,"retenciones:Retenciones") !== FALSE) { $tipo="retenciones";} else { die("Tipo de XML no identificado ...."); }

				if ( $tipo == "retenciones" ) {
				    $root = $xml->getElementsByTagName('Retenciones')->item(0);
				    $Version = $root->getAttribute("Version");
				} else {
				    $root = $xml->getElementsByTagName('Comprobante')->item(0);
				    $version = $root->getAttribute("version");
				    if ($version == null) $version = $root->getAttribute("Version");
				}

				$factura = [];
				$Receptor   = $root->getElementsByTagName('Receptor')->item(0);
				$Emisor     = $root->getElementsByTagName('Emisor')->item(0);
        $Conceptos  = $root->getElementsByTagName('Conceptos')->item(0);

				$factura['fecha'] = $root->getAttribute("fecha");
				$factura['noap'] = $root->getAttribute("noAprobacion");
				$factura['anoa'] = $root->getAttribute("anoAprobacion");
				$factura['tipo']=$tipo;
				#se realiza la validacion y el parseo de datos dependiendo el tipo de documento y la version
				if ( $tipo=="retenciones" ) {
				    $factura['rfc'] = utf8_decode ($Emisor->getAttribute('RFCEmisor') );
				    $factura['rfc_receptor'] = utf8_decode( $Receptor->getAttribute('RFCRecep') );
				    $factura['version'] = $root->getAttribute("Version");
				    $factura['no_certificado'] = $root->getAttribute("NumCert");
				    $factura['cert'] = $root->getAttribute("Cert");
				    $factura['sello'] = $root->getAttribute("Sello");
				    $Totales = $root->getElementsByTagName('Totales')->item(0);
				    $factura['total'] = $Totales->getAttribute("montoTotGrav");
				} else {
				    $factura['version'] = $version;
				    if ($version=="3.3") { // Mayusculas
				        $factura['total'] = $root->getAttribute('Total');
				        $factura['subTotal'] = $root->getAttribute('SubTotal');
				        $factura['fecha'] = $root->getAttribute('Fecha');
				        $factura['metodo_pago'] = $root->getAttribute('MetodoPago');
                $factura['forma_pago'] = $root->getAttribute("FormaPago");
				        $factura['moneda'] = $root->getAttribute('Moneda');
				        $factura['no_certificado'] = $root->getAttribute('NoCertificado');
				        $factura['cert'] = $root->getAttribute('Certificado');
				        $factura['sello'] = $root->getAttribute('Sello');
				        $factura['rfc'] = utf8_decode( $Emisor->getAttribute('Rfc') );
				        $factura['rfc_receptor'] = utf8_decode( $Receptor->getAttribute('Rfc') );
				        $factura['razon_social'] = utf8_decode( $Receptor->getAttribute('Nombre') );
                $factura['serie'] = $root->getAttribute("Serie");
                $factura['folio'] = $root->getAttribute("Folio");
                foreach ($Conceptos->getElementsByTagName('Concepto') as $productos ) {
                  $factura['conceptos'][] = [
                    'cantidad'      => $productos->getAttribute('Cantidad')
                    ,'clave'        => $productos->getAttribute('ClaveUnidad')
                    ,'servicio'     => $productos->getAttribute('ClaveProdServ')
                    ,'nombre'       => $productos->getAttribute('Descripcion')
                    ,'precio'       => $productos->getAttribute('ValorUnitario')
                  ];

                }

				    } else { // NO es 3.3, es 3.2 o anterior minusculas
				        $factura['total'] = $root->getAttribute('total');
				        $factura['subTotal'] = $root->getAttribute('subTotal');
				        $factura['fecha'] = $root->getAttribute('fecha');
				        $factura['metodo_pago'] = $root->getAttribute('metodoPago');
                $factura['forma_pago'] = $root->getAttribute("formaPago");
				        $factura['moneda'] = $root->getAttribute('moneda');
				        $factura['no_certificado'] = $root->getAttribute('noCertificado');
				        $factura['cert'] = $root->getAttribute('certificado');
				        $factura['sello'] = $root->getAttribute('sello');
				        $factura['rfc'] = utf8_decode( $Emisor->getAttribute('rfc') );
				        $factura['rfc_receptor'] = utf8_decode( $Receptor->getAttribute('rfc') );
                $factura['razon_social'] = utf8_decode( $Receptor->getAttribute('nombre') );
                $factura['serie'] = $root->getAttribute("serie");
                $factura['folio'] = $root->getAttribute("folio");
                foreach ($Conceptos->getElementsByTagName('Concepto') as $productos ) {
                  $factura['conceptos'][] = [
                    'cantidad'      => $productos->getAttribute('cantidad')
                    ,'clave'        => $productos->getAttribute('claveUnidad')
                    ,'servicio'     => $productos->getAttribute('claveProdServ')
                    ,'nombre'       => $productos->getAttribute('descripcion')
                    ,'precio'       => $productos->getAttribute('valorUnitario')
                  ];

                }

				    } // version 3.3
				} // Retencion o CFDI

				$TFD = $root->getElementsByTagName('TimbreFiscalDigital')->item(0);
				if ($TFD!=null) {
				    $factura['version_tfd'] = $TFD->getAttribute("Version");
				    if ($factura['version_tfd'] == "") $factura['version_tfd'] =  $TFD->getAttribute("version");
				    if ($factura['version_tfd'] == "1.0") {
				        $factura['sellocfd'] = $TFD->getAttribute("selloCFD");
				        $factura['sellosat'] = $TFD->getAttribute("selloSAT");
				        $factura['no_cert_sat'] = $TFD->getAttribute("noCertificadoSAT");
				    } else {
				        $factura['sellocfd'] = $TFD->getAttribute("SelloCFD");
				        $factura['sellosat'] = $TFD->getAttribute("SelloSAT");
				        $factura['no_cert_sat'] = $TFD->getAttribute("NoCertificadoSAT");
				    }
				    $factura['uuid'] = $TFD->getAttribute("UUID");
				} else {
				    $factura['sellocfd'] = null;
				    $factura['sellosat'] = null;
				    $factura['no_cert_sat'] = null;
				    $factura['uuid'] = null;
				}
				#debuger($factura);
				return $factura;
  		}
  		return false;

    }
  /**
   * Se crea un metodo para cargar el archivo en el dom
   * @access protected
   * @param $xml_path [Description]
   * @return onject []
   */
  	protected static function _load_file_xml( $xml_path = false){

  		if ( !empty( $xml_path )) {

  				$texto = file_get_contents($xml_path);
  				if( substr($texto, 0,3) == pack("CCC",0xef,0xbb,0xbf) ) { $texto = substr($texto, 3); }
  				if (!mb_check_encoding($texto,"utf-8")) { echo "<h3>Error en XML, no esta en UTF-8!</h3>";}
  				if (mb_check_encoding( utf8_decode( $texto ) ,"utf-8")) {utf8_decode($texto);}
  				#quita addenda solo valida fiscal
  				$texto = preg_replace('{<Addenda.*/Addenda>}is', '<Addenda/>', $texto);
  				$texto = preg_replace('{<cfdi:Addenda.*/cfdi:Addenda>}is', '<cfdi:Addenda/>', $texto);
  				$xml = new DOMDocument();
  				$xml->preserveWhiteSpace = false;
  				$load_xml = $xml->loadXML($texto);
  				if (!$load_xml) {display_xml_errors(); die(); }

  				return $data = ['object' => $xml , 'texto' => $texto];
  		}

  		return false;

  	}
/**
 * Metodo para realizar los reportes de las facturas.
 * @access public
 * @param Request $request [Description]
 * @return void
 */
    public static function reporte_general( $filtros = [] ){
                    
             $fecha_actual = date('Y-m-d');
             $fecha_actual = explode('-',$fecha_actual);
             $anio = isset($fecha_actual[0])?$fecha_actual[0]: "";
             $mes  = isset($fecha_actual[1])?$fecha_actual[1]: "";
             $ejecutivo  = ( isset( $filtros['ejecutivo']) && count($filtros['ejecutivo']) > 0 )? implode(',',$filtros['ejecutivo']): "";
             $estatus_factura = ( isset( $filtros['estatus']) && $filtros['estatus'] != "" && $ejecutivo != 0)? " AND sf.id_estatus = ".$filtros['estatus'] : "";
             $ejecutivo  = ($ejecutivo != "" && $ejecutivo != 0 )? " AND suf.id_users IN (".$ejecutivo.")": "";
             #dd($ejecutivo);
             $fechas     = ( isset( $filtros['fecha_inicio'] ) && $filtros['fecha_inicio'] != "" && isset( $filtros['fecha_final'] ) && $filtros['fecha_final'] != "" )? " AND sp.fecha_pago BETWEEN '".$filtros['fecha_inicio']."' AND '".$filtros['fecha_final']."'" : "";
             $group_by   = "";
             $group_by_suma = "";
             $orderby = " ORDER BY su.id ASC, sp.fecha_pago DESC, sf.fecha_factura DESC";
             $filtro_fechas = " AND MONTH(sp.fecha_pago) = ".$mes." AND YEAR(sp.fecha_pago) = ".$anio;
             $suma = false;
             if( $ejecutivo == "" &&  $fechas == "" ){
                     $group_by .= " GROUP BY suf.id_users";
                     $total    =  ",sum(distinct sf.total) as total_general";
                     $pago     =  ",sum( distinct sf.comision) as comision_general";
                     $comision =  ",sum( distinct sf.pago) as pago_general";

             }
             if( $ejecutivo != "" && $fechas == "" ){
                     $group_by .= " GROUP BY suf.id_factura";
                     $total    = ",sum(distinct sf.total) as total_general";
                     $pago     =  ",sum( distinct sf.comision) as comision_general";
                     $comision = ",sum( distinct sf.pago) as pago_general";
             }
             if( $ejecutivo == "" && $fechas != "" ){
                     $group_by  .= " GROUP BY sp.id";
                     $total    = " ,sum(distinct sf.total) as total_general";
                     $pago     = " ,sum( distinct sf.comision) as comision_general";
                     $comision = " ,sum( distinct sf.pago) as pago_general";
             }
             if( $ejecutivo != "" && $fechas != "" ){
                     $group_by  .= " GROUP BY sp.id ";

                     $total    = " ,sum( distinct sf.total ) as total_general";
                     $pago     = " ,sum( distinct sf.comision ) as comision_general";
                     $comision = " ,sum( distinct sf.pago ) as pago_general";
                     #$suma = true;
             }

             $sql = "SELECT
                     suf.id_users as id_usuario
                     ,concat(su.name,' ',su.first_surname,' ',su.second_surname) as nombre_completo
                     ,su.estatus
                     ,sr.perfil
                     ,sc.rfc_receptor
                     ,sc.razon_social
                     ,sp.fecha_pago
                     ,sfp.clave as forma_pago
                     ,sm.clave as metodo_pago
                     ,suf.id_factura
                     ,sf.fecha_factura
                     ,concat(sf.serie,'-',sf.folio) as factura
                     ,sf.uuid
                     ,sf.iva
                     ,sf.subtotal"
                     .$total
                     .$pago
                     .$comision.
                     ",sf.descripcion
                     ,sf.archivo
                     ,se.id as id_estatus
                     ,se.nombre as estatus_factura
                     FROM sys_users_facturacion suf
                     INNER JOIN sys_facturacion sf ON suf.id_factura = sf.id
                     LEFT JOIN sys_parcialidades_fechas sp ON sp.id_factura = sf.id
                     INNER JOIN sys_users su ON suf.id_users = su.id
                     INNER JOIN sys_clientes sc ON suf.id_cliente = sc.id
                     INNER JOIN sys_roles sr ON suf.id_rol = sr.id
                     LEFT JOIN sys_estatus se ON sf.id_estatus = se.id
                     INNER JOIN sys_formas_pagos sfp ON suf.id_forma_pago = sfp.id
                     INNER JOIN sys_metodos_pagos sm ON suf.id_metodo_pago = sm.id
                     WHERE sr.id = 2 AND sr.estatus = 1 AND su.estatus = 1 ".$estatus_factura.$ejecutivo.$fechas;

                     if( !$suma ){ $sql1 = $sql.$group_by.$orderby; }
                     $suma = true;
                     $group_by_suma .= " GROUP BY suf.id_factura";
                     if( $suma ){ $sql2 = $sql.$group_by_suma.$orderby; }
                     #debuger($sql1);
                     $response = [
                         'request'      => DB::select( $sql1 )
                         ,'cantidades'  => DB::select( $sql2 )
                     ];
                     return $response;

		 }
/**
 * Metodo para obtener los registros de los productos por empresa.
 * @access public
 * @param Request $request [Description]
 * @return void
 */
    protected function _consulta( $table_model ){
        
        $response = $table_model::with(['empresas' => function( $query ){
            if(Session::get('id_rol') != 1){
                return $query->where([ 'sys_empresas.estatus' => 1, 'id' => Session::get('id_empresa') ]);
            }
            }])->orderby('id','desc')->get();
            $request = [];
            foreach($response as $respuesta){
                if( count($respuesta->empresas) > 0 ){
                    $request[] = $respuesta;
                }
            }
        return $request;
        
    }
/**
 * Metodo para obtener los registros de los productos por empresa.
 * @access public
 * @param Request $request [Description]
 * @return void
 */
    protected function _consulta_employes( $table_model ){
        
        $response = $table_model::with(['empresas' => function( $query ){
            if(Session::get('id_rol') != 1){
                return $query->where([ 'sys_empresas.estatus' => 1, 'id' => Session::get('id_empresa') ]);
            }
            }])->where(['id' => Session::get('id')])->orderby('id','desc')->get();
            $request = [];
            foreach($response as $respuesta){
                if( count($respuesta->empresas) > 0 ){
                    $request = $respuesta->empresas;
                }
            }
        return $request;
        
    }


}