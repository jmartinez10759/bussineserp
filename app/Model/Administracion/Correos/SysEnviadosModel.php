<?php

namespace App\Model\Administracion\Correos;

use Illuminate\Database\Eloquent\Model;

class SysEnviadosModel extends Model
{
  public $table = "sys_enviados";
  public $fillable = [
    'id'
    ,'id_users'
    ,'id_sucursal'
    ,'id_empresa'
    ,'correo'
    ,'asunto'
    ,'descripcion'
    ,'estatus_destacados'
    ,'estatus_papelera'
  ];
}
