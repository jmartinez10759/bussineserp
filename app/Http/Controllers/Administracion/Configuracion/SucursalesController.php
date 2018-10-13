<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysSucursalesModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;

class SucursalesController extends MasterController
{
    #se crea las propiedades
    private static $_tabla_model;

    public function __construct(){
        parent::__construct();
        self::$_tabla_model = new SysSucursalesModel;
    }
    /**
     *Metodo para pintar la vista y cargar la informacion principal del menu
     *@access public
     *@return void
     */
     public static function index(){
         if( Session::get('permisos')['GET'] ){
          return view('errors.error');
        }
           $response = self::$_tabla_model::all();
           $registros = [];
           foreach ($response as $respuesta) {
             $id['id'] = $respuesta->id;
             $editar = build_acciones_usuario($id,'v-editar','Editar','btn btn-primary','fa fa-edit');
             $borrar = build_acciones_usuario($id,'v-destroy','Borrar','btn btn-danger','fa fa-trash');
             $registros[] = [
                $respuesta->id
               ,$respuesta->codigo
               ,$respuesta->sucursal
               ,$respuesta->direccion
               ,($respuesta->estatus == 1)?"ACTIVO":"BAJA"
               ,$editar
               ,$borrar
             ];
           }

           $titulos = [ 'id','Codigo','Sucursal','Dirección','Estatus','',''];
           $table = [
             'titulos' 		     => $titulos
             ,'registros' 	     => $registros
             ,'id' 			     => "datatable"
           ];

           $data = [
             'page_title' 	     => "Configuracion"
             ,'title'  		       => "Sucursales"
             ,'subtitle' 	       => "Creacion de Sucursales"
             ,'data_table'  	   =>  data_table($table)
           ];
            
         return self::_load_view( 'administracion.configuracion.sucursales', $data );

     }
     /**
      *Metodo para
      *@access public
      *@param Request $request [Description]
      *@return void
      */
     public static function store( Request $request){

        $response_store = self::$_model::create_model([$request->all()], self::$_tabla_model );
        if ($response_store) {
          return message( true,$response_store[0],self::$message_success );
        }
        return message( false,[],self::$message_error );

     }
     /**
      *Metodo para realizar la consulta por medio de su id
      *@access public
      *@param Request $request [Description]
      *@return void
      */
     public static function show( Request $request ){
        $where = ['id' => $request->id];
        $response_show =self::$_model::show_model([],$where, self::$_tabla_model );
        if ($response_show) {
          return message( true,$response_show[0],self::$message_success );
        }
        return message( false,[],self::$message_error );

     }
     /**
      *Metodo para la actualizacion de los registros
      *@access public
      *@param Request $request [Description]
      *@return void
      */
     public static function update( Request $request){
       $where = ['id' => $request->id];
       $response_update = self::$_model::update_model($where, $request->all(), self::$_tabla_model );
       if ($response_update) {
         return message( true,$response_update[0],self::$message_success );
       }
       return message( false,[],self::$message_error );

     }
     /**
      *Metodo para borrar el registro
      *@access public
      *@param $id [Description]
      *@return void
      */
     public static function destroy( $id ){
        $where = ['id' => $id];
        $response_destroy = self::$_model::delete_model( $where, self::$_tabla_model );
        if (!$response_destroy) {
          return message( true,$response_destroy,self::$message_success );
        }
        return message( false,$response_destroy,self::$message_error );

     }
     /**
      *Metodo para listar las sucursales. por empresa.
      *@access public
      *@param $id [Description]
      *@return void
      */
      public static function lista_sucursal( Request $request ){

        Session::put(['id_empresa' => $request->id_empresa ]);
        $response = SysEmpresasModel::with(['sucursales' => function($query){
            return $query->groupby('id');
        }])->where(['id' => $request->id_empresa])->get();
          #debuger($response);
         $sucursal = [];
         foreach ($response as $sucursales) {
            foreach ($sucursales->sucursales as $bussines) {
                if( $bussines->pivot->estatus == 1){
                  $sucursal[] = $bussines;
                }
            }
         }
         $data['sucursales'] = $sucursal;
         return message( true, $data , "¡Listado de sucursales de la empresa!" );
          
      }
      /**
       *Metodo para Cargar la vista de las sucursales por empresa.
       *@access public
       *@param $id [Description]
       *@return void
       */
      public static function load_lista_sucursal(){

            return view('administracion.configuracion.lista_sucursales' );
      }
      /**
       *Metodo meter en session la empresa y/o sucursal..
       *@access public
       *@param Request $request [Description]
       *@return void
       */
      public static function portal( Request $request ){
          //$sessions['id_empresa']  = Session::get('id_empresa');
          $sessions['id_sucursal']  = $request->id_sucursal;
          Session::put($sessions);
          $response = SysUsersModel::with(['menus' => function($query){
             return $query->where(['sys_rol_menu.estatus' => 1, 'sys_rol_menu.id_empresa' => Session::get('id_empresa') ])
                             ->groupBy('sys_rol_menu.id_users','sys_rol_menu.id_menu','sys_rol_menu.estatus');
           },'roles' => function( $query ){
               return $query->where(['sys_roles.estatus' => 1 ])
                             ->groupBy('sys_users_roles.id_users','sys_users_roles.id_rol');
           }])->where( ['id' => Session::get('id')] )->get();

           $sessions['id_rol'] = isset($response[0]->roles[0]->id)?$response[0]->roles[0]->id: "";
           $ruta = self::data_session( $response[0]->menus );
           $sesiones = array_merge($sessions,$ruta);
 					if( count($response[0]->menus) < 1 ){
 							return message(true,$sesiones,'¡No cuenta con permisos necesarios, favor de contactar al administrador!');
 					}
           Session::put( $sesiones );
           #consulta para obtener las rutas.
           return message( true, array_merge($sessions,$ruta) ,'¡Seleccion de la sucursal correctamente!');

      }

}
