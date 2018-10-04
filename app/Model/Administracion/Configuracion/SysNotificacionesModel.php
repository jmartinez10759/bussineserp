<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysNotificacionesModel extends Model
{
  public $table = "sys_notificaciones";
  public $fillable = [
    'id'
      ,'portal'
      ,'mensaje'
      ,'estatus'
  ];

  public function roles(){
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysRolesModel','sys_rol_notificaciones','id_notificacion','id_rol')->withPivot('estatus');
  }

}
