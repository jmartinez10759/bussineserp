<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysAccionesModel extends Model
{
    public $table = "sys_actions";
    public $fillable = [
        'id'
        ,'clave_corta'
        ,'descripcion'
        ,'estatus'
    ];
    public function usuarios()
    {
      return $this->belongsToMany(SysUsersModel::class, 'sys_users_permisos', 'id_accion', 'id_users')->withPivot(['estatus']);
    }
    public function empresas()
    {
        return $this->belongsToMany(SysEmpresasModel::class, 'sys_users_permisos', 'id_acciones', 'id_empresa')->withPivot(['estatus']);
    }



}
