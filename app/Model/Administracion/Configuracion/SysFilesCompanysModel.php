<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysFilesCompanysModel extends Model
{
    public $table = "sys_files_companys";
    public $fillable = [
        'id'
        ,'ruta_archivo'
        ,'estatus'
    ];

    public function actividades()
    {
    	return $this->belongsToMany(SysActivitiesModel::class,'sys_activities_files','id_actividad','id_archivo');
    }
    public function clientes()
    {
    	return $this->belongsToMany(SysClientesModel::class,'sys_users_files','id_archivo','id_cliente');
    }



}
