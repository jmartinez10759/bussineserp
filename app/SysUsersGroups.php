<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SysUsersGroups extends Model
{
    public $table = "sys_users_groups";
    public $fillable = [
        "user_id" ,
        "group_id"
    ];
}
