<?php

namespace App\Model\Administracion\Configuracion;

use App\SysOrders;
use Illuminate\Database\Eloquent\Model;

class SysFormasPagosModel extends Model
{
  public $table = "sys_formas_pagos";
  public $fillable = [
    'id'
    ,'clave'
    ,'descripcion'
  ];

    public function orders()
    {
        return $this->belongsTo(SysOrders::class,'box_id','id');
    }

}
