<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysRolMenuModel extends Model
{
    protected $table = "sys_rol_menu";
    #protected $primaryKey = 'id_rol';
    public $fillable = [
    	   'id_rol'
        ,'id_users'
        ,'id_empresa'
        ,'id_sucursal'
        ,'id_menu'
        ,'id_permiso'
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
    public function permisos(){
        return $this->hasMany('App\Model\Administracion\Configuracion\SysUsersPermisosModel','id_permiso','id_permiso');
    }
    public function empresas(){
        return $this->hasMany('App\Model\Administracion\Configuracion\SysEmpresasModel','id','id_empresa');
    }
    public function sucursales(){
        return $this->hasMany('App\Model\Administracion\Configuracion\SysSucursalesModel','id','id_sucursal');
    }


}
