<?php

namespace App\Model\Administracion\Correos;

use Illuminate\Database\Eloquent\Model;

class SysCategoriasModel extends Model
{
  public $table = "sys_categorias";
  public $fillable = [
    'id'
    ,'id_users'
    ,'categoria'
    ,'descripcion'
    ,'estatus'
  ];

  public function usuarios(){
    return $this->belongsTo('App\Model\Administracion\Configuracion\SysUsersModel','id','id_users');
  }
  public function correos(){
    return $this->belongsToMany('App\Model\Administracion\Configuracion\SysCorreosModel','sys_categorias_correos','id_categorias','id_correo')->withPivot('id_users');
  }

}
