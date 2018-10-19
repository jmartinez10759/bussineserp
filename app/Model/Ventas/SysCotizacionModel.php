<?php

namespace App\Model\Ventas;

use Illuminate\Database\Eloquent\Model;

class SysCotizacionModel extends Model
{
      public $table = "sys_cotizaciones";
      public $fillable = [

		'id'
		,'codigo'
		,'descripcion'
            ,'iva'
            ,'subtotal'
            ,'total'
            ,'id_cliente'
            ,'id_moneda'
            ,'id_contacto'
            ,'id_metodo_pago'
            ,'id_forma_pago'
            ,'id_estatus'

      ];

      public function conceptos(){
            return $this->belongsToMany('App\Model\Ventas\SysConceptosCotizacionesModel','sys_users_cotizaciones','id_cotizacion','id_concepto');
      }

      public function usuarios(){
            return $this->belongsToMany('App\Model\Administracion\Configuracion\SysUsersModel','sys_users_cotizaciones','id_cotizacion','id_users');
      }

       
}