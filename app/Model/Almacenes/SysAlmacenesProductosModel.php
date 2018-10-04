<?php

namespace App\Model\Almacenes;

use Illuminate\Database\Eloquent\Model;

class SysAlmacenesProductosModel extends Model
{
      public $table = "sys_almacenes_productos";
      public $fillable = [
          'id_almacen'
          ,'id_producto'
          ,'id_proveedor'
      ];
    
}
