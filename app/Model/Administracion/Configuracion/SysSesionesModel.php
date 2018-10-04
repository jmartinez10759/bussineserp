<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysSesionesModel extends Model
{

  protected $table = "sys_sesiones";
  public $fillable = [
    'id'
    ,'id_users'
    ,'ip_address'
    ,'user_agent'
    ,'conect'
    ,'disconect'
    ,'time_conected'
  ];

  public function usuarios(){
      return $this->belongsTo('App\Model\Administracion\Configuracion\SysUsersModel','id_bitacora','id');
  }


}
