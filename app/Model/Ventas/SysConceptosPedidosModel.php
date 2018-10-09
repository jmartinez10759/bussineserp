<?php

namespace App\Model\Ventas;

use Illuminate\Database\Eloquent\Model;

class SysConceptosPedidosModel extends Model
{
    public $table = "sys_conceptos_pedidos";
    public $fillable = [
             'id'
            ,'id_producto'
            ,'id_plan'
            ,'cantidad'
            ,'precio'
            ,'total'
      ];
}
