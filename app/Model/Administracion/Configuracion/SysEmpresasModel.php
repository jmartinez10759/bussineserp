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
    ,'id_codigo'
    ,'id_country'
    ,'id_estado'
    ,'id_regimen_fiscal'
    ,'id_servicio_comercial'
    ,'telefono'
    ,'logo'
    ,'estatus'
  ];

  public function menus()
  {
    return $this->belongsToMany(SysMenuModel::class,'sys_rol_menu','id_empresa','id_menu')->withPivot('estatus');
  }
  public function sucursales()
  {
    return $this->belongsToMany(SysSucursalesModel::class,'sys_empresas_sucursales','id_empresa','id_sucursal')->withPivot('estatus');
  }
  public function roles()
  {
    return $this->belongsToMany(SysRolesModel::class,'sys_users_roles','id_empresa','id_rol');
  }

  public function permisos()
  {
    return $this->belongsToMany(SysAccionesModel::class,'sys_rol_menu','id_empresa','id_permiso');
  }

  public function usuarios()
  {
    return $this->belongsToMany(SysUsersModel::class,'sys_users_roles','id_empresa','id_users');
  }
  
  public function proveedores()
  {
    return $this->belongsToMany(SysProveedoresModel::class,'sys_proveedores_empresas','id_empresa','id_proveedor');
  }
  public function cuentas()
  {
    return $this->belongsToMany(SysCuentasModel::class,'sys_cuentas_empresas','id_empresa','id_cuenta');
  }
  public function contactos()
  {
    return $this->belongsToMany(SysContactosModel::class,'sys_contactos_sistemas','id_empresa','id_contacto');
  }
  public function productos()
  {
    return $this->belongsToMany(SysProductosModel::class, 'sys_planes_productos', 'id_empresa', 'id_producto');
  }
  public function planes()
  {
    return $this->belongsToMany('App\Model\Administracion\Configuracion\SysPlanesModel', 'sys_planes_productos', 'id_empresa', 'id_plan');
  }
  public function clientes()
  {
    return $this->belongsToMany(SysClientesModel::class, 'sys_clientes_empresas', 'id_empresa', 'id_cliente');
  }
  public function pedidos()
  {
    return $this->belongsToMany('App\Model\Ventas\SysPedidosModel','sys_users_pedidos','id_empresa','id_pedido');
  }
  public function facturaciones()
  {
    return $this->belongsToMany('App\Model\Ventas\SysFacturacionesModel','sys_users_facturaciones','id_empresa','id_facturacion');
  }
  public function notificaciones()
  {
    return $this->belongsToMany(SysNotificacionesModel::class,'sys_rol_notificaciones','id_notificacion','id_empresa')->withPivot('estatus');
  }
  public function regimenes()
  {
    return $this->hasOne(SysRegimenFiscalModel::class, 'id','id_regimen_fiscal');
  }
  public function estados()
  {
    return $this->hasOne(SysEstadosModel::class, 'id','id_estado');
  }
  public function paises()
  {
    return $this->hasOne(SysPaisModel::class, 'id','id_country');
  }
  public function comerciales()
  {
    return $this->hasOne( SysServiciosComercialesModel::class, 'id','id_servicio_comercial');
  }
  public function codigos()
  {
     return $this->hasOne( SysCodigoPostalModel::class, 'id','id_codigo');
  }
  public function plantillas()
  {
    return $this->belongsToMany('App\Model\Administracion\Correos\SysTemplatesModel','sys_users_templates','id_empresa','id_template');
  }
  public function almacenes()
  {
    return $this->belongsToMany('App\Model\Almacenes\SysAlmacenesModel', 'sys_almacenes_empresas', 'id_empresa', 'id_almacen');
  }


}
