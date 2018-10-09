<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysPlanesProductosModel extends Model
{
      public $table = "sys_planes_productos";
      public $fillable = [
            'id_empresa'
            ,'id_sucursal'
            ,'id_plan'
            ,'id_producto'
      ];
}
