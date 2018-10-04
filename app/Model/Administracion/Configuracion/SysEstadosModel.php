<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysEstadosModel extends Model
{
  public $table = "sys_estados";
  public $fillable = [
      'id'
      ,'country_id'
      ,'nombre'
  ];

    public function clientes(){
        return $this->hasOne('App\Model\Administracion\Configuracion\SysClientesModel','id_estado','id');
    }
    
    public function sucursales(){
        return $this->hasOne('App\Model\Administracion\Configuracion\SysSucursalesModel','id_estado','id');
    }
    
    public function empresas(){
        return $this->hasOne('App\Model\Administracion\Configuracion\SysEmpresasModel','id_estado','id');
    }
    
    public function proveedores(){
        return $this->hasOne('App\Model\Administracion\Configuracion\SysProveedoresModel','id_estado','id');
    }
    
}
