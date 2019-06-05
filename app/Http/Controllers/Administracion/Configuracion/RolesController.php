<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use App\Model\Administracion\Configuracion\SysUsersModel;
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

          $data = [
              "roles"     => $this->_rolesBelongsCompany() ,
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
            $data = array_filter($request->all(), function ($key) use ($request){
                if($key != "companyId"){
                    return $request->get($key);
                }
            },ARRAY_FILTER_USE_KEY);
            $response = $roles->create($data);
            if( Session::get('id_rol') != 1 ){
                $data = [
                  'id_rol'       => $response->id ,
                  'id_empresa'   => Session::get('id_empresa') ,
                  'id_sucursal'  => Session::get('id_sucursal') ,
                ];
            }else{
                $data = [
                    'id_rol'       => $response->id ,
                    'id_empresa'   => $request->get("companyId") ,
                ];
            }
            $companyRoles->create($data);

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
     * This method is for get information the roles by companies
     * @access public
     * @param Request $request [Description]
     * @param SysRolesModel $roles
     * @return JsonResponse
     */
     public function show( Request $request, SysRolesModel $roles )
     {
        try {
          $response = $roles->with('empresas')->whereId( $request->get("id") )->first();
            return new JsonResponse([
                'success'   => TRUE
                ,'data'     => $response
                ,'message'  => self::$message_success
            ],Response::HTTP_OK);

        } catch (\Exception $e) {
          $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            return new JsonResponse([
                'success'   => FALSE
                ,'data'     => $error
                ,'message'  => self::$message_error
            ],Response::HTTP_BAD_REQUEST);

        }

     }

    /**
     * This method is for update register the roles
     * @access public
     * @param Request $request [Description]
     * @param SysRolesModel $roles
     * @param SysCompaniesRoles $companyRoles
     * @return JsonResponse
     */
     public function update( Request $request, SysRolesModel $roles, SysCompaniesRoles $companyRoles )
     {
        $error = null;
        DB::beginTransaction();
        try {
            $data = array_filter($request->all(), function ($key) use ($request){
                if($key != "companyId"){
                    return $request->get($key);
                }
            },ARRAY_FILTER_USE_KEY);
            $roles->whereId($request->get('id'))->update($data);
            if( Session::get('id_rol') == 1 ){
                $companyRoles->whereIdRol($request->get("id"))->delete();
                if ( isset($request->companyId ) ){
                    for ($i = 0; $i < count($request->get("companyId")); $i++){
                        $data = [
                            'id_rol'       => $request->get("id") ,
                            'id_empresa'   => $request->get("companyId")[$i] ,
                        ];
                        $companyRoles->create($data);
                    }
                }
            }
            DB::commit();
          $success = true;
        } catch (\Exception $e) {
          $success = false;
          $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
          DB::rollback();
        }

        if ($success) {
           return $this->show( new Request($request->all()), new SysRolesModel );
        }
         return new JsonResponse([
             'success'   => FALSE
             ,'data'     => $error
             ,'message'  => self::$message_error
         ],Response::HTTP_BAD_REQUEST);

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
            $roles->whereId($id)->delete();
            SysUsersRolesModel::whereIdRol($id)->delete();
            SysCompaniesRoles::whereIdRol($id)->delete();
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
                ,'data'     => []
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
                                      ->orderBy('id','DESC')
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
