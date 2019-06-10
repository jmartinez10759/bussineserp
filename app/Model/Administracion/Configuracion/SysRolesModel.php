<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysRolesModel extends Model
{
    public $table = "sys_roles";
    public $fillable = [
    	'id'
        ,'perfil'
        ,'clave_corta'
        ,'estatus'
    ];
    public function companies()
    {
        return $this->belongsToMany(SysEmpresasModel::class,'sys_users_pivot','roles_id','company_id');
    }
    public function groups()
    {
        return $this->belongsToMany(SysSucursalesModel::class,'sys_users_pivot','roles_id','group_id');
    }
    public function users()
    {
        return $this->belongsToMany(SysUsersModel::class,'sys_users_pivot','roles_id','user_id');
    }
    public function menus()
    {
        return $this->belongsToMany(SysMenuModel::class,'sys_users_menus','roles_id','menu_id');
    }
    public function permission()
    {
        return $this->belongsToMany('App\SysPermission','sys_permission_menus','roles_id','permission_id');
    }



    public function notificaciones()
    {
        return $this->belongsToMany(SysNotificacionesModel::class,'sys_rol_notificaciones','id_rol','id_notificacion'); 
    }

}
