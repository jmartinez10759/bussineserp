<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SysPermission extends Model
{
    public $table = "sys_permission";
    public $fillable = [
        "id" ,
        "short_key" ,
        "description" ,
        "status"
    ];

    public function menus()
    {
        return $this->belongsToMany('App\Model\Administracion\Configuracion\SysMenuModel','sys_permission_menus','permission_id','menu_id');
    }
}
