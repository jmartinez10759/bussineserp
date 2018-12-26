<?php

namespace App\Model\Almacenes;

use Illuminate\Database\Eloquent\Model;

class SysAlmacenesModel extends Model
{
      public $table = "sys_almacenes";
      public $fillable = [
        'id'
        ,'nombre'
        ,'entradas'
        ,'salidas'
        ,'estatus'
      ];

	  public function sucursales(){
	    return $this->belongsToMany('App\Model\Administracion\Configuracion\SysSucursalesModel','sys_almacenes_empresas','id_almacen','id_sucursal');
	  }
	  public function empresas(){
	    return $this->belongsToMany('App\Model\Administracion\Configuracion\SysEmpresasModel','sys_almacenes_empresas','id_almacen','id_empresa');
	  }
	  public function proveedores(){
	    return $this->belongsToMany('App\Model\Administracion\Configuracion\SysProveedoresModel','sys_almacenes_productos','id_almacen','id_proveedor');
	  }
	  public function productos(){
        return $this->belongsToMany('App\Model\Administracion\Configuracion\SysProductosModel', 'sys_almacenes_productos','id_almacen','id_producto');
	  }

}