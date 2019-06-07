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
        return $this->belongsToMany(SysEmpresasModel::class,'sys_companies_roles','roles_id','company_id');
    }
    public function groups()
    {
        return $this->belongsToMany(SysSucursalesModel::class,'sys_groups_roles','roles_id','group_id');
    }
    public function users()
    {
        return $this->belongsToMany(SysUsersModel::class,'sys_users_roles','roles_id','user_id');
    }


    public function permisos()
    {
        return $this->belongsToMany(SysAccionesModel::class,'sys_rol_menu','id_rol','id_permiso');
    }
    public function notificaciones()
    {
        return $this->belongsToMany(SysNotificacionesModel::class,'sys_rol_notificaciones','id_rol','id_notificacion'); 
    }

}
