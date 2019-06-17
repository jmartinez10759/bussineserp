<?php

namespace App\Http\Controllers;

use App\Model\Administracion\Configuracion\SysRolesModel;
use PDF;
use DOMDocument;
use App\Facades\Menu;
use GuzzleHttp\Client;
use App\Facades\Upload;
use App\Model\MasterModel;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Model\Administracion\Correos\SysCorreosModel;
use App\Model\Administracion\Correos\SysEnviadosModel;
use App\Model\Administracion\Correos\SysCategoriasModel;
use App\Model\Administracion\Correos\SysUsersCorreosModel;
use App\Model\Administracion\Configuracion\SysMenuModel;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysEstadosModel;
use App\Model\Administracion\Configuracion\SysRolMenuModel;
use App\Model\Administracion\Configuracion\SysSesionesModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysSucursalesModel;
use App\Model\Administracion\Correos\SysCategoriasCorreosModel;
use App\Model\Administracion\Configuracion\SysNotificacionesModel;
use App\Model\Administracion\Configuracion\SysProveedoresModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class MasterController extends Controller
{
	public static $_client;
	public $_tipo_user;
	public static $_domain = "";
	protected $tipo = "application/json";
	public $_http;
	protected static $_titulo = "Empresa No Asignada";
	protected static $_desarrollo = "";
	protected static $_link_desarrollo = "";
	public static $_model;
	protected static $message_success;
	protected static $message_error;
	protected static $ssl_ruta = [];
	protected $permisos_full = [];

	protected $_today;

	public function __construct()
	{
		self::$_client = new Client(self::$ssl_ruta);
		self::$_domain = domain();
		self::$message_success  = "¡Transacción Exitosa!";
		self::$message_error    = "¡Ocurrio un error, favor de verificar!";
		$this->_today = new \DateTime('now');
		$this->middleware('permisos.menus', ['except' => ['listCompanies', 'listGroup', 'loadCompanies', 'portal', 'showLogin', 'authLogin', 'logout', 'verify_code'] ] );
		$this->middleware('permisos.rutas', ['only' => ['index']]);
	}

    /**
     * Metodo general para consumir endpoint utilizando una clase de laravel
     * @access protected
     * @param bool $url
     * @param array $headers
     * @param array $data
     * @param bool $method
     * @return json [description]
     */
	protected static function endpoint($url = false, $headers = [], $data = [], $method = false)
	{
		$response = self::$_client->$method($url, ['headers' => $headers, 'body' => json_encode($data)]);
		return json_decode($response->getBody());
	}

    /**
     *Metodo donde muestra el mensaje de success
     * @access protected
     * @param int $code [Envia la clave de codigo.]
     * @param array $data [envia la informacion correcta ]
     * @param bool $message
     * @return JsonResponse
     */
	/*protected function _message_success( int $code = null, $data = [], $message = false)
	{
		$code = ( $code ) ? $code : 200;
		$datos = [
			"success" => true,
			"message" => ($message) ? $message : "Transacción exitosa",
			"code" => "SYS-" . $code . "-" . $this->setCabecera($code),
			"result" => $data
		];
		return new JsonResponse($datos, $code);
	}*/
	/**
	 * Metodo para establecer si se realizo con exito la peticion
	 * @access private
	 * @param bool $codigo [description]
	 * @return string [description]
	 */
/*	private function get_status_message( $codigo = false )
	{
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
		return ($estado[ $codigo ]) ? $estado[$codigo] : $estado[500];
	}*/

    /**
     *Se crea un metodo para mostrar los errores dependinedo la accion a realizar
     * @access protected
     * @param int $id [ Coloca el indice para mandar el error que corresponde. ]
     * @param array $datos [ Envia la informacion para pintar el error. ]
     * @param string $message
     * @return string $errores
     */
	/*protected function show_error( int $id = null, $datos = [], string $message = null)
	{
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
				$codigo = 400;
				break;
		}

		$errors = [
			#0
			[
				'success' => false,
				'message' => ($message) ? $message : "Acceso Denegado",
				'code' => "SYS-" . $codigo . "-" . $this->setCabecera($codigo),
				'error' => ['description' => "No tiene permisos para realizar esta acción"],
				'result' => $datos
			],
			#1
			[
				'success' => false,
				'message' => ($message) ? $message : "Error en la transacción",
				'code' => "SYS-" . $codigo . "-" . $this->setCabecera($codigo),
				'error' => ['description' => "Token expiro, favor de verificar"],
				'result' => $datos

			],
			#2
			[
				'success' => false,
				'message' => ($message) ? $message : "Petición Incorrecta",
				'code' => "SYS-" . $codigo . "-" . $this->setCabecera($codigo),
				'error' => ['description' => "El Servicio de Internet es Incorrecto"],
				'result' => $datos
			],
			#3
			[
				'success' => false,
				'message' => ($message) ? $message : "Registros ingresados incorrectos",
				'code' => "SYS-" . $codigo . "-" . $this->setCabecera($codigo),
				'error' => ['description' => "Verificar los campos solicitados."],
				'result' => $datos

			],
			#4
			[
				'success' => false,
				'message' => ($message) ? $message : "Sin Registros",
				'code' => "SYS-" . $codigo . "-" . $this->setCabecera($codigo),
				'error' => ['description' => "No se encontro ningún registro"],
				'result' => $datos
			],
			#5
			[
				'success' => false,
				'message' => ($message) ? $message : "Sin Registros",
				'code' => "SYS-" . $codigo . "-" . $this->setCabecera($codigo),
				'error' => ['description' => "Ingrese datos para poder realizar la acción"],
				'result' => $datos
			],
			#6
			[
				'success' => false,
				'message' => ($message) ? $message : "Error en la Transacción",
				'code' => "SYS-" . $codigo . "-" . $this->setCabecera($codigo),
				'error' => ['description' => "Ocurrio un error en el registro solicitado"],
				'result' => $datos
			]

		];
		return new JsonResponse($errors[$id], $codigo);
	}*/
	/**
	 * Se crea un metodo en el cual se establece el formato en el que se enviara la informacion del REST
	 * @access protected
	 * @param $codigo int [description]
	 * @return void
	 */
	/*protected function setCabecera($codigo)
	{
		header("HTTP/1.0 " . $codigo . " " . $this->get_status_message($codigo));
		header("Content-Type:" . $this->tipo);
		header("status:" . $codigo);
		return $this->get_status_message($codigo);
	}*/

    /**
     * Metodo para mandar a cargar el menu dependiendo el rol del usuario
     * @access public
     * @param $response
     * @param bool $estatus
     * @return array
     */
	/*protected static function menus( $response = [], bool $estatus = false)
	{
		$menusArray = [];
        for ($j = 0; $j < count($response->menus); $j++) {
            if ($response->menus[$j]->pivot->estatus == 1) {
                $menusArray[] = ($response->menus[$j]);
            }
        }
		if ($estatus) {
			return $menusArray;
		}
		return Menu::build_menu_tle($menusArray);
        #return Menu::build_menu( $menus_array );
	}*/

    /**
     * This method is for load all menus of users
     * @param array $response
     * @param bool $status
     * @return array
     */
    protected function _loadMenus($response = [], bool $status = false)
    {
        $menusArray = [];
        for ($j = 0; $j < count($response); $j++) {
            $menusArray[] = ($response[$j]);
        }
        if ($status) {
            return $menusArray;
        }
        #var_export($menusArray);die();
        return Menu::build_menu_tle($menusArray);
    }

    /**
     * Metodo para cargar la vista general de la platilla que se va a utilizar
     * @access protected
     * @param string $view [Description]
     * @param array $parse
     * @return void
     */
	/*protected function _load_view(string $view = null, array $parse = [])
	{
		$emails = [];
		$response = SysUsersModel::with(['menus' => function($query){
			$where = [
				'sys_rol_menu.estatus' 		=> 1
				,'sys_rol_menu.id_empresa' 	=> Session::get('id_empresa')
				,'sys_rol_menu.id_sucursal' => Session::get('id_sucursal')
				,'sys_rol_menu.id_rol' 		=> Session::get('id_rol')
			];
			return $query->where($where)->orderBy('orden', 'asc');

		},'roles','details','empresas','correos'])->whereId( Session::get('id') )->first();

		$parse['MENU_DESKTOP'] 		= self::menus($response);
		self::$_titulo = (isset(SysEmpresasModel::whereId( Session::get('id_empresa') )->first()->nombre_comercial)) ? SysEmpresasModel::whereId( Session::get('id_empresa') )->first()->nombre_comercial : "Empresa No Asignada";
		$parse['APPTITLE'] 			= utf8_decode(ucwords(strtolower(self::$_titulo)));
		$parse['IMG_PATH'] 			= domain() . 'images/';
		$parse['icon'] 				= "img/company.png";
		$parse['anio'] 				= date('Y');
		$parse['version'] 			= "2.0.2";
		$parse['base_url'] 			= domain();
		$parse['nombre_completo'] 	= Session::get('name') . " " . Session::get('first_surname');
		$parse['desarrollo'] 		= utf8_decode(self::$_desarrollo);
		$parse['link_desarrollo'] 	= utf8_decode(self::$_link_desarrollo);
		$parse['welcome'] 			= "Bienvenid@";
		$parse['photo_profile'] 	= isset($response[0]->details->foto)?$response[0]->details->foto : asset('img/profile/profile.png');
		$parse['rol'] 				= isset($response[0]->roles[0])? $response[0]->roles[0]->perfil : "Perfil No Asignado";
		$parse['empresa'] 			= (isset(SysEmpresasModel::whereId( Session::get('id_empresa') )->first()->nombre_comercial)) ? SysEmpresasModel::where(['id' => Session::get('id_empresa')])->get()[0]->nombre_comercial : "Empresa No Asignada";
		$parse['sucursal'] 			= (isset(SysSucursalesModel::whereId( Session::get('id_sucursal') )->first()->sucursal)) ? SysSucursalesModel::where(['id' => Session::get('id_sucursal')])->get()[0]->sucursal : "Sucursal No Asignada";
		$parse['url_previus'] 		= (Session::get('company_id') != 0 && Session::get('group_id') != 0) ? route('list.empresas') : route("/");

		$parse['page_title'] 		= isset($parse['page_title']) ? $parse['page_title'] : " ";
		$parse['title'] 			= isset($parse['title']) 	  ? $parse['title'] : "";
		$parse['subtitle'] 			= isset($parse['subtitle'])   ? $parse['subtitle'] : "";

		Session::put(['permisos_full' =>  Session::get('permisos')]);

		$eliminar       = (isset(Session::get('permisos')['DEL'])) ? Session::get('permisos')['DEL'] : true;
		$insertar       = (isset(Session::get('permisos')['INS'])) ? Session::get('permisos')['INS'] : true;
		$update         = (isset(Session::get('permisos')['UPD'])) ? Session::get('permisos')['UPD'] : true;
		$select         = (isset(Session::get('permisos')['GET'])) ? Session::get('permisos')['GET'] : true;
		$upload_files   = (isset(Session::get('permisos')['UPLF'])) ? Session::get('permisos')['UPLF'] : true;
		$correos        = (isset(Session::get('permisos')['EMAIL'])) ? Session::get('permisos')['EMAIL'] : true;
		$reportes       = (isset(Session::get('permisos')['PDF'])) ? Session::get('permisos')['PDF'] : true;
		$excel          = (isset(Session::get('permisos')['EXL'])) ? Session::get('permisos')['EXL'] : true;
		$modal          = (isset(Session::get('permisos')['AGR'])) ? Session::get('permisos')['AGR'] : true;
		$notify         = (isset(Session::get('permisos')['NTF'])) ? Session::get('permisos')['NTF'] : true;
		$permisos       = (isset(Session::get('permisos')['PER'])) ? Session::get('permisos')['PER'] : true;
		$email          = (isset(Session::get('permisos')['SEND'])) ? Session::get('permisos')['SEND'] : true;
		$upload         = (isset(Session::get('permisos')['UPL'])) ? Session::get('permisos')['UPL'] : true;
		$impresion      = (isset(Session::get('permisos')['IMP'])) ? Session::get('permisos')['IMP'] : true;

		$parse['eliminar']          = (!$eliminar) ? "style=display:block;" : "style=display:none;";
		$parse['insertar']          = (!$insertar) ? "style=display:block;" : "style=display:none;";
		$parse['button_insertar']   = build_buttons($insertar, 'v-insert_register', 'Registrar', 'btn btn-primary', 'fa fa-save', 'id="insert"');
		$parse['update']            = (!$update) ? "style=display:block;" : "style=display:none;";
		$parse['button_update']     = build_buttons($update, 'v-update_register', 'Actualizar', 'btn btn-info', 'fa fa-save', 'id="insert"');
		$parse['select']            = (!$select) ? "style=display:block;" : "style=display:none;";
		$parse['correos']           = (!$correos) ? "style=display:block;" : "style=display:none;";

		$parse['reportes']      = (!$reportes) ? "style=display:block;" : "style=display:none;";
		$parse['seccion_reportes'] = reportes($reportes, $excel);
		$parse['excel']         = (!$excel) ? "style=display:block;" : "style=display:none;";
		
		$parse['notify']        = (!$notify) ? "style=display:block;" : "style=display:none;";
		$parse['permisos']      = (!$permisos) ? "style=display:block;" : "style=display:none;";
		$parse['email']         = (!$email) ? "style=display:block;" : "style=display:none;";
		$parse['upload']        = (!$upload) ? "style=display:block;" : "style=display:none;";
		
		$parse['agregar']       = (isset($parse['agregar'])) ? "#" . $parse['agregar'] : "#modal_add_register";
		$parse['buscador']      = (isset($parse['buscador'])) ? "#" . $parse['buscador'] : "#datatable";

		$parse['upload_files']  = build_buttons($upload_files, 'upload_files_general()', 'Cargar Catalogos', 'btn btn-warning' ,'fa fa-upload', '');

		$parse['modal']         = build_buttons($modal, 'register_modal_general("'.$parse['agregar'].'")', 'Agregar','btn btn-success','fa fa-plus-circle', 'id="modal_general"');
		
		return View($view, $parse);

	}*/

    /**
     * @param string|null $view
     * @param array $parse
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function _loadView(string $view = null, array $parse = [] )
    {
        if( Session::get('roles_id') != 1 && Session::get('permisos')['GET'] ){
            return view('errors.error');
        }
        $users = SysUsersModel::find( Session::get('id') );
        $company = $users->companies()->find(Session::get('company_id'));
        $groups  = $users->groups()->find(Session::get('group_id'));
        $menus = $users->menus()->where([
            "sys_users_menus.user_id"    =>  $users->id ,
            "sys_users_menus.roles_id"   =>  Session::get("roles_id") ,
            "sys_users_menus.company_id" =>  Session::get("company_id") ,
            "sys_users_menus.group_id"   =>  Session::get("group_id") ,
        ])->whereEstatus(TRUE)->orderBy('orden','ASC')->get();

        $parse['MENU_DESKTOP'] 		= $this->_loadMenus($menus);
        self::$_titulo              = (isset($company->nombre_comercial) )? $company->nombre_comercial: "Empresa no asignada";
        $parse['APPTITLE'] 			= utf8_decode(ucwords(strtolower(self::$_titulo)));
        $parse['IMG_PATH'] 			= domain() . 'images/';
        $parse['icon'] 				= "img/company.png";
        $parse['anio'] 				= date('Y');
        $parse['version'] 			= "2.0.2";
        $parse['base_url'] 			= domain();
        $parse['nombre_completo'] 	= Session::get('name') . " " . Session::get('first_surname');
        $parse['desarrollo'] 		= utf8_decode(self::$_desarrollo);
        $parse['link_desarrollo'] 	= utf8_decode(self::$_link_desarrollo);
        $parse['welcome'] 			= "Bienvenid@";
        $parse['photo_profile'] 	= isset($users->details)?$users->details->foto : asset('img/profile/profile.png');
        $parse['rol'] 				= isset($users->roles[0])? $users->roles[0]->perfil : "Perfil No Asignado";
        $parse['empresa'] 			= (isset($company->nombre_comercial) )? $company->nombre_comercial: "Empresa no asignada";
        $parse['sucursal'] 			= (isset($groups->sucursal))?$groups->sucursal : "Sucursal no asignada";
        $parse['url_previus'] 		= (Session::get('company_id') != 0 && Session::get('group_id') != 0) ? route('list.empresas') : route("/");

        $parse['page_title'] 		= isset($parse['page_title']) ? $parse['page_title'] : " ";
        $parse['title'] 			= isset($parse['title']) 	  ? $parse['title'] : "";
        $parse['subtitle'] 			= isset($parse['subtitle'])   ? $parse['subtitle'] : "";

        $upload_files   = (isset(Session::get('permisos')['UPLF'])) ? Session::get('permisos')['UPLF'] : true;
        $notify         = (isset(Session::get('permisos')['NTF'])) ? Session::get('permisos')['NTF'] : true;
        $reportes       = (isset(Session::get('permisos')['PDF'])) ? Session::get('permisos')['PDF'] : true;
        $excel          = (isset(Session::get('permisos')['EXL'])) ? Session::get('permisos')['EXL'] : true;
        #$modal          = (isset(Session::get('permisos')['AGR'])) ? Session::get('permisos')['AGR'] : true;

        $parse['seccion_reportes'] = reportes($reportes, $excel);
        $parse['notify']        = (!$notify) ? "style=display:block;" : "style=display:none;";
        $parse['upload_files']  = build_buttons($upload_files, 'upload_files_general()', 'Cargar Catalogos', 'btn btn-warning' ,'fa fa-upload', '');
        #$parse['buscador']      = (isset($parse['buscador'])) ? "#" . $parse['buscador'] : "#datatable";
        #$parse['agregar']       = (isset($parse['agregar'])) ? "#" . $parse['agregar'] : "#modal_add_register";
        #$parse['modal']         = build_buttons($modal, 'register_modal_general("'.$parse['agregar'].'")', 'Agregar','btn btn-success','fa fa-plus-circle', 'id="modal_general"');

        return View($view, $parse);
    }

    /**
     * This is method is for login session for system.
     * @access public
     * @param Request $request
     * @param SysUsersModel $users
     * @return JsonResponse
     */
	public function startSession(  Request $request , SysUsersModel $users )
	{
		$error = null;
		try {
			$conditions = [];
			if ( isset( $request->email ) && isset( $request->password ) ) {
				$conditions     = ( filter_var( $request->email, FILTER_VALIDATE_EMAIL ) )? ['email' => $request->email ]: ['username' => $request->email];
				$conditions['confirmed'] = TRUE;
			}
			$information = ['api_token' => str_random(50)];
			$where = ( filter_var( $request->email, FILTER_VALIDATE_EMAIL  ) )? ['email' => $request->email ]: ['username' => $request->email ];
			$users::where( $where )->update($information);
            $response = $users->where($where)->first();
            $conditions['api_token'] = ( $response ) ? $response->api_token : NULL;
            $user = $users::with(['menus' => function( $query ){
					return $query->groupby('id');
			},'companies','groups','roles'])->where( $conditions )->first();

            if ( password_verify($request->password, $user->password) ) {
                $session = [];
                $keys = ['password', 'remember_token', 'confirmed_code'];
                foreach ($user->fillable as $key => $value) {
                    if (!in_array($value, $keys)) {
                        $session[$value] = $user->$value;
                    }
                }
				if ( count( $user->companies ) > 1 || count($user->groups) > 1 ) {
					Session::put( $session );
					$this->_binnacleCreate($users);
					$session['ruta'] = 'list/companies';
					return new JsonResponse([
					    "success"   => TRUE ,
					    "data"      => $session ,
                        "message"   => "¡Usuario Inicio Sesión Correctamente!"
                    ],Response::HTTP_OK);
				}
				$sessions['company_id']  = isset( $user->companies[0]->id) ? $user->companies[0]->id : 0;
				$sessions['group_id']    = isset( $user->groups[0]->id) ? $user->groups[0]->id : 0;
				$sessions['roles_id']    = isset( $user->roles[0]->id) ? $user->roles[0]->id : "";
                $path       = self::dataSession( $user->menus );
                $sesiones   = array_merge($sessions, $path);
                if ( count($user->menus) < 1 ) {
                    return new JsonResponse([
                        "success"   => FALSE ,
                        "data"      => $sesiones ,
                        "message"   => "¡No cuenta con permisos necesarios, favor de contactar al administrador!"
                    ],Response::HTTP_BAD_REQUEST);
                }
                Session::put( array_merge( $session, $sesiones ) );
                $this->_binnacleCreate($users);
                return new JsonResponse([
                    "success"   => TRUE ,
                    "data"      => array_merge( $session, $sesiones ) ,
                    "message"   => "¡Usuario Inicio Sesión Correctamente!"
                ],Response::HTTP_OK);
			}
            return new JsonResponse([
                "success"   => FALSE ,
                "data"      => $user ,
                "message"   => "¡Por favor verificar la información ingresada!"
            ],Response::HTTP_BAD_REQUEST);
		} catch ( \Exception $e) {
			$error = $e->getFile() . " " . $e->getMessage() . " " . $e->getLine();
            return new JsonResponse([
                "success"   => FALSE ,
                "data"      => $error ,
                "message"   => self::$message_error
            ],Response::HTTP_BAD_REQUEST);
		}

	}

    /**
     * Metodo Donde se realizan las consultas necesarias para cargar los datos del correo.
     * @access public
     * @return array
     */
	public static function page_mail()
	{
		$ruta_validate = substr(parse_domain()->uri, 1);
		$titulos = "";
		switch ($ruta_validate) {
			case 'correos/papelera':				
				$titulos = "Papelera";
				break;
			case "correos/destacados":
				$titulos = "Destacados";
				break;

			case "correos/recibidos":
				$titulos = "Recibidos";
				break;
			case "correos/envios":
				$titulos = "Enviados";
				break;

			case "correos/borradores":
				$titulos = "Borradores";
				break;
			default:				
				$titulos = "Redactar";
				break;
		}
		
		$data = [
			'page_title' 	=> "Correos"
			, 'title' 		=> $titulos
			, 'titulo' 		=> $titulos
			, 'campo_1' 	=> "Categoria"
			, 'campo_2' 	=> "Descripcion"			
		];
			#debuger($data);
		return $data;
	}
	/**
	 * Metodo Donde se realizan las consultas necesarias para cargar los datos del correo.
	 * @access public
	 * @param $where array [description]
	 * @return void
	 */
	public function consulta_emails()
	{
		$ruta_validate = substr(parse_domain()->urls, 1);
		$recibidos = $papelera = $destacados = $enviados = $borradores = $etiquetas = [];
		$categorias = SysCategoriasModel::where(['estatus' => 1, 'id_users' => Session::get('id')])->get();
		$response_correo = SysUsersModel::with(['correos','plantillas'])->whereId( Session::get('id') )->first();
		/*se realiza la consulta de los correos recibidos*/
		$recibidos = $response_correo->correos()
										->with(['categorias'])
										->where(['estatus_recibidos' => 1])
										->where(['estatus_papelera' => 0])
										->orderby('created_at','desc')
										->get();
		/*se utiliza esta consulta para realizar el conteo de recibidos*/										
		$recibidos_conteo = $response_correo->correos()
										->with(['categorias'])
										->where(['estatus_recibidos' => 1])
										->where(['estatus_vistos' => 0])
										->orderby('created_at','desc')
										->get();
		#debuger($recibidos);
		/*se realiza la consulta para los correos enviados*/
		$enviados  = $response_correo->correos()
										->with(['categorias'])
										->where(['estatus_enviados' => 1])
										->where(['estatus_papelera' => 0])
										->orderby('created_at','desc')
										->get();

		/*se realiza la consulta de los datos de los correos enviados a la papelera*/
		$papelera  = $response_correo->correos()
										->with(['categorias'])
										->where(['estatus_papelera' => 1])
										->orderby('created_at','desc')
										->get();
		/*se realiza la consulta de los datos de los correos destacados*/
		$destacados  = $response_correo->correos()
										  ->with(['categorias'])
										  ->where(['estatus_destacados' => 1])
										  ->where(['estatus_papelera' => 0])
										  ->orderby('created_at','desc')
										  ->get();
		/*se realiza la consulta de los datos de los correos borradores*/
		$borradores  = $response_correo->correos()
										  ->with(['categorias'])
										  ->where(['estatus_borradores' => 1])
										  ->where(['estatus_papelera' => 0])
										  ->orderby('created_at','desc')
										  ->get();
	    #$tags = $response_correo[0]->correos()->categorias(); 
		#debuger($ruta_validate);
		$titulos = "";
		switch ($ruta_validate) {
			case 'correos/papelera':
				$datos_correo = $papelera;
				$titulos = "Papelera";
				break;
			case "correos/destacados":
				$datos_correo = $destacados;
				$titulos = "Destacados";
				break;

			case "correos/recibidos":
				$datos_correo = $recibidos;
				$titulos = "Recibidos";
				break;
			case "correos/envios":
				$datos_correo = $enviados;
				$titulos = "Enviados";

				break;

			case "correos/borradores":
				$datos_correo = $borradores;
				$titulos = "Borradores";
				break;
			default:
				$datos_correo = [];
				$titulos = "Redactar";
				break;
		}
		#debuger($datos_correo);
		$data = [
			 'correos' 		=> $datos_correo
			, 'correo' 		=> count($recibidos_conteo)
			, 'papelera' 	=> count($papelera)
			, 'destacados' 	=> count($destacados)
			#, 'categoria' 	=> count($etiquetas)
			, 'categorias' 	=> count($categorias)
			, 'enviados' 	=> count($enviados)
			, 'borradores' 	=> count($borradores)
		];

		return $data;

	}
	/**
	 * Metodo para obtener el conteo y la informacion de cada seccion de los correos.
	 * @access public
	 * @param array $data [Description]
	 * @return array
	 */
	/*private static function _parse_array( $data = [] )
	{
		$datos = [];
		foreach ($data as $key => $value) {
			foreach ($value as $key => $values) {
				$datos[] = $values;
			}
		}
		return $datos;
	}*/
	/**
	 * Metodo para hacer la consulta de la vacante
	 * @access public
	 * @param string $request [Description]
	 * @param boolean $encode_64  [Description]
	 * @return void
	 */
	public static function upload_file($request, $encode_64 = false, $directorio = false)
	{
		$files = $request->file('file');
		$archivo = [];
		for ($i = 0; $i < count($files); $i++) {
			
			if ($encode_64) {
				$imagedata = file_get_contents($files[$i]);
				$nombre_temp = $files[$i]->getClientOriginalName();
				$extension = strtolower($files[$i]->getClientOriginalExtension());
				switch ($extension) {
					case 'pdf':
						$file = "application";
						break;
					case 'png':
						$file = "image";
						break;
					case 'jpg':
						$file = "image";
						break;
					case 'jpeg':
						$file = "image";
						break;
				}
				//$archivo['file'][] = addslashes($imagedata);
				$archivo['file'][] = 'data:' . $file . '/' . $extension . ';base64,' . base64_encode($imagedata);;
			} else {
				$upload = new Upload;
				$upload->directorio = (isset($directorio) && $directorio != "") ? $directorio : "upload_file/catalogos/";
				$archivo['file'][] = $upload->upload_file(new Request( $request->all() ));
			}


		}
		return $archivo;
	}
	/**
	 * Carga y manda a llamar un facades para leer la informacion e insertar la informacion en sus respectivas tablas
	 * @access public
	 * @param string $request [Description]
	 * @param boolean nombre tabla a insertar  [Description]
	 * @return void
	 */
	public static function upload_file_catalogos(Request $request, $directorio, $models = null)
	{
		try {
			$upload = new Upload;
			$upload->directorio = (isset($directorio) && $directorio != "") ? $directorio : "upload_file/catalogos/";
			$upload->table_model = $models;
			$load_file = $upload->upload_file(new Request($request->all()));
			for ($i = 0; $i < count($load_file->result); $i++) {
				$ruta = ['ruta' => $load_file->result[$i]];
				if (!$models) {
					return array_to_object(['success' => false, 'message' => "Modelo no encontrado"]);
				}
				$upload->upload_read(new Request($ruta));
				$response = $upload->store_register();
			}
			return array_to_object($response);
		} catch (Exception $e) {
			$error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
			return ['success' => false, 'result' => $error, 'message' => "Ocurrio un error, favor de verificar"];
		}

	}

    /**
     * Metodo para hacer la consulta para los menus
     * @access public
     * @param string $request [Description]
     * @return array
     */
	public static function dataSession( $request )
	{
		$session = [];
		if ($request) {
			foreach ($request as $path ) {
				if (isset( $path->link ) && $path->link != "") {
					$session['ruta'] = $path->link;
					break;
				}
			}
		} else {
			$session['ruta'] = 'failed/error';
		}
		return $session;
	}

    /**
     *This method is for created one bitacora
     * @access private
     * @param bool $logout
     * @param SysUsersModel $users
     * @return void
     */
	protected function _binnacleCreate( SysUsersModel $users, bool $logout = false )
	{
		$error = null;
		DB::beginTransaction();
		try {
			$user = $users->whereId(Session::get('id'))->first();
			$sessions = SysSesionesModel::whereId($user->id_bitacora)->whereIdUsers(Session::get('id'))->fisrt();
			$beginDate  = isset($sessions->created_at) ? $sessions->created_at : timestamp();
			$endDate    = isset($sessions->updated_at) ? $sessions->updated_at : timestamp();

			if ($logout) {
				$dataLogout = [
					'conect'        => FALSE ,
                    'disconect'     => TRUE ,
                    'updated_at'    => timestamp() ,
                    'time_conected' => time_fechas($beginDate, timestamp())
				];
				SysSesionesModel::whereId($user->id_bitacora)->whereIdUsers(Session::get('id'))->update($dataLogout);

			} else {
				$data = [
					'id_users'      => Session::get('id') ,
                    'ip_address'    => get_client_ip() ,
                    'user_agent'    => detect()['user_agent'] ,
                    'conect'        => TRUE ,
                    'disconect'     => FALSE
				];
				$binnacle = SysSesionesModel::create($data);
				$users->whereId( Session::get('id') )->update(['id_bitacora' => $binnacle->id ]);
			}

			DB::commit();
			$success = true;
		} catch (\Exception $e) {
			$success = false;
			$error = $e->getMessage()." ".$e->getFile()." ".$e->getLine();
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
	protected static function _validateXml($xml_path = false)
	{
		if (!empty($xml_path)) {
			$data = self::_load_file_xml($xml_path);
			$texto = $data['texto'];
			$xml = $data['object'];
				#debuger($data);
				#se realiza las validaciones necesarias para identificar el tipo de comprobante que es.
			if (strpos($texto, "cfdi:Comprobante") !== false) {
				$tipo = "cfdi";
			} else
				if (strpos($texto, "<Comprobante") !== false) {
				$tipo = "cfd";
			} else
				if (strpos($texto, "retenciones:Retenciones") !== false) {
				$tipo = "retenciones";
			} else {
				die("Tipo de XML no identificado ....");
			}

			if ($tipo == "retenciones") {
				$root = $xml->getElementsByTagName('Retenciones')->item(0);
				$Version = $root->getAttribute("Version");
			} else {
				$root = $xml->getElementsByTagName('Comprobante')->item(0);
				$version = $root->getAttribute("version");
				if ($version == null) $version = $root->getAttribute("Version");
			}

			$factura = [];
			$Receptor = $root->getElementsByTagName('Receptor')->item(0);
			$Emisor = $root->getElementsByTagName('Emisor')->item(0);
			$Conceptos = $root->getElementsByTagName('Conceptos')->item(0);

			$factura['fecha'] = $root->getAttribute("fecha");
			$factura['noap'] = $root->getAttribute("noAprobacion");
			$factura['anoa'] = $root->getAttribute("anoAprobacion");
			$factura['tipo'] = $tipo;
				#se realiza la validacion y el parseo de datos dependiendo el tipo de documento y la version
			if ($tipo == "retenciones") {
				$factura['rfc'] = utf8_decode($Emisor->getAttribute('RFCEmisor'));
				$factura['rfc_receptor'] = utf8_decode($Receptor->getAttribute('RFCRecep'));
				$factura['version'] = $root->getAttribute("Version");
				$factura['no_certificado'] = $root->getAttribute("NumCert");
				$factura['cert'] = $root->getAttribute("Cert");
				$factura['sello'] = $root->getAttribute("Sello");
				$Totales = $root->getElementsByTagName('Totales')->item(0);
				$factura['total'] = $Totales->getAttribute("montoTotGrav");
			} else {
				$factura['version'] = $version;
				if ($version == "3.3") { // Mayusculas
					$factura['total'] = $root->getAttribute('Total');
					$factura['subTotal'] = $root->getAttribute('SubTotal');
					$factura['fecha'] = $root->getAttribute('Fecha');
					$factura['metodo_pago'] = $root->getAttribute('MetodoPago');
					$factura['forma_pago'] = $root->getAttribute("FormaPago");
					$factura['moneda'] = $root->getAttribute('Moneda');
					$factura['no_certificado'] = $root->getAttribute('NoCertificado');
					$factura['cert'] = $root->getAttribute('Certificado');
					$factura['sello'] = $root->getAttribute('Sello');
					$factura['rfc'] = utf8_decode($Emisor->getAttribute('Rfc'));
					$factura['rfc_receptor'] = utf8_decode($Receptor->getAttribute('Rfc'));
					$factura['razon_social'] = utf8_decode($Receptor->getAttribute('Nombre'));
					$factura['serie'] = $root->getAttribute("Serie");
					$factura['folio'] = $root->getAttribute("Folio");
					foreach ($Conceptos->getElementsByTagName('Concepto') as $productos) {
						$factura['conceptos'][] = [
							'cantidad' => $productos->getAttribute('Cantidad'), 'clave' => $productos->getAttribute('ClaveUnidad'), 'servicio' => $productos->getAttribute('ClaveProdServ'), 'nombre' => $productos->getAttribute('Descripcion'), 'precio' => $productos->getAttribute('ValorUnitario')
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
					$factura['rfc'] = utf8_decode($Emisor->getAttribute('rfc'));
					$factura['rfc_receptor'] = utf8_decode($Receptor->getAttribute('rfc'));
					$factura['razon_social'] = utf8_decode($Receptor->getAttribute('nombre'));
					$factura['serie'] = $root->getAttribute("serie");
					$factura['folio'] = $root->getAttribute("folio");
					foreach ($Conceptos->getElementsByTagName('Concepto') as $productos) {
						$factura['conceptos'][] = [
							'cantidad' => $productos->getAttribute('cantidad'), 'clave' => $productos->getAttribute('claveUnidad'), 'servicio' => $productos->getAttribute('claveProdServ'), 'nombre' => $productos->getAttribute('descripcion'), 'precio' => $productos->getAttribute('valorUnitario')
						];

					}

				} // version 3.3
			} // Retencion o CFDI

			$TFD = $root->getElementsByTagName('TimbreFiscalDigital')->item(0);
			if ($TFD != null) {
				$factura['version_tfd'] = $TFD->getAttribute("Version");
				if ($factura['version_tfd'] == "") $factura['version_tfd'] = $TFD->getAttribute("version");
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
	protected static function _load_file_xml($xml_path = false)
	{
		if (!empty($xml_path)) {
			$texto = file_get_contents($xml_path);
			if (substr($texto, 0, 3) == pack("CCC", 0xef, 0xbb, 0xbf)) {
				$texto = substr($texto, 3);
			}
			if (!mb_check_encoding($texto, "utf-8")) {
				echo "<h3>Error en XML, no esta en UTF-8!</h3>";
			}
			if (mb_check_encoding(utf8_decode($texto), "utf-8")) {
				utf8_decode($texto);
			}
  				#quita addenda solo valida fiscal
			$texto = preg_replace('{<Addenda.*/Addenda>}is', '<Addenda/>', $texto);
			$texto = preg_replace('{<cfdi:Addenda.*/cfdi:Addenda>}is', '<cfdi:Addenda/>', $texto);
			$xml = new DOMDocument();
			$xml->preserveWhiteSpace = false;
			$load_xml = $xml->loadXML($texto);
			if (!$load_xml) {
				display_xml_errors();
				die();
			}

			return $data = ['object' => $xml, 'texto' => $texto];
		}

		return false;

	}

    /**
     * Metodo para realizar los reportes de las facturas.
     * @access public
     * @param array $filtros
     * @return array
     */
	public static function reporte_general( $filtros = [] )
	{
		$fecha_actual = date('Y-m-d');
		$fecha_actual = explode('-', $fecha_actual);
		$anio = isset($fecha_actual[0]) ? $fecha_actual[0] : "";
		$mes = isset($fecha_actual[1]) ? $fecha_actual[1] : "";
		$ejecutivo = (isset($filtros['ejecutivo']) && count($filtros['ejecutivo']) > 0) ? implode(',', $filtros['ejecutivo']) : "";
		$estatus_factura = (isset($filtros['estatus']) && $filtros['estatus'] != "" && $ejecutivo != 0) ? " AND sf.id_estatus = " . $filtros['estatus'] : "";
		$ejecutivo = ($ejecutivo != "" && $ejecutivo != 0) ? " AND suf.id_users IN (" . $ejecutivo . ")" : "";
             #dd($ejecutivo);
		$fechas = (isset($filtros['fecha_inicio']) && $filtros['fecha_inicio'] != "" && isset($filtros['fecha_final']) && $filtros['fecha_final'] != "") ? " AND sp.fecha_pago BETWEEN '" . $filtros['fecha_inicio'] . "' AND '" . $filtros['fecha_final'] . "'" : "";
		$group_by = "";
		$group_by_suma = "";
		$orderby = " ORDER BY su.id ASC, sp.fecha_pago DESC, sf.fecha_factura DESC";
		$filtro_fechas = " AND MONTH(sp.fecha_pago) = " . $mes . " AND YEAR(sp.fecha_pago) = " . $anio;
		$suma = false;
		if ($ejecutivo == "" && $fechas == "") {
			$group_by .= " GROUP BY suf.id_users";
			$total = ",sum(distinct sf.total) as total_general";
			$pago = ",sum( distinct sf.comision) as comision_general";
			$comision = ",sum( distinct sf.pago) as pago_general";

		}
		if ($ejecutivo != "" && $fechas == "") {
			$group_by .= " GROUP BY suf.id_factura";
			$total = ",sum(distinct sf.total) as total_general";
			$pago = ",sum( distinct sf.comision) as comision_general";
			$comision = ",sum( distinct sf.pago) as pago_general";
		}
		if ($ejecutivo == "" && $fechas != "") {
			$group_by .= " GROUP BY sp.id";
			$total = " ,sum(distinct sf.total) as total_general";
			$pago = " ,sum( distinct sf.comision) as comision_general";
			$comision = " ,sum( distinct sf.pago) as pago_general";
		}
		if ($ejecutivo != "" && $fechas != "") {
			$group_by .= " GROUP BY sp.id ";

			$total = " ,sum( distinct sf.total ) as total_general";
			$pago = " ,sum( distinct sf.comision ) as comision_general";
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
			. $total
			. $pago
			. $comision .
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
                     WHERE sr.id = 2 AND sr.estatus = 1 AND su.estatus = 1 " . $estatus_factura . $ejecutivo . $fechas;

		if (!$suma) {
			$sql1 = $sql . $group_by . $orderby;
		}
		$suma = true;
		$group_by_suma .= " GROUP BY suf.id_factura";
		if ($suma) {
			$sql2 = $sql . $group_by_suma . $orderby;
		}
                     #debuger($sql1);
		$response = [
			'request' => DB::select($sql1), 'cantidades' => DB::select($sql2)
		];
		return $response;

	}

    /**
     * @return mixed
     */
    protected function _menusBelongsCompany()
    {
        if (Session::get("roles_id") == 1){

            $response = SysMenuModel::with('companiesMenus')
                ->orderBy('orden','ASC')
                ->groupby('id')
                ->get();
        }else{
            $response = SysEmpresasModel::find(Session::get('company_id'))
                ->menusCompanies()->with('companiesMenus')
                ->orderBy('orden','ASC')
                ->groupby('id')
                ->get();
        }
        return $response;
    }

    /**
     * @param SysUsersModel $users
     * @return mixed
     */
    protected function _actionByCompanies(SysUsersModel $users )
    {
        $user = $users->find(Session::get('id'));
        return $user->permission()->where([
            "status"       => TRUE
            ,"sys_permission_menus.company_id"  => Session::get('company_id')
            ,"sys_permission_menus.group_id"    => Session::get('group_id')
            ,"sys_permission_menus.roles_id"    => Session::get('roles_id')
        ])->groupby('id')->orderby('id','ASC')->get();

    }

    /**
     * @return mixed
     */
    protected function _groupsBelongsCompanies()
    {
        if( Session::get('roles_id') == 1 ){
            $response = SysSucursalesModel::with('companiesGroups')
                ->orderBy('id','DESC')
                ->get();
        }else{
            $response = SysEmpresasModel::find( Session::get('company_id') )
                ->groupsCompanies()->with('companiesGroups','rolesGroups')
                ->orderBy('id','DESC')
                ->groupby('id')
                ->get();
        }
        return $response;
    }

    /**
     * This method is for get roles by companies
     * @access public
     * @return void
     */
    protected function _rolesBelongsCompany()
    {
        if( Session::get('roles_id') == 1 ){
            $response = SysRolesModel::with('companiesRoles','groupsRoles')
                        ->orderBy('id','DESC')
                        ->get();
        }else{
            $response = SysEmpresasModel::find( Session::get('company_id') )
                        ->rolesCompanies()->with('companiesRoles','groupsRoles')
                        ->orderBy('id','DESC')
                        ->groupby('id')
                        ->get();
        }
        return $response;
    }

    /**
     * This is method is for do query
     * @return SysUsersModel[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function _usersBelongsCompany()
    {
        if( Session::get('roles_id') == 1 ){
            $response = SysUsersModel::with([
                            'bitacora'
                            ,'roles'
                            ,'groups'
                            ,'companies'
                        ])->orderBy('id','DESC')
                        ->groupby('id')->get();
        }else{
            $response = SysEmpresasModel::find(Session::get('company_id'))
                        ->users()
                        ->with([
                            'roles' ,
                            'groups' ,
                            'bitacora' ,
                            'companies' ,
                        ])->orderBy('id','DESC')->groupby('id')->get();
        }
        return $response;
    }

    /**
     * @return mixed
     */
    protected function _companyBelongsUsers()
    {
        if( Session::get('roles_id') == 1 ){
            $response = SysEmpresasModel::with("comerciales","postalCode","regimenes","states","countries","contacts" )
                        ->orderBy('id','DESC')->get();
        }else{
            $user = SysUsersModel::find(Session::get("id"));
            $response = $user->companies()
                            ->with("comerciales","postalCode","regimenes","states","countries","contacts" )
                            ->orderBy('id','DESC')->groupby('id')->get();
        }
        return $response;
    }

    /**
     * Metodo para cargar la platilla de forma general para la generacion de las cotizaciones/ pedidos
     * @access public
     * @param Request $request [Description]
     * @param bool $correo
     * @return void
     */
	protected function _plantillas( $request, $correo = false )
    {
		#debuger($request);
		$pdf = PDF::loadView('plantillas.reportes', $request );
		if (!$correo) {
        	return $pdf->stream();
		}else{
        	return $pdf->output();
		}
	}






}