<?php

namespace App\Model\Ventas;

use Illuminate\Database\Eloquent\Model;

class SysConceptosCotizacionesModel extends Model
{
    public $table = "sys_conceptos_cotizaciones";
      public $fillable = [
            'id'
            ,'id_producto'
            ,'id_plan'
            ,'cantidad'
            ,'precio'
            ,'total'
      ];
}
