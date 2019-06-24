<?php

namespace App\Model\Administracion\Configuracion;

use App\SysOrders;
use Illuminate\Database\Eloquent\Model;

class SysProductosModel extends Model
{
      public $table = "sys_productos";
      public $fillable = [
        'id'
        ,'id_categoria'
        ,'id_unidadmedida'
        ,'id_tasa'
        ,'id_impuesto'
        ,'id_tipo_factor'
        ,'id_servicio'
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
    public function companies()
    {
        return $this->belongsToMany(SysEmpresasModel::class, 'sys_companies_products', 'product_id', 'company_id')->withPivot('group_id');;
    }
    public function groups()
    {
        return $this->belongsToMany(SysSucursalesModel::class, 'sys_companies_products', 'product_id', 'group_id')->withPivot('company_id');;
    }
    public function categories()
    {
      return $this->hasOne(SysCategoriasProductosModel::class,'id','id_categoria');
    }
    public function units()
    {
      return $this->hasOne(SysUnidadesMedidasModel::class, 'id', 'id_unidadmedida');
    }
    public function services()
    {
      return $this->hasOne(SysClaveProdServicioModel::class, 'id', 'id_servicio');
    }
    public function tasas()
    {
      return $this->hasOne(SysTasaModel::class, 'id', 'id_tasa');
    }
    public function taxes()
    {
      return $this->hasOne(SysImpuestoModel::class, 'id', 'id_impuesto');
    }
    public function factorType()
    {
      return $this->hasOne(SysTipoFactorModel::class, 'id', 'id_tipo_factor');
    }
    public function planes()
    {
      return $this->belongsToMany(SysPlanesModel::class,'sys_planes_productos','id_producto','id_plan');
    }
    public function warehouses()
    {
      return $this->belongsToMany('App\Model\Almacenes\SysAlmacenesModel','sys_almacenes_productos','id_producto','id_almacen');
    }
    public function providers()
    {
      return $this->belongsToMany(SysProveedoresModel::class,'sys_proveedores_productos','id_producto','id_proveedor');
    }
    public function concepts()
    {
      return $this->belongsTo('App\Model\Ventas\SysConceptosPedidosModel', 'id', 'id_producto');
    }
    public function orders()
    {
        return $this->belongsTo(SysOrders::class,'box_id','id');
    }
    

    
}