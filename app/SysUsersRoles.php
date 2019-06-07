<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SysUsersRoles extends Model
{
    public $table = "sys_users_roles";
    public $fillable = [
        "user_id" ,
        "roles_id"
    ];
}
