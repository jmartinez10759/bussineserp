<?php
/**
 * Created by PHP Storm
 * User : jmartinez
 * Date : 20/07/19
 * Time : 05:26 PM
 */

namespace App\Facades;

use App\Model\Administracion\Configuracion\SysRolesModel;
use App\SysNotifications;
use Illuminate\Support\Facades\Session;

class Notification
{

    /**
     * @param string $title
     * @param string $message
     * @param string $module
     * @param array $rules
     * @return mixed
     */
    public function creating(string $title, string $message, string $module ,array $rules )
    {
        $roles = SysRolesModel::with('users')->whereIn('id',$rules)->get();
        $users = [];
        foreach ($roles as $rule){
            foreach ($rule->users as $user){
                $users[] = $user->id;
            }
        }
        $data = [
            "title"     => $title ,
            "message"   => $message ,
            "module"    => $module ,
            "status"    => true
        ];
        $notifyCreate = SysNotifications::create($data);
        $notify = SysNotifications::find($notifyCreate->id);
        $notify->users()->attach($users,[
            'company_id' => Session::get('company_id') ,
            'group_id'   => Session::get('group_id')
        ]);
        return $notifyCreate;

    }


}