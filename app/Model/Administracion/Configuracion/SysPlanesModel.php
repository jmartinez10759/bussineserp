<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysPlanesModel extends Model
{
    public $table = "sys_planes";
    public $fillable = [
        'id'
        ,'clave_unidad'
        ,'clave_producto_servicio'
        ,'codigo'
        ,'nombre'
        ,'descripcion'
        ,'subtotal'
        ,'iva'
        ,'total'
        ,'estatus'
    ];
    
    public function productos(){
        return $this->belongsToMany('App\Model\Administracion\Configuracion\SysProductosModel','sys_planes_productos','id_producto','id_plan');
    }
    public function empresas(){
        return $this->belongsToMany('App\Model\Administracion\Configuracion\SysEmpresasModel','sys_planes_productos','id_empresa','id_plan');
    }
    
}