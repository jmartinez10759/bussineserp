<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysMenuModel;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysRolMenuModel;

class MenuController extends MasterController
{
    private static $_tabla_model;

    public function __construct(){
      parent::__construct();
      self::$_tabla_model = new SysMenuModel;
    }
  /**
   *Metodo para pintar la vista y cargar la informacion principal del menu
   *@access public
   *@return void
   */
   public function index(){

       $response = $this->_consulta_menus( new SysUsersModel);
         $registros = [];
         $eliminar = (Session::get('permisos')['DEL'] == false)? 'style="display:block" ': 'style="display:none" ';
         foreach ($response as $respuesta) {
           $id['id'] = $respuesta->id;
           $editar = build_acciones_usuario($id,'v-editar','Editar','btn btn-primary','fa fa-edit', 'title="Editar"' );
           $borrar = build_acciones_usuario($id,'v-destroy','Borrar','btn btn-danger','fa fa-trash ','title="Borrar"'.$eliminar);
           $registros[] = [
              $respuesta->id
             ,self::menu_padre( $respuesta )
             ,$respuesta->texto
             ,$respuesta->link
             ,$respuesta->tipo
             ,$respuesta->icon
             ,$respuesta->orden
             ,($respuesta->estatus == 1)?"ACTIVO":"BAJA"
             ,$editar
             ,$borrar
           ];
         }

         $titulos = [
           'id'
           ,'Menú Padre'
           ,'Nombre Menu'
           ,'Url'
           ,'Tipo'
           ,'Icono'
           ,'Orden'
           ,'Estatus'
           ,''
           ,''
         ];
         $table = [
           'titulos' 		    => $titulos
           ,'registros' 	    => $registros
           ,'id' 			    => "datatable"
           ,'class'             => "fixed_header"
         ];

         $data = [
      			'page_title' 	      => "Configuración"
      			,'title'  		      => "Menus"
      			,'subtitle' 	      => "Creación de Menus"
      			,'data_table'  	      =>  data_table($table)
      			,'titulo_modal'       => "Crear Menú"
      			,'titulo_modal_edit'  => "Actualizar Menus"
      			,'campo_1' 		      => 'Menú'
      			,'campo_2' 		      => 'Tipo'
      			,'campo_3' 		      => 'Menú Padre'
      			,'campo_4' 		      => 'Url'
      			,'campo_5' 		      => 'Icono'
      			,'campo_6' 		      => 'Estatus'
      			,'campo_7' 		      => 'Posición'
      		];
          #debuger($data);
  		 return self::_load_view( 'administracion.configuracion.menu', $data );

   }

 /**
  *Metodo para pintar la vista y cargar la informacion principal del menu
  *@access public
  *@param Request $request [Description]
  *@return void
  */
  public static function tipo( Request $request ){
      $response = self::$_tabla_model::where( $request->all() )->get();
      $data = ['tipo_menu' => $response];
      return message(true, $data ,self::$message_success);
  }

  /**
   *Metodo para pintar la vista y cargar la informacion principal del menu
   *@access public
   *@param Request $request [Description]
   *@return void
   */
   public function store( Request $request ){
     
      $error = null;
      DB::beginTransaction();
      try {
        $response = SysMenuModel::create( $request->all() );
        if( Session::get('id_rol') != 1){
            $data = [
                'id_rol'  => Session::get('id_rol')
                ,'id_users'  => Session::get('id')
                  ,'id_empresa'  => Session::get('id_empresa')
                  ,'id_sucursal'   => Session::get('id_sucursal')
                    ,'id_menu'        => $response->id
                    ,'id_permiso'       => 5
                      ,'estatus'            => 1
            ];
            
            SysRolMenuModel::create($data);
        }
        $data_admin = [
            'id_rol'  => 1
            ,'id_users'  => 1
              ,'id_empresa'  => 0
              ,'id_sucursal'   => 0
                ,'id_menu'        => $response->id
                ,'id_permiso'       => 5
                  ,'estatus'           => 1
        ];
        SysRolMenuModel::create($data_admin);

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
    *Metodo para pintar la vista y cargar la informacion principal del menu
    *@access public
    *@param  $id [Description]
    *@return void
    */
    public function destroy( Request $request ){

      $error = null;
      DB::beginTransaction();
      try {
          $response = SysMenuModel::where(['id' => $request->id])->delete();
            SysRolMenuModel::where(['id_menu' => $request->id])->delete();
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
        $response = SysMenuModel::where(['id' => $request->id])->get();        
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
        SysMenuModel::where(['id' => $request->id])->update($request->all());
          $response = SysMenuModel::where(['id' => $request->id])->get();
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
     *Metodo para la actualizacion de los registros
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public static function menu_padre( $request ){
        $response = SysMenuModel::where(['id' => $request->id_padre])->get();
        if( count($response) ){
          return $response[0]->texto;
        }
        return "";
    }

}
