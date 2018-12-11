<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysAlmacenesEmpresasModel extends Model
{
    public $table = "sys_almacenes_empresas";
      public $fillable = [
          'id_empresa'
          ,'id_sucursal'
          ,'id_almacen'
      ];
}
