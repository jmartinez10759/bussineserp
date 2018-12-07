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
    ,'id_servicio_comercial'
    ,'telefono'
    ,'logo'
    ,'estatus'
];


  public function sucursales(){
    return $this->belongsToMany(SysSucursalesModel::class,'sys_proveedores_empresas','id_proveedor','id_sucursal');
  }
  public function empresas(){
    return $this->belongsToMany(SysEmpresasModel::class,'sys_proveedores_empresas','id_proveedor','id_empresa');
  }
  
  public function contactos(){
      return $this->belongsToMany(SysContactosModel::class,'sys_contactos_sistemas','id_proveedor','id_contacto');
  }

  public function productos(){
        return $this->belongsToMany(SysProductosModel::class, 'sys_proveedores_productos', 'id_proveedor', 'id_producto');
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
  public function servicios()
  {
      return $this->hasOne(SysClaveProdServicioModel::class, 'id','id_servicio_comercial');
  }

}