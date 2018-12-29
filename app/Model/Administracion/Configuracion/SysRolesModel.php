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

    public function menus()
    {
      return $this->belongsToMany(SysMenuModel::class,'sys_rol_menu','id_rol','id_menu');
    }
    public function empresas()
    {
        return $this->belongsToMany(SysEmpresasModel::class,'sys_empresas_roles','id_rol','id_empresa');
    }
    public function sucursales()
    {
        return $this->belongsToMany(SysSucursalesModel::class,'sys_empresas_roles','id_rol','id_sucursal');
    }
    public function permisos()
    {
        return $this->belongsToMany(SysAccionesModel::class,'sys_rol_menu','id_rol','id_permiso');
    }
    public function usuarios()
    {
        return $this->belongsToMany(SysUsersModel::class,'sys_users_roles','id_rol','id_users');
    }
    public function notificaciones()
    {
        return $this->belongsToMany(SysNotificacionesModel::class,'sys_rol_notificaciones','id_rol','id_notificacion'); 
    }

}
