<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use App\Model\Administracion\Configuracion\SysPermissionMenus;
use App\SysPermission;
use App\SysUsersMenus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysUsersModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PermisosController extends MasterController
{
    public function __construct()
    {
      parent::__construct();
    }

    /**
     * @param Request $request
     * @param SysUsersModel $users
     * @return JsonResponse
     */
    public function findMenuByUsers( Request $request, SysUsersModel $users )
    {
        try {
            if ($request->get("rolesId") != 1 ){
                if ( !$request->get("groupId")|| $request->get("groupId") == 0 || $request->get("groupId") == NULL){
                    return new JsonResponse([
                        "success"   => FALSE ,
                        "data"      => "Groupid no tiene Informacion" ,
                        "message"   => self::$message_error
                    ],Response::HTTP_BAD_REQUEST);
                }
                $user = $users->find($request->get("userId"));
                $permission = $user->menus()->where([
                    "sys_users_menus.user_id"    => $request->get("userId"),
                    "sys_users_menus.roles_id"   => $request->get("rolesId"),
                    "sys_users_menus.company_id" => $request->get("companyId"),
                    "sys_users_menus.group_id"   => $request->get("groupId")
                ])->get();
            }else{
                $user = $users->with('menus')->whereId($request->get("userId"))->first();
                $permission = $user->menus()->whereEstatus(TRUE)->get();
            }

            return new JsonResponse([
                "success"   => TRUE ,
                "data"      => ["menusByUser" => $permission],
                "message"   => self::$message_success
            ],Response::HTTP_OK);

        } catch ( \Exception $error ) {
            $errors = $error->getMessage()." ".$error->getFile()." ".$error->getLine();
            return new JsonResponse([
                "success"   => FALSE,
                "data"      => $errors,
                "message"   => self::$message_error
            ],Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * This method is for find one actions by Menu
     * @param Request $request
     * @param SysUsersModel $users
     * @return JsonResponse
     */
    public function findActionsByMenu(Request $request, SysUsersModel $users )
    {
        try {
            $user = $users->find($request->get("userId"));
            if($request->get("rolesId") == 1){
                $menus = $user->menus()->with('permission')->whereEstatusAndId(TRUE,$request->get("menuId"))->first();
                $actions = $menus->permission()->whereStatus(TRUE)->groupby('id')->orderby('id','DESC')->get();
            }else{
                $actions = $user->permission()->where([
                    "sys_permission_menus.user_id"    => $request->get("userId"),
                    "sys_permission_menus.roles_id"   => $request->get("rolesId"),
                    "sys_permission_menus.company_id" => $request->get("companyId"),
                    "sys_permission_menus.group_id"   => $request->get("groupId"),
                    "sys_permission_menus.menu_id"    => $request->get("menuId"),
                ])->get();
            }
            return new JsonResponse([
                "success"   => true ,
                "data"      => ["actionsByUser" => $actions] ,
                "message"   => self::$message_success
            ],Response::HTTP_OK);

        } catch ( \Exception $error ) {
            $errors = $error->getMessage()." ".$error->getFile()." ".$error->getLine();
            return new JsonResponse([
                "success"   => false,
                "data"      => $errors,
                "message"   => self::$message_error
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * This method is for create the permission of menu by User
     * @access public
     * @param Request $request
     * @param SysUsersMenus $usersMenus
     * @return void
     */
   public function createPermission( Request $request, SysUsersMenus $usersMenus )
   {
      $error = null;
      DB::beginTransaction();
      try {
          $dataMenus = [];
          foreach ($request->get('menus') as $key => $value){
              if($key != 0 && $value != false && $value != NULL){
                  $dataMenus[] = $key;
              }
          }
          $data = [
              "user_id"     => $request->get("userId") ,
              "roles_id"    => $request->get("rolesId"),
              "company_id"  => $request->get("companyId"),
              "group_id"    => $request->get("groupId"),
          ];
          $usersMenus->where($data)->delete();
          for ($i = 0; $i < count($dataMenus); $i++){
                $data["menu_id"] = $dataMenus[$i];
                $usersMenus->insert($data);
          }

          DB::commit();
        $success = true;
      } catch (\Exception $e) {
          $success = false;
          $error = $e->getMessage()." ".$e->getFile()." ".$e->getLine();
          DB::rollback();
      }
       
       if ($success) {
           return $this->findMenuByUsers( new Request($request->all()), new SysUsersModel );
       }
        return new JsonResponse([
            "success"   =>  $success,
            "data"      =>  $error,
            "message"   =>  self::$message_error,
        ],Response::HTTP_BAD_REQUEST);
       return $this->show_error(6,$error, self::$message_error );
   }

    /**
     * This method is for the creations of permission of actions
     * @access public
     * @param Request $request
     * @param SysPermissionMenus $userPermission
     * @return JsonResponse
     */
    public function createAction( Request $request, SysPermissionMenus $userPermission )
    {
          $error = null;
          DB::beginTransaction();
          try {
              $dataActions = [];
              foreach ($request->get('actions') as $key => $value){
                  if($key != 0 && $value != false && $value != NULL){
                      $dataActions[] = $key;
                  }
              }
            $userPermission->where([
                "company_id"    => $request->get('companyId') ,
                "roles_id"      => $request->get('rolesId') ,
                "user_id"       => $request->get('userId') ,
                "group_id"      => $request->get('groupId') ,
                "menu_id"       => $request->get('menuId')
            ])->delete();

            for ($i=0; $i < count($dataActions) ; $i++) {
                $dataRegister = [
                    "company_id"    => $request->get('companyId') ,
                    "roles_id"      => $request->get('rolesId') ,
                    "user_id"       => $request->get('userId') ,
                    "group_id"      => $request->get('groupId'),
                    "menu_id"       => $request->get('menuId') ,
                    "permission_id" => $dataActions[$i] ,
                ];
                $userPermission->insert($dataRegister);
            }

            DB::commit();
            $success = true;
          } catch (\Exception $e) {
              $success = false;
              $error = $e->getMessage()." ".$e->getFile()." ".$e->getLine();
              DB::rollback();
          }

          if ($success) {
              return $this->findActionsByMenu( new Request($request->all()), new SysUsersModel );
          }
        return new JsonResponse([
            "success"   => $success ,
            "data"      => $error,
            "message"   => self::$message_error
        ], Response::HTTP_BAD_REQUEST);

    }


}
