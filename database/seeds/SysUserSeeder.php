<?php

use Illuminate\Database\Seeder;

class SysUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Model\Administracion\Configuracion\SysUsersModel::create([
          'name'               => "JORGE"
          ,'first_surname'      => "MARTINEZ"
          ,'second_surname'     => "QUEZADA"
          ,'email'              => "jorge.martinez@burolaboralmexico.com"
          ,'password'           => sha1('root-007')
          ,'remember_token'     => str_random(50)
          ,'api_token'          => str_random(50)
          ,'estatus'            => 1
          ,'confirmed'          => 1
          ,'confirmed_code'     => ""
        ]);

        App\Model\Administracion\Configuracion\SysUsersModel::create([
          'name'               => "USUARIO"
          ,'first_surname'      => "DEMO"
          ,'second_surname'     => ""
          ,'email'              => "usuario.demo@burolaboralmexico.com"
          ,'password'           => sha1('demo-001')
          ,'remember_token'     => str_random(50)
          ,'api_token'          => str_random(50)
          ,'estatus'            => 1
          ,'confirmed'          => 1
          ,'confirmed_code'     => ""
        ]);

        App\Model\Administracion\Configuracion\SysUsersModel::create([
          'name'               => "JORGE"
          ,'first_surname'      => "MARTINEZ"
          ,'second_surname'     => "QUEZADA"
          ,'email'              => "notificacionesbussines@gmail.com"
          ,'password'           => sha1('root-007')
          ,'remember_token'     => str_random(50)
          ,'api_token'          => str_random(50)
          ,'estatus'            => 1
          ,'confirmed'          => 1
          ,'confirmed_code'     => ""
        ]);



    }

}
