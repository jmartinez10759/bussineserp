<?php

namespace App\Model\Ventas;

use Illuminate\Database\Eloquent\Model;

class SysUsersPedidosModel extends Model
{
    public $table = "sys_users_pedidos";
      public $fillable = [
            'id_users'
            ,'id_rol'
            ,'id_empresa'
            ,'id_sucursal'
            ,'id_modulo'
            ,'id_pedido'
            ,'id_concepto'
            ,'id_producto'
      ];
}
