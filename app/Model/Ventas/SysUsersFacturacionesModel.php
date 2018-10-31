<?php

namespace App\Model\Ventas;

use Illuminate\Database\Eloquent\Model;

class SysUsersFacturacionesModel extends Model
{
    public $table = "sys_users_facturaciones";
	public $fillable = [
        'id_users'
        ,'id_rol'
        ,'id_empresa'
        ,'id_sucursal'
        ,'id_menu'
        ,'id_facturacion'
        ,'id_concepto'
	];
}
