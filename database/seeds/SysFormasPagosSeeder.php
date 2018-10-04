<?php

use Illuminate\Database\Seeder;

class SysFormasPagosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $data = [
        '1' =>	'Efectivo'
        ,'2' =>	'Cheque nominativo'
        ,'3' =>	'Transferencia electrónica de fondos'
        ,'4' =>	'Tarjeta de crédito'
        ,'5' =>	'Monedero electrónico'
        ,'6' =>	'Dinero electrónico'
        ,'8' =>	'Vales de despensa'
        ,'12' =>	'Dación en pago'
        ,'13' =>	'Pago por subrogación'
        ,'14' =>	'Pago por consignación'
        ,'15' =>	'Condonación'
        ,'17' =>	'Compensación'
        ,'23' =>	'Novación'
        ,'24' =>	'Confusión'
        ,'25' =>	'Remisión de deuda'
        ,'26' =>	'Prescripción o caducidad'
        ,'27' =>	'A satisfacción del acreedor'
        ,'28' =>	'Tarjeta de débito'
        ,'29' =>	'Tarjeta de servicios'
        ,'30' =>	'Aplicación de anticipos'
        ,'31' =>	'Intermediario pagos'
        ,'99' =>	'Por definir'
      ];

      foreach ($data as $key => $value) {

        App\Model\Administracion\Configuracion\SysFormasPagosModel::create([
          'clave'         =>  $key
          ,'descripcion'  =>  $value
        ]);

      }


    }
}
