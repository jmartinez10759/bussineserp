<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysRolesNotificacionesModel extends Model
{
  public $table = "sys_rol_notificaciones";
  public $fillable = [
    'id_users'
    ,'id_rol'
    ,'id_empresa'
    ,'id_notificacion'
    ,'estatus'
  ];

}
