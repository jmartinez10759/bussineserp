<?php

namespace App\Model\Ventas;

use Illuminate\Database\Eloquent\Model;

class SysConceptosPedidosModel extends Model
{
    public $table = "sys_conceptos_pedidos";
    public $fillable = [
         'id'
        ,'product_id'
        ,'plan_id'
        ,'cantidad'
        ,'precio'
        ,'total'
    ];
    public function products()
    {
    	return $this->hasOne('App\Model\Administracion\Configuracion\SysProductosModel','id','product_id');
    }
    public function planes()
    {
    	return $this->hasOne('App\Model\Administracion\Configuracion\SysPlanesModel','id','plan_id');
    }


}
