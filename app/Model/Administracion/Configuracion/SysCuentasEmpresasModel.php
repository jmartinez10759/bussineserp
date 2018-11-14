<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysCuentasEmpresasModel extends Model
{
    public $table = "sys_cuentas_empresas";
      public $fillable = [
        'id_cuenta'
        ,'id_empresa'
        ,'id_sucursal'
        ,'id_cliente'
      ];
}
