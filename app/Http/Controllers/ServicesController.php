<?php

namespace App\Http\Controllers;

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
    		$response = SysUsersModel::with(['notificaciones','correos'])->whereId( Session::get('id') )->first();
			$correos  = $response->correos()->whereEstatus_recibidosAndEstatus_vistos(1,0)->orderBy('id','desc')->get();
			$where = [substr(parse_domain()->urls, 1)];
			$permissionMenu = [];
			$menus = SysMenuModel::select('id')->whereIn('link', $where)->first();
			$where = [
				'id_users'      => Session::get('id')
				,'id_rol'        => Session::get('id_rol')
				,'id_empresa'    => Session::get('id_empresa')
				,'id_sucursal'   => Session::get('id_sucursal')
				,'id_menu'       => isset($menus->id)? $menus->id : 0
			];
			$permission = SysUsersPermisosModel::select('id_accion','estatus')->where($where)->groupby('id_accion')->get();
			$actionsAll = SysAccionesModel::whereEstatus( 1 )->get();
			$keys = [];
			$i = $j = 0;

			foreach ($actionsAll as $clave) {
				$keys[] = $clave->clave_corta;
				$permissionMenu['permisos'][$keys[$i]] = false;
				$i++;
			}
			foreach ($permission as $actions) {
				$action = SysAccionesModel::whereId( $actions->id_accion )->get();
				foreach ($action as $key => $value) {
					if (in_array($value->clave_corta, $keys)) {
						$permissionMenu['permisos'][$value->clave_corta] = $actions->estatus;
					}
				}
			}
			if( Session::get('id_rol') != 1){
			    $notification = $response->notificaciones()->orderBy('id','desc')->get();
			} else{
			    $notification = SysNotificacionesModel::orderBy('id','desc')->get();
			}

	        $data = [
	        	'notification' => $notification
				,'correos'	   => $correos
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
