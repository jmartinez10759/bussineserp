<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SysCompaniesMenus extends Model
{
    public $table = "sys_companies_menus";
    public $fillable = [
        "company_id" ,
        "menu_id"
    ];
}
