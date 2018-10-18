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

      public function pedidos(){
        return $this->belongsTo('App\Model\Ventas\SysPedidosModel','id_moneda','id');
      }
}