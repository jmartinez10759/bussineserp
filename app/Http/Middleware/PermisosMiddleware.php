<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysSesionesModel;
use App\Model\Administracion\Configuracion\SysPermissionMenus;

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
        $user = SysUsersModel::find(Session::get("id") );
        if (Session::get("roles_id") != 1){
            $webPath = substr(parse_domain()->uri,1);
            $menus = $user->menus()->where([
                "sys_users_menus.user_id"       => Session::get("id") ,
                "sys_users_menus.roles_id"      => Session::get("roles_id") ,
                "sys_users_menus.company_id"    => Session::get("company_id") ,
                "sys_users_menus.group_id"      => Session::get("group_id") ,
                "link"  => $webPath
            ])->first();
            if ($menus){
                return $next($request);
            }
        }
        if( !is_null($user) ){
            $sessions = SysSesionesModel::whereIdAndIdUsers($user->id_bitacora,Session::get('id'))->first();
            $startDate = isset($sessions->created_at)?$sessions->created_at: timestamp();
            $data = ['time_conected' => time_fechas( $startDate ,timestamp() )];
            SysSesionesModel::whereIdAndIdUsers( $user->id_bitacora,Session::get('id') )->update($data);
        }
        return $next($request);

    }
}
