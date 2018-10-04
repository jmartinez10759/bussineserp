<?php

namespace App\Model\Administracion\Configuracion;

use Illuminate\Database\Eloquent\Model;

class SysAccionesModel extends Model
{
    public $table = "sys_actions";
    public $fillable = [
        'id'
        ,'clave_corta'
        ,'descripcion'
        ,'estatus'
    ];
}
