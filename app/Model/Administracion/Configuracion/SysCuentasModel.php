<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysCuentasModel extends Model
{
      public $table = "sys_cuentas";
      public $fillable = [
        'id'
        ,'nombre_comercial'
        ,'id_cliente'
        ,'giro_comercial'
        ,'logo'
        ,'estatus'
      ];
    
    public function empresas()
    {
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysEmpresasModel','sys_cuentas_empresas','id_cuenta','id_empresa');
    }
      
    public function sucursales()
    {
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysSucursalesModel','sys_cuentas_empresas','id_cuenta','id_sucursal');
    }
    public function clientes()
    {
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysClientesModel','sys_cuentas_empresas','id_cuenta','id_cliente');
    }
    
    public function contactos()
    {
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysContactosModel','sys_cuentas_empresas','id_cuenta','id_contacto');
    }
    

}