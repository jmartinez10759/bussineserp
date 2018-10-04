<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysEmpresasSecursalesModel extends Model
{
  public $table = "sys_empresas_sucursales";
  public $fillable = [
    'id_cuenta'
    ,'id_empresa'
    ,'id_sucursal'
    ,'id_contacto'
    ,'id_clientes'
    ,'id_proveedores'
    ,'estatus'
  ];
}
