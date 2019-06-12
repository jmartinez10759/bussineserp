<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use App\SysUsersMenus;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysSucursalesModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;

class SucursalesController extends MasterController
{
    private $_tabla_model;

    public function __construct(){
        parent::__construct();
        $this->_tabla_model = new SysSucursalesModel;
    }

    /**
     * This method load the view.
     * @access public
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
     public function index()
     {
           $data = [
             'page_title' 	     => "Configuracion" ,
             'title'  		     => "Sucursales" ,
           ];
         return $this->_loadView( 'administracion.configuracion.sucursales', $data );
     }

    /**
     * This method is for load all information
     * @access public
     * @return JsonResponse
     */
      public function all()
      {
          try {
              $data = [
                  "groups"     => $this->_groupsBelongsCompanies() ,
              ];
              return new JsonResponse([
                  "success" => TRUE ,
                  "data"    => $data ,
                  "message" => self::$message_success
              ],Response::HTTP_OK);

          } catch ( \Exception $e) {
              $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
              return new JsonResponse([
                  "success" => FALSE ,
                  "data"    => $error ,
                  "message" => self::$message_error
              ],Response::HTTP_BAD_REQUEST);
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
     * @access public
     * @param Request $request
     * @return JsonResponse
     */
      public function listGroup(Request $request)
      {
        Session::put(['company_id' => $request->get("id_empresa")]);
        $companies = SysEmpresasModel::with(['groups'])->whereId($request->get("id_empresa"))->first();
        $groups = $companies->groups()->groupBy('id')->get();
         $data['groups'] = $groups;
         return new JsonResponse([
             'success'  => true
            ,'data'     => $data
            ,'message'  => "¡Listado de sucursales por empresa!"
         ],Response::HTTP_OK);

      }

    /**
     *This method is for get acces the portal system
     * @access public
     * @param int $groupId
     * @param SysUsersMenus $usersMenus
     * @return JsonResponse
     */
      public function portal( int $groupId = null )
      {
          $sessions['group_id']  = $groupId;
          $user  = SysUsersModel::find(Session::get('id'));
          $roles = $user->roles()->first();
          $menus = $user->menus()->where([
              "sys_users_menus.user_id"     => $user->id ,
              "sys_users_menus.roles_id"    => $roles->id ,
              "sys_users_menus.company_id"  => Session::get("company_id") ,
              "sys_users_menus.group_id"    => $groupId
          ])->get();
          $sessions['roles_id'] = isset($roles->id)? $roles->id: "";
          $pathWeb = self::dataSession( $menus );
          $session = array_merge($sessions,$pathWeb);
            if( count($menus) < 1 ){
                return new JsonResponse([
                    'success'   => true
                    ,'data'     => $sessions
                    ,"message"  => '¡No cuenta con Menus asignados, favor de contactar al administrador!'
                ],Response::HTTP_OK);
            }
           Session::put( $session );
            return new JsonResponse([
                'success'   => true
                ,'data'     => $session
                ,'message'  => "¡Grupo seleccionado correctamente!"
            ], Response::HTTP_OK);

      }

}
