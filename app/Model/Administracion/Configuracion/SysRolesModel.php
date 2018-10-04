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

    public function menus(){
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysMenuModel','sys_rol_menu','id_rol','id_menu');
    }

    public function empresas(){
        return $this->belongsToMany('App\Model\Administracion\Configuracion\SysEmpresasModel','sys_users_roles','id_rol','id_empresa');
    }

    public function sucursales(){
        return $this->belongsToMany('App\Model\Administracion\Configuracion\SysSucursalesModel','sys_users_roles','id_rol','id_sucursal');
    }

    public function permisos(){
        return $this->belongsToMany('App\Model\Administracion\Configuracion\SysAccionesModel','sys_rol_menu','id_rol','id_permiso');
    }

    public function usuarios(){
        return $this->belongsToMany('App\Model\Administracion\Configuracion\SysUsersModel','sys_users_roles','id_rol','id_users');
    }

    public function notificaciones(){
        return $this->belongsToMany('App\Model\Administracion\Configuracion\SysNotificacionesModel','sys_rol_notificaciones','id_rol','id_notificacion');
    }

}
