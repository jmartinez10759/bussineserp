<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SysCuts extends Model
{
    public $table = "cuts";
    public $fillable = [
        'id'
        ,'box_id'
        ,'n_cuts'
        ,'n_orders'
        ,'subtotal'
        ,'iva'
        ,'total'
        ,'file_path'
    ];

    public function boxes()
    {
        return $this->belongsTo(SysBoxes::class,'box_id','id');
    }
}
