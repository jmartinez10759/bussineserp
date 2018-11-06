<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysCodigoPostalModel extends Model
{
      public $table = "sys_codigos_postales";
      public $fillable = [
      	'id'
      	,'codigo_postal'
      	,'estado'
      	,'municipio'
      	,'localidad'
      ];
}