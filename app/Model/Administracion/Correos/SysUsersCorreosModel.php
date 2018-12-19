<?php

namespace App\Model\Administracion\Correos;

use Illuminate\Database\Eloquent\Model;

class SysUsersCorreosModel extends Model
{
    public $table = "sys_users_correos";
	public $fillable = [
		 'id_users'
		,'id_rol'
		,'id_empresa'
		,'id_sucursal'
		,'id_correo'
	];
}
