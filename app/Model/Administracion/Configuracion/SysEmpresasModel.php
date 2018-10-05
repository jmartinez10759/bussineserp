<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysEmpresasModel extends Model
{
  public $table = "sys_empresas";
  public $fillable = [
    'id'
    ,'rfc_emisor'
    ,'nombre_comercial'
    ,'razon_social'
    ,'calle'
    ,'colonia'
    ,'municipio'
    ,'cp'
    ,'id_estado'
    ,'giro_comercial'
    ,'telefono'
    ,'logo'
    ,'estatus'
  ];

  public function menus(){
    return $this->belongsToMany('App\Model\Administracion\Configuracion\SysMenuModel','sys_rol_menu','id_empresa','id_menu')->withPivot('estatus');
  }

  public function sucursales(){
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysSucursalesModel','sys_empresas_sucursales','id_empresa','id_sucursal')->withPivot('estatus');
  }

  public function roles(){
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysRolesModel','sys_users_roles','id_empresa','id_rol');
  }

  public function permisos(){
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysAccionesModel','sys_rol_menu','id_empresa','id_permiso');
  }

  public function usuarios(){
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysUsersModel','sys_users_roles','id_empresa','id_users');
  }
  
  public function proveedores(){
//      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysUsersModel','sys_users_roles','id_empresa','id_users');
  }
  
  public function cuentas(){
      
  }
  
  public function contactos(){
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysContactosModel','sys_empresas_sucursales','id_empresa','id_contacto');
  }

    public function productos(){
        return $this->belongsToMany('App\Model\Administracion\Configuracion\SysProductosModel', 'sys_planes_productos', 'id_empresa', 'id_producto');
    }

}
