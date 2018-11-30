<?php

namespace App\Model\Development;

use Illuminate\Database\Eloquent\Model;

class SysProyectosModel extends Model
{
      public $table = "sys_users_projects";
      public $fillable = [
            'id_users'
            ,'id_rol'
            ,'id_empresa'
            ,'id_sucursal'
            ,'id_proyecto'
            ,'id_tarea'
            ,'id_proyecto'
      ];
}