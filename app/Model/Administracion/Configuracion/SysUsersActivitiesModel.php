<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysUsersActivitiesModel extends Model
{
    public $table = "sys_users_activities";
    public $fillable = [
        'id_users'
        ,'id_rol'
        ,'id_empresa'
        ,'id_sucursal'
        ,'id_actividad'
        ,'id_cliente'
    ];
}
