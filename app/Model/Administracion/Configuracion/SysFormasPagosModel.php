<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysFormasPagosModel extends Model
{
  public $table = "sys_formas_pagos";
  public $fillable = [
    'id'
    ,'clave'
    ,'descripcion'
  ];

}
