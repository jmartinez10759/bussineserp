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


class ServicesController extends MasterController
{
    public function __construct(){
        parent::__construct();
    }

    public function services(){

    	try {
    		$response = SysUsersModel::with(['notificaciones','correos'])->whereId( Session::get('id') )->first();
			$correos  = $response->correos()->whereEstatus_recibidosAndEstatus_vistos(1,0)->orderBy('id','desc')->get();
			
			#se registra la parte de permisos
			$where = [substr(parse_domain()->urls, 1)];
			$permisos_menus = [];
			$menus = SysMenuModel::select('id')->whereIn('link', $where)->first();
			$where = [
				'id_users'      => Session::get('id')
				,'id_rol'        => Session::get('id_rol')
				,'id_empresa'    => Session::get('id_empresa')
				,'id_sucursal'   => Session::get('id_sucursal')
				,'id_menu'       => isset($menus->id)? $menus->id : 0
			];
			$permisos = SysUsersPermisosModel::select('id_accion','estatus')->where($where)->groupby('id_accion')->get();
			$acciones_all = SysAccionesModel::whereEstatus( 1 )->get();
			$claves = [];
			$i = $j = 0;

			foreach ($acciones_all as $clave) {
				$claves[] = $clave->clave_corta;
				$permisos_menus['permisos'][$claves[$i]] = false;
				$i++;
			}
			foreach ($permisos as $actions) {
				$accion = SysAccionesModel::whereId( $actions->id_accion )->get();				
				foreach ($accion as $key => $value) {
					if (in_array($value->clave_corta, $claves)) {
						$permisos_menus['permisos'][$value->clave_corta] = $actions->estatus;
					}
				}
			}
			if( Session::get('id_rol') != 1){ $notification = $response->notificaciones()->orderBy('id','desc')->get();}
			else{ $notification = SysNotificacionesModel::orderBy('id','desc')->get(); }

	        $data = [
	        	'notification' => $notification
				,'correos'	   => $correos
			];
			$datos = array_merge($data,$permisos_menus);
			#debuger($datos);
        	return $this->_message_success( 200, $datos , self::$message_success );
      	} catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return $this->show_error(6, $error, self::$message_error );
      	}


    }


}
