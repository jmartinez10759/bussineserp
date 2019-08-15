<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SysUsersPivot extends Model
{
    public $table = "sys_users_pivot";
    public $fillable = [
        "user_id" ,
        "roles_id" ,
        "company_id" ,
        "group_id" ,
    ];
}
