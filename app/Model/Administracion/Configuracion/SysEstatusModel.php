<?php

namespace App\Model\Administracion\Configuracion;

use App\SysOrders;
use Illuminate\Database\Eloquent\Model;

class SysEstatusModel extends Model
{
      public $table = "sys_estatus";
      public $fillable = [
            'id'
            ,'nombre'
            ,'detalles'
            ,"estatus"
      ];

      public function facturas(){
        return $this->belongsTo('App\Model\Administracion\Facturacion\SysFacturaModel','id_estatus','id');
      }
      public function cotizaciones(){
        return $this->belongsTo('App\Model\Ventas\SysCotizacionModel','id_estatus','id');
      }
      public function pedidos(){
        return $this->belongsTo('App\Model\Ventas\SysPedidosModel','id_estatus','id');
      }
      public function orders()
      {
          return $this->belongsTo(SysOrders::class,'box_id','id');
      }


}
