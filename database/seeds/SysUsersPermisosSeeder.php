<?php

use Illuminate\Database\Seeder;

class SysUsersPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $acciones = [1,2,3,4,5,6,7];
        for ($i=0; $i < count($acciones); $i++) {

          App\Model\Administracion\Configuracion\SysUsersPermisosModel::create([
              'id_accion'       => $acciones[$i]
              ,'id_permiso'     =>  7
              ,'id_rol'         =>  1
              ,'id_menu'        =>  7
              ,'id_users'       =>  1
              ,'id_empresa'     =>  0
              ,'id_sucursal'    =>  0
              ,'estatus'        =>  1
          ]);

        }

    }
}
