<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysMenuModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysUsersModel;

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

      // if (Session::get('id_rol') != 1) {
      //     $response = SysMenuModel::orderBy('tipo','desc')->get();
      // }else{
      // }
        $usuarios = SysUsersModel::with(['menus' => function ($query) {
          $where = [
            'sys_rol_menu.estatus' => 1, 'sys_rol_menu.id_empresa' => Session::get('id_empresa'), 'sys_rol_menu.id_sucursal' => Session::get('id_sucursal'), 'sys_rol_menu.id_rol' => Session::get('id_rol')
          ];
          return $query->where($where)->orderBy('orden', 'asc')->get();
        }])->where(['id' => Session::get('id')])->get();
        $response = [];
        foreach ($usuarios as $menu) {
            $response = $menu->menus;
        }
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
           'titulos' 		  => $titulos
           ,'registros' 	=> $registros
           ,'id' 			    => "datatable"
           ,'class'       => "fixed_header"
         ];

         $data = [
      			'page_title' 	      => "Configuración"
      			,'title'  		      => "Menus"
      			,'subtitle' 	      => "Creación de Menus"
      			,'data_table'  	    =>  data_table($table)
      			,'titulo_modal'     => "Crear Menú"
      			,'titulo_modal_edit'=> "Actualizar Menus"
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
   public static function store( Request $request ){
        $response_insert = self::$_model::create_model([$request->all()], self::$_tabla_model );
        if($response_insert){
            return message(true,$response_insert[0],self::$message_success);
        }
        return message(false,[],self::$message_error);
   }

   /**
    *Metodo para pintar la vista y cargar la informacion principal del menu
    *@access public
    *@param  $id [Description]
    *@return void
    */
    public static function destroy( $id ){

        $response_destroy = self::$_model::delete_model(['id' => $id],self::$_tabla_model );
        if( !$response_destroy ){
          return message(true,[],self::$message_success);
        }
        return message(false,$response_destroy,self::$message_error);

    }
    /**
     *Metodo para realizar la consulta por medio de su id
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public static function show( Request $request ){

        $response = self::$_model::show_model([],['id' => $request->id],self::$_tabla_model );
        if($response){
          return message(true,$response[0],self::$message_success);
        }
        return message(false,[],self::$message_error);

    }
    /**
     *Metodo para la actualizacion de los registros
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public static function update( Request $request){
        $where = ['id' => $request->id];
        $response = self::$_model::update_model($where,$request->all(), self::$_tabla_model );
        if ($response) {
          return message(true,$response[0],self::$message_success);
        }
        return message(false,[],self::$message_error);

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
