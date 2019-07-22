<?php

namespace App;

use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysSucursalesModel;
use App\Model\Administracion\Configuracion\SysUsersModel;
use Illuminate\Database\Eloquent\Model;

class SysNotifications extends Model
{
    public $table = "notifications";
    public $fillable = [
        'id'
        ,'title'
        ,'message'
        ,'module'
        ,'status'
    ];

    public function users()
    {
        return $this->belongsToMany(SysUsersModel::class,'users_notifications','notify_id','user_id')
            ->withPivot('company_id','group_id');
    }

}
