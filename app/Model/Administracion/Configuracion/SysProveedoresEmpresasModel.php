<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysProveedoresEmpresasModel extends Model
{
    public $table = "sys_proveedores_empresas";
      public $fillable = [
         'id_proveedor'
        ,'id_empresa'
        ,'id_sucursal'
        ,'id_contacto'
      ];
}
