<?php

namespace App\Model\Administracion\Configuracion;

use App\SysOrders;
use Illuminate\Database\Eloquent\Model;

class SysMetodosPagosModel extends Model
{
	  public $table = "sys_metodos_pagos";
	  public $fillable = [
	    'id'
	    ,'clave'
	    ,'descripcion'
	    ,'estatus'
	  ];

    public function orders()
    {
        return $this->belongsTo(SysOrders::class,'payment_method_id','id');
    }

}
