<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysSkillsModel extends Model
{
  public $table = "sys_skills";
  public $fillable = [
    'id'
    ,'id_users'
    ,'skills'
    ,'porcentaje'
  ];

  public function usuarios(){
      return $this->belongsTo('App\Model\Administracion\Configuracion\SysUsersModel','id','id_users');
  }

}
