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

    public function usuarios()
    {
      return $this->belongsToMany(SysUsersModel::class,'sys_rol_menu','id_menu','id_users')->withPivot(['estatus']);
    }
    public function empresas()
    {
        return $this->belongsToMany(SysEmpresasModel::class,'sys_rol_menu','id_menu','id_empresa')->withPivot(['estatus']);
    }
    public function sucursales()
    {
        return $this->belongsToMany(SysSucursalesModel::class,'sys_rol_menu','id_menu','id_sucursal')->withPivot(['estatus']);
    }
    public function permisos()
    {
        return $this->belongsToMany(SysAccionesModel::class,'sys_rol_menu','id_menu','id_permiso')->withPivot(['estatus']);
    }
    public function roles()
    {
        return $this->belongsToMany(SysRolesModel::class,'sys_rol_menu','id_menu','id_rol')->withPivot(['estatus']);
    }



}
