<?php

namespace App\Model\Ventas;

use Illuminate\Database\Eloquent\Model;

class SysFacturacionesModel extends Model
{
      public $table = "sys_facturaciones";
      public $fillable = [
			'id'
	        ,'folio'
	        ,'serie'
	        ,'descripcion'
	        ,'iva'
            ,'subtotal'
            ,'total'
            ,'id_pedidos'
	        ,'id_cliente'
	        ,'id_moneda'
	        ,'id_tipo_comprobante'
	        ,'id_contacto'
	        ,'id_forma_pago'
	        ,'id_metodo_pago'
	        ,'id_estatus'
	  ];

	  public function conceptos()
	  {
	      return $this->belongsToMany('App\Model\Ventas\SysConceptosFacturacionesModel','sys_users_facturaciones','id_facturacion','id_concepto');
	  }

	  public function usuarios()
	  {
	      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysUsersModel','sys_users_facturaciones','id_facturacion','id_users');
	  }

	  public function empresas()
	  {
	      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysEmpresasModel','sys_users_facturaciones','id_facturacion','id_empresa');
	  }

	  public function clientes()
	  {
	      return $this->hasOne('App\Model\Administracion\Configuracion\SysClientesModel','id','id_cliente');
	  }

	  public function monedas()
	  {
	      return $this->hasOne('App\Model\Administracion\Configuracion\SysMonedasModel','id','id_moneda');
	  }

	  public function contactos()
	  {
	      return $this->hasOne('App\Model\Administracion\Configuracion\SysContactosModel','id','id_contacto');
	  }

	  public function formaspagos()
	  {
	      return $this->hasOne('App\Model\Administracion\Configuracion\SysFormasPagosModel','id','id_forma_pago');
	  }

	  public function metodospagos()
	  {
	      return $this->hasOne('App\Model\Administracion\Configuracion\SysMetodosPagosModel','id','id_metodo_pago');
	  }

	  public function estatus()
	  {
	      return $this->hasOne('App\Model\Administracion\Configuracion\SysEstatusModel','id','id_estatus');
	  }

	  public function pedidos()
	  {
	      return $this->hasOne('App\Model\Ventas\SysPedidosModel','id','id_pedidos');
	  }

}