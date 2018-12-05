<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysActivitiesFilesModel extends Model
{
    public $table = "sys_activities_files";
    public $fillable = [
        'id_users'
        ,'id_rol'
        ,'id_empresa'
        ,'id_sucursal'
        ,'id_cliente'
        ,'id_actividad'
    ];
    
}
