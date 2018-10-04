<?php

namespace App\Model\Administracion\Facturacion;

use Illuminate\Database\Eloquent\Model;

class SysFacturacionModel extends Model
{
  public $table = "sys_facturacion";
  public $fillable = [
    'id'
    ,'id_estatus'
    ,'fecha_factura'
    ,'serie'
    ,'folio'
    ,'uuid'
    ,'iva'
    ,'subtotal'
    ,'total'
    ,'comision'
    ,'pago'
    ,'descripcion'
    ,'archivo'
  ];

  public function usuarios(){
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysUsersModel','sys_users_facturacion','id_factura','id_users');
  }

  public function clientes(){
    return $this->belongsToMany('App\Model\Administracion\Configuracion\SysClientesModel','sys_users_facturacion','id_factura','id_cliente');
    #return $this->hasOne('App\Model\Administracion\Configuracion\SysClientesModel','id','id_cliente');
  }

  public function formasPagos(){
    return $this->belongsToMany('App\Model\Administracion\Configuracion\SysFormasPagosModel','sys_users_facturacion','id_factura','id_forma_pago');
  }

  public function metodoPagos(){
    return $this->belongsToMany('App\Model\Administracion\Configuracion\SysMetodosPagosModel','sys_users_facturacion','id_factura','id_metodo_pago');
  }

  public function estatus(){
    return $this->hasOne('App\Model\Administracion\Configuracion\SysEstatusModel','id','id_estatus');
  }

  public function conceptos(){
    return $this->belongsToMany('App\Model\Administracion\Facturacion\SysConceptosModel','sys_users_facturacion','id_factura','id_concepto');
    #return $this->hasMany('App\Model\Administracion\Facturacion\SysConceptosModel','sys_users_facturacion','id_concepto','id_factura');
  }

  public function fechas(){
     return $this->hasMany('App\Model\Administracion\Facturacion\SysParcialidadesFechasModel','id_factura','id');
  }


}
