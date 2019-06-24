<?php

namespace App;

use App\Model\Administracion\Configuracion\SysEstatusModel;
use App\Model\Administracion\Configuracion\SysFormasPagosModel;
use App\Model\Administracion\Configuracion\SysMetodosPagosModel;
use App\Model\Administracion\Configuracion\SysProductosModel;
use Illuminate\Database\Eloquent\Model;

class SysOrders extends Model
{
    public $table = "orders";
    public $fillable = [
        'id'
        ,'box_id'
        ,'product_id'
        ,'payment_form_id'
        ,'payment_method_id'
        ,'status_id'
        ,'quality'
        ,'discount'
        ,'whole'
        ,'subtotal'
        ,'iva'
        ,'total'
    ];
    public function boxes()
    {
        return $this->hasOne(SysBoxes::class,'id','box_id');
    }
    public function products()
    {
        return $this->hasOne(SysProductosModel::class,'id','product_id');
    }
    public function paymentsForms()
    {
        return $this->hasOne(SysFormasPagosModel::class,'id','payment_form_id');
    }
    public function paymentsMethods()
    {
        return $this->hasOne(SysMetodosPagosModel::class,'id','payment_form_id');
    }
    public function status()
    {
        return $this->hasOne(SysEstatusModel::class,'id','status_id');
    }

}
