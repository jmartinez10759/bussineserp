<?php

use Illuminate\Database\Seeder;

class SysEstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $estados = [
        'Aguascalientes'
        ,'Baja California'
        ,'Baja California Sur'
        ,'Campeche'
        ,'Coahuila de Zaragoza'
        ,'Colima'
        ,'Chiapas'
        ,'Chihuahua'
        ,'Ciudad de México'
        ,'Durango'
        ,'Guanajuato'
        ,'Guerrero'
        ,'Hidalgo'
        ,'Jalisco'
        ,'México'
        ,'Michoacán de Ocampo'
        ,'Morelos'
        ,'Nayarit'
        ,'Nuevo León'
        ,'Oaxaca'
        ,'Puebla'
        ,'Querétaro'
        ,'Quintana Roo'
        ,'San Luis Potosí'
        ,'Sinaloa'
        ,'Sonora'
        ,'Tabasco'
        ,'Tamaulipas'
        ,'Tlaxcala'
        ,'Veracruz'
        ,'Yucatán'
        ,'Zacatecas'
        ];

      $conteo = 1;
        for ($i=0; $i < count($estados); $i++) {

          App\Model\Administracion\Configuracion\SysEstadosModel::create([
            'id'          => $conteo
            ,'country_id' => $conteo
            ,'nombre'     => $estados[$i]
          ]);
          $conteo++;
        }
    }
}
