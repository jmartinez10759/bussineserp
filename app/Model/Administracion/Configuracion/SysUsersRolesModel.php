<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysUsersRolesModel extends Model
{
  protected $table = "sys_users_roles";
  public $fillable = [
    'id_users'
    ,'id_rol'
    ,'id_empresa'
    ,'id_sucursal'
    ,'estatus'
  ];

}
