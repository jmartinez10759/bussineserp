<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysSucursalesModel extends Model
{

  public $table = "sys_sucursales";
  public $fillable = [
    'id'
    ,'codigo'
    ,'sucursal'
    ,'direccion'
    ,'telefono'
    ,'id_estado'
    ,'estatus'
  ];

  public function menus(){
    return $this->belongsToMany('App\Model\Administracion\Configuracion\SysMenuModel','sys_rol_menu','id_sucursal','id_menu');
  }

  public function empresas(){
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysEmpresasModel','sys_empresas_sucursales','id_sucursal','id_empresa');
  }

  public function roles(){
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysRolesModel','sys_users_roles','id_sucursal','id_rol');
  }

  public function permisos(){
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysAccionesModel','sys_rol_menu','id_sucursal','id_permiso');
  }

  public function usuarios(){
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysUsersModel','sys_users_roles','id_sucursal','id_users');
  }
  
    public function estados(){
        return $this->hasOne('App\Model\Administracion\Configuracion\SysEstadosModel','id_estado','id');
    }





}
