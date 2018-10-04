<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysClientesModel extends Model
{
    public $table = "sys_clientes";
    public $fillable = [
      'id'
      ,'rfc_receptor'
      ,'nombre_comercial'
      ,'razon_social'
      ,'calle'
      ,'colonia'
      ,'municipio'
      ,'cp'
      ,'id_estado'
      ,'giro_comercial'
      ,'contacto'
      ,'departamento'
      ,'correo'
      ,'telefono'
      ,'estatus'
    ];

    public function facturas(){
      #return $this->belongsTo('App\Model\Administracion\Facturacion\SysFacturacionModel','id_cliente','id');
      return $this->belongsToMany('App\Model\Administracion\Facturacion\SysFacturacionModel','sys_users_facturacion','id_cliente','id_factura');
    }

    public function usuarios(){
        return $this->belongsToMany('App\Model\Administracion\Facturacion\SysUsersModel','sys_users_facturacion','id_cliente','id_users');
    }
    
    public function estados(){
        return $this->hasOne('App\Model\Administracion\Configuracion\SysEstadosModel','id','id_estado');
    }
    
    public function contactos(){
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysContactosModel','sys_empresas_sucursales','id_clientes','id_contacto');
  }

}
