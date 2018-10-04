<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysUsersPermisosModel extends Model
{
	  public $table = "sys_users_permisos";
	  public $fillable = [
	      'id_accion'
	      ,'id_permiso'
	      ,'id_rol'
	      ,'id_menu'
	      ,'id_users'
	      ,'id_empresa'
	      ,'id_sucursal'
	      ,'estatus'
	  ];

		public function roles(){
        return $this->hasMany('App\Model\Administracion\Configuracion\SysRolesModel','id','id_rol');
    }
    public function menus(){
        return $this->hasMany('App\Model\Administracion\Configuracion\SysMenuModel','id','id_menu');
    }
    public function usuarios(){
        return $this->hasMany('App\Model\Administracion\Configuracion\SysUsersModel','id','id_users');
    }
    public function acciones(){
        return $this->hasMany('App\Model\Administracion\Configuracion\SysAccionesModel','id','id_accion');
    }
    public function empresas(){
        return $this->hasMany('App\Model\Administracion\Configuracion\SysEmpresasModel','id','id_empresa');
    }
    public function sucursales(){
        return $this->hasMany('App\Model\Administracion\Configuracion\SysSucursalesModel','id','id_sucursal');
    }


}
