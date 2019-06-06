<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SysUsersCompanies extends Model
{
    public $table = "sys_users_companies";
    public $fillable = [
        "user_id" ,
        "company_id"
    ];
}
