<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysImpuestoModel extends Model
{
      public $table = "sys_impuestos";
      public $fillable = [
      	'id'
        ,'clave'
        ,'descripcion'
        ,'retencion'
        ,'traslado'
        ,'localfederal'
      ];
}