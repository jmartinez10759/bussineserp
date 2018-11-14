<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysTasaModel extends Model
{
  public $table = "sys_tasas";
  public $fillable = [
  	'id'
    ,'rango'
    ,'valor_minimo'
    ,'valor_maximo'
    ,'clave'
    ,'factor'
    ,'trasladado'
    ,'retencion'
    ,'fecha_inicio_vigencia'
    ,'fecha_final_vigencia'
  ];

  public function productos()
  {
    return $this->belongsTo(SysProductosModel::class,'id_tasa','id');
  }
  public function planes()
  {
    return $this->belongsTo(SysPlanesModel::class,'id_tasa','id');
  }
}