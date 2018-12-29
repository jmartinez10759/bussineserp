<?php

namespace App\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysEmpresasRoles extends Model
{
    public $table = "sys_empresas_roles";
	public $fillable = [
	    'id_rol'
	    ,'id_empresa'
	    ,'id_sucursal'
	];
}
