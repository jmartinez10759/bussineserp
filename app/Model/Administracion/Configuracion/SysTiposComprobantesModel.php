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
}