<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysPlanesModel extends Model
{
    public $table = "sys_planes";
    public $fillable = [
        'id'
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
    
    public function productos()
    {
        return $this->belongsToMany(SysProductosModel::class,'sys_planes_productos','id_plan','id_producto');
    }
    public function empresas()
    {
        return $this->belongsToMany(SysEmpresasModel::class,'sys_planes_productos','id_plan','id_empresa');
    }
    
    public function sucursales()
    {
        return $this->belongsToMany(SysSucursalesModel::class,'sys_planes_productos','id_plan','id_sucursal');
    }   
    
    public function conceptos()
    {
      return $this->belongsTo('App\Model\Ventas\SysConceptosPedidosModel', 'id', 'id_plan');
    }
    public function unidades()
    {
      return $this->hasOne(SysUnidadesMedidasModel::class, 'id', 'id_unidadmedida');
    }
    public function servicios()
    {
      return $this->hasOne(SysClaveProdServicioModel::class, 'id', 'id_servicio');
    }
    public function tasas()
    {
      return $this->hasOne(SysTasaModel::class, 'id', 'id_tasa');
    }
    public function impuestos()
    {
      return $this->hasOne(SysImpuestoModel::class, 'id', 'id_impuesto');
    }
    public function tipoFactor()
    {
      return $this->hasOne(SysTipoFactorModel::class, 'id', 'id_tipo_factor');
    }


}