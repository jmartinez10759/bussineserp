<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
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
      $where = [substr(parse_domain()->uri,1)];
      $permisos_menus = [];
      $menu = SysMenuModel::select('id')->whereIn('link', $where)->get();
      #se realiza la consulta para obtener el permiso.
      $where = [
          'id_users'      => Session::get('id')
          ,'id_rol'        => Session::get('id_rol')
          ,'id_empresa'    => Session::get('id_empresa')
          ,'id_sucursal'   => Session::get('id_sucursal')
          ,'id_menu'       => isset($menu[0]->id)? $menu[0]->id : 0
          ,'estatus'       => 1
      ];
      $rutas = SysRolMenuModel::select('*')->where( $where )->get();
      if( count( $rutas ) > 0){
          return $next($request);
      }else{
        return redirect('failed/error');
      }




    }

}
