<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysMetodosPagosModel extends Model
{
  public $table = "sys_metodos_pagos";
  public $fillable = [
    'id'
    ,'clave'
    ,'descripcion'
  ];

}
