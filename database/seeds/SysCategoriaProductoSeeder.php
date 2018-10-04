<?php

use Illuminate\Database\Seeder;

class SysCategoriaProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [

        ];

        foreach ($data as $key => $value) {

          App\Model\Administracion\Configuracion\SysCategoriasProductosModel::create([
            'clave'         =>  $key
            ,'descripcion'  =>  $value
          ]);

        }


    }
}
