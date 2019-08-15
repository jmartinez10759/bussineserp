<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SysUsersMenus extends Model
{
    public $table = "sys_users_menus";
    public $fillable = [
        "user_id" ,
        "roles_id" ,
        "company_id" ,
        "group_id" ,
        "menu_id" ,
    ];
}
