<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysPaisModel;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysUsoCfdiModel;
use App\Model\Administracion\Configuracion\SysEstadosModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysClientesModel;
use App\Model\Administracion\Facturacion\SysFacturacionModel;
use App\Model\Administracion\Configuracion\SysContactosModel;
use App\Model\Administracion\Configuracion\SysActivitiesModel;
use App\Model\Administracion\Facturacion\SysUsersFacturacionModel;
use App\Model\Administracion\Configuracion\SysUsersActivitiesModel;
use App\Model\Administracion\Configuracion\SysClientesEmpresasModel;
use App\Model\Administracion\Configuracion\SysEmpresasSucursalesModel;
use App\Model\Administracion\Configuracion\SysContactosSistemasModel;
use App\Model\Administracion\Configuracion\SysServiciosComercialesModel;

class ClientesController extends MasterController
{
    #se crea las propiedades
    private $_tabla_model;

    public function __construct(){
        parent::__construct();
        $this->_tabla_model = new SysClientesModel;
    }
    /**
     *Metodo para obtener la vista y cargar los datos
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function index(){
      if( Session::get('permisos')['GET'] ){ return view('errors.error'); }
        
      $data = [
         'page_title' 	          => "Configuración"
         ,'title'  		            => "Prospectos"
      ];
         #debuger($data);
        return self::_load_view( 'administracion.configuracion.clientes', $data );
    }
    /**
     *Metodo para realizar la consulta por medio de su id
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function all( Request $request ){
      try { 
        $datos = $this->consulta_clientes();
        $data = [
          'prospectos'            => $datos['response']
          ,'clientes'             => $datos['response_clientes']
          ,'empresas'             => SysEmpresasModel::where(['estatus' => 1])->get()
          ,'paises'               => SysPaisModel::get()
          ,'servicio_comercial'   => SysServiciosComercialesModel::get()
          ,'uso_cfdi'             => SysUsoCfdiModel::get()
        ];

        return $this->_message_success( 200, $data , self::$message_success );
      } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return $this->show_error(6, $error, self::$message_error );
      }
        
    }
    /**
     *Metodo para realizar la consulta por medio de su id
     *@access public
     *@param Request $request [Description]
     *@return void
     **/ 
    public function show( Request $request ){
        #debuger($request->all());
        try {        
          $response = SysClientesModel::with(['contactos','actividades' => function( $query ){
             return $query->with(['usuarios','roles'])->orderby('id','desc')->get();
          }])->where(['id' => $request->id])->get();

          return $this->_message_success( 200, $response[0] , self::$message_success );
        } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return $this->show_error(6, $error, self::$message_error );
        }
        
    }
    /**
     *Metodo para
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function store( Request $request){
          #debuger( $request->all() );
          $error = null;
          DB::beginTransaction();
          try {
              $string_key_contactos = [ 'contacto','departamento','telefono', 'correo','id_study','extension', 'cargo' ];
                $string_data_clientes = [];
                $string_data_contactos = [];
                foreach( $request->all() as $key => $value ){
                    if( in_array( $key, $string_key_contactos) ){
                        if( $key == 'contacto' ){
                            $string_data_contactos['nombre_completo'] = strtoupper($value);
                        }else if( $key == 'correo'){
                            $string_data_contactos[$key] = strtolower( trim($value) );
                        }else{
                            $string_data_contactos[$key] = strtoupper($value);
                        }
                    };
                    if( !in_array( $key, $string_key_contactos) ){
                        if( !is_array($value)){
                            if($key == "logo"){
                              $string_data_clientes[$key] = (trim($value));
                            }else{
                              $string_data_clientes[$key] = strtoupper($value);
                            }
                        }
                    };
                }
                #debuger($string_data_contactos,false);
                #debuger($string_data_clientes);
                $response = $this->_tabla_model::create( $string_data_clientes );
                $response_contactos = SysContactosModel::create($string_data_contactos);
                $data = [
                    'id_empresa'       => (Session::get('id_rol') != 1)? Session::get('id_empresa')  :0
                    ,'id_sucursal'     => (Session::get('id_rol') != 1)? Session::get('id_sucursal') :0
                    ,'id_cliente'      => $response->id
                ];
                SysClientesEmpresasModel::create($data); 
                $datos['id_contacto'] = $response_contactos->id;   
                $datos['id_cliente']  = $response->id;   
                SysContactosSistemasModel::create($datos);
            DB::commit();
            $success = true;
          } catch (\Exception $e) {
              $success = false;
              $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
              DB::rollback();
          }

          if ($success) {
            return $this->_message_success( 201, $response , self::$message_success );
          }
          return $this->show_error(6, $error, self::$message_error );

    }
    /**
     *Metodo para la actualizacion de los registros
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function update( Request $request){
        #debuger( $request->all() );
        $error = null;
          DB::beginTransaction();
          try {
                $string_key_contactos = [ 'contacto','departamento','telefono', 'correo','id_study','extension', 'cargo' ];
                $string_data_clientes = [];
                $string_data_contactos = [];
                foreach( $request->all() as $key => $value ){
                    if( in_array( $key, $string_key_contactos) ){
                        if( $key == 'contacto' ){
                            $string_data_contactos['nombre_completo'] = strtoupper($value);
                        }else if( $key == 'correo'){
                            $string_data_contactos[$key] = strtolower( trim($value) );
                        }else{
                            $string_data_contactos[$key] = strtoupper($value);
                        }
                    };
                    if( !in_array( $key, $string_key_contactos) ){
                        if( !is_array($value)){
                            if($key == "logo"){
                              $string_data_clientes[$key] = (trim($value));
                            }else{
                              $string_data_clientes[$key] = strtoupper($value);
                            }
                        }
                    };
                    
                }
              #debuger($string_data_contactos,false);
              #debuger($string_data_clientes);
                #debuger($request->contactos);
            $this->_tabla_model::where(['id' => $request->id] )->update( $string_data_clientes );
            if( count($request->contactos) > 0){
               SysContactosModel::where(['id' => $request->contactos[0]['id'] ])->update($string_data_contactos);
            }else{
                $response_contactos = SysContactosModel::create($string_data_contactos);
                $data = [
                     'id_contacto'     => $response_contactos->id
                    ,'id_cliente'      => $request->id
                ];
               SysContactosSistemasModel::create($data);  
               if (Session::get('id_rol') != 1) {
                  $data['id_empresa']  = Session::get('id_empresa');
                  $data['id_sucursal'] = Session::get('id_sucursal');
                  SysClientesEmpresasModel::create($data); 
               }
                
            }
            DB::commit();
            $success = true;
          } catch (\Exception $e) {
              $success = false;
              $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
              DB::rollback();
          }

          if ($success) {
            #return $this->_message_success( 201, $success , self::$message_success );
            return $this->show( new Request(['id' => $request->id ] ) );
          }
          return $this->show_error(6, $error, self::$message_error );
        
    }
     /**
     *Metodo para la actualizacion de los registros
     *@access public
     *@param Request $request [Description]
     *@return void
     */
     public function store_activies( Request $request ){
        #debuger($request->all());
        $error = null;
          DB::beginTransaction();
          try {

              $actividad = SysActivitiesModel::create($request->comentarios);
              $data_comments = [
                  'id_users'      => Session::get('id')
                  ,'id_rol'       => Session::get('id_rol')
                  ,'id_empresa'   => Session::get('id_empresa')
                  ,'id_sucursal'  => Session::get('id_sucursal')
                  ,'id_cliente'   => $request->id
                  ,'id_actividad' => $actividad->id
              ];

              SysUsersActivitiesModel::create($data_comments); 
            DB::commit();
            $success = true;
          } catch (\Exception $e) {
              $success = false;
              $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
              DB::rollback();
          }

          if ($success) {
            return $this->show( new Request(['id' => $request->id ] ) );
          }
          return $this->show_error(6, $error, self::$message_error );

     }

     /**
     *Metodo para la actualizacion de los registros
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function estatus_update( Request $request ){

        $error = null;
          DB::beginTransaction();
          try {
             $this->_tabla_model::where(['id' => $request->id] )->update( [ 'estatus' => $request->estatus ] );
            DB::commit();
            $success = true;
          } catch (\Exception $e) {
              $success = false;
              $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
              DB::rollback();
          }

          if ($success) {
            return $this->_message_success( 201, $success , self::$message_success );
          }
          return $this->show_error(6, $error, self::$message_error );

    }
    /**
     *Metodo para borrar el registro
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function destroy( Request $request ){
        #debuger($request->all());
        $error = null;
        DB::beginTransaction();
        try {
          $where = ['id' => $request->id];
          $users_facturas = SysUsersFacturacionModel::where(['id_cliente' => $request->id])->get();
          $clientes_empresas = SysClientesEmpresasModel::where(['id_cliente' => $request->id])->get(); 
            #debuger($clientes_empresas);
          if( count($users_facturas) > 0){
              foreach ($users_facturas as $tbl_factura) {
                SysFacturacionModel::where(['id' => $tbl_factura->id_factura])->delete();
              }
          }
            if( count($clientes_empresas) > 0){
               foreach ($clientes_empresas as $tbl_clientes) {
                SysContactosModel::where(['id' => $tbl_clientes->id_contacto])->delete();
              } 
            }
          SysClientesModel::where( $where )->delete();
          SysClientesEmpresasModel::where(['id_cliente' => $request->id])->delete();
          SysContactosSistemasModel::where(['id_cliente' => $request->id])->delete();
          SysUsersActivitiesModel::where(['id_cliente' => $request->id])->delete();

          DB::commit();
          $success = true;
        } catch (\Exception $e) {
            $success = false;
            $error = $e->getFile()." ".$e->getMessage()." ".$e->getLine();
            DB::rollback();
        }

        if ($success) {
          return $this->_message_success(201,$request->all(),self::$message_success );
        }
        return $this->show_error(6,$error,self::$message_error);

        #return message(true,$request->all(),self::$message_success);
    
    }
    /**
     * Metodo para borrar el registro
     * @access public
     * @param Request $request [Description]
     * @return void
     */
    public function display_sucursales( Request $request ){
        #debuger($request->all());
        try {
            $response = SysEmpresasModel::with(['sucursales' => function($query){
                return $query->where(['sys_sucursales.estatus' => 1])->groupby('id')->get();
            }])->where(['id' => $request->id_empresa])->get();
            
            $sucursales = SysClientesEmpresasModel::select('id_sucursal')->where($request->all())->get();
            #se crea la tabla 
            $registros = [];
            foreach ($response[0]->sucursales as $respuesta) {
                $id['id'] = 'sucursal_'.$respuesta->id;
                $icon = build_actions_icons($id, 'id_sucursal="' . $respuesta->id . '" ','sucursal');
                $registros[] = [
                    $respuesta->codigo
                    ,$respuesta->sucursal
                    ,$respuesta->direccion
                    ,($respuesta->estatus == 1)?"ACTIVO":"BAJA"
                    ,$icon
                ];
            }

            $titulos = [ 'Codigo','Sucursal','Direccion', 'Estatus',''];
            $table = [
                'titulos' 		   => $titulos
                ,'registros' 	   => $registros
                ,'id' 			     => "sucursales"
            ];
            $data = [
                'tabla_sucursales'  => data_table($table)
                ,'sucursales'       => $sucursales
            ];
            return $this->_message_success(200, $data, self::$message_success);
        } catch (\Exception $e) {
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            return $this->show_error(6, $error, self::$message_error);
        }

    }
    /**
     * Metodo para insertar los permisos de los productos
     * @access public
     * @param Request $request [Description]
     * @return void
     */
    public function register_permisos(Request $request){

        $error = null;
        DB::beginTransaction();
        try {
            #$id_contacto = SysClientesModel::with(['contactos'])->where(['id' => $request->id_cliente])->get();
            SysClientesEmpresasModel::where(['id_cliente'=> $request->id_cliente])->delete();
            $response = [];
            for ($i=0; $i < count($request->matrix) ; $i++) { 
                $matrices = explode('|', $request->matrix[$i] );
                $id_sucursal = $matrices[0];
                #se realiza una consulta si existe un registro.
                $data = [
                    'id_empresa'    => $request->id_empresa
                    ,'id_sucursal'  => $id_sucursal
                    ,'id_cliente'   => $request->id_cliente
                ];
                $response[] = SysClientesEmpresasModel::create($data);
            }

            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            DB::rollback();
        }

        if ($success) {
            return $this->_message_success(201, $response, self::$message_success);
        }
        return $this->show_error(6, $error, self::$message_error);

    }
    /**
     * Metodo para realizar la parte de consulta de clientes
     * @access public
     * @param Request $request [Description]
     * @return void
     */
    public function consulta_clientes(){


        if( Session::get('id_rol') == 1 ){

            $response = SysClientesModel::with(['estados','contactos','empresas'])
                            ->where(['estatus' => 0])
                            ->orderBy('id','desc')
                            ->groupby('id')
                            ->get();

            $response_clientes = SysClientesModel::with(['estados','contactos','empresas'])
                                      ->where(['estatus' => 1])
                                      ->orderBy('id','desc')
                                      ->groupby('id')
                                      ->get();

        }elseif( Session::get('id_rol') == 3 ){
            $data = SysEmpresasModel::with(['clientes'])
            ->where(['id' => Session::get('id_empresa')])            
            ->get();

            $response = $data[0]->clientes()
                                    ->with(['estados','contactos','empresas'])
                                    ->where(['estatus' => 0])
                                    ->orderBy('id','desc')
                                    ->groupby('id')
                                    ->get();
            $response_clientes = $data[0]->clientes()
                                    ->with(['estados','contactos','empresas'])
                                    ->where(['estatus' => 1])
                                    ->orderBy('id','desc')
                                    ->groupby('id')
                                    ->get();

        }else{

            $data = SysUsersModel::with(['empresas'])
                                  ->where(['id' => Session::get('id')])            
                                  ->get();
            $empresas = $data[0]->empresas()
                                ->with(['clientes'])
                                ->where([ 'id' => Session::get('id_empresa') ])
                                ->get();
            $response = $empresas[0]->clientes()
                                    ->with(['estados','contactos','empresas'])
                                    ->where(['estatus' => 0])
                                    ->orderBy('id','desc')
                                    ->groupby('id')
                                    ->get();
            $response_clientes = $empresas[0]->clientes()
                                    ->with(['estados','contactos','empresas'])
                                    ->where(['estatus' => 1])
                                    ->orderBy('id','desc')
                                    ->groupby('id')
                                    ->get();


        }
        
        return [ 'response' => $response ,'response_clientes' => $response_clientes ];

    }




}
