<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysClientesModel extends Model
{
    public $table = "sys_clientes";
    public $fillable = [
      'id'
      ,'rfc_receptor'
      ,'nombre_comercial'
      ,'razon_social'
      ,'calle'
      ,'colonia'
      ,'municipio'
      ,'cp'
      ,'id_estado'
      ,'giro_comercial'
      ,'contacto'
      ,'departamento'
      ,'correo'
      ,'telefono'
      ,'estatus'
    ];

    public function facturas()
    {
      return $this->belongsToMany('App\Model\Administracion\Facturacion\SysFacturacionModel','sys_users_facturacion','id_cliente','id_factura');
    }
    public function usuarios()
    {
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysUsersModel','sys_users_facturacion','id_cliente','id_users');
    }
    public function estados()
    {
      return $this->hasOne('App\Model\Administracion\Configuracion\SysEstadosModel','id','id_estado');
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
    

}
