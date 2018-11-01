<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysRolesModel;
use App\Model\Administracion\Configuracion\SysUsersRolesModel;

class RolesController extends MasterController
{
      private $_tabla_model;

      public function __construct(){
        parent::__construct();
        $this->_tabla_model = new SysRolesModel;
      }
    /**
     *Metodo para pintar la vista y cargar la informacion principal del menu
     *@access public
     *@return void
     */
     public function index(){
           if( Session::get('permisos')['GET'] ){
              return view('errors.error');
           }
         $response = (Session::get('id_rol') == 1 )? $this->_tabla_model::get() : $this->_consulta( $this->_tabla_model,[],[],['id' => Session::get('id_empresa')],false );
         #debuger($response);
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
             'titulos' 		      => $titulos
             ,'registros' 	      => $registros
             ,'id' 			      => "datatable"
             ,'class'             => "fixed_header"
           ];

           $data = [
             'page_title' 	            => "Configuracion"
             ,'title'  		            => "Roles"
             ,'subtitle' 	            => "Creacion de Roles"
             ,'data_table'  	        =>  data_table($table)
             ,'titulo_modal'            => "Registro de Roles"
             ,'titulo_modal_edit'       => "Actualacion de Roles"
             ,'campo_1' 		        => 'Nombre Rol'
             ,'campo_2' 		        => 'Clave Corta'
             ,'campo_3' 		        => 'Estatus'
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
     public function store( Request $request){
        #debuger($request->all());
        $error = null;
        DB::beginTransaction();
        try {
            $response = SysRolesModel::create( $request->all() );
            if( Session::get('id_rol') != 1 ){
                $data = [
                  'id_users'      => 0 
                  ,'id_rol'       => $response->id
                  ,'id_empresa'   => Session::get('id_empresa')
                  ,'id_sucursal'  => Session::get('id_sucursal')
                ];
                SysUsersRolesModel::create($data);
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
      *Metodo para realizar la consulta por medio de su id
      *@access public
      *@param Request $request [Description]
      *@return void
      */
     public function show( Request $request ){
        try {
            $response = SysRolesModel::with('empresas')->where(['estatus' => 1, 'id' => $request->id ])->get();
          return $this->_message_success(201, $response[0], self::$message_success);
        } catch (\Exception $e) {
          $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
          return $this->show_error(6, $error, self::$message_error);
        }

     }
     /**
      *Metodo para la actualizacion de los registros
      *@access public
      *@param Request $request [Description]
      *@return void
      */
     public function update( Request $request){
        
        $error = null;
        DB::beginTransaction();
        try {
            $data = [];
            foreach ( $request->all() as $key => $value ) {
                if ( !in_array($key,['empresas'])) {
                    $data[$key] = $value;
                }
            }
            #debuger($data);
           SysRolesModel::where(['estatus' => 1, 'id' => $request->id])->update($data);
            $response = SysRolesModel::where(['id' => $request->id])->get();
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
      *Metodo para borrar el registro
      *@access public
      *@param $id [Description]
      *@return void
      */
     public function destroy( Request $request ){

        $error = null;
        DB::beginTransaction();
        try {
            $response = SysRolesModel::where(['id' => $request->id_rol ])->delete();
            SysUsersRolesModel::where(['id_rol' => $request->id_rol])->delete();
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

}
