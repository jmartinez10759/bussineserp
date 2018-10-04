<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysContactosModel extends Model
{
  public $table = "sys_contactos";
  public $fillable = [
    'id'
    ,'nombre_completo'
    ,'departamento'
    ,'correo'
    ,'telefono'
    ,'estatus'
  ];
    
}
