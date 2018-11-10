<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysClientesEmpresasModel extends Model
{
  public $table = "sys_clientes_empresas";
  public $fillable = [
    'id_empresa'
    ,'id_sucursal'
    ,'id_cliente'
  ];

}
