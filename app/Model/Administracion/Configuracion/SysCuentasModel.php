<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysCuentasModel extends Model
{
      public $table = "sys_cuentas";
      public $fillable = [
        'id'
        ,'nombre_comercial'
        ,'giro_comercial'
        ,'logo'
        ,'estatus'
      ];
    
      public function empresas(){
          return $this->belongsToMany('App\Model\Administracion\Configuracion\SysEmpresasModel','sys_empresas_sucursales','id_cuenta','id_empresa');
      }
  
      public function clientes(){
         return $this->belongsToMany('App\Model\Administracion\Configuracion\SysClientesModel','sys_empresas_sucursales','id_cuenta','id_cliente');
      }
    
      public function contactos(){
         return $this->belongsToMany('App\Model\Administracion\Configuracion\SysContactosModel','sys_empresas_sucursales','id_cuenta','id_contacto');
      }
    

}