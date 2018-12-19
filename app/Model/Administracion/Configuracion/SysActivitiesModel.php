<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysActivitiesModel extends Model
{
    public $table = "sys_activities";
    public $fillable = [
        'id'
        ,'id_type_task'
        ,'titulo'
        ,'descripcion'
        ,'estatus'
    ];
    public function files()
    {
     	return $this->belongsToMany(SysFilesCompanys::class, 'sys_activities_files', 'id_actividad' ,'id_archivo');
    }
    public function clientes()
    {
     	return $this->belongsToMany(SysClientesModel::class, 'sys_users_activities',  'id_actividad' ,'id_cliente');
    }
    public function usuarios()
    {
     	return $this->belongsToMany(SysUsersModel::class, 'sys_users_activities',  'id_actividad' ,'id_users');
    }
    public function roles()
    {
     	return $this->belongsToMany(SysRolesModel::class, 'sys_users_activities', 'id_actividad' , 'id_rol');
    }
    public function empresas()
    {
      	return $this->belongsToMany(SysEmpresasModel::class, 'sys_users_activities', 'id_actividad' ,'id_empresa');
    }


}
