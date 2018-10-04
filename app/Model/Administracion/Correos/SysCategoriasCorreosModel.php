<?php

namespace App\Model\Administracion\Correos;

use Illuminate\Database\Eloquent\Model;

class SysCategoriasCorreosModel extends Model
{
  public $table = "sys_categorias_correos";
  public $fillable = [
    'id_users'
    ,'id_register'
    ,'id_sucursal'
    ,'id_empresa'
    ,'id_categorias'
    ,'id_correo'
  ];



}
