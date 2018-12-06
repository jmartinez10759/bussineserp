<?php

namespace App\Model\Administracion\Correos;

use Illuminate\Database\Eloquent\Model;

class SysTemplatesModel extends Model
{
    public $table = "sys_templates";
    public $fillable = [
    	 'id'
    	,'estructura'
    	,'estatus'
    ];
    public function usuarios()
    {
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysUsersModel','sys_users_templates','id_users','id_template');
    }
    public function empresas()
    {
      return $this->belongsToMany('App\Model\Administracion\Configuracion\SysEmpresasModel','sys_users_templates','id_empresa','id_template');
    }



}
