<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysRolMenuModel extends Model
{
    protected $table = "sys_rol_menu";
    public $fillable = [
    	 'id_rol'
        ,'id_users'
        ,'id_empresa'
        ,'id_sucursal'
        ,'id_menu'
        ,'id_permiso'
        ,'estatus'
    ];

}
