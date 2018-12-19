<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysActivitiesModel;
use App\Model\Administracion\Configuracion\SysUsersActivitiesModel;
use App\Model\Administracion\Configuracion\SysNotificacionesModel;
use App\Model\Administracion\Configuracion\SysRolesNotificacionesModel;
use App\Http\Controllers\Administracion\Configuracion\ClientesController;

class ActivitiesController extends MasterController
{
    #se crea las propiedades
    private $_tabla_model;

    public function __construct(){
        parent::__construct();
        $this->_tabla_model = new SysActivitiesModel;
    }
    /**
     *Metodo para obtener la vista y cargar los datos
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function index(){

        $data = [
          'page_title' 	        	=> ""
          ,'title'  		        => ""
        ];
        return self::_load_view( 'development.vista',$data );
    }
    /**
     *Metodo para obtener los datos de manera asicronica.
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function all( Request $request ){

        try {


          return $this->_message_success( 200, $response , self::$message_success );
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
     */
    public function show( Request $request ){

        try {


          return $this->_message_success( 200, $response , self::$message_success );
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
    	
      $error = null;
      DB::beginTransaction();
      try {
      	  $users = SysUsersModel::with(['roles:id','empresas','sucursales:id',])
      	  						->where(['id' => $request->comentarios['id_users'] ])
      	  						->get();
      	  	$notifications =[
      	  		'portal' 	=> $users[0]->empresas[0]->razon_social
      	  		,'titulo' 	=> $request->comentarios['titulo']
      	  		,'mensaje' 	=> $request->comentarios['descripcion']
      	  	]; 
      	  	$register_notifications = SysNotificacionesModel::create( $notifications );
      	  	$pivot = [
      	  	   'id_users'      	    => $request->comentarios['id_users']
	          ,'id_rol'       		=> $users[0]->roles[0]->id
	          ,'id_empresa'   		=> $users[0]->empresas[0]->id
	          ,'id_sucursal'  		=> $users[0]->sucursales[0]->id
	          ,'id_notificacion'  	=> $register_notifications->id
      	  	];
      	  	SysRolesNotificacionesModel::create( $pivot );

      	  $actividad = SysActivitiesModel::create( $request->comentarios );
	      $data_activities = [
	          'id_users'      => $request->comentarios['id_users']
	          ,'id_rol'       => $users[0]->roles[0]->id
	          ,'id_empresa'   => $users[0]->empresas[0]->id
	          ,'id_sucursal'  => $users[0]->sucursales[0]->id
	          ,'id_cliente'   => $request->id
	          ,'id_actividad' => $actividad->id
	      ];
	      SysUsersActivitiesModel::create($data_activities); 
	      $cliente = new ClientesController();

        DB::commit();
        $success = true;
      } catch (\Exception $e) {
          $success = false;
          $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
          DB::rollback();
      }

      if ($success) {
        return $cliente->show( new Request(['id' => $request->id]));
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

      $error = null;
      DB::beginTransaction();
      try {


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
   * Metodo para borrar el registro
   * @access public
   * @param Request $request [Description]
   * @return void
   */
    public function destroy( Request $request ){
        #debuger($request->all());
        $error = null;
        DB::beginTransaction();
        try {
        	$response = $this->_tabla_model::where(['id' => $request->id ])->delete();
        	SysUsersActivitiesModel::where(['id_actividad' => $request->id ])->delete();
        	$cliente = new ClientesController();
        	#$clientes = $cliente->show( new Request(['id' => $request->id_cliente]))->original['result'];

          DB::commit();
          $success = true;
        } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            DB::rollback();
        }

        if ($success) {
          #return $this->_message_success( 201, $response , self::$message_success );
          return $cliente->show( new Request(['id' => $request->id_cliente]));
        }
        return $this->show_error(6, $error, self::$message_error );

    }
    /**
     * Metodo subir los catalogos e insertar la informacion
     * @access public
     * @param Request $request [Description]
     * @return void
     */
     public function upload_catalos( Request $request ){

         try {

           return $this->_message_success( 201, $response , self::$message_success );
         } catch (\Exception $e) {
             $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
             return $this->show_error(6, $error, self::$message_error );
         }

     }



}
