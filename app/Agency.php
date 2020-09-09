<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    public $table = "agencies";
    public $guarded = [];

    public function order()
    {
        return $this->belongsTo(SysOrders::class);
    }
}
