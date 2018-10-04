<?php

use Illuminate\Database\Seeder;

class SysEmpresasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Model\Administracion\Configuracion\SysEmpresasModel::create([
            'empresa' => "Empresa 1"
            ,'rfc' =>  ""
            ,'razon_social' => ""
            ,'descripcion' => "Empresa Dedicada a "
            ,'logo' => ""
            ,'estatus' => 1
        ]);
    }
}
