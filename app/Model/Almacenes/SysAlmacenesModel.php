<?php

namespace App\Model\Almacenes;

use Illuminate\Database\Eloquent\Model;

class SysAlmacenesModel extends Model
{
      public $table = "sys_almacenes";
      public $fillable = [
        'id'
        ,'nombre'
        ,'entradas'
        ,'salidas'
        ,'estatus'
      ];
}