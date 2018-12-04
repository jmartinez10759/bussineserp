<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysSucursalesModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysEstadosModel;

class SucursalesController extends MasterController
{
    #se crea las propiedades
    private $_tabla_model;

    public function __construct(){
        parent::__construct();
        $this->_tabla_model = new SysSucursalesModel;
    }
    /**
     *Metodo para pintar la vista y cargar la informacion principal del menu
     *@access public
     *@return void
     */
     public function index(){
      if( Session::get('permisos')['GET'] )
        { return view('errors.error'); }
           $data = [
             'page_title' 	     => "Configuracion"
             ,'title'  		       => "Sucursales"
             
           ];
            
         return self::_load_view( 'administracion.configuracion.sucursales', $data );

     }
      /**
         *Metodo para obtener los datos de manera asicronica.
         *@access public
         *@param Request $request [Description]
         *@return void
         */
        public function all( Request $request ){

            try {
                $response = $this->_tabla_model::get();

        // debuger($data);
        $data = [
          'sucursales'  => $response
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
        */
        public function show( Request $request ){

            try {
                $response = $this->_tabla_model::where([ 'id' => $request->id ])->get();
                
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
            // debuger($request->all());
            $error = null;
            DB::beginTransaction();
            try {
              $response = $this->_tabla_model::create( $request->all());
                // debuger($request->all());
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
                // debuger($request->all());
                $response = $this->_tabla_model::where(['id' => $request->id] )->update( $request->all() );
            DB::commit();
            $success = true;
            } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            DB::rollback();
            }

            if ($success) {
            return $this->_message_success( 200, $response , self::$message_success );
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
         $error = null;
                DB::beginTransaction();
                try {
                    // debuger($request->id);
                    $response = $this->_tabla_model ::where(['id' => $request->id])->delete(); 
                    
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
      *Metodo para listar las sucursales. por empresa.
      *@access public
      *@param $id [Description]
      *@return void
      */
      public function lista_sucursal( Request $request ){

        Session::put(['id_empresa' => $request->id_empresa ]);
        $response = SysEmpresasModel::with(['sucursales' => function($query){
                 return $query->groupby('id');
              }])->where(['id' => $request->id_empresa])->get();
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
      public function load_lista_sucursal(){
          return view('administracion.configuracion.lista_sucursales' );
      }
      /**
       *Metodo meter en session la empresa y/o sucursal..
       *@access public
       *@param Request $request [Description]
       *@return void
       */
      public function portal( Request $request ){
          //$sessions['id_empresa']  = Session::get('id_empresa');
          $sessions['id_sucursal']  = $request->id_sucursal;
          Session::put($sessions);
          $response = SysUsersModel::with(['menus' => function($query){
             return $query->where(['sys_rol_menu.estatus' => 1, 'sys_rol_menu.id_empresa' => Session::get('id_empresa') ])->groupBy('sys_rol_menu.id_users','sys_rol_menu.id_menu','sys_rol_menu.estatus');
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
