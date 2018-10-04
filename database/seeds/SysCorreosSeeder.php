<?php

use Illuminate\Database\Seeder;

class SysCorreosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $correo = [1,2,4,5,6,7,8,9];
        for ($i=0; $i < sizeof($correo); $i++) {

          App\Model\Administracion\Correos\SysCorreosModel::create([
                 'nombre'                 => "Jorge Martinez Quezada"
                ,'correo'                 => "jorge.martinez.developer@gmail.com"
                ,'asunto'                 => "FYI"
                ,'descripcion'            => "Mensaje de prueba"
                ,'estatus_destacados'     => 0
                ,'estatus_papelera'       => 0
                ,'estatus_vistos'         => 0
                ,'estatus_enviados'       => 0
                ,'estatus_recibidos'      => 1
                ,'estatus_borradores'     => 0
          ]);

          App\Model\Administracion\Correos\SysCategoriasCorreosModel::create([
            'id_users'          => 2
            ,'id_sucursal'      => 0
            ,'id_empresa'       => 0
            ,'id_categorias'    => 0
            ,'id_correo'        => $correo[$i]
          ]);

        }




    }
}
