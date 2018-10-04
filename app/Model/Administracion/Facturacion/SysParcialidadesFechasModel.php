<?php

namespace App\Model\Administracion\Facturacion;

use Illuminate\Database\Eloquent\Model;

class SysParcialidadesFechasModel extends Model
{
  public $table = "sys_parcialidades_fechas";
  public $fillable = [
    'id'
    ,'id_factura'
    ,'fecha_pago'
    ,'estatus'
  ];

  public function facturas(){
     return $this->belongsTo('App\Model\Administracion\Facturacion\SysFacturacionModel','id_factura','id');
  }


}
