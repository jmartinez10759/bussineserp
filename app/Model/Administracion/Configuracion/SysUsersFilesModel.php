<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysUsersFilesModel extends Model
{
    protected $table = "sys_users_files";
    public $fillable = [
    	'id_users'
        ,'id_rol'
        ,'id_empresa'
        ,'id_sucursal'
        ,'id_cliente'
        ,'id_proveedor'
        ,'id_producto'
        ,'id_planes'
        ,'id_archivo'
    ];

}
