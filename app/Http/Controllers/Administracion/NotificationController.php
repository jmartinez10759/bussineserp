<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;

use App\Model\Administracion\Configuracion\SysNotificacionesModel;
use App\Model\Administracion\Configuracion\SysRolesNotificacionesModel;

class NotificationController extends MasterController
{
    #se crea las propiedades
    private $_tabla_model;

    public function __construct(){
          parent::__construct();
          $this->_tabla_model = "";
    }
    /**
     *Metodo para obtener la vista y cargar los datos
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function index(){

        $data = [
          'page_title' 	        => ""
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
        	$response = SysNotificacionesModel::whereId( $request->id )->first();
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

}