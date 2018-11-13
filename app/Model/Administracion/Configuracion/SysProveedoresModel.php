<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysProveedoresModel extends Model
{
      public $table = "sys_proveedores";
      public $fillable = [
      'id'
    ,'rfc'
    ,'nombre_comercial'
    ,'razon_social'
    ,'calle'
    ,'colonia'
    ,'municipio'
    ,'id_codigo'
    ,'id_country'
    ,'id_estado'
    ,'id_regimen_fiscal'
    ,'id_servicio'
    ,'telefono'
    ,'logo'
    ,'estatus'
];


  public function sucursales(){
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysSucursalesModel','sys_proveedores_empresas','id_empresa','id_sucursal')->withPivot('estatus');
  }
  
  public function contactos(){
      return $this->belongsToMany(SysContactosModel::class,'sys_proveedores_empresas','id_proveedor','id_contacto');
  }

  public function productos(){
        return $this->belongsToMany('App\Model\Administracion\Configuracion\SysProductosModel', 'sys_planes_productos', 'id_proveedor', 'id_producto');
  }
  public function regimenes()
  {
      return $this->hasOne('App\Model\Administracion\Configuracion\SysRegimenFiscalModel', 'id','id_regimen_fiscal');
  }
  public function estados()
  {
      return $this->hasOne('App\Model\Administracion\Configuracion\SysEstadosModel', 'id','id_estado');
  }
  public function paises()
  {
      return $this->hasOne('App\Model\Administracion\Configuracion\SysPaisModel', 'id','id_country');
  }

}