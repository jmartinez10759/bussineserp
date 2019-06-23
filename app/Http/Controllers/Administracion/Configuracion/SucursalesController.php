<?php

namespace App\Http\Controllers\Administracion\Configuracion;

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
    /**
     * SucursalesController constructor.
     */
    public function __construct()
    {
        parent::__construct();
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
     * This method is used load all information
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
     * This method is used get data with id of group
     * @access public
     * @param int|null $id
     * @param SysSucursalesModel $groups
     * @return JsonResponse
     */
    public function show( int $id = null , SysSucursalesModel $groups )
    {
        try {
            $response = $groups->with('companiesGroups','rolesGroups')->find($id);
            return new JsonResponse([
                'success'   => TRUE
                ,'data'     => $response
                ,'message'  => self::$message_success
            ],Response::HTTP_OK);

        } catch ( \Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return new JsonResponse([
                'success'   => FALSE
                ,'data'     => $error
                ,'message'  => self::$message_error
            ],Response::HTTP_BAD_REQUEST);

        }
    }

    /**
     * This method is used to insert data in relations tables
     * @access public
     * @param Request $request [Description]
     * @param SysSucursalesModel $groups
     * @return JsonResponse
     */
    public function store( Request $request, SysSucursalesModel $groups )
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

            $response = $groups->create($data);
            $group = $groups->find($response->id);
            if ( isset($request->companyId ) && $request->companyId){
                $group->companiesGroups()->sync($request->get("companyId"));
            }else{
                $group->companiesGroups()->sync([Session::get('company_id')]);
            }

            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
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
     * This method is used to update the information
     * @access public
     * @param Request $request [Description]
     * @param SysSucursalesModel $groups
     * @return JsonResponse
     */
     public function update( Request $request, SysSucursalesModel $groups )
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
            $groups->whereId($request->get('id'))->update($data);
            if ( isset($request->companyId) && $request->companyId){
                $group = $groups->find($request->get("id") );
                $group->companiesGroups()->sync($request->get("companyId"));
            }
            DB::commit();
            $success = true;

        } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            DB::rollback();
        }

        if ($success) {
            return $this->show( $request->get("id"), new SysSucursalesModel );
        }
         return new JsonResponse([
             'success'   => FALSE
             ,'data'     => $error
             ,'message'  => self::$message_error
         ],Response::HTTP_BAD_REQUEST);

     }

    /**
     *This method is delete register of group
     * @access public
     * @param int|null $id
     * @param SysSucursalesModel $groups
     * @return JsonResponse
     */
     public function destroy( int $id = null, SysSucursalesModel $groups )
     {
         $error = null;
         DB::beginTransaction();

         try {
             $group = $groups->find($id);
             $group->companiesGroups()->detach();
             $group->rolesGroups()->detach();
             $group->companies()->detach();
             $group->delete();

            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
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
     * This method is used to list group by company
     * @access public
     * @param Request $request
     * @return JsonResponse
     */
      public function listGroup(Request $request)
      {
        Session::put(['company_id' => $request->get("id_empresa")]);
        $companies = SysEmpresasModel::find($request->get("id_empresa"));
        $groups = $companies->groups()->where([
            "sys_users_pivot.user_id"    => Session::get("id") ,
            "sys_users_pivot.company_id" => $request->get("id_empresa")
        ])->groupBy('id')->get();
         $data['groups'] = $groups;
         return new JsonResponse([
             'success'  => true
            ,'data'     => $data
            ,'message'  => "¡Listado de sucursales por empresa!"
         ],Response::HTTP_OK);

      }

    /**
     * This method is used get access system portal
     * @access public
     * @param int $groupId
     * @return JsonResponse
     */
      public function portal( int $groupId = null )
      {
          $sessions['group_id']  = $groupId;
          $user  = SysUsersModel::find(Session::get('id'));
          $roles = $user->roles()->where([
              "sys_users_pivot.user_id" => Session::get('id')
          ])->first();
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
                    'success'   => false
                    ,'data'     => $sessions
                    ,"message"  => '¡No cuenta con Menus asignados, favor de contactar al administrador!'
                ],Response::HTTP_BAD_REQUEST);
            }
           Session::put( $session );
            return new JsonResponse([
                'success'   => true
                ,'data'     => $session
                ,'message'  => "¡Grupo seleccionado correctamente!"
            ], Response::HTTP_OK);

      }

}
