<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysProveedoresProductosModel extends Model
{
    public $table = "sys_proveedores_productos";
      public $fillable = [
            'id'
            ,'id_users'
            ,'id_rol'
            ,'id_empresa'
            ,'id_sucursal'
            ,'id_proveedor'
            ,'id_producto'
      ];    
}
