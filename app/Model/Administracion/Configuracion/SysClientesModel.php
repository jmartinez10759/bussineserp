<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysClientesModel extends Model
{
    public $table = "sys_clientes";
    public $fillable = [
      'id'
      ,'id_uso_cfdi'
      ,'rfc_receptor'
      ,'nombre_comercial'
      ,'razon_social'
      ,'calle'
      ,'colonia'
      ,'municipio'
      ,'id_country'
      ,'id_codigo'
      ,'id_estado'
      ,'id_servicio'
      ,'telefono'
      ,'logo'
      ,'estatus'
    ];

    public function facturas()
    {
      return $this->belongsToMany('App\Model\Administracion\Facturacion\SysFacturacionModel','sys_users_facturacion','id_cliente','id_factura');
    }
    public function usuarios()
    {
      return $this->belongsToMany(SysUsersModel::class,'sys_users_facturacion','id_cliente','id_users');
    }
    public function estados()
    {
      return $this->hasOne(SysEstadosModel::class,'id','id_estado');
    }
    public function contactos()
    {
      return $this->belongsToMany(SysContactosModel::class,'sys_contactos_sistemas','id_cliente','id_contacto');
    }
    public function empresas()
    {
      return $this->belongsToMany(SysEmpresasModel::class,'sys_clientes_empresas','id_cliente','id_empresa');
    }
    public function sucursales()
    {
      return $this->belongsToMany(SysSucursalesModel::class,'sys_clientes_empresas','id_cliente','id_sucursal');
    }
    public function pedidos()
    {
        return $this->belongsTo('App\Model\Ventas\SysPedidosModel','id','id_cliente');
    }
    public function usoCfdi()
    {
      return $this->hasOne(SysUsoCfdiModel::class,'id','id_uso_cfdi');
    }
    public function paises()
    {
      return $this->hasOne(SysPaisModel::class, 'id','id_country');
    }
    public function servicios()
    {
      return $this->hasOne( SysClaveProdServicioModel::class, 'id','id_servicio');
    }
    public function codigos()
    {
       return $this->hasOne( SysCodigoPostalModel::class, 'id','id_codigo');
    }

}
