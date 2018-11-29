<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysTiposComprobantesModel extends Model
{
  public $table = "sys_tipo_comprobantes";
  public $fillable = [
        'id'
        ,'nombre'
        ,'descripcion'
        ,'estatus'
  ];
  
  public function facturaciones()
  {
  	return $this->belongsTo('App\Model\Ventas\SysFacturacionesModel','id_tipo_comprobante','id');
  }



}