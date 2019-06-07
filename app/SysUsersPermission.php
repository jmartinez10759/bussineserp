<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SysUsersPermission extends Model
{
    public $table = "sys_users_permission";
    public $fillable = [
        "user_id" ,
        "permission_id"
    ];
}
