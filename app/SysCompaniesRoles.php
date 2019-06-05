<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SysCompaniesRoles extends Model
{
    public $table = "sys_empresas_roles";
    public $fillable = [
        'id_rol'
        ,'id_empresa'
        ,'id_sucursal'
    ];
}
