<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysEstadosModel extends Model
{
  public $table = "sepomex";
  public $fillable = [
      'id'
      ,'idCountry'
      ,'idEstado'
      ,'estado'
      ,'idMunicipio'
      ,'municipio'
      ,'ciudad'
      ,'zona'
      ,'cp'
      ,'asentamiento'
      ,'tipo'
  ];

    public function clientes()
    {
        return $this->hasOne(SysClientesModel::class,'id_estado','idEstado');
    }
    
    public function sucursales()
    {
        return $this->hasOne(SysSucursalesModel::class,'id_estado','idEstado');
    }
    
    public function empresas()
    {
        return $this->hasOne(SysEmpresasModel::class,'id_estado','idEstado');
    }
    
    public function proveedores()
    {
        return $this->hasOne(SysProveedoresModel::class,'id_estado','id');
    }
    public function countries()
    {
        return $this->hasOne( SysPaisModel::class,'id','idCountry');
    }
    public function postalCode()
    {
        return $this->hasMany( SysEstadosModel::class,'idMunicipio','id' );
    }

}
