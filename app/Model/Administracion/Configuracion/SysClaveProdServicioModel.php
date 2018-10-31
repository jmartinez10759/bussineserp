<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysClaveProdServicioModel extends Model
{
      public $table = "sys_clave_servicios";
      public $fillable = [
      	'id'
        ,'clave'
        ,'descripcion'
        ,'iva_trasladado'
        ,'ieps_trasladado'
        ,'complemento'
        ,'fecha_inicio_vigencia'
        ,'fecha_final_vigencia'
        ,'similares'
      ];
}