<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysRolesModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysUsersRolesModel;
use App\SysCompaniesRoles;
use Symfony\Component\HttpFoundation\JsonResponse;

class RolesController extends MasterController
{

      public function __construct()
      {
        parent::__construct();
      }

    /**
     * @access public
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
     public function index()
     {
       $data = [
         'page_title' 	              => "Configuración"
         ,'title'  		              => "Roles"
         ,'titulo_modal'              => "Agregar Registro"
         ,'campo_1' 		          => 'Perfil'
         ,'campo_2' 		          => 'Clave Corta'
         ,'campo_3' 		          => 'Estatus'
       ];

       return $this->_loadView( 'administracion.configuracion.roles', $data );

     }

    /**
     * This method is for get all data roles by company
     * @access public
     * @return JsonResponse
     */
     public function all()
     {
        try {
          $data = $this->_rolesBelongsCompany();
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
     * This method is for insert information in roles
     * @access public
     * @param Request $request [Description]
     * @param SysRolesModel $roles
     * @param SysCompaniesRoles $companyRoles
     * @return JsonResponse
     */
     public function store( Request $request, SysRolesModel $roles, SysCompaniesRoles $companyRoles )
     {
        $error = null;
        DB::beginTransaction();
        try {
            $response = $roles->create($request->all());
            if( Session::get('id_rol') != 1 ){
                $data = [
                  'id_rol'       => $response->id ,
                  'id_empresa'   => Session::get('id_empresa') ,
                  'id_sucursal'  => Session::get('id_sucursal') ,
                ];
                $companyRoles->create($data);
            }

          DB::commit();
          $success = true;
        } catch (\Exception $e) {
          $success = false;
          $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
          DB::rollback();
        }

        if ($success) {
            return new JsonResponse([
                'success'   => $success
                ,'data'     => $response
                ,'message' => self::$message_success
            ],Response::HTTP_CREATED);
        }
         return new JsonResponse([
             'success'   => $success
             ,'data'     => $error
             ,'message' => self::$message_error
         ],Response::HTTP_BAD_REQUEST);

     }
     /**
      *Metodo para realizar la consulta por medio de su id
      *@access public
      *@param Request $request [Description]
      *@return void
      */
     public function show( Request $request ){

        try {
          $response = SysRolesModel::with('empresas')->whereId( $request->id )->first();
          return $this->_message_success(201, $response, self::$message_success);
        } catch (\Exception $e) {
          $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
          return $this->show_error(6, $error, self::$message_error);
        }

     }

    /**
     * This method is for update register the roles
     * @access public
     * @param Request $request [Description]
     * @param SysRolesModel $roles
     * @return void
     */
     public function update( Request $request, SysRolesModel $roles )
     {
        $error = null;
        DB::beginTransaction();
        try {
            $data = [];
            foreach ( $request->all() as $key => $value ) {
                if ( !in_array($key,['empresas'])) {
                    $data[$key] = $value;
                }
            }
            $roles->whereEstatus(1)->whereId($request->get('id'))->update($data);
            $response = $roles->whereId($request->get('id') )->first();
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
     * This method is for destroy register the rol by companies
     * @access public
     * @param int $id [Description]
     * @param SysRolesModel $roles
     * @return JsonResponse
     */
     public function destroy( int $id = null, SysRolesModel $roles )
     {
        $error = null;
        DB::beginTransaction();
        try {
            $response = $roles->whereId($id)->delete();
            SysUsersRolesModel::whereIdRol($id)->delete();
          DB::commit();
          $success = true;
        } catch (\Exception $e) {
          $success = false;
          $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
          DB::rollback();
        }

        if ($success) {
            return new JsonResponse([
                'success'   => $success
                ,'data'     => $response
                ,'message' => self::$message_success
            ],Response::HTTP_OK);
        }
         return new JsonResponse([
             'success'   => $success
             ,'data'     => $error
             ,'message' => self::$message_error
         ],Response::HTTP_BAD_REQUEST);

     }

    /**
     * Metodo para realizar la parte de consulta de general
     * @access public
     * @return void
     */
    private function _rolesBelongsCompany(){

        if( Session::get('id_rol') == 1 ){
            $response = SysRolesModel::with(['empresas','sucursales'])
                                      ->orderBy('id','desc')
                                      ->groupby('id')
                                      ->get();

        }else{

            $response = SysEmpresasModel::with('roles')
                                    ->whereId( Session::get('id_empresa') )            
                                    ->first()
                                    ->roles()->with(['empresas','sucursales'])
                                    ->orderBy('id','DESC')
                                    ->groupby('id')
                                    ->get();
        }

        return $response;

    }



}
