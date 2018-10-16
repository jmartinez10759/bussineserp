<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysEmpresasSucursalesModel extends Model
{
  public $table = "sys_empresas_sucursales";
  public $fillable = [
    'id_cliente'
    ,'id_empresa'
    ,'id_sucursal'
    ,'id_contacto'
    ,'estatus'
  ];
}
