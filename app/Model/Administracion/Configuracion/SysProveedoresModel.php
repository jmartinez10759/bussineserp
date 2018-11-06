<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysProveedoresModel extends Model
{
      public $table = "sys_proveedores";
      public $fillable = [
      'id'
    ,'rfc_emisor'
    ,'nombre_comercial'
    ,'razon_social'
    ,'calle'
    ,'colonia'
    ,'municipio'
    ,'cp'
    ,'id_country'
    ,'id_estado'
    ,'id_regimen_fiscal'
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
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysCuentasModel','sys_empresas_sucursales','id_empresa','id_proeedor');
  }
  
  public function cuentas(){
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysCuentasModel','sys_empresas_sucursales','id_empresa','id_cuenta');
  }
  
  public function contactos(){
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysContactosModel','sys_empresas_sucursales','id_empresa','id_contacto');
  }

  public function productos(){
        return $this->belongsToMany('App\Model\Administracion\Configuracion\SysProductosModel', 'sys_planes_productos', 'id_empresa', 'id_producto');
  }
  
   public function planes(){
    return $this->belongsToMany('App\Model\Administracion\Configuracion\SysPlanesModel', 'sys_planes_productos', 'id_empresa', 'id_plan');
  }
    
  public function clientes(){
        return $this->belongsToMany('App\Model\Administracion\Configuracion\SysClientesModel', 'sys_empresas_sucursales', 'id_empresa', 'id_cliente');
  }

  public function pedidos()
  {
        return $this->belongsToMany('App\Model\Ventas\SysPedidosModel','sys_users_pedidos','id_empresa','id_pedido');
  }

  public function notificaciones()
  {
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysNotificacionesModel','sys_rol_notificaciones','id_notificacion','id_empresa')->withPivot('estatus');
  }
  public function regimenes()
  {
      return $this->hasOne('App\Model\Administracion\Configuracion\SysRegimenFiscalModel', 'id','id_regimen_fiscal');
  }
  public function estados()
  {
      return $this->hasOne('App\Model\Administracion\Configuracion\SysEstadosModel', 'id','id_estado');
  }
  public function paises()
  {
      return $this->hasOne('App\Model\Administracion\Configuracion\SysPaisModel', 'id','id_country');
  }

}