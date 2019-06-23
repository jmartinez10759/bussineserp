<?php

namespace App;

use App\Model\Administracion\Configuracion\SysEmpresasModel;
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
        return $this->belongsToMany(SysEmpresasModel::class,'companies_boxes','boxes_id','company_id')
                    ->withPivot("group_id","user_id");
    }
}
