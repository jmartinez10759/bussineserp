<?php

namespace App\Http\Middleware;

use App\Model\Administracion\Configuracion\SysUsersModel;
use Closure;
use Illuminate\Support\Facades\Session;
use App\Model\Administracion\Configuracion\SysMenuModel;
use App\Model\Administracion\Configuracion\SysRolMenuModel;

class RutaMiddleware
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

        if (Session::get("roles_id") != 1 ){
            $pathWeb = substr(parse_domain()->uri,1);
            $user = SysUsersModel::find(Session::get('id'));
            $menus = $user->menus()->whereLink($pathWeb)->first();
            $actions = $user->permission()->where([
                'user_id'        => $user->id
                ,'roles_id'      => Session::get('roles_id')
                ,'company_id'    => Session::get('company_id')
                ,'group_id'      => Session::get('group_id')
                ,'menu_id'       => isset($menus->id)? $menus->id : 0
            ])->get();
            if (!$actions) {
                return redirect('failed/error');
            }
        }
        return $next($request);

    }

}
