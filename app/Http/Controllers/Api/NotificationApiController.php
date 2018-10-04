<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Api\MasterApiController;
use App\Model\Administracion\Configuracion\SysNotificacionesModel;
use App\Model\Administracion\Configuracion\SysRolesNotificacionesModel;

class NotificationApiController extends MasterApiController
{
  #se crea las propiedades
  private $_id = "id";

  public function __construct(){
      parent::__construct();
  }
  /**
   *Metodo para obtener la vista y cargar los datos
   *@access public
   *@param Request $request [Description]
   *@return void
   */
  public function index( Request $request ){
    return self::validate_permisson($this->_id,[],$request);
  }
  /**
   *Metodo para realizar la consulta por medio de su id
   *@access public
   *@param Request $request [Description]
   *@return void
   */
  public function show( Request $request ){
      //ddebuger($request->all());
      return $this->_message_success( 201,$request->all() );
  }
  /**
   *Metodo para
   *@access public
   *@param Request $request [Description]
   *@return void
   */
  public function store( Request $request ){
    #debuger($request->all());
    $error = null;
    DB::beginTransaction();
    try {
      $roles = [1,3];
      $response = SysNotificacionesModel::create( $request->all() );
      for($i = 0; $i < count($roles); $i++){
            $data = [
                'id_rol'              =>  $roles[$i]
                ,'id_empresa'         =>  1
                ,'id_notificacion'    =>  ( isset($response->id) )? $response->id : 0
                ,'estatus'            =>  1
            ];
          SysRolesNotificacionesModel::create( $data );
          
      }
      DB::commit();
      $success = true;
    } catch (\Exception $e) {
        $success = false;
        $error = $e->getMessage()." ".$e->getLine();
        DB::rollback();
    }

    if ($success) {
      return $this->_message_success( 201, $response );
    }
      return $this->show_error(6,$error);


  }
  /**
   *Metodo para la actualizacion de los registros
   *@access public
   *@param Request $request [Description]
   *@return void
   */
  public function update( Request $request, $id){
    #debuger($request->all());
    $error = null;
    DB::beginTransaction();
    try {
      $response = SysNotificacionesModel::where([$this->_id => $id])->update( $request->all() );
      $data = ['id_notificacion' =>  $id ];
      SysRolesNotificacionesModel::where( $data )->update(['estatus' => 0]);
      DB::commit();
      $success = true;
    } catch (\Exception $e) {
        $success = false;
        $error = $e->getMessage()." ".$e->getLine();
        DB::rollback();
    }

    if ($success) {
      return $this->_message_success( 201, $response );
    }
      return $this->show_error(6,$error);
  }
  /**
   *Metodo para borrar el registro
   *@access public
   *@param Request $request [Description]
   *@return void
   */
  public static function destroy( Request $request ){


  }

}
