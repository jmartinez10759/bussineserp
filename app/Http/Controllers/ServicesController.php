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
    		$user = SysUsersModel::with(['notificaciones','correos','companies'])->whereId( Session::get('id') )->first();
			$mails  = $user->correos()->whereEstatus_recibidosAndEstatus_vistos(1,0)->orderBy('id','desc')->get();
			$menuText = [substr(parse_domain()->urls, 1)];
			$permissionMenu = [];
			$menus = SysMenuModel::with('permission')->whereIn('link', $menuText)->first();
			if (Session::get('roles_id') != 1 ){
                $companies = $user->companies()->with('groups')->whereEstatusAndId(TRUE,Session::get('company_id'))->first();
                $groups = $companies->groups()->with('menus')->whereEstatusAndId(TRUE,Session::get('group_id'))->first();
                $menus = $groups->menus()->with('permission')->whereLink($menuText)->first();
            }
            $permissionAll = SysPermission::whereStatus(TRUE)->get();
            $keys = [];
			$i = $j = 0;
			foreach ($permissionAll as $key) {
				$keys[] = $key->short_key;
				$permissionMenu['permisos'][$keys[$i]] = false;
				$i++;
			}
            foreach ($menus->permission as $actions) {
                if (in_array($actions->short_key, $keys)) {
                    $permissionMenu['permisos'][$actions->short_key] = $actions->status;
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
