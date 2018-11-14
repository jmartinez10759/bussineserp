<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysClaveProdServicioModel extends Model
{
      public $table = "sys_clave_servicios";
      public $fillable = [
      	'id'
        ,'clave'
        ,'descripcion'
        ,'iva_trasladado'
        ,'ieps_trasladado'
        ,'complemento'
        ,'fecha_inicio_vigencia'
        ,'fecha_final_vigencia'
        ,'similares'
      ];

  public function empresas()
  {
    return $this->belongsTo( SysEmpresasModel::class,'id_servicio','id');
  }
  public function cuentas()
  {
    return $this->belongsTo( SysCuentasModel::class,'id_servicio','id');
  }
  public function clientes()
  {
    return $this->belongsTo( SysClientesModel::class,'id_servicio','id');
  }
  public function proveedores()
  {
    return $this->belongsTo( SysProveedoresModel::class,'id_servicio','id');
  }



}