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

  public function menus()
  {
    return $this->belongsToMany(SysMenuModel::class,'sys_rol_menu','id_sucursal','id_menu');
  }
  public function empresas()
  {
    return $this->belongsToMany(SysEmpresasModel::class,'sys_empresas_sucursales','id_sucursal','id_empresa');
  }
  public function roles()
  {
    return $this->belongsToMany(SysRolesModel::class,'sys_users_roles','id_sucursal','id_rol');
  }
  public function permisos()
  {
    return $this->belongsToMany(SysAccionesModel::class,'sys_rol_menu','id_sucursal','id_permiso');
  }
  public function usuarios()
  {
    return $this->belongsToMany(SysUsersModel::class,'sys_users_roles','id_sucursal','id_users');
  }
  public function estados()
  {
    return $this->hasOne(SysEstadosModel::class,'id_estado','id');
  }
  public function productos()
  {
    return $this->belongsToMany(SysProductosModel::class, 'sys_planes_productos', 'id_sucursal', 'id_producto');
  }
  public function planes()
  {
    return $this->belongsToMany(SysPlanesModel::class, 'sys_planes_productos', 'id_sucursal', 'id_plan');
  }


}
