<?php

use Illuminate\Database\Seeder;

class SysEstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $data = [
          'No Pagada'   =>  ""
          ,'Pagada'     =>  ""
          ,'Credito'    =>  ""
          ,'Cancelada'  =>  ""
      ];

      foreach ($data as $key => $value) {

        App\Model\Administracion\Configuracion\SysEstatusModel::create([
          'nombre'      =>  $key
          ,'detalles'   =>  $value
          ,'estatus'    =>  1
        ]);

      }


    }
}
