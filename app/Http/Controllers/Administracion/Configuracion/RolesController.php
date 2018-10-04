<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysRolesModel;

class RolesController extends MasterController
{
      private static $_tabla_model;

      public function __construct(){
        parent::__construct();
        self::$_tabla_model = new SysRolesModel;
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
           $response = self::$_tabla_model::get();
           $registros = [];
           $eliminar = (Session::get('permisos')['DEL'] == false)? 'style="display:block" ': 'style="display:none" ';
           foreach ($response as $respuesta) {
             $id['id'] = $respuesta->id;
             $editar = build_acciones_usuario($id,'v-editar','Editar','btn btn-primary','fa fa-edit');
             $borrar = build_acciones_usuario($id,'v-destroy','Borrar','btn btn-danger','fa fa-trash','title="Borrar" '.$eliminar);
             $registros[] = [
                $respuesta->id
               ,$respuesta->perfil
               ,$respuesta->clave_corta
               ,($respuesta->estatus == 1)?"ACTIVO":"BAJA"
               ,$editar
               ,$borrar
             ];
           }

           $titulos = [ 'id','Nombre Rol','Clave Corta','Estatus','',''];
           $table = [
             'titulos' 		   => $titulos
             ,'registros' 	   => $registros
             ,'id' 			   => "datatable"
             ,'class'          => "fixed_header"
           ];

           $data = [
             'page_title' 	     => "Configuracion"
             ,'title'  		       => "Roles"
             ,'subtitle' 	       => "Creacion de Roles"
             ,'data_table'  	   =>  data_table($table)
             ,'titulo_modal'     => "Registro de Roles"
             ,'titulo_modal_edit'=> "Actualacion de Roles"
             ,'campo_1' 		     => 'Nombre Rol'
             ,'campo_2' 		     => 'Clave Corta'
             ,'campo_3' 		     => 'Estatus'
           ];
            #debuger($data);
         return self::_load_view( 'administracion.configuracion.roles', $data );

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
     public static function destroy( Request $request ){
        $where = ['id' => $request->id_rol];
        $response_destroy = self::$_model::delete_model( $where, self::$_tabla_model );
        if (!$response_destroy) {
          return message( true,$response_destroy,self::$message_success );
        }
        return message( false,$response_destroy,self::$message_error );

     }

}
