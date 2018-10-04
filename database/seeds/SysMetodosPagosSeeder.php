<?php

use Illuminate\Database\Seeder;

class SysMetodosPagosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $data = [
        'PUE' => "Pago en una sola exhibición"
        ,'PPD' => "Pago en parcialidades o diferido"
      ];

      foreach ($data as $key => $value) {

        App\Model\Administracion\Configuracion\SysMetodosPagosModel::create([
          'clave'         =>  $key
          ,'descripcion'  =>  $value
        ]);

      }

    }
}
