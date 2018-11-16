<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysContactosSistemasModel extends Model
{
  public $table = "sys_contactos_sistemas";
  public $fillable = [
    'id_empresa'
    ,'id_cliente'
    ,'id_proveedor'
    ,'id_cuenta'
    ,'id_contacto'
  ];
}
