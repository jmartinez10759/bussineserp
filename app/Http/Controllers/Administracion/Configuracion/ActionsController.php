<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysAccionesModel;

class ActionsController extends MasterController
{

    public function __construct(){
        parent::__construct();
    }
    /**
     *Metodo para obtener la vista y cargar los datos
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public static function index(){

        $response = SysAccionesModel::orderBy('id','ASC')->get();
        $registros = [];
        $eliminar = (Session::get('permisos')['DEL'] == false)? 'style="display:block" ': 'style="display:none" ';
        foreach ($response as $respuesta) {
          $id['id'] = $respuesta->id;
          $editar = build_acciones_usuario($id,'v-editar','Editar','btn btn-primary','fa fa-edit','title="editar"');
          $borrar = build_acciones_usuario($id,'v-destroy','Borrar','btn btn-danger','fa fa-trash','title="borrar" '.$eliminar);
          $registros[] = [
             $respuesta->id
            ,$respuesta->clave_corta
            ,$respuesta->descripcion
            ,($respuesta->estatus == 1)?"ACTIVO":"BAJA"
            ,$editar
            ,$borrar
          ];
        }
        $titulos = [
          'id'
          ,'Clave Corta'
          ,'Descripción'
          ,'Estatus'
          ,''
          ,''
        ];
        $table = [
          'titulos' 		  => $titulos
          ,'registros' 	  => $registros
          ,'id' 			    => "datatable"
          ,'class'       => "fixed_header"
        ];

        $data = [
           'page_title' 	      => "Configuracion"
           ,'title'  		        => "Acciones"
           ,'subtitle' 	        => "Creacion Acciones"
           ,'data_table'  	    =>  data_table($table)
           ,'titulo_modal'      => "Agregar Accion"
           ,'titulo_modal_edit' => "Actualizar Accion"
           ,'campo_1' 		      => 'Clave'
           ,'campo_2' 		      => 'Descripción'
           ,'campo_3' 		      => 'Estatus'
         ];
        return self::_load_view( 'administracion.configuracion.actions',$data );
    }
    /**
     *Metodo para realizar la consulta por medio de su id
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public static function show( Request $request ){

        $where = ['id' => $request->id];
        $response_show =self::$_model::show_model([],$where, new SysAccionesModel);
        if ($response_show) {
          return message( true,$response_show[0],self::$message_success );
        }
        return message( false,[],self::$message_error );

    }
    /**
     *Metodo para
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public static function store( Request $request){

      $response_store = self::$_model::create_model([$request->all()], new SysAccionesModel );
      if ($response_store) {
        return message( true,$response_store[0],self::$message_success );
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
        $response_update = self::$_model::update_model($where, $request->all(), new SysAccionesModel );
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
      $response_destroy = self::$_model::delete_model( $where, new SysAccionesModel );
      if (!$response_destroy) {
        return message( true,$response_destroy,self::$message_success );
      }
      return message( false,$response_destroy,self::$message_error );

    }


}
