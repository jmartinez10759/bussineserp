<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysTipoFactorModel extends Model
{
  public $table = "sys_tipo_factores";
  public $fillable = [
  	'id'
    ,'clave'
    ,'descripcion'
    ,'fecha_inicio_vigencia'
    ,'fecha_final_vigencia'
  ];
  public function productos()
  {
    return $this->belongsTo(SysProductosModel::class,'id_tipo_factor','id');
  }
  public function planes()
  {
    return $this->belongsTo(SysPlanesModel::class,'id_tipo_factor','id');
  }
  public function empresas()
  {
    return $this->belongsTo(SysEmpresasModel::class,'id_tipo_factor','id');
  }

}