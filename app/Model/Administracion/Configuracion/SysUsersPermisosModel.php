<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysUsersPermisosModel extends Model
{
	  public $table = "sys_users_permisos";
	  public $fillable = [
	      'id_accion'
	      ,'id_permiso'
	      ,'id_rol'
	      ,'id_menu'
	      ,'id_users'
	      ,'id_empresa'
	      ,'id_sucursal'
	      ,'estatus'
	  ];
}
