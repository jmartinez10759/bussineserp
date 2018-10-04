<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysUnidadesMedidasModel extends Model
{
      public $table = "sys_unidades_medidas";
      public $fillable = [
            'id'
            ,'clave'
            ,'nombre'
            ,'descripcion'
            ,'estatus'
            ,'created_at'
            ,'updated_at'
      ];

      public function productos(){
            return $this->belongsTo('App\Model\Administracion\Configuracion\SysProductosModel', 'id_unidadmedida', 'id');
      }
      
}