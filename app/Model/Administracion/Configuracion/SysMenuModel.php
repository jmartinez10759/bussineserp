<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysMenuModel extends Model
{
    protected $table = "sys_menus";
    public $fillable = [
    	'id'
        ,'id_padre'
        ,'texto'
        ,'link'
        ,'tipo'
        ,'orden'
        ,'estatus'
        ,'icon'
    ];

    public function users()
    {
      return $this->belongsToMany(SysUsersModel::class,'sys_users_menus','menu_id','user_id');
    }
    public function companies()
    {
        return $this->belongsToMany(SysEmpresasModel::class,'sys_companies_menus','menu_id','company_id');
    }
    public function permission()
    {
        return $this->belongsToMany('App\SysPermission','sys_permission_menus','menu_id','permission_id');
    }

}
