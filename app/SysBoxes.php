<?php

namespace App;

use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysSucursalesModel;
use App\Model\Administracion\Configuracion\SysUsersModel;
use Illuminate\Database\Eloquent\Model;

class SysBoxes extends Model
{
    public $table = "boxes";
    public $fillable = [
        'id'
        ,'name'
        ,'description'
        ,'status'
    ];
    public function companies()
    {
        return $this->belongsToMany(SysEmpresasModel::class,'companies_boxes','box_id','company_id')
                    ->withPivot("group_id","user_id");
    }
    public function groups()
    {
        return $this->belongsToMany(SysSucursalesModel::class,'companies_boxes','box_id','group_id')
            ->withPivot("company_id","user_id");
    }
    public function users()
    {
        return $this->belongsToMany(SysUsersModel::class,'companies_boxes','box_id','user_id')
            ->withPivot("company_id","group_id");
    }
}
