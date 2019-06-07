<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Model\Administracion\Configuracion\SysMenuModel;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysRolMenuModel;
use App\Model\Administracion\Configuracion\SysSesionesModel;
use App\Model\Administracion\Configuracion\SysAccionesModel;
use App\Model\Administracion\Configuracion\SysUsersPermisosModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;

class PermisosMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = SysUsersModel::with('companies')->whereId(Session::get("id") )->first();
        if (Session::get("roles_id") != 1){
            $permissionMenus = [];
            $webPath = [substr(parse_domain()->uri,1)];
            var_export($user);die();
        }

        if( !is_null($user) ){
            $sessions = SysSesionesModel::whereIdAndIdUsers($user->id_bitacora,Session::get('id'))->first();
            $startDate = isset($sessions->created_at)?$sessions->created_at: timestamp();
            $data = ['time_conected' => time_fechas( $startDate ,timestamp() )];
            SysSesionesModel::whereIdAndIdUsers( $user->id_bitacora,Session::get('id') )->update($data);
        }

        return $next($request);

        /*$menu = SysMenuModel::select('id')->whereIn('link', $where)->first();
        $company = SysEmpresasModel::whereId( Session::get('company_id') )->first();
        $iva = ( isset($company->iva) )? $company->iva : 16;
        $where = [
            'id_users'      => Session::get('id')
            ,'id_rol'        => Session::get('roles_id')
            ,'id_empresa'    => Session::get('company_id')
            ,'id_sucursal'   => Session::get('group_id')
            ,'id_menu'       => isset($menu->id)? $menu->id : 0
        ];
        $id_permiso = SysRolMenuModel::select('id_permiso')->where( $where )->groupby('id_permiso')->first();
        $where['id_permiso']  = isset($id_permiso->id_permiso)? $id_permiso->id_permiso : 5;
        $where['estatus']     = 1;
        $response = (SysUsersPermisosModel::select('id_accion')->where( $where )->groupby('id_accion')->get());
        $acciones_all = SysAccionesModel::where([ 'estatus' => 1 ])->get();
        $claves = [];
        $i = 0;
        $j = 0;
        foreach ($acciones_all as $clave) {
            $claves[] = $clave->clave_corta;
            $permisos_menus['permisos'][$claves[$i]] = true;
            $i++;
        }
        foreach ($response as $actions) {
          $accion = SysAccionesModel::where(['id' => $actions->id_accion])->get();
          foreach ($accion as $key => $value) {
            if( in_array($value->clave_corta,$claves ) ){
              $permisos_menus['permisos'][$value->clave_corta] = false;
            }
          }
        }
        Session::put(['iva' => $iva]);
        Session::put($permisos_menus);
        #se debe crear un metodo para crear esta parte
        $users = SysUsersModel::where(['id' => Session::get('id')])->get();
        if( count($users) > 0 ){
          $where = ['id' => $users[0]->id_bitacora,'id_users' => Session::get('id')];
          $sesiones = SysSesionesModel::where($where)->get();
          $fecha_inicio = isset($sesiones[0]->created_at)?$sesiones[0]->created_at: timestamp();
          $data = ['time_conected' => time_fechas( $fecha_inicio ,timestamp() )];
          SysSesionesModel::where( $where )->update($data);
        }*/


    }
}
