<?php

use Illuminate\Database\Seeder;

class SysSucursalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      App\Model\Administracion\Configuracion\SysSucursalesModel::create([
          'sucursal'      => "Sucursal 1"
          ,'descripcion'  => "Sucursal perteneciente a la empresa "
          ,'estatus'      => 1
      ]);

    }
}
