<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysServiciosComercialesModel extends Model
{
    public $table = "sys_servicios_comerciales";
    public $fillable = [
    	'id'
    	,'nombre'
    	,'descripcion'
    ];

  public function empresas()
  {
    return $this->belongsTo( SysEmpresasModel::class, 'id','id_servicio_comercial');
  }
  public function clientes()
  {
    return $this->belongsTo( SysClientesModel::class, 'id','id_servicio_comercial');
  }
  public function proveedores()
  {
    return $this->belongsTo( SysProveedoresModel::class, 'id','id_servicio_comercial');
  }
  public function cuentas()
  {
    return $this->belongsTo( SysCuentasModel::class, 'id','id_servicio_comercial');
  }

}