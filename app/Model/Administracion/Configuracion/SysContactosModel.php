<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysContactosModel extends Model
{
  public $table = "sys_contactos";
  public $fillable = [
    'id'
    ,'nombre_completo'
    ,'departamento'
    ,'correo'
    ,'telefono'
    ,'estatus'
  ];
    
      public function empresas(){
          return $this->belongsToMany('App\Model\Administracion\Configuracion\SysEmpresasModel','sys_empresas_sucursales','id_contacto','id_empresa');
      }
  
      public function clientes(){
         return $this->belongsToMany('App\Model\Administracion\Configuracion\SysClientesModel','sys_empresas_sucursales','id_contacto','id_cliente');
      }
    
      public function cuentas(){
         return $this->belongsToMany('App\Model\Administracion\Configuracion\SysCuentasModel','sys_cuentas_empresas','id_contacto','id_cuenta');
      }
    
}
