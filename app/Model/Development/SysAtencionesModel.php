<?php

namespace App\Model\Development;

use Illuminate\Database\Eloquent\Model;

class SysAtencionesModel extends Model
{
    public $table = "sys_atenciones";
    public $fillable = [
        'id'
        ,'nombre'
        ,'primer_apellido'
        ,'segundo_apellido'
        ,'fecha_nacimiento'
        ,'direccion'
        ,'telefono'
        ,'solicitud'
        ,'foto'
        ,'ine'
        ,'ine_tutores'
        ,'descripcion'
    ];
}
