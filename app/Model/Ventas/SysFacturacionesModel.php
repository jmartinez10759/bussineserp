<?php

namespace App\Model\Ventas;

use Illuminate\Database\Eloquent\Model;

class SysFacturacionesModel extends Model
{
      public $table = "sys_facturaciones";
      public $fillable = [
			'id'
	        ,'codigo'
	        ,'descripcion'
	        ,'iva'
            ,'subtotal'
            ,'total'
            ,'id_pedido'
	        ,'id_cliente'
	        ,'id_moneda'
	        ,'id_contacto'
	        ,'id_forma_pago'
	        ,'id_metodo_pago'
	        ,'id_estatus'
	  ];
}