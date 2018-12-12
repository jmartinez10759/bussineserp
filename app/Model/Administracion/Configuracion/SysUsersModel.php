<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysUsersModel extends Model
{
    protected $table = "sys_users";
    public $fillable = [
    	'id'
    	,'id_bitacora'
  		,'name'
  		,'first_surname'
  		,'second_surname'
  		,'email'
  		,'password'
  		,'remember_token'
  		,'api_token'
  		,'estatus'
  		,'confirmed'
  		,'confirmed_code'
    ];

    public function categorias()
    {
      return $this->hasMany('App\Model\Administracion\Correos\SysCategoriasModel','id_users','id');
    }

    public function correos()
    {
      return $this->belongsToMany('App\Model\Administracion\Correos\SysCorreosModel','sys_users_correos','id_users','id_correo');
    }

    public function menus()
    {
      return $this->belongsToMany(SysMenuModel::class,'sys_rol_menu','id_users','id_menu')->withPivot('estatus');
    }

    public function empresas()
    {
      return $this->belongsToMany(SysEmpresasModel::class,'sys_users_roles','id_users','id_empresa')->withPivot('estatus');
    }
    public function sucursales()
    {
      return $this->belongsToMany(SysSucursalesModel::class,'sys_users_roles','id_users','id_sucursal')->withPivot('estatus');
    }
    public function permisos()
    {
      return $this->belongsToMany(SysAccionesModel::class,'sys_rol_menu','id_users','id_permiso');
    }
    public function roles()
    {
      return $this->belongsToMany(SysRolesModel::class,'sys_users_roles','id_users','id_rol')->withPivot('id_rol','estatus');
    }

    public function skills()
    {
      return $this->hasMany(SysSkillsModel::class,'id_users','id');
    }

    public function details()
    {
      return $this->hasOne(SysPerfilUsersModel::class,'id_users','id');
    }

    public function bitacora()
    {
      return $this->hasOne(SysSesionesModel::class,'id','id_bitacora');
    }

    public function facturas()
    {
      return $this->belongsToMany('App\Model\Administracion\Facturacion\SysFacturacionModel','sys_users_facturacion','id_users','id_factura');
    }

    public function clientes()
    {
        return $this->belongsToMany(SysClientesModel::class,'sys_users_facturacion','id_users','id_cliente');
    }

    public function pedidos()
    {
      return $this->belongsToMany('App\Model\Ventas\SysPedidosModel','sys_users_pedidos','id_users','id_pedido');
    }

    public function cotizaciones()
    {
      return $this->belongsToMany('App\Model\Ventas\SysCotizacionesModel','sys_users_cotizaciones','id_users','id_cotizacion');
    }

    public function facturaciones()
    {
      return $this->belongsToMany('App\Model\Ventas\SysFacturacionesModel','sys_users_facturaciones','id_users','id_facturacion');
    }
    public function plantillas()
    {
      return $this->belongsToMany('App\Model\Administracion\Correos\SysTemplatesModel','sys_users_templates','id_users','id_template');
    }



}
