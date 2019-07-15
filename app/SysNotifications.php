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
        ,'status'
    ];

    public function companies()
    {
        return $this->belongsToMany(SysEmpresasModel::class,'companies_notifications','company_id','notify_id')
                    ->withPivot('group_id','user_id');
    }
    public function groups()
    {
        return $this->belongsToMany(SysSucursalesModel::class,'companies_notifications','group_id','notify_id')
            ->withPivot('company_id','user_id');
    }
    public function users()
    {
        return $this->belongsToMany(SysUsersModel::class,'companies_notifications','user_id','notify_id')
            ->withPivot('group_id','company_id');
    }

}
