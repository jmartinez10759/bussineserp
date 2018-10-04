<?php

namespace App\Model\Administracion\Facturacion;

use Illuminate\Database\Eloquent\Model;

class SysUsersFacturacionModel extends Model
{

  public $table = "sys_users_facturacion";
  public $fillable = [
    'id_users'
    ,'id_rol'
    ,'id_empresa'
    ,'id_sucursal'
    ,'id_cliente'
    ,'id_factura'
    ,'id_metodo_pago'
    ,'id_forma_pago'
    ,'id_concepto'
  ];

}
