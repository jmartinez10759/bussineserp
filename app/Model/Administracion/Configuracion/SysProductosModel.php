<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysProductosModel extends Model
{
      public $table = "sys_productos";
      public $fillable = [
        'id'
        ,'id_categoria'
        ,'id_unidadmedida'
        ,'clave_producto_servicio'
        ,'clave_unidad'
        ,'codigo'
        ,'nombre'
        ,'descripcion'
        ,'subtotal'
        ,'iva'
        ,'total'
        ,'stock'
        ,'logo'
        ,'estatus'
      ];
    
    public function categorias(){
         return $this->hasOne('App\Model\Administracion\Configuracion\SysCategoriasProductosModel','id','id_categoria');
    }

    public function unidades(){
      return $this->hasOne('App\Model\Administracion\Configuracion\SysUnidadesMedidasModel', 'id', 'id_unidadmedida');
    }

    public function planes(){
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysPlanesModel','sys_planes_productos','id_producto','id_plan');
    }
    
    public function almacenes(){
      return $this->belongsToMany('App\Model\Almacenes\SysAlmacenesModel','sys_almacenes_productos','id_producto','id_almacen');
    }
    
    public function proveedores(){
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysProveedoresModel','sys_almacenes_productos','id_producto','id_proveedor');
    }

    public function empresas(){
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysEmpresasModel', 'sys_planes_productos', 'id_producto', 'id_empresa');
    }
    
}