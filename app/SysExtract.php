<?php

namespace App;

use App\Model\Administracion\Configuracion\SysUsersModel;
use Illuminate\Database\Eloquent\Model;

class SysExtract extends Model
{
    public $table = "extracts";
    public $fillable = [
        'id'
        ,'box_id'
        ,'user_id'
        ,'extract'
    ];

    public function boxes()
    {
        return $this->belongsTo(SysBoxes::class,'box_id','id');
    }
    public function users()
    {
        return $this->belongsTo(SysUsersModel::class,'user_id','id');
    }
}
