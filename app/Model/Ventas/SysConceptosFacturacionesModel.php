<?php

namespace App\Model\Ventas;

use Illuminate\Database\Eloquent\Model;

class SysConceptosFacturacionesModel extends Model
{
     public $table = "sys_conceptos_facturaciones";
    public $fillable = [
         'id'
        ,'id_producto'
        ,'id_plan'
        ,'cantidad'
        ,'precio'
        ,'total'
      ];
    
    public function productos()
    {
    	return $this->hasOne('App\Model\Administracion\Configuracion\SysProductosModel','id','id_producto');
    }

    public function planes()
    {
    	return $this->hasOne('App\Model\Administracion\Configuracion\SysPlanesModel','id','id_plan');
    }
}
