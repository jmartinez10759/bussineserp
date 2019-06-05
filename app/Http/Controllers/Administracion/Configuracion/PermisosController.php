<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use App\Model\Administracion\Configuracion\SysRolMenuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysUsersPermisosModel;
use App\Model\Administracion\Configuracion\SysEmpresasSecursalesModel;
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
            }
            $user = $users->with('menus')->whereId($request->get("userId"))->first();
            $permission = $user->menus()->where([
                'sys_rol_menu.estatus'      => true ,
                'sys_rol_menu.id_empresa'   => $request->get("companyId"),
                'sys_rol_menu.id_rol'       => $request->get("rolesId"),
                'sys_rol_menu.id_sucursal'  => $request->get("groupId")
            ])->groupby('sys_rol_menu.id_menu')->get();

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
            $user = $users->with('acciones')->whereId($request->userId)->first();
            $actions = $user->acciones()->where([
                'sys_users_permisos.estatus'      => true ,
                'sys_users_permisos.id_empresa'   => $request->companyId ,
                'sys_users_permisos.id_rol'       => $request->rolesId ,
                'sys_users_permisos.id_sucursal'  => $request->groupId ,
                'sys_users_permisos.id_menu'      => $request->menuId
            ])->groupby('sys_users_permisos.id_accion')->orderby('id','DESC')->get();

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
     * @param SysRolMenuModel $rolesMenus
     * @return void
     */
   public function createPermission( Request $request, SysRolMenuModel $rolesMenus )
   {
      $error = null;
      DB::beginTransaction();
      try {
          $dataMenus = [];
          foreach ($request->get('menus') as $key => $value){
              if($key != 0 && $value != false && $value != NULL){
                  $dataMenus [] = $key;
              }
          }
          $rolesMenus->where([
              "id_empresa"    => $request->get('companyId') ,
              "id_rol"        => $request->get('rolesId'),
              "id_users"      => $request->get('userId'),
              "id_sucursal"   => $request->get('groupId'),
          ])->delete();

        for ($i=0; $i < count($dataMenus) ; $i++) {

            $dataRegister = [
                "id_empresa"    => $request->get('companyId') ,
                "id_rol"        => $request->get('rolesId') ,
                "id_users"      => $request->get('userId') ,
                "id_sucursal"   => $request->get('groupId') ,
                "id_menu"       => $dataMenus[$i] ,
                "id_permiso"    => 7 ,
                "estatus"       => TRUE
            ];
            $rolesMenus->create($dataRegister);
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
     * @param SysUsersPermisosModel $userPermission
     * @return JsonResponse
     */
    public function createAction( Request $request, SysUsersPermisosModel $userPermission )
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
                "id_empresa"    => $request->get('companyId') ,
                "id_rol"        => $request->get('rolesId'),
                "id_users"      => $request->get('userId'),
                "id_sucursal"   => $request->get('groupId'),
                "id_menu"       => $request->get('menuId')
            ])->delete();

            for ($i=0; $i < count($dataActions) ; $i++) {

                $dataRegister = [
                    "id_empresa"    => $request->get('companyId') ,
                    "id_rol"        => $request->get('rolesId') ,
                    "id_users"      => $request->get('userId') ,
                    "id_sucursal"   => $request->get('groupId'),
                    "id_menu"       => $request->get('menuId') ,
                    "id_accion"     => $dataActions[$i] ,
                    "id_permiso"    => 7 ,
                    "estatus"       => true
                ];
                $userPermission->create($dataRegister);
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
