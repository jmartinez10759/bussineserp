<?php

namespace App\Model\Ventas;

use Illuminate\Database\Eloquent\Model;

class SysUsersCotizacionesModel extends Model
{
      public $table = "sys_users_cotizaciones";
      public $fillable = [
            'id_users'
            ,'id_rol'
            ,'id_empresa'
            ,'id_sucursal'
            ,'id_menu'
            ,'id_cotizacion'
            ,'id_concepto'
            ,'id_producto'
      ];
}
