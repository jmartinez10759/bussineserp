<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysUsoCfdiModel extends Model
{
      public $table = "sys_uso_cfdi";
      public $fillable = [
      	'id'
        ,'clave'
        ,'descripcion'
        ,'fisica'
        ,'moral'
        ,'fecha_inicio_vigencia'
        ,'fecha_final_vigencia'
      ];
public function clientes()
{
  return $this->belongsTo(SysClientesModel::class,'id_uso_cfdi','id');
}


}