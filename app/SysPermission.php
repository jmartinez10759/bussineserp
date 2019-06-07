<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SysPermission extends Model
{
    public $table = "sys_permission";
    public $fillable = [
        "id" ,
        "short_key" ,
        "description" ,
        "status"
    ];

    public function menus()
    {
        return $this->belongsToMany('App\Model\Administracion\Configuracion\SysMenuModel','sys_permission_menus','permission_id','menu_id');
    }
    public function companies()
    {
        return $this->belongsToMany('App\Model\Administracion\Configuracion\SysEmpresasModel','sys_companies_permission','permission_id','company_id');
    }
    public function groups()
    {
        return $this->belongsToMany('App\Model\Administracion\Configuracion\SysSucursalesModel','sys_groups_permission','permission_id','group_id');
    }
    public function users()
    {
        return $this->belongsToMany('App\Model\Administracion\Configuracion\SysUsersModel','sys_users_permission','permission_id','user_id');
    }
}
