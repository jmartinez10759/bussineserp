<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysPermissionMenus extends Model
{
	  public $table = "sys_permission_menus";
	  public $fillable = [
	      'user_id' ,
	      'roles_id' ,
	      'company_id' ,
	      'group_id' ,
	      'permission_id' ,
	      'menu_id' ,
	  ];
}
