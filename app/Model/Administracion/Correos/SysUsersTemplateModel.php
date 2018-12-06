<?php

namespace App\Model\Administracion\Correos;

use Illuminate\Database\Eloquent\Model;

class SysUsersTemplateModel extends Model
{
	public $table = "sys_users_templates";
	public $fillable = [
		 'id_users'
		,'id_rol'
		,'id_empresa'
		,'id_sucursal'
		,'id_template'
	];
}
