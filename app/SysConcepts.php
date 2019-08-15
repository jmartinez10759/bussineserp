<?php

namespace App;

use App\Model\Administracion\Configuracion\SysProductosModel;
use Illuminate\Database\Eloquent\Model;

class SysConcepts extends Model
{
    public $table = "concepts";
    public $fillable = [
        'id'
        ,'order_id'
        ,'product_id'
        ,'quantity'
        ,'discount'
        ,'price'
        ,'total'
        ,'comments'
    ];
    public function orders()
    {
        return $this->belongsTo(SysOrders::class,'id','order_id');
    }
    public function products()
    {
        return $this->hasOne(SysProductosModel::class,'id','product_id');
    }

}
