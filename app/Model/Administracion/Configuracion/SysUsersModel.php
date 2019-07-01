<?php

namespace App\Model\Administracion\Configuracion;

use App\SysBoxes;
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
  		,'username'
  		,'email'
  		,'password'
  		,'remember_token'
  		,'api_token'
  		,'estatus'
  		,'confirmed'
  		,'confirmed_code'
    ];

    public function roles()
    {
        return $this->belongsToMany(SysRolesModel::class,'sys_users_pivot','user_id','roles_id');
    }
    public function companies()
    {
      return $this->belongsToMany(SysEmpresasModel::class,'sys_users_pivot','user_id','company_id');
    }
    public function groups()
    {
      return $this->belongsToMany(SysSucursalesModel::class,'sys_users_pivot','user_id','group_id');
    }
    public function menus()
    {
        return $this->belongsToMany(SysMenuModel::class,'sys_users_menus','user_id','menu_id');
    }
    public function permission()
    {
        return $this->belongsToMany('App\SysPermission','sys_permission_menus','user_id','permission_id');
    }
    public function boxes()
    {
        return $this->belongsToMany(SysBoxes::class,'companies_boxes','user_id','box_id')
            ->withPivot("company_id","group_id");
    }
    public function logs()
    {
        return $this->belongsToMany(SysBoxes::class,'boxes_logs','user_id','box_id')->withPivot("created_at");
    }








    public function categorias()
    {
        return $this->hasMany('App\Model\Administracion\Correos\SysCategoriasModel','id_users','id');
    }
    public function correos()
    {
        return $this->belongsToMany('App\Model\Administracion\Correos\SysCorreosModel','sys_users_correos','id_users','id_correo');
    }

    public function acciones()
    {
        return $this->belongsToMany(SysAccionesModel::class,'sys_users_permisos','id_users','id_accion')->withPivot('estatus');
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
    public function notificaciones()
    {
      return $this->belongsToMany(SysNotificacionesModel::class,'sys_rol_notificaciones','id_users','id_notificacion')->withPivot('estatus');
    }



}
