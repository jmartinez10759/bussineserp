<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysTipoFactorModel extends Model
{
      public $table = "sys_tipo_factores";
      public $fillable = [
      	'id'
        ,'clave'
        ,'descripcion'
        ,'fecha_inicio_vigencia'
        ,'fecha_final_vigencia'
      ];
}