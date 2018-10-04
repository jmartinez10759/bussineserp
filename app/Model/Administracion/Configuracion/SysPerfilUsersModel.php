<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysPerfilUsersModel extends Model
{
  public $table = "sys_perfil_users";
  public $fillable = [
    'id'
    ,'id_users'
    ,'direccion'
    ,'telefono'
    ,'puesto'
    ,'genero'
    ,'estado_civil'
    ,'experiencia'
    ,'notas'
    ,'foto'
  ];

  public function usuarios(){
      return $this->belongsTo('App\Model\Administracion\Configuracion\SysUsersModel','id','id_users');
  }


}
