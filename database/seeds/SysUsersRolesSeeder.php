<?php

use Illuminate\Database\Seeder;

class SysUsersRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Model\Administracion\Configuracion\SysUsersRolesModel::create([
           'id_rol'		      => 1
           ,'id_users'		  => 1
           ,'id_empresa'    => 0
           ,'id_sucursal'   => 0
       ]);

    }
}
