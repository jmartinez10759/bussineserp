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
        ,'id_servicio'
        ,'logo'
        ,'estatus'
      ];
    
    public function empresas()
    {
      return $this->belongsToMany(SysEmpresasModel::class,'sys_cuentas_empresas','id_cuenta','id_empresa');
    }
      
    public function sucursales()
    {
      return $this->belongsToMany(SysSucursalesModel::class,'sys_cuentas_empresas','id_cuenta','id_sucursal');
    }
    public function clientes()
    {
      return $this->belongsToMany(SysClientesModel::class,'sys_cuentas_empresas','id_cuenta','id_cliente');
    }
    public function cliente()
    {
      return $this->hasOne(SysClientesModel::class,'id','id_cliente');
    }
    public function contactos()
    {
      return $this->belongsToMany(SysContactosModel::class,'sys_contactos_sistemas','id_cuenta','id_contacto');
    }
    public function servicios()
    {
      return $this->hasOne(SysClaveProdServicioModel::class,'id','id_servicio');
    }
    

}