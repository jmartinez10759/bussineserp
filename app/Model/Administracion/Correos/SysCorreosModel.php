<?php

namespace App\Model\Administracion\Correos;

use Illuminate\Database\Eloquent\Model;

class SysCorreosModel extends Model
{
  public $table = "sys_correos";
  public $fillable = [
     'id'
    ,'nombre'
    ,'correo'
    ,'asunto'
    ,'descripcion'
    ,'estatus_enviados'
    ,'estatus_recibidos'
    ,'estatus_papelera'
    ,'estatus_vistos'
    ,'estatus_destacados'
    ,'estatus_borradores'
  ];

  public function categorias()
  {
      return $this->belongsToMany('App\Model\Administracion\Correos\SysCategoriasModel','sys_categorias_correos','id_correo','id_categorias')->withPivot('id_users');
  }

  public function usuarios()
  {
    return $this->belongsToMany('App\Model\Administracion\Configuracion\SysUsersModel','sys_users_correos','id_correo','id_users');
  }



}
