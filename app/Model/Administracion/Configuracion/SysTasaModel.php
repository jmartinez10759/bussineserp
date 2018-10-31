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
}