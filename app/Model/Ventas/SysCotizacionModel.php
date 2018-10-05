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
      		,'id_moneda'
      		,'id_contacto'
      		,'condiciones_pago'
      		,'id_estatus'
      ];
}