<?php

namespace App;

use App\Model\Administracion\Configuracion\SysEstatusModel;
use App\Model\Administracion\Configuracion\SysFormasPagosModel;
use App\Model\Administracion\Configuracion\SysMetodosPagosModel;
use Illuminate\Database\Eloquent\Model;

class SysOrders extends Model
{
    public $table = "orders";
    public $fillable = [
        'id'
        ,'box_id'
        ,'payment_form_id'
        ,'payment_method_id'
        ,'status_id'
        ,'comments'
        ,'file_path'
        ,'subtotal'
        ,'iva'
        ,'total'
        ,'swap'
        ,'count'
    ];
    public function boxes()
    {
        return $this->belongsTo(SysBoxes::class,'box_id','id');
    }
    public function concepts()
    {
        return $this->hasMany(SysConcepts::class,'order_id','id');
    }
    public function paymentsForms()
    {
        return $this->hasOne(SysFormasPagosModel::class,'id','payment_form_id');
    }
    public function paymentsMethods()
    {
        return $this->hasOne(SysMetodosPagosModel::class,'id','payment_method_id');
    }
    public function status()
    {
        return $this->hasOne(SysEstatusModel::class,'id','status_id');
    }

}
