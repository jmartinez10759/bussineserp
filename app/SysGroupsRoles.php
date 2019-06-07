<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SysGroupsRoles extends Model
{
    public $table = "sys_groups_roles";
    public $fillable = [
        'group_id' ,
        'roles_id'
    ];
}
