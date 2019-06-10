<?php

namespace App\Http\Controllers;

use App\SysPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;

use App\Model\Administracion\Configuracion\SysMenuModel;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysAccionesModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysNotificacionesModel;
use App\Model\Administracion\Configuracion\SysUsersPermisosModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class ServicesController extends MasterController
{
    public function __construct(){
        parent::__construct();
    }

    public function services(){

    	try {
    		$user = SysUsersModel::find( Session::get('id') );
			$mails  = $user->correos()->whereEstatus_recibidosAndEstatus_vistos(1,0)->orderBy('id','desc')->get();
			$menuText = substr(parse_domain()->urls, 1);
			$permissionMenu = [];
			$menu = $user->menus()->with('permission')->whereLink($menuText)->first();
            $actions = $menu->permission()->where([
                "sys_permission_menus.user_id"      => $user->id ,
                "sys_permission_menus.roles_id"     => Session::get("roles_id") ,
                "sys_permission_menus.company_id"   => Session::get("company_id") ,
                "sys_permission_menus.group_id"     => Session::get("group_id") ,
                "sys_permission_menus.menu_id"      => $menu->id ,
            ])->get();

            $permissionAll = SysPermission::whereStatus(TRUE)->get();
            $keys = [];
			$i = $j = 0;
			foreach ($permissionAll as $key) {
				$keys[] = $key->short_key;
				$permissionMenu['permisos'][$keys[$i]] = false;
				$i++;
			}
            foreach ($actions as $action) {
                if (in_array($action->short_key, $keys)) {
                    $permissionMenu['permisos'][$action->short_key] = $action->status;
                }
            }
            if( Session::get('roles_id') != 1){
			    $notification = $user->notificaciones()->orderBy('id','desc')->get();
			} else{
			    $notification = SysNotificacionesModel::orderBy('id','desc')->get();
			}
	        $data = [
	        	'notification' => $notification
				,'correos'	   => $mails
				,'companies'   => SysEmpresasModel::whereEstatus(1)->get()
			];
			$datos = array_merge($data,$permissionMenu);
            return new JsonResponse([
                "success"   => TRUE ,
                "data"      => $datos ,
                "message"   => self::$message_success
            ],Response::HTTP_OK);
      	} catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return new JsonResponse([
                "success"   => FALSE ,
                "data"      => $error ,
                "message"   => self::$message_error
            ],Response::HTTP_BAD_REQUEST);
      	}


    }


}
