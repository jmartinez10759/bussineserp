<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysEstatusModel extends Model
{
  public $table = "sys_estatus";
  public $fillable = [
    'id'
    ,'nombre'
    ,'detalles'
  ];

  public function facturas(){
    return $this->belongsTo('App\Model\Administracion\Facturacion\SysFacturaModel','id_estatus','id');
  }


}
