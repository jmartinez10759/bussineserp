<?php

namespace App\Model\Administracion\Facturacion;

use Illuminate\Database\Eloquent\Model;

class SysConceptosModel extends Model
{
  public $table = "sys_conceptos";
  public $fillable = [
    'id'
    ,'id_producto'
    ,'cantidad'
    ,'precio'
    ,'total'
  ];

  // public function facturas(){
  //   return $this->belongsToMany('App\Model\Administracion\Facturacion\SysFacturacionModel','sys_users_facturacion','id_factura','id_concepto');
  // }

  public function productos(){
    return $this->hasOne('App\Model\Administracion\Configuracion\SysProductosModel','id','id_producto');
  }


}
