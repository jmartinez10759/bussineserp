<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysEmpresasSucursalesModel extends Model
{
  public $table = "sys_empresas_sucursales";
  public $fillable = [
    'id_cuenta'
    ,'id_empresa'
    ,'id_sucursal'
    ,'id_contacto'
    ,'id_cliente'
    ,'id_proveedor'
    ,'estatus'
  ];
}
