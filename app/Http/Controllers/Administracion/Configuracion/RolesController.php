<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysRolesModel;
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
     * @return JsonResponse
     */
     public function store( Request $request, SysRolesModel $roles )
     {
        $error = null;
        DB::beginTransaction();
        try {
            $data = array_filter($request->all(), function ($key) use ($request){
                if($key != "companyId"){
                    $data[$key] = $request->$key;
                    if ($request->$key == 0){
                        $data[$key] = "0";
                    }
                    return $data;
                }
            },ARRAY_FILTER_USE_KEY);

            $response = $roles->create($data);
            $rol = $roles->find($response->id);
            if ( isset($request->companyId ) ){
                $rol->companiesRoles()->sync($request->get("companyId"));
            }else{
                $rol->companiesRoles()->sync([Session::get('company_id')]);
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
     * This method is for get information the roles by companies
     * @access public
     * @param int|null $id
     * @param SysRolesModel $roles
     * @return JsonResponse
     */
     public function show( int $id = null, SysRolesModel $roles )
     {
        try {
          $response = $roles->with('companiesRoles','groupsRoles')->find($id);
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
     * @return JsonResponse
     */
     public function update( Request $request, SysRolesModel $roles )
     {
        $error = null;
        DB::beginTransaction();
        try {
            $data = array_filter($request->all(), function ($key) use ($request){
                if($key != "companyId"){
                    $data[$key] = $request->$key;
                    if ($request->$key == 0){
                        $data[$key] = "0";
                    }
                    return $data;
                }
            },ARRAY_FILTER_USE_KEY);

            $roles->whereId($request->get('id'))->update($data);
            if ( isset($request->companyId) && $request->companyId){
                $rol = $roles->find($request->get('id'));
                $rol->companiesRoles()->sync($request->get("companyId"));
            }

            DB::commit();
          $success = true;
        } catch ( \Exception $e) {
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
            $rol = $roles->find($id);
            $rol->companiesRoles()->detach();
            $rol->companies()->detach();
            $rol->delete();
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

}
