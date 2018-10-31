<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysRegimenFiscalModel extends Model
{
      public $table = "sys_regimen_fiscales";
      public $fillable = [
      	'id'
        ,'clave'
        ,'descripcion'
        ,'fisica'
        ,'moral'
        ,'fecha_inicio_vigencia'
        ,'fecha_final_vigencia'
      ];

      
}