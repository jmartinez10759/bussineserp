<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysMonedasModel extends Model
{
      public $table = "sys_monedas";
      public $fillable = [
         'id'
        ,'nombre'
        ,'descripcion'
        ,'estatus'
      ];
}