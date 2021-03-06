<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysContactosModel extends Model
{
  public $table = "sys_contactos";
  public $fillable = [
    'id'
    ,'id_study'
    ,'nombre_completo'
    ,'departamento'
    ,'correo'
    ,'telefono'
    ,'extension'
    ,'cargo'
    ,'estatus'
  ];
    
    public function empresas()
    {
      return $this->belongsToMany(SysEmpresasModel::class,'sys_empresas_sucursales','id_contacto','id_empresa');
    }
    public function clientes()
    {
      return $this->belongsToMany(SysClientesModel::class,'sys_empresas_sucursales','id_contacto','id_cliente');
    }  
    public function cuentas()
    {
      return $this->belongsToMany(SysCuentasModel::class,'sys_cuentas_empresas','id_contacto','id_cuenta');
    }
    public function pedidos()
    {
      return $this->belongsTo('App\Model\Ventas\SysPedidosModel','id_contacto','id');
    }
    
}
