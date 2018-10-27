<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysPaisModel extends Model
{
      public $table = "sys_paises";
      public $fillable = [
      	'id'
      	,'clave'
      	,'descripcion'
      	,'formato_codigo_postal'
      	,'formato_registro'
      	,'validacion_registro'
      	,'agrupaciones'
      ];
}