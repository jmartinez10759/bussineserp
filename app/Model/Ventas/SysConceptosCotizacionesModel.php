<?php

namespace App\Model\Ventas;

use Illuminate\Database\Eloquent\Model;

class SysConceptosCotizacionesModel extends Model
{
    public $table = "sys_conceptos_cotizaciones";
      public $fillable = [
            'id'
            ,'id_producto'
            ,'id_plan'
            ,'cantidad'
            ,'precio'
            ,'total'
      ];
 
	 public function cotizaciones(){
	 	return $this->belongsToMany('AppApp\Model\Ventas\SysCotizacionModel','sys_users_cotizaciones','id_concepto','id_cotizacion');
	 }


}
