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

    public function companies()
      {
        return $this->belongsToMany(SysEmpresasModel::class,'sys_users_pivot','group_id','company_id');
      }
    public function users()
      {
        return $this->belongsToMany(SysUsersModel::class,'sys_users_pivot','group_id','user_id');
      }
      public function roles()
      {
          return $this->belongsToMany(SysRolesModel::class,'sys_users_pivot','group_id','roles_id');
      }
    public function menus()
    {
        return $this->belongsToMany(SysMenuModel::class,'sys_users_menus','group_id','menu_id');
    }
    public function permission()
    {
        return $this->belongsToMany('App\SysPermission' ,'sys_permission_menus','group_id','permission_id');
    }

    public function rolesGroups()
    {
        return $this->belongsToMany(SysSucursalesModel::class,'sys_groups_roles','group_id','roles_id');
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
  public function almacenes()
  {
    return $this->belongsToMany('App\Model\Almacenes\SysAlmacenesModel', 'sys_almacenes_empresas', 'id_sucursal', 'id_almacen');
  }


}
