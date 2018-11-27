<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysCategoriasProductosModel extends Model
{
  public $table = "sys_categoria_producto";
  public $fillable = [
    'id'
    ,'nombre'
    ,'detalles'
    ,'estatus'
  ];

  public function productos()
  {
     return $this->belongsTo(SysProductosModel::class,'id','id_categoria');
  }

}