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

  public function users()
  {
      return $this->belongsTo(SysUsersModel::class,'id_bitacora','id');
  }


}
